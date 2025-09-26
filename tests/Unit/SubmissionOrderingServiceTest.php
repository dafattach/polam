<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SubmissionOrderingService;
use App\Models\Submission;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeePosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class SubmissionOrderingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_submission_type_string_returns_correct_type()
    {
        $this->assertEquals('pkl', SubmissionOrderingService::getSubmissionTypeString(0));
        $this->assertEquals('skripsi', SubmissionOrderingService::getSubmissionTypeString(1));
        $this->assertEquals('penelitian-matkul', SubmissionOrderingService::getSubmissionTypeString(2));
        $this->assertEquals('aktif-kuliah', SubmissionOrderingService::getSubmissionTypeString(3));
        $this->assertEquals('bebas-sanksi-akademik', SubmissionOrderingService::getSubmissionTypeString(4));
        $this->assertEquals('cuti', SubmissionOrderingService::getSubmissionTypeString(5));
        $this->assertEquals('transfer', SubmissionOrderingService::getSubmissionTypeString(6));
        $this->assertEquals('pengunduran-diri', SubmissionOrderingService::getSubmissionTypeString(7));
        $this->assertEquals('transkrip', SubmissionOrderingService::getSubmissionTypeString(8));
        $this->assertEquals('beasiswa', SubmissionOrderingService::getSubmissionTypeString(9));
        $this->assertEquals('mbkm', SubmissionOrderingService::getSubmissionTypeString(10));
        $this->assertEquals('non-mbkm', SubmissionOrderingService::getSubmissionTypeString(11));
        $this->assertEquals('', SubmissionOrderingService::getSubmissionTypeString(99));
    }

    public function test_apply_ordering_method_exists_and_returns_builder()
    {
        // Create a mock position that can verify
        $position = new EmployeePosition([
            'level' => 4, // staff level
            'code' => 'staff',
            'name' => 'Staff',
        ]);

        // Create a mock employee
        $employee = new Employee([
            'name' => 'Test Employee',
            'email' => 'test@example.com',
        ]);
        $employee->setRelation('position', $position);

        // Mock the Auth facade
        Auth::shouldReceive('guard')
            ->with('employee')
            ->andReturnSelf();
        Auth::shouldReceive('user')
            ->andReturn($employee);

        // Test that the method returns a Builder instance
        $query = Submission::where('type', 'pkl');
        $result = SubmissionOrderingService::applyOrdering($query, 'pkl');
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $result);
    }
}
