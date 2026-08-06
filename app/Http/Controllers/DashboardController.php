<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
    {
        $user = $request->user();
        $role = $user?->getRoleNames()->first() ?? 'user';

        if ($role === 'guru-bk' || $role === 'guru_bk') {
            return redirect()->route('bk.dashboard');
        }

        $statistics = [
            'users' => User::query()->count('*'),
            'teachers' => Teacher::query()->count('*'),
            'students' => Student::query()->count('*'),
            'classes' => AcademicClass::query()->count('*'),
            'subjects' => Subject::query()->count('*'),
            'academic_years' => AcademicYear::query()->count('*'),
            'semesters' => Semester::query()->count('*'),
            'schedules' => Schedule::query()->count('*'),
            'announcements' => Announcement::query()->count('*'),
            'grades' => Grade::query()->count('*'),
        ];

        $recentWarningLetters = [];
        $recentAttendances = [];
        $personalStats = [];
        $recentAnnouncements = Announcement::query()->latest()->take(5)->get();

        if ($role === 'teacher' && $user->teacher) {
            $teacherClassIds = \App\Models\AcademicClass::whereHas('schedules', fn ($q) => $q->where('teacher_id', $user->teacher->id))
                ->orWhere('teacher_id', $user->teacher->id)
                ->pluck('id');
            
            $personalStats = [
                'classes' => $teacherClassIds->count(),
                'grades' => Grade::whereIn('academic_class_id', $teacherClassIds, 'and', false)->count('*'),
                'students' => \App\Models\Student::query()->whereHas('classes', fn ($q) => $q->whereIn('academic_classes.id', $teacherClassIds, 'and', false))->count('*'),
                'today_attendances' => \App\Models\Attendance::query()
                                            ->whereIn('academic_class_id', $teacherClassIds->toArray(), 'and', false)
                                            ->whereDate('attendance_time', '=', today(), 'and')
                                            ->count('*'),
            ];

            $recentAttendances = \App\Models\Attendance::query()
                                            ->with(['student.user', 'academicClass'])
                                            ->whereIn('academic_class_id', $teacherClassIds->toArray(), 'and', false)
                                            ->latest('attendance_time')
                                            ->take(5)
                                            ->get();

            $studentIds = \App\Models\Student::query()->whereHas('classes', fn ($q) => $q->whereIn('academic_classes.id', $teacherClassIds, 'and', false))->pluck('id');
            $recentWarningLetters = \App\Models\WarningLetter::with(['student.user'])
                                            ->whereIn('student_id', $studentIds, 'and', false)
                                            ->latest()
                                            ->take(5)
                                            ->get();
        }

        $activeSp = null;
        if ($role === 'student' && $user->student) {
            $attendanceCount = $user->student->attendances()->count();
            $presentCount = $user->student->attendances()->whereIn('status', ['present', 'late'])->count();
            $personalStats = [
                'attendanceRate' => $attendanceCount > 0 ? round($presentCount / $attendanceCount * 100) . '%' : 'N/A',
                'grades' => $user->student->grades()->count(),
                'classes' => $user->student->classes()->count(),
            ];
            $activeSp = $user->student->warningLetters()->whereNull('resolved_at')->latest('issued_at')->first();
        }

        return view('dashboard', compact('role', 'statistics', 'personalStats', 'recentAttendances', 'recentAnnouncements', 'recentWarningLetters', 'activeSp'));
    }
}
