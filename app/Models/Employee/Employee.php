<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Department;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'employee_position_id',
        'department_id',
        'name',
        'email',
        'registration_type',
        'registration_number',
        'signature',
        'password',
    ];

    function department() {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    function position() {
        return $this->belongsTo(EmployeePosition::class, 'employee_position_id', 'id');
    }
}
