<?php

namespace App\Http\Controllers\BK;

use App\Exceptions\WarningLetterException;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Student;
use App\Models\WarningLetter;
use App\Services\WarningLetterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WarningLetterController extends Controller
{
    public function __construct(
        private WarningLetterService $warningLetterService,
    ) {
    }

    public function index(Request $request): View
    {
        $query = WarningLetter::with('student.user', 'issuer')->latest('issued_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student.user', function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->whereNull('resolved_at');
            } elseif ($request->input('status') === 'revoked') {
                $query->whereNotNull('resolved_at');
            }
        }

        $letters = $query->paginate(20);

        return view('bk.warning-letters.index', compact('letters'));
    }

    public function create(): View
    {
        $students = Student::with('user')
            ->whereHas('user')
            ->withCount(['attendances as alpha_count' => function ($q): void {
                $q->where('status', 'alpha');
            }])
            ->orderByDesc('alpha_count')
            ->get();

        $academicClasses = \App\Models\AcademicClass::orderBy('name')->get();
        $semester = Semester::active();

        return view('bk.warning-letters.create', compact('students', 'academicClasses', 'semester'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_name' => 'nullable|string',
            'student_id' => 'nullable|exists:students,id',
            'academic_class_id' => 'nullable|exists:academic_classes,id',
            'type' => 'required|in:SP1,SP2,SP3',
            'reason' => 'nullable|string|max:2000',
            'issued_at' => 'nullable|date',
        ]);

        $student = null;
        if (! empty($data['student_id'])) {
            $student = Student::find($data['student_id']);
        }

        if (! $student && ! empty($data['student_name'])) {
            $search = trim($data['student_name']);
            $student = Student::where('student_number', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->first();

            if (! $student) {
                $user = \App\Models\User::create([
                    'name' => $search,
                    'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $search)) . rand(100, 999) . '@siswa.smpn13.sch.id',
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                ]);
                $user->assignRole('student');
                $student = Student::create([
                    'user_id' => $user->id,
                    'student_number' => 'NIS-' . rand(10000, 99999),
                    'grade_level' => '7',
                ]);
            }
        }

        if (! $student) {
            return back()->withInput()->withErrors(['student_name' => 'Siswa tidak ditemukan. Silakan ketik Nama Siswa atau NIS yang valid.']);
        }

        if (! empty($data['academic_class_id'])) {
            $student->classes()->syncWithoutDetaching([$data['academic_class_id']]);
        }

        try {
            $this->warningLetterService->issueWarningLetter(
                $student,
                (int) str_replace('SP', '', $data['type']),
                $data['reason'] ?? '',
                $request->user(),
            );
        } catch (WarningLetterException $e) {
            return back()->withInput()->withErrors(['type' => $e->getMessage()]);
        }

        return redirect()->route('bk.warning-letters.index')
            ->with('success', 'Surat peringatan berhasil diterbitkan.');
    }

    public function show(WarningLetter $warningLetter): View
    {
        $warningLetter->loadMissing('student.user', 'issuer');

        return view('bk.warning-letters.show', ['letter' => $warningLetter]);
    }

    public function revoke(Request $request, WarningLetter $warningLetter): RedirectResponse
    {
        $data = $request->validate([
            'reason' => 'required|string|max:2000',
        ]);

        if (! $this->warningLetterService->revokeWarningLetter($warningLetter, $data['reason'])) {
            return back()->withErrors(['reason' => 'Surat peringatan ini sudah dicabut.']);
        }

        return redirect()->route('bk.warning-letters.index')
            ->with('success', 'Surat peringatan berhasil dicabut.');
    }

    public function downloadPdf(WarningLetter $warningLetter): BinaryFileResponse
    {
        return response()->download(
            $this->warningLetterService->generateSpPdf($warningLetter),
            'sp_' . $warningLetter->id . '.pdf'
        );
    }
}
