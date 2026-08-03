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
    public function getGuruBKDashboardData(): array
    {
        $monthStart = now()->startOfMonth();
        $semester = Semester::where('active', true)->first();

        $statistics = [
            'students_needing_attention' => Student::whereHas('attendances', function ($query) use ($monthStart): void {
                $query->where('status', 'alpha')
                    ->where('attendance_time', '>=', $monthStart);
            }, '>=', 3)->count(),
            'active_sp1' => WarningLetter::query()->where('type', 'SP1')->whereNull('resolved_at')->count(),
            'active_sp2' => WarningLetter::query()->where('type', 'SP2')->whereNull('resolved_at')->count(),
            'active_sp3' => WarningLetter::query()->where('type', 'SP3')->whereNull('resolved_at')->count(),
            'counselings_this_month' => Counseling::query()->where('session_at', '>=', $monthStart)->count(),
        ];

        $studentsNeedingAttention = Student::with(['user', 'academicClass'])
            ->withCount(['attendances as alpha_count' => function ($query): void {
                $query->where('status', 'alpha');
            }])
            ->having('alpha_count', '>=', 3)
            ->orderByDesc('alpha_count')
            ->limit(10)
            ->get();

        $recentCounselings = Counseling::with(['student.user', 'counselor'])
            ->latest('session_at')
            ->limit(5)
            ->get();

        $alphaTrend = $this->getAlphaTrendPerWeek($semester?->id);
        $spDistribution = $this->getActiveSpDistribution();

        return compact(
            'statistics',
            'studentsNeedingAttention',
            'recentCounselings',
            'alphaTrend',
            'spDistribution'
        );
    }

    /**
     * Get the alpha trend per week for the last 4 weeks.
     *
     * @param int|null $semesterId
     * @return \Illuminate\Support\Collection
     */
    public function getAlphaTrendPerWeek(?int $semesterId): Collection
    {
        $weeks = collect();
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();

            $count = Attendance::alpha()
                ->when($semesterId, fn ($q) => $q->where('semester_id', $semesterId))
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
     * @return \Illuminate\Support\Collection
     */
    public function getActiveSpDistribution(): Collection
    {
        return WarningLetter::query()->selectRaw('type, COUNT(*) as total')
            ->whereNull('resolved_at')
            ->groupBy('type')
            ->pluck('total', 'type');
    }
}
