<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Overall Statistics
        $totalSubmissions = Submission::count();
        $totalUnprocessed = Submission::whereNull('verified_at')
            ->whereNull('approved_at')
            ->whereNull('rejected_at')
            ->count();
        $totalVerifiedPending = Submission::whereNotNull('verified_at')
            ->whereNull('approved_at')
            ->whereNull('rejected_at')
            ->count();
        $totalApproved = Submission::whereNotNull('approved_at')->count();
        $totalRejected = Submission::whereNotNull('rejected_at')->count();

        // Today's Statistics
        $today = Carbon::today();
        $todaySubmissions = Submission::whereDate('created_at', $today)->count();
        $todayUnprocessed = Submission::whereDate('created_at', $today)
            ->whereNull('verified_at')
            ->whereNull('approved_at')
            ->whereNull('rejected_at')
            ->count();
        $todayVerifiedPending = Submission::whereDate('created_at', $today)
            ->whereNotNull('verified_at')
            ->whereNull('approved_at')
            ->whereNull('rejected_at')
            ->count();
        $todayApproved = Submission::whereDate('created_at', $today)
            ->whereNotNull('approved_at')
            ->count();
        $todayRejected = Submission::whereDate('created_at', $today)
            ->whereNotNull('rejected_at')
            ->count();

        // Statistics by Submission Type
        $typeStatistics = [];
        foreach (Submission::TYPES as $index => $type) {
            $typeStatistics[$type] = [
                'total' => Submission::where('type', $type)->count(),
                'unprocessed' => Submission::where('type', $type)
                    ->whereNull('verified_at')
                    ->whereNull('approved_at')
                    ->whereNull('rejected_at')
                    ->count(),
                'verified_pending' => Submission::where('type', $type)
                    ->whereNotNull('verified_at')
                    ->whereNull('approved_at')
                    ->whereNull('rejected_at')
                    ->count(),
                'approved' => Submission::where('type', $type)
                    ->whereNotNull('approved_at')
                    ->count(),
                'rejected' => Submission::where('type', $type)
                    ->whereNotNull('rejected_at')
                    ->count(),
            ];
        }

        return view('admin.dashboard.index', compact(
            'totalSubmissions',
            'totalUnprocessed',
            'totalVerifiedPending',
            'totalApproved',
            'totalRejected',
            'todaySubmissions',
            'todayUnprocessed',
            'todayVerifiedPending',
            'todayApproved',
            'todayRejected',
            'typeStatistics'
        ));
    }
}
