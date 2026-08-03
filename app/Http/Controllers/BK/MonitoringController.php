<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Semester;
use App\Services\DashboardService;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function alpha(Request $request): View
    {
        // Asumsikan DashboardService memiliki metode untuk data ini
        $dashboardService = app(DashboardService::class);

        $semesterId = $request->input('semester_id', Semester::query()->where('active', true)->first()?->id);
        $minAlpha = (int) $request->input('min_alpha', 3);
        $classId = $request->input('academic_class_id');

        $semesters = Semester::query()->latest()->get();

        $query = Student::with(['user', 'academicClass'])
            ->withCount(['attendances as alpha_count' => function ($q) use ($semesterId): void {
                $q->where('status', 'alpha');
                if ($semesterId) {
                    $q->where('semester_id', $semesterId);
                }
            }])
            ->having('alpha_count', '>=', $minAlpha)
            ->orderByDesc('alpha_count');

        if ($classId) {
            $query->where('academic_class_id', $classId);
        }

        $students = $query->paginate(20)->withQueryString();

        // Ambil data dari service
        $weeks = $dashboardService->getAlphaTrendPerWeek($semesterId);
        $spDistribution = $dashboardService->getActiveSpDistribution();

        return view('bk.monitoring.alpha', compact(
            'students', 'semesters', 'semesterId', 'minAlpha', 'classId', 'weeks', 'spDistribution',
        ));
    }

    public function updateStatus(Request $request, Student $student): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'monitoring_status' => 'required|in:perlu_dipanggil,sudah_dipanggil,dalam_pembinaan',
        ]);

        $student->fill($data)->save();

        return back()->with('success', 'Status monitoring siswa berhasil diperbarui.');
    }
}
