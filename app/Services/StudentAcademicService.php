<?php

namespace App\Services;

use App\Models\AcademicClass;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StudentAcademicService
{
    public function getRecordsForStudent(Student $student): array
    {
        $records = $student->grades()
            ->with('academicClass')
            ->get()
            ->map(fn (Grade $grade) => [
                'subject' => $grade->academicClass?->name,
                'grade' => $grade->score,
                'status' => $grade->status,
            ])
            ->all();

        return $records;
    }

    public function getAttendanceRateForStudent(Student $student): string
    {
        $attendanceCount = $student->attendances()->count();

        if ($attendanceCount === 0) {
            return 'N/A';
        }

        $presentCount = $student->attendances()
            ->whereIn('status', ['present', 'late'])
            ->count();

        return round($presentCount / $attendanceCount * 100) . '%';
    }

    public function getScheduleForStudent(Student $student): Collection
    {
        $classIds = $student->classes()->pluck('academic_classes.id')->all();

        if (empty($classIds)) {
            return collect();
        }

        return Schedule::with(['subject', 'teacher.user', 'academicClass'])
            ->whereIn('academic_class_id', $classIds)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function getClassesForStudent(Student $student): Collection
    {
        $studentGradeLevel = TeacherAcademicService::extractGradeLevel($student->grade_level ?? '') ?? $student->grade_level;

        return $student->classes()
            ->with(['teacher.user', 'students'])
            ->get()
            ->filter(function (AcademicClass $class) use ($studentGradeLevel) {
                if (! $studentGradeLevel) {
                    return true;
                }
                $classGradeLevel = TeacherAcademicService::extractGradeLevel($class->name);
                return ! $classGradeLevel || $classGradeLevel === $studentGradeLevel;
            })
            ->values();
    }

    public function getClassDetailsForStudent(Student $student, int $classId): array
    {
        $studentGradeLevel = TeacherAcademicService::extractGradeLevel($student->grade_level ?? '') ?? $student->grade_level;

        $class = $student->classes()
            ->with(['teacher.user', 'students.user', 'schedules.subject', 'schedules.teacher.user'])
            ->where('academic_classes.id', $classId)
            ->firstOrFail();

        $classGradeLevel = TeacherAcademicService::extractGradeLevel($class->name);

        if ($studentGradeLevel && $classGradeLevel && $classGradeLevel !== $studentGradeLevel) {
            abort(403, "Akses Ditolak: Anda terdaftar pada tingkat kelas {$studentGradeLevel} dan tidak dapat mengakses kelas tingkat {$classGradeLevel}.");
        }

        $myGrades = $student->grades()
            ->with(['subject', 'semester'])
            ->where('academic_class_id', $classId)
            ->get();

        $myAttendances = $student->attendances()
            ->where('academic_class_id', $classId)
            ->orderBy('date', 'desc')
            ->get();

        return [
            'class' => $class,
            'myGrades' => $myGrades,
            'myAttendances' => $myAttendances,
            'classmates' => $class->students,
        ];
    }
}
