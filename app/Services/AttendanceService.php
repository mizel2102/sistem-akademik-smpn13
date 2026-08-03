<?php

namespace App\Services;

use App\Events\AlphaThresholdReached;
use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Collection;

class AttendanceService
{
    public function createAttendance(array $data): Attendance
    {
        return Attendance::create($data);
    }

    /**
     * Store multiple attendances for a class in bulk.
     *
     * @param array $attendances Array of ['student_id', 'status', 'note', 'attendance_time']
     * @param int $academicClassId
     * @param int|null $semesterId
     * @return Collection
     */
    public function storeAttendances(array $attendances, int $academicClassId, ?int $semesterId = null): Collection
    {
        $semesterId ??= Semester::active()?->id;

        $created = collect();
        foreach ($attendances as $attendanceData) {
            $attendance = Attendance::create([
                'student_id' => $attendanceData['student_id'],
                'academic_class_id' => $academicClassId,
                'semester_id' => $semesterId,
                'status' => $attendanceData['status'] ?? 'hadir',
                'attendance_time' => $attendanceData['attendance_time'] ?? now(),
                'note' => $attendanceData['note'] ?? null,
            ]);

            $created->push($attendance);

            // Check alpha threshold for students marked as 'alpha'
            if (($attendanceData['status'] ?? 'hadir') === 'alpha') {
                $this->checkAlphaThreshold(
                    Student::find($attendanceData['student_id']),
                    Semester::find($semesterId),
                );
            }
        }

        return $created;
    }

    /**
     * Check if a student's alpha count has exceeded the threshold.
     * Fires AlphaThresholdReached event if threshold is met.
     */
    public function checkAlphaThreshold(Student $student, ?Semester $semester = null): void
    {
        $semester ??= Semester::active()?->first();

        if (! $semester) {
            return;
        }

        $alphaCount = Attendance::alpha()
            ->byStudent($student->id)
            ->bySemester($semester->id)
            ->count();

        // Threshold levels: 3, 6, 9 (SP1, SP2, SP3)
        $thresholds = [3, 6, 9];

        foreach ($thresholds as $threshold) {
            if ($alphaCount >= $threshold) {
                $existingLetters = $student->warningLetters()
                    ->active()
                    ->where('type', 'SP' . array_search($threshold, [3 => 3, 6 => 2, 9 => 1]))
                    ->exists();

                if (! $existingLetters) {
                    event(new AlphaThresholdReached($student, $alphaCount, $semester));
                    break;
                }
            }
        }
    }

    /**
     * Get monthly attendance recap for a class.
     *
     * @return Collection<int, array{student_id: int, name: string, hadir: int, sakit: int, izin: int, alpha: int}>
     */
    public function getMonthlyRecap(AcademicClass $class, int $month, int $year): Collection
    {
        $students = $class->students()->with('user')->get();
        $recaps = collect();

        foreach ($students as $student) {
            $attendances = Attendance::where('student_id', $student->id)
                ->where('academic_class_id', $class->id)
                ->whereMonth('attendance_time', $month)
                ->whereYear('attendance_time', $year)
                ->get();

            $recaps->push([
                'student_id' => $student->id,
                'name' => $student->user?->name ?? $student->student_number,
                'hadir' => $attendances->where('status', 'hadir')->count(),
                'sakit' => $attendances->where('status', 'sakit')->count(),
                'izin' => $attendances->where('status', 'izin')->count(),
                'alpha' => $attendances->where('status', 'alpha')->count(),
            ]);
        }

        return $recaps;
    }
}
