<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Counseling;
use App\Models\Semester;
use App\Models\Student;
use App\Models\WarningLetter;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Get dashboard data for Guru BK role.
     *
     * @return array<string, mixed>
     */
    public function getGuruBKDashboardData(?int $classId = null): array
    {
        $monthStart = now()->startOfMonth();
        $semester = Semester::active();

        $statistics = [
            'students_needing_attention' => Student::whereHas('attendances', function ($query) use ($monthStart): void {
                $query->where('status', 'alpha')
                    ->where('attendance_time', '>=', $monthStart);
            }, '>=', 3)
            ->when($classId, fn ($q) => $q->where('academic_class_id', $classId))
            ->count(),
            'active_sp1' => WarningLetter::active()->where('type', 'SP1')
                ->when($classId, fn ($q) => $q->whereHas('student', fn ($sq) => $sq->where('academic_class_id', $classId)))->count(),
            'active_sp2' => WarningLetter::active()->where('type', 'SP2')
                ->when($classId, fn ($q) => $q->whereHas('student', fn ($sq) => $sq->where('academic_class_id', $classId)))->count(),
            'active_sp3' => WarningLetter::active()->where('type', 'SP3')
                ->when($classId, fn ($q) => $q->whereHas('student', fn ($sq) => $sq->where('academic_class_id', $classId)))->count(),
            'counselings_this_month' => Counseling::query()->where('session_at', '>=', $monthStart)
                ->when($classId, fn ($q) => $q->whereHas('student', fn ($sq) => $sq->where('academic_class_id', $classId)))->count(),
        ];

        $studentsNeedingAttention = Student::with(['user', 'academicClass'])
            ->withCount(['attendances as alpha_count' => function ($query): void {
                $query->where('status', 'alpha');
            }])
            ->having('alpha_count', '>=', 3)
            ->when($classId, fn ($q) => $q->where('academic_class_id', $classId))
            ->orderByDesc('alpha_count')
            ->limit(10)
            ->get();

        $recentCounselings = Counseling::with(['student.user', 'counselor'])
            ->when($classId, fn ($q) => $q->whereHas('student', fn ($sq) => $sq->where('academic_class_id', $classId)))
            ->latest('session_at')
            ->limit(5)
            ->get();

        $recentAttendances = Attendance::with(['student.user', 'academicClass'])
            ->when($classId, fn ($q) => $q->where('academic_class_id', $classId))
            ->latest('attendance_time')
            ->limit(10)
            ->get();

        $alphaTrend = $this->getAlphaTrendPerWeek($semester?->id, $classId);
        $spDistribution = $this->getActiveSpDistribution($classId);

        return compact(
            'statistics',
            'studentsNeedingAttention',
            'recentCounselings',
            'alphaTrend',
            'spDistribution',
            'recentAttendances'
        );
    }

    /**
     * Get the alpha trend per week for the last 4 weeks.
     *
     * @param int|null $semesterId
     * @param int|null $classId
     * @return \Illuminate\Support\Collection
     */
    public function getAlphaTrendPerWeek(?int $semesterId, ?int $classId = null): Collection
    {
        $weeks = collect();
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();

            $count = Attendance::alpha()
                ->when($semesterId, fn ($q) => $q->where('semester_id', $semesterId))
                ->when($classId, fn ($q) => $q->where('academic_class_id', $classId))
                ->whereBetween('attendance_time', [$startOfWeek, $endOfWeek])
                ->count();

            $weeks->push([
                'label' => $startOfWeek->format('d M'),
                'count' => $count,
            ]);
        }

        return $weeks;
    }

    /**
     * Get the distribution of active warning letters.
     *
     * @param int|null $classId
     * @return \Illuminate\Support\Collection
     */
    public function getActiveSpDistribution(?int $classId = null): Collection
    {
        return WarningLetter::active()->selectRaw('type, COUNT(*) as total')
            ->when($classId, fn ($q) => $q->whereHas('student', fn ($sq) => $sq->where('academic_class_id', $classId)))
            ->groupBy('type')
            ->pluck('total', 'type');
    }
}
