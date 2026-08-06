<?php

use App\Http\Controllers\Admin\AcademicClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Student\AcademicController as StudentAcademicController;
use App\Http\Controllers\Teacher\AcademicController as TeacherAcademicController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BK\DashboardController as BKDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\AcademicClass;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\WarningLetter;

Route::get('/', [SchoolController::class, 'index'])->name('home');

// Public pages
Route::get('/guru', function () {
    return view('guru.index');
})->name('guru.index');

Route::get('/prestasi', function () {
    return view('prestasi.index');
})->name('prestasi.index');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    // Registration disabled for public. Admins should create accounts.
    // Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    // Route::post('register', [AuthController::class, 'register'])->name('register.store');
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('berita', fn () => redirect()->route('welcome'))->name('berita.index');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->parameters(['users' => 'id']);
        Route::get('roles', [UserController::class, 'roles'])->name('roles.index');
        Route::get('reports', [SchoolController::class, 'reports'])->name('reports.index');
        Route::get('reports/pdf', [SchoolController::class, 'reportsPdf'])->name('reports.pdf');

        // Data Import/Export
        Route::post('users/import', [\App\Http\Controllers\Admin\DataImportExportController::class, 'importUsers'])->name('users.import');
        Route::get('users/export', [\App\Http\Controllers\Admin\DataImportExportController::class, 'exportUsers'])->name('users.export');
        
        Route::post('teachers/import', [\App\Http\Controllers\Admin\DataImportExportController::class, 'importTeachers'])->name('teachers.import');
        Route::get('teachers/export', [\App\Http\Controllers\Admin\DataImportExportController::class, 'exportTeachers'])->name('teachers.export');
        
        Route::post('students/import', [\App\Http\Controllers\Admin\DataImportExportController::class, 'importStudents'])->name('students.import');
        Route::get('students/export', [\App\Http\Controllers\Admin\DataImportExportController::class, 'exportStudents'])->name('students.export');

        // Subjects
        Route::resource('subjects', SubjectController::class)
            ->except(['create']);

        // Academic Years
        Route::resource('academic-years', AcademicYearController::class)
            ->except(['create']);

        // Semesters
        Route::resource('semesters', SemesterController::class)
            ->except(['create']);

        // Schedules
        Route::resource('schedules', ScheduleController::class)
            ->except(['create']);

        // Announcements
        Route::resource('announcements', AnnouncementController::class)
            ->except(['create']);

        // Teachers
        Route::resource('teachers', TeacherController::class);

        // Students
        Route::resource('students', StudentController::class);

        // Academic Classes
        Route::resource('academic-classes', AcademicClassController::class);
        // Rapor per siswa (printable)
        Route::get('reports/rapor/{student}', [\App\Http\Controllers\Admin\ReportController::class, 'studentRapor'])->name('reports.rapor');
        Route::get('reports/rapor/{student}/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'studentRaporPdf'])->name('reports.rapor.pdf');
    });

    Route::middleware('role:admin|guru-bk')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('warning-letters', \App\Http\Controllers\Admin\WarningLetterController::class)->except(['edit','update']);
        Route::get('warning-letters/{warningLetter}/pdf', [\App\Http\Controllers\Admin\WarningLetterController::class, 'pdf'])->name('warning-letters.pdf');
        Route::post('warning-letters/{warningLetter}/revoke', [\App\Http\Controllers\Admin\WarningLetterController::class, 'revoke'])->name('warning-letters.revoke');
        Route::resource('counselings', \App\Http\Controllers\Admin\CounselingController::class)->except(['show','edit','update']);
    });

