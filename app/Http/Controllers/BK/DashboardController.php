<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {
    }

    public function index(Request $request): View
    {
        $classId = $request->input('academic_class_id') ? (int) $request->input('academic_class_id') : null;
        $data = $this->dashboardService->getGuruBKDashboardData($classId);
        $classes = \App\Models\AcademicClass::orderBy('name')->get();

        return view('bk.dashboard', array_merge($data, [
            'classes' => $classes,
            'selectedClassId' => $classId
        ]));
    }
}
