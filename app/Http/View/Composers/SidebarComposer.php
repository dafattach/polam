<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\SubmissionBadgeService;

class SidebarComposer
{
    protected $badgeService;

    public function __construct(SubmissionBadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function compose(View $view)
    {
        $submissionCounts = $this->badgeService->getAllSubmissionCounts();
        
        $view->with('submissionCounts', $submissionCounts);
    }
}
