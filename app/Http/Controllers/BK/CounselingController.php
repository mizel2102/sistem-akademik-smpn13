<?php

namespace App\Http\Controllers\BK;

use App\Http\Requests\StoreCounselingRequest;
use App\Http\Controllers\Controller;
use App\Models\Counseling;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CounselingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Counseling::with('student.user', 'counselor')->latest('session_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student.user', function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $counselings = $query->paginate(20);

        return view('bk.counselings.index', compact('counselings'));
    }

    public function create(): View
    {
        $students = Student::with('user')
            ->whereHas('user')
            ->orderBy('student_number')
            ->get();

        return view('bk.counselings.create', compact('students'));
    }

    public function store(StoreCounselingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['counselor_id'] = $request->user()->id;

        Counseling::create($data);

        return redirect()->route('bk.counselings.index')
            ->with('success', 'Data pembinaan berhasil disimpan.');
    }

    public function edit(Counseling $counseling): View
    {
        $students = Student::with('user')
            ->whereHas('user')
            ->orderBy('student_number')
            ->get();

        return view('bk.counselings.edit', compact('counseling', 'students'));
    }

    public function update(StoreCounselingRequest $request, Counseling $counseling): RedirectResponse
    {
        $counseling->fill($request->validated())->save();

        return redirect()->route('bk.counselings.index')
            ->with('success', 'Data pembinaan berhasil diperbarui.');
    }

    public function destroy(Counseling $counseling): RedirectResponse
    {
        Counseling::destroy($counseling->id);

        return redirect()->route('bk.counselings.index')
            ->with('success', 'Data pembinaan berhasil dihapus.');
    }
}