Route::middleware('role:guru-bk')->prefix('bk')->name('bk.')->group(function () {
        Route::get('dashboard', [BKDashboardController::class, 'index'])->name('dashboard');

        // Counseling (Pembinaan)
        Route::get('counselings', [\App\Http\Controllers\BK\CounselingController::class, 'index'])->name('counselings.index');
        Route::get('counselings/create', [\App\Http\Controllers\BK\CounselingController::class, 'create'])->name('counselings.create');
        Route::post('counselings', [\App\Http\Controllers\BK\CounselingController::class, 'store'])->name('counselings.store');
        Route::get('counselings/{counseling}/edit', [\App\Http\Controllers\BK\CounselingController::class, 'edit'])->name('counselings.edit');
        Route::put('counselings/{counseling}', [\App\Http\Controllers\BK\CounselingController::class, 'update'])->name('counselings.update');
        Route::delete('counselings/{counseling}', [\App\Http\Controllers\BK\CounselingController::class, 'destroy'])->name('counselings.destroy');

        // Monitoring Alpha
        Route::get('monitoring/alpha', [\App\Http\Controllers\BK\MonitoringController::class, 'alpha'])->name('monitoring.alpha');
        Route::patch('monitoring/{student}/status', [\App\Http\Controllers\BK\MonitoringController::class, 'updateStatus'])->name('monitoring.update-status');

        // Warning Letters (SP)
        Route::get('warning-letters', [\App\Http\Controllers\BK\WarningLetterController::class, 'index'])->name('warning-letters.index');
        Route::get('warning-letters/create', [\App\Http\Controllers\BK\WarningLetterController::class, 'create'])->name('warning-letters.create');
        Route::post('warning-letters', [\App\Http\Controllers\BK\WarningLetterController::class, 'store'])->name('warning-letters.store');
        Route::get('warning-letters/{warningLetter}', [\App\Http\Controllers\BK\WarningLetterController::class, 'show'])->name('warning-letters.show');
        Route::patch('warning-letters/{warningLetter}/revoke', [\App\Http\Controllers\BK\WarningLetterController::class, 'revoke'])->name('warning-letters.revoke');
        Route::get('warning-letters/{warningLetter}/pdf', [\App\Http\Controllers\BK\WarningLetterController::class, 'downloadPdf'])->name('warning-letters.download-pdf');
    });

    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('classes', [ClassController::class, 'classes'])->name('classes.index');
        Route::post('classes', [ClassController::class, 'storeClass'])->name('classes.store');
        Route::put('classes/{id}', [ClassController::class, 'updateClass'])->name('classes.update');
        Route::delete('classes/{id}', [ClassController::class, 'destroyClass'])->name('classes.destroy');
        Route::post('classes/{id}/regenerate-token', [ClassController::class, 'regenerateToken'])->name('classes.regenerate-token');

        Route::get('grades', [GradeController::class, 'grades'])->name('grades.index');
        Route::post('grades', [GradeController::class, 'storeGrade'])->name('grades.store');
        Route::put('grades/{id}', [GradeController::class, 'updateGrade'])->name('grades.update');
        Route::delete('grades/{id}', [GradeController::class, 'destroyGrade'])->name('grades.destroy');
        Route::get('schedule', [TeacherAcademicController::class, 'schedule'])->name('schedule.index');
        Route::get('attendance', [TeacherAcademicController::class, 'attendance'])->name('attendance.index');
        
        // New features for Guru
        Route::get('subjects', [TeacherAcademicController::class, 'subjects'])->name('subjects.index');
        Route::get('warning-letters', [TeacherAcademicController::class, 'warningLetters'])->name('warning-letters.index');
        Route::get('warning-letters/create', [TeacherAcademicController::class, 'createWarningLetter'])->name('warning-letters.create');
        Route::post('warning-letters', [TeacherAcademicController::class, 'storeWarningLetter'])->name('warning-letters.store');
        Route::get('students', [TeacherAcademicController::class, 'students'])->name('students.index');
        Route::get('report-cards', [TeacherAcademicController::class, 'reportCards'])->name('report-cards.index');
        Route::get('report-cards/{student}/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'studentRaporPdf'])->name('report-cards.pdf');
    });

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::middleware(['role:student','student'])->prefix('student')->name('student.')->group(function () {
        Route::get('classes', [StudentAcademicController::class, 'classes'])->name('classes.index');
        Route::get('classes/{id}', [StudentAcademicController::class, 'showClass'])->name('classes.show');
        Route::get('records', [StudentAcademicController::class, 'records'])->name('records.index');
        Route::get('join-class', [StudentAcademicController::class, 'joinClassForm'])->name('join-class');
        Route::post('join-class', [StudentAcademicController::class, 'processJoinClass'])->name('join-class.process');
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
        Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });
});

