<?php

namespace App\Services;

use App\Models\AcademicClass;
use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class SchoolReportService
{
    public function summary(): array
    {
        return [
            'totalUsers' => User::query()->count('*'),
            'adminCount' => $this->countUsersByRole('admin'),
            'teacherCount' => $this->countUsersByRole('teacher'),
            'studentCount' => $this->countUsersByRole('student'),
            'totalRoles' => Role::query()->count('*'),
            'classCount' => AcademicClass::count('*'),
            'subjectCount' => Subject::count('*'),
            'academicYearCount' => AcademicYear::count('*'),
            'semesterCount' => Semester::count('*'),
            'scheduleCount' => Schedule::count('*'),
            'announcementCount' => Announcement::count('*'),
            'gradeCount' => Grade::count('*'),
            'attendanceCount' => Attendance::count('*'),
        ];
    }

    private function countUsersByRole(string $roleName): int
    {
        return User::query()
            ->whereHas('roles', fn (Builder $query) => $query->where('name', $roleName))
            ->count('*');
    }
}
