<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\Employee\EmployeePosition;
use Illuminate\Support\Facades\Auth;

class SubmissionBadgeService
{
    protected $userPosition;
    
    public function __construct()
    {
        $this->userPosition = Auth::guard('employee')->user()->position ?? null;
    }

    /**
     * Get submission count for a specific type based on user permissions
     */
    public function getSubmissionCount($type)
    {
        if (!$this->userPosition) {
            return 0;
        }

        $count = 0;

        // If user can verify submissions
        if ($this->userPosition->getAllowedToVerifyAttribute()) {
            $count += Submission::where('type', $type)
                ->whereNull('verified_at')
                ->whereNull('rejected_at')
                ->count();
        }

        // If user can approve submissions
        if ($this->userPosition->allowedToApprove($type)) {
            $count += Submission::where('type', $type)
                ->whereNotNull('verified_at')
                ->whereNull('approved_at')
                ->whereNull('rejected_at')
                ->count();
        }

        return $count;
    }

    /**
     * Get submission counts for all types in a category
     */
    public function getCategoryCount($types)
    {
        $totalCount = 0;
        
        foreach ($types as $type) {
            $totalCount += $this->getSubmissionCount($type);
        }
        
        return $totalCount;
    }

    /**
     * Get all submission counts organized by categories
     */
    public function getAllSubmissionCounts()
    {
        $categories = [
            'surat-pengantar' => ['pkl', 'skripsi', 'penelitian-matkul'],
            'surat-keterangan' => ['aktif-kuliah', 'bebas-sanksi-akademik'],
            'surat-rekomendasi' => ['beasiswa', 'mbkm', 'non-mbkm'],
            'surat-lainnya' => ['transkrip', 'cuti', 'transfer', 'pengunduran-diri']
        ];

        $counts = [];
        
        foreach ($categories as $category => $types) {
            $counts[$category] = [
                'total' => $this->getCategoryCount($types),
                'types' => []
            ];
            
            foreach ($types as $type) {
                $counts[$category]['types'][$type] = $this->getSubmissionCount($type);
            }
        }

        return $counts;
    }

    /**
     * Get formatted badge HTML for display
     */
    public function getBadgeHtml($count, $classes = 'badge-danger')
    {
        if ($count > 0) {
            return '<span class="badge ' . $classes . '">' . $count . '</span>';
        }
        
        return '';
    }
}
