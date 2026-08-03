<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Subject;
use App\Services\StudentAcademicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AcademicController extends Controller
{
    public function __construct(protected StudentAcademicService $service)
    {
        $this->middleware('role:student');
    }

    public function records(Request $request): View
    {
        $student = Auth::user()->student;

        $attendanceRate = $student ? $this->service->getAttendanceRateForStudent($student) : 'N/A';
        $records = $student ? $this->service->getRecordsForStudent($student) : [];

        $grades = $student
            ? $student->grades()
                ->with(['subject', 'semester'])
                ->when($request->filled('semester_id'), fn ($query) => $query->where('semester_id', $request->semester_id))
                ->when($request->filled('subject_id'), fn ($query) => $query->where('subject_id', $request->subject_id))
                ->get()
            : collect();

        $subjects = Subject::query()->orderBy('name', 'asc')->get();
        $semesters = Semester::query()->orderBy('name', 'asc')->get();

        return view('student.records', compact('records', 'attendanceRate', 'grades', 'subjects', 'semesters'));
    }

    public function schedule(): View
    {
        $student = Auth::user()->student;
        $schedules = $student ? $this->service->getScheduleForStudent($student) : collect();

        return view('student.schedule', compact('schedules'));
    }

    public function joinClassForm(): View
    {
        $student = Auth::user()->student;
        $myClasses = $student ? $this->service->getClassesForStudent($student) : collect();

        return view('student.join-class', compact('myClasses'));
    }

    public function processJoinClass(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string|max:20',
        ], [
            'access_token.required' => 'Token Akses Kelas wajib diisi.',
        ]);

        $student = Auth::user()->student;
        if (! $student) {
            return back()->withErrors(['access_token' => 'Profil siswa tidak ditemukan.']);
        }

        $token = strtoupper(trim($request->access_token));
        $class = \App\Models\AcademicClass::query()->where('access_token', '=', $token)->first();

        if (! $class) {
            return back()->withInput()->withErrors(['access_token' => 'Kode Token Akses Kelas tidak valid atau tidak ditemukan.']);
        }

        $classGradeLevel = \App\Services\TeacherAcademicService::extractGradeLevel($class->name);
        $studentGradeLevel = \App\Services\TeacherAcademicService::extractGradeLevel($student->grade_level ?? '') ?? $student->grade_level;

        if ($classGradeLevel && $studentGradeLevel && $classGradeLevel !== $studentGradeLevel) {
            return back()->withInput()->withErrors(['access_token' => "Kelas '{$class->name}' ini khusus untuk tingkat kelas {$classGradeLevel}. Anda terdaftar pada tingkat kelas {$studentGradeLevel}."]);
        }

        if ($student->classes()->where('academic_class_id', $class->id)->exists()) {
            return back()->withErrors(['access_token' => "Anda sudah terdaftar di kelas '{$class->name}'."]);
        }

        $student->classes()->attach($class->id);
        $student->fill(['academic_class_id' => $class->id])->save();

        return redirect()->route('student.join-class')->with('success', "Berhasil bergabung ke kelas '{$class->name}'!");
    }

    public function classes(): View
    {
        $student = Auth::user()->student;
        $myClasses = $student ? $this->service->getClassesForStudent($student) : collect();

        return view('student.classes.index', compact('myClasses'));
    }

    public function showClass(string $id): View
    {
        $student = Auth::user()->student;
        if (! $student) {
            abort(404, 'Student profile not found.');
        }

        $details = $this->service->getClassDetailsForStudent($student, (int) $id);

        return view('student.classes.show', $details);
    }
}
