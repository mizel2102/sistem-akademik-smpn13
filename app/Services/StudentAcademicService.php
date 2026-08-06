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
            ->with(['academicClass', 'subject'])
            ->get()
            ->map(fn (Grade $grade) => [
                'subject' => $grade->subject?->name ?? $grade->academicClass?->name ?? 'Mata Pelajaran',
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

    public function getAvailableClassesForStudent(Student $student): Collection
    {
        $studentGradeLevel = TeacherAcademicService::extractGradeLevel($student->grade_level ?? '') ?? $student->grade_level;

        if (! $studentGradeLevel) {
            return collect();
        }

        return AcademicClass::with(['teacher.user', 'students'])
            ->get()
            ->filter(function (AcademicClass $class) use ($studentGradeLevel) {
                $classGradeLevel = TeacherAcademicService::extractGradeLevel($class->name);
                return $classGradeLevel === $studentGradeLevel;
            })
            ->values();
    }

    public function getClassDetailsForStudent(Student $student, int $classId): array
    {
        $studentGradeLevel = TeacherAcademicService::extractGradeLevel($student->grade_level ?? '') ?? $student->grade_level;

        // Check if the student is enrolled in this class
        $isEnrolled = $student->classes()->where('academic_classes.id', $classId)->exists();
        if (! $isEnrolled) {
            abort(403, "Akses Ditolak: Anda belum bergabung dengan kelas ini. Silakan masukkan token kelas terlebih dahulu.");
        }

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
            ->orderBy('attendance_time', 'desc')
            ->get();

        return [
            'class' => $class,
            'myGrades' => $myGrades,
            'myAttendances' => $myAttendances,
            'classmates' => $class->students,
        ];
    }
}
