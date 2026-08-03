<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\StoreGradeRequest;
use App\Models\AcademicClass;
use App\Services\TeacherAcademicService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AcademicController extends Controller
{
    public function __construct(protected TeacherAcademicService $service)
    {
        $this->middleware('role:teacher');
        $this->authorizeResource(AcademicClass::class, 'academic_class');
    }

    public function classes(): View
    {
        $teacher = Auth::user()->teacher;
        $classes = $teacher ? $this->service->getClassesForTeacher($teacher) : [];

        return view('teacher.classes', compact('classes'));
    }

    public function storeClass(StoreClassRequest $request): RedirectResponse
    {
        $this->authorize('create', AcademicClass::class);

        $teacher = Auth::user()->teacher;
        if (! $teacher) {
            return redirect()->back()->withErrors(['teacher' => 'Teacher profile not found.']);
        }

        $this->service->createClassForTeacher($teacher, $request->validated());

        return redirect()->route('teacher.classes.index')->with('success', 'Class created.');
    }

    public function destroyClass(string $id): RedirectResponse
    {
        $teacher = Auth::user()->teacher;

        if ($teacher) {
            $this->service->deleteClassForTeacher($teacher, (int) $id);
        }

        return redirect()->route('teacher.classes.index');
    }

    public function schedule(): View
    {
        $teacher = Auth::user()->teacher;
        $schedules = $teacher ? $this->service->getScheduleForTeacher($teacher) : collect();

        return view('teacher.schedule', compact('schedules'));
    }

    public function attendance(): View
    {
        $teacher = Auth::user()->teacher;
        $attendances = collect();
        $studentStats = collect();

        if ($teacher) {
            $classIds = \App\Models\AcademicClass::whereHas('schedules', fn ($q) => $q->where('teacher_id', $teacher->id))
                ->orWhere('teacher_id', $teacher->id)
                ->pluck('id');

            $attendances = \App\Models\Attendance::with(['student.user', 'academicClass'])
                ->whereIn('academic_class_id', $classIds)
                ->latest('attendance_time')
                ->paginate(15, ['*'], 'attendance_page');

            $studentStats = \App\Models\Student::with(['user', 'academicClass'])
                ->whereIn('academic_class_id', $classIds)
                ->withCount([
                    'attendances as present_count' => fn($q) => $q->where('status', 'present'),
                    'attendances as late_count' => fn($q) => $q->where('status', 'late'),
                    'attendances as sick_count' => fn($q) => $q->where('status', 'sick'),
                    'attendances as permission_count' => fn($q) => $q->where('status', 'permission'),
                    'attendances as alpha_count' => fn($q) => $q->where('status', 'alpha'),
                ])
                ->get()
                ->map(function($student) {
                    $recSp = null;
                    if ($student->alpha_count >= 9) {
                        $recSp = 'SP3';
                    } elseif ($student->alpha_count >= 6) {
                        $recSp = 'SP2';
                    } elseif ($student->alpha_count >= 3) {
                        $recSp = 'SP1';
                    }
                    $student->rec_sp = $recSp;
                    return $student;
                });
        }

        return view('teacher.attendance', compact('attendances', 'studentStats'));
    }

    public function subjects(): View
    {
        $teacher = Auth::user()->teacher;
        $subject = $teacher ? $teacher->subject : null;
        return view('teacher.subjects', compact('subject'));
    }

    public function warningLetters(): View
    {
        $teacher = Auth::user()->teacher;
        $warningLetters = collect();
        if ($teacher) {
            // Get warning letters for students in teacher's classes (schedule-based)
            $classIds = \App\Models\AcademicClass::whereHas('schedules', fn ($q) => $q->where('teacher_id', $teacher->id))
                ->orWhere('teacher_id', $teacher->id)
                ->pluck('id');
            $studentIds = \App\Models\Student::whereIn('academic_class_id', $classIds)->pluck('id');
            $warningLetters = \App\Models\WarningLetter::with(['student.user'])
                ->whereIn('student_id', $studentIds)
                ->latest()
                ->paginate(20);
        }
        return view('teacher.warning-letters', compact('warningLetters'));
    }

    public function createWarningLetter(\Illuminate\Http\Request $request): View
    {
        $teacher = Auth::user()->teacher;
        $students = [];
        if ($teacher) {
            $students = $this->service->getStudentOptionsForTeacher($teacher);
        }

        $prefill = [
            'name' => $request->query('name'),
            'class' => $request->query('class'),
            'nisn' => $request->query('nisn'),
            'type' => $request->query('type'),
        ];

        return view('teacher.warning-letters-create', compact('students', 'prefill'));
    }

    public function storeWarningLetter(\Illuminate\Http\Request $request): RedirectResponse
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            abort(403);
        }

        $data = $request->validate([
            'student_name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
            'student_number' => 'required|string|max:255',
            'type' => 'required|in:SP1,SP2,SP3',
            'reason' => 'required|string|max:2000',
        ]);

        // Find the student by NISN (student_number) or NIS
        $student = \App\Models\Student::where('student_number', $data['student_number'])
            ->orWhere('nis', $data['student_number'])
            ->first();

        if (!$student) {
            return back()->withInput()->withErrors(['student_number' => 'Siswa dengan NISN tersebut tidak ditemukan.']);
        }

        // Verify the student is enrolled in one of the classes taught by the teacher
        $teacherStudents = $this->service->getStudentOptionsForTeacher($teacher);
        $enrolledIds = collect($teacherStudents)->pluck('id')->all();

        if (! in_array($student->id, $enrolledIds)) {
            return back()->withInput()->withErrors(['student_number' => 'Siswa tidak terdaftar di kelas Anda.']);
        }

        $level = (int) str_replace('SP', '', $data['type']);
        $warningLetterService = app(\App\Services\WarningLetterService::class);

        try {
            $warningLetterService->issueWarningLetter(
                $student,
                $level,
                $data['reason'],
                Auth::user()
            );
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['type' => $e->getMessage()]);
        }

        return redirect()->route('teacher.warning-letters.index')
            ->with('success', 'Surat pernyataan/peringatan berhasil diterbitkan.');
    }

    public function students(): View
    {
        $teacher = Auth::user()->teacher;
        $students = collect();
        if ($teacher) {
            $classIds = $this->service->getClassesForTeacher($teacher)->pluck('id');
            $students = \App\Models\Student::with(['user', 'academicClass'])
                ->whereIn('academic_class_id', $classIds)
                ->paginate(20);
        }
        return view('teacher.students', compact('students'));
    }

    public function reportCards(): View
    {
        $teacher = Auth::user()->teacher;
        $students = collect();
        if ($teacher) {
            $classIds = $this->service->getClassesForTeacher($teacher)->pluck('id');
            $students = \App\Models\Student::with(['user', 'academicClass'])
                ->whereIn('academic_class_id', $classIds)
                ->paginate(20);
        }
        return view('teacher.report-cards', compact('students'));
    }
}
