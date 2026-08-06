<?php

namespace App\Services;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TeacherAcademicService
{
    public function getClassesForTeacher(Teacher $teacher): Collection
    {
        return AcademicClass::query()
            ->whereHas('schedules', fn (Builder $query) => $query->where('teacher_id', $teacher->id))
            ->orWhere('teacher_id', $teacher->id)
            ->with(['students.user'])
            ->withCount('students')
            ->orderBy('name')
            ->get();
    }

    public function getGradebookForTeacher(Teacher $teacher): array
    {
        $subjectId = $teacher->subject_id ?? \App\Models\Subject::query()->first()?->id;

        return Grade::query()
            ->with(['student.user', 'academicClass'])
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('academicClass.schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhereHas('academicClass', fn (Builder $q) => $q->where('teacher_id', $teacher->id));
            })
            ->where('subject_id', $subjectId)
            ->get()
            ->map(fn (Grade $grade) => [
                'id' => $grade->id,
                'student_id' => $grade->student_id,
                'academic_class_id' => $grade->academic_class_id,
                'student_name' => $grade->student->user->name,
                'class_name' => $grade->academicClass?->name,
                'assignment' => $grade->assignment,
                'score' => $grade->score,
                'status' => $grade->status,
            ])
            ->all();
    }

    public function getStudentOptionsForTeacher(Teacher $teacher): array
    {
        return AcademicClass::query()
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhere('teacher_id', $teacher->id);
            })
            ->with('students.user')
            ->get()
            ->flatMap(fn (AcademicClass $class) => $class->students->map(fn ($student) => [
                'id' => $student->id,
                'name' => $student->user->name,
                'label' => $student->user->name . ' (' . $student->student_number . ')',
                'class' => $class->name,
            ]))
            ->values()
            ->all();
    }

    public function createClassForTeacher(Teacher $teacher, array $data): AcademicClass
    {
        /** @var AcademicClass $class */
        $class = AcademicClass::query()->create([
            'teacher_id' => $teacher->id,
            'name' => $data['name'],
            'room' => $data['room'],
            'schedule' => $data['schedule'],
        ]);

        // $this->autoEnrollStudentsByGradeLevel($class);

        return $class;
    }

    public function autoEnrollStudentsByGradeLevel(AcademicClass $class): void
    {
        $gradeLevel = static::extractGradeLevel($class->name);

        if (! $gradeLevel) {
            return;
        }

        $gradeVariations = match ($gradeLevel) {
            '7' => ['7', 'VII', 'vii'],
            '8' => ['8', 'VIII', 'viii'],
            '9' => ['9', 'IX', 'ix'],
            default => [$gradeLevel],
        };

        $students = Student::query()->whereIn('grade_level', $gradeVariations, 'and', false)->get();

        if ($students->isNotEmpty()) {
            $class->students()->syncWithoutDetaching($students->pluck('id')->all());

            foreach ($students as $student) {
                if (empty($student->academic_class_id)) {
                    $student->academic_class_id = $class->id;
                    $student->saveQuietly();
                }
            }
        }
    }

    public static function autoEnrollStudentInClasses(Student $student): void
    {
        $studentGrade = static::extractGradeLevel($student->grade_level ?? '');
        if (! $studentGrade) {
            return;
        }

        $classes = AcademicClass::all();
        $classIdsToEnroll = [];

        foreach ($classes as $class) {
            $classGrade = static::extractGradeLevel($class->name);
            if ($classGrade === $studentGrade) {
                $classIdsToEnroll[] = $class->id;
            }
        }

        if (! empty($classIdsToEnroll)) {
            $student->classes()->syncWithoutDetaching($classIdsToEnroll);

            if (empty($student->academic_class_id) || ! in_array($student->academic_class_id, $classIdsToEnroll, true)) {
                $student->academic_class_id = $classIdsToEnroll[0];
                $student->saveQuietly();
            }
        }
    }

    public static function extractGradeLevel(string $className): ?string
    {
        $upper = strtoupper($className);

        if (str_contains($upper, 'VIII') || preg_match('/\b8[A-Z0-9]*\b/', $upper) || preg_match('/KELAS\s*8\b/', $upper)) {
            return '8';
        }
        if (str_contains($upper, 'IX') || preg_match('/\b9[A-Z0-9]*\b/', $upper) || preg_match('/KELAS\s*9\b/', $upper)) {
            return '9';
        }
        if (str_contains($upper, 'VII') || preg_match('/\b7[A-Z0-9]*\b/', $upper) || preg_match('/KELAS\s*7\b/', $upper)) {
            return '7';
        }

        return null;
    }

    public function updateClassForTeacher(Teacher $teacher, int $classId, array $data): AcademicClass
    {
        $class = $teacher->classes()->where('id', $classId)->first();

        if (! $class instanceof AcademicClass) {
            throw new \RuntimeException('Kelas tidak ditemukan atau Anda tidak memiliki akses untuk mengubah kelas ini.');
        }

        $class->fill([
            'name' => $data['name'],
            'room' => $data['room'],
            'schedule' => $data['schedule'],
        ]);
        $class->save();

        return $class;
    }

    public function deleteClassForTeacher(Teacher $teacher, int $classId): bool
    {
        $class = $teacher->classes()->where('id', $classId)->first();

        if (! $class instanceof AcademicClass) {
            return false;
        }

        return (bool) AcademicClass::destroy($class->getKey());
    }

    public function regenerateTokenForTeacher(Teacher $teacher, int $classId): ?string
    {
        $class = AcademicClass::query()
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhere('teacher_id', $teacher->id);
            })
            ->where('id', $classId)
            ->first();

        if (! $class instanceof AcademicClass) {
            return null;
        }

        $newToken = AcademicClass::generateUniqueToken();
        $class->forceFill(['access_token' => $newToken])->save();

        return $newToken;
    }

    public function createGradeForTeacher(Teacher $teacher, array $data): Grade
    {
        $class = AcademicClass::query()
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhere('teacher_id', $teacher->id);
            })
            ->where('id', $data['academic_class_id'])
            ->first();

        if (! $class instanceof AcademicClass) {
            throw new \RuntimeException('Class not found or not owned by teacher.');
        }

        if (! $class->students()->where('student_id', $data['student_id'])->exists()) {
            throw new \RuntimeException('Student is not enrolled in this class.');
        }

        $semesterId = Semester::active()?->id ?? Semester::query()->first()?->id;

        $subjectId = $teacher->subject_id;
        if (! $subjectId) {
            $subjectId = \App\Models\Subject::query()->first()?->id;
        }

        /** @var Grade $grade */
        $grade = Grade::query()->create([
            'student_id' => $data['student_id'],
            'academic_class_id' => $class->id,
            'subject_id' => $subjectId,
            'semester_id' => $semesterId,
            'assignment' => $data['assignment'],
            'score' => $data['score'],
            'status' => $data['status'],
        ]);

        return $grade;
    }

    public function deleteGradeForTeacher(Teacher $teacher, int $gradeId): bool
    {
        $subjectId = $teacher->subject_id ?? \App\Models\Subject::query()->first()?->id;

        $grade = Grade::query()
            ->where('id', $gradeId)
            ->where('subject_id', $subjectId)
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('academicClass.schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhereHas('academicClass', fn (Builder $q) => $q->where('teacher_id', $teacher->id));
            })
            ->first();

        if (! $grade instanceof Grade) {
            return false;
        }

        return (bool) Grade::destroy($grade->getKey());
    }

    public function updateGradeForTeacher(Teacher $teacher, int $gradeId, array $data): Grade
    {
        $subjectId = $teacher->subject_id ?? \App\Models\Subject::query()->first()?->id;

        $grade = Grade::query()
            ->where('id', $gradeId)
            ->where('subject_id', $subjectId)
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('academicClass.schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhereHas('academicClass', fn (Builder $q) => $q->where('teacher_id', $teacher->id));
            })
            ->first();

        if (! $grade instanceof Grade) {
            throw new \RuntimeException('Grade not found or not owned by teacher.');
        }

        $class = AcademicClass::query()
            ->where(function (Builder $query) use ($teacher) {
                $query->whereHas('schedules', fn (Builder $q) => $q->where('teacher_id', $teacher->id))
                      ->orWhere('teacher_id', $teacher->id);
            })
            ->where('id', $data['academic_class_id'])
            ->first();

        if (! $class instanceof AcademicClass) {
            throw new \RuntimeException('Class not found or not owned by teacher.');
        }

        if (! $class->students()->where('student_id', $data['student_id'])->exists()) {
            throw new \RuntimeException('Student is not enrolled in this class.');
        }

        $grade->fill([
            'student_id' => $data['student_id'],
            'academic_class_id' => $class->id,
            'assignment' => $data['assignment'],
            'score' => $data['score'],
            'status' => $data['status'],
        ]);
        $grade->save();

        return $grade;
    }

    public function getScheduleForTeacher(Teacher $teacher): Collection
    {
        return Schedule::query()
            ->with(['subject', 'academicClass'])
            ->where('teacher_id', $teacher->id)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function createBulkAttendance(Teacher $teacher, int $classId, string $date, array $attendances): void
    {
        $class = $teacher->classes()->where('id', $classId)->first();

        if (! $class instanceof AcademicClass) {
            throw new \RuntimeException('Class not found or not owned by teacher.');
        }

        $semesterId = Semester::active()?->id;

        if (! $semesterId) {
            throw new \RuntimeException('No active semester found.');
        }

        foreach ($attendances as $studentId => $status) {
            if (empty($status)) {
                continue;
            }

            if (! $class->students()->where('student_id', $studentId)->exists()) {
                continue;
            }

            Attendance::query()->updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_class_id' => $classId,
                    'semester_id' => $semesterId,
                    'attendance_time' => $date . ' 07:00:00',
                ],
                [
                    'status' => $status,
                ]
            );
        }
    }
}
