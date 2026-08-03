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
        return view('admin.warning-letters.create', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:SP1,SP2,SP3',
            'reason' => 'nullable|string',
            'issued_at' => 'nullable|date',
        ]);

        try {
            $this->service->issueWarningLetter(
                Student::findOrFail($data['student_id']),
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
