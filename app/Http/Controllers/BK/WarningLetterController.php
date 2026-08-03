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

        $semester = Semester::active();

        return view('bk.warning-letters.create', compact('students', 'semester'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:SP1,SP2,SP3',
            'reason' => 'nullable|string|max:2000',
            'issued_at' => 'nullable|date',
        ]);

        try {
            $this->warningLetterService->issueWarningLetter(
                Student::findOrFail($data['student_id']),
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
