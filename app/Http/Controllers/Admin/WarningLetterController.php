<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WarningLetter;
use App\Models\Student;
use App\Exceptions\WarningLetterException;
use App\Services\WarningLetterService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WarningLetterController extends Controller
{
    public function __construct(private WarningLetterService $service)
    {
    }

    public function index()
    {
        $letters = WarningLetter::with('student.user')->latest()->paginate(20);
        return view('admin.warning-letters.index', compact('letters'));
    }

    public function create()
    {
        $students = Student::with('user')->orderBy('student_number')->get();
        $academicClasses = \App\Models\AcademicClass::orderBy('name')->get();
        return view('admin.warning-letters.create', compact('students', 'academicClasses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_name' => 'nullable|string',
            'student_id' => 'nullable|exists:students,id',
            'academic_class_id' => 'nullable|exists:academic_classes,id',
            'type' => 'required|in:SP1,SP2,SP3',
            'reason' => 'nullable|string',
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
            $this->service->issueWarningLetter(
                $student,
                (int) str_replace('SP', '', $data['type']),
                $data['reason'] ?? '',
                $request->user(),
            );
        } catch (WarningLetterException $exception) {
            return back()->withInput()->withErrors(['type' => $exception->getMessage()]);
        }

        return redirect()->route('admin.warning-letters.index')->with('success', 'Warning letter created.');
    }

    public function show(WarningLetter $warningLetter)
    {
        return view('admin.warning-letters.show', ['letter' => $warningLetter->load('student','issuer')]);
    }

    public function pdf(WarningLetter $warningLetter): BinaryFileResponse
    {
        return response()->download(
            $this->service->generateSpPdf($warningLetter),
            'sp_' . $warningLetter->id . '.pdf'
        );
    }

    public function revoke(Request $request, WarningLetter $warningLetter): RedirectResponse
    {
        $data = $request->validate([
            'reason' => 'required|string|max:2000',
        ]);

        if (! $this->service->revokeWarningLetter($warningLetter, $data['reason'])) {
            return back()->withErrors(['reason' => 'Surat peringatan ini sudah dicabut.']);
        }

        return redirect()->route('admin.warning-letters.index')->with('success', 'Warning letter revoked.');
    }

    public function destroy(WarningLetter $warningLetter)
    {
        WarningLetter::destroy($warningLetter->id);
        return redirect()->route('admin.warning-letters.index')->with('success', 'Deleted.');
    }
}
