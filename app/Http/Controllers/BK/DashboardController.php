<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {
    }

    public function index(): View
    {
        $data = $this->dashboardService->getGuruBKDashboardData();

        return view('bk.dashboard', $data);
    }
}
