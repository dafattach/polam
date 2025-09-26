<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SubmissionOrderingService
{
    /**
     * Apply ordering logic to submissions query based on authenticated admin's permissions
     * 
     * @param Builder $query
     * @param string $submissionType
     * @return Builder
     */
    public static function applyOrdering(Builder $query, string $submissionType): Builder
    {
        $admin = Auth::guard('employee')->user();
        $position = $admin->position;
        
        $canVerify = $position->getAllowedToVerifyAttribute();
        $canApprove = $position->allowedToApprove($submissionType);
        
        return $query->orderByRaw(
            self::buildOrderByRaw($canVerify, $canApprove)
        )->orderBy('created_at', 'desc');
    }
    
    /**
     * Build the ORDER BY RAW SQL based on admin permissions
     * 
     * @param bool $canVerify
     * @param bool $canApprove
     * @return string
     */
    private static function buildOrderByRaw(bool $canVerify, bool $canApprove): string
    {
        if ($canVerify && $canApprove) {
            // Admin can do both verify and approve: [need verified] → [need approved] → [approved] → [rejected]
            return "
                CASE 
                    WHEN rejected_at IS NOT NULL THEN 4
                    WHEN approved_at IS NOT NULL THEN 3
                    WHEN verified_at IS NOT NULL AND approved_at IS NULL THEN 2
                    WHEN verified_at IS NULL AND approved_at IS NULL THEN 1
                    ELSE 5
                END ASC
            ";
        } elseif ($canVerify && !$canApprove) {
            // Admin can only verify: [need verified] → [need approved] → [approved] → [rejected]
            return "
                CASE 
                    WHEN rejected_at IS NOT NULL THEN 4
                    WHEN approved_at IS NOT NULL THEN 3
                    WHEN verified_at IS NOT NULL AND approved_at IS NULL THEN 2
                    WHEN verified_at IS NULL AND approved_at IS NULL THEN 1
                    ELSE 5
                END ASC
            ";
        } elseif (!$canVerify && $canApprove) {
            // Admin can only approve: [need approved] → [need verified] → [approved] → [rejected]
            return "
                CASE 
                    WHEN rejected_at IS NOT NULL THEN 4
                    WHEN approved_at IS NOT NULL THEN 3
                    WHEN verified_at IS NULL AND approved_at IS NULL THEN 2
                    WHEN verified_at IS NOT NULL AND approved_at IS NULL THEN 1
                    ELSE 5
                END ASC
            ";
        } else {
            // Admin cannot verify or approve: just show by status with newest first
            return "
                CASE 
                    WHEN rejected_at IS NOT NULL THEN 4
                    WHEN approved_at IS NOT NULL THEN 3
                    WHEN verified_at IS NOT NULL AND approved_at IS NULL THEN 2
                    WHEN verified_at IS NULL AND approved_at IS NULL THEN 1
                    ELSE 5
                END ASC
            ";
        }
    }
    
    /**
     * Get the submission type string from the Submission::TYPES array index
     * 
     * @param int $typeIndex
     * @return string
     */
    public static function getSubmissionTypeString(int $typeIndex): string
    {
        $types = [
            0 => 'pkl',
            1 => 'skripsi', 
            2 => 'penelitian-matkul',
            3 => 'aktif-kuliah',
            4 => 'bebas-sanksi-akademik',
            5 => 'cuti',
            6 => 'transfer',
            7 => 'pengunduran-diri',
            8 => 'transkrip',
            9 => 'beasiswa',
            10 => 'mbkm',
            11 => 'non-mbkm',
        ];
        
        return $types[$typeIndex] ?? '';
    }
}
