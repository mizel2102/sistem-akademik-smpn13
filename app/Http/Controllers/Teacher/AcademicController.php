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
            $classIds = \App\Models\AcademicClass::whereHas('schedules', fn($q) => $q->where('teacher_id', $teacher->id))
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
                ->map(function ($student) {
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
        $primarySubject = $teacher ? $teacher->subject : null;

        $classes = $teacher ? $this->service->getClassesForTeacher($teacher) : collect();
        $allSubjects = \App\Models\Subject::orderBy('name', 'asc')->get();

        return view('teacher.subjects', compact('primarySubject', 'classes', 'allSubjects'));
    }

    public function warningLetters(): View
    {
        $teacher = Auth::user()->teacher;
        $warningLetters = collect();
        if ($teacher) {
            $classIds = \App\Models\AcademicClass::whereHas('schedules', fn($q) => $q->where('teacher_id', $teacher->id))
                ->orWhere('teacher_id', $teacher->id)
                ->pluck('id');
            $studentIds = \App\Models\Student::query()->whereIn('academic_class_id', $classIds, 'and', false)->pluck('id');
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

        /** @disregard P1005 */
        $student = \App\Models\Student::where('student_number', $data['student_number'])
            ->orWhere('nis', $data['student_number'])
            ->first();

        if (!$student) {
            return back()->withInput()->withErrors(['student_number' => 'Siswa dengan NISN tersebut tidak ditemukan.']);
        }

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
        $classes = $teacher ? $this->service->getClassesForTeacher($teacher) : collect();

        if ($classes->isEmpty()) {
            $classes = \App\Models\AcademicClass::orderBy('name', 'asc')->get();
        }

        $classIds = $classes->pluck('id')->all();

        // Extract grade levels taught by this teacher (e.g., IX/9, VIII/8, VII/7)
        $gradeLevels = [];
        foreach ($classes as $c) {
            if (preg_match('/(IX|VIII|VII|9|8|7)/i', $c->name, $matches)) {
                $rawGrade = strtoupper($matches[1]);
                $gradeLevels[] = $rawGrade;
                if ($rawGrade === 'IX') $gradeLevels[] = '9';
                if ($rawGrade === '9') $gradeLevels[] = 'IX';
                if ($rawGrade === 'VIII') $gradeLevels[] = '8';
                if ($rawGrade === '8') $gradeLevels[] = 'VIII';
                if ($rawGrade === 'VII') $gradeLevels[] = '7';
                if ($rawGrade === '7') $gradeLevels[] = 'VII';
            }
        }
        $gradeLevels = array_unique($gradeLevels);

        $query = \App\Models\Student::with(['user', 'academicClass', 'classes']);

        // Filter by specific class if selected in dropdown
        if (request()->filled('class_id')) {
            $filterClassId = (int) request('class_id');
            $query->where(function ($q) use ($filterClassId) {
                $q->where('academic_class_id', $filterClassId)
                    ->orWhereHas('classes', fn($sub) => $sub->where('academic_classes.id', $filterClassId));
            });
        } else {
            // Strictly filter by teacher's classes
            $query->where(function ($q) use ($classIds) {
                if (! empty($classIds)) {
                    $q->whereIn('academic_class_id', $classIds)
                        ->orWhereHas('classes', fn($sub) => $sub->whereIn('academic_classes.id', $classIds));
                } else {
                    $q->whereRaw('1 = 0');
                }
            });
        }

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $students = $query->orderBy('student_number')->paginate(20)->withQueryString();

        return view('teacher.students', compact('students', 'classes'));
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
