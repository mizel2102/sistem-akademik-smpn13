<?php

namespace App\Providers;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\Teacher;
use App\Models\Student;
use App\Policies\AcademicClassPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\GradePolicy;
use App\Policies\UserPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\AcademicYearPolicy;
use App\Policies\SemesterPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\AnnouncementPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        AcademicClass::class => AcademicClassPolicy::class,
        Attendance::class => AttendancePolicy::class,
        Grade::class => GradePolicy::class,
        Subject::class => SubjectPolicy::class,
        AcademicYear::class => AcademicYearPolicy::class,
        Semester::class => SemesterPolicy::class,
        Schedule::class => SchedulePolicy::class,
        Announcement::class => AnnouncementPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Student::class => StudentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
