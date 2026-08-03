<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Services\SemesterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function index(SemesterService $service): View
    {
        $this->authorize('viewAny', Semester::class);

        $semesters = $service->all();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('admin.semesters', compact('semesters', 'academicYears'));
    }

    public function show(Semester $semester): View
    {
        return view('admin.semesters.show', compact('semester'));
    }

    public function edit(Semester $semester): View
    {
        $academicYears = AcademicYear::query()->orderByDesc('start_date')->get();

        return view('admin.semesters.edit', compact('semester', 'academicYears'));
    }

    public function store(StoreSemesterRequest $request, SemesterService $service): RedirectResponse
    {
        $this->authorize('create', Semester::class);

        $service->create($request->validated());

        return redirect()->route('admin.semesters.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    public function update(UpdateSemesterRequest $request, Semester $semester, SemesterService $service): RedirectResponse
    {
        $this->authorize('update', $semester);

        $service->update($semester, $request->validated());

        return redirect()->route('admin.semesters.index')->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        $this->authorize('delete', $semester);

        Semester::destroy($semester->id);

        return redirect()->route('admin.semesters.index')->with('success', 'Semester berhasil dihapus.');
    }
}
