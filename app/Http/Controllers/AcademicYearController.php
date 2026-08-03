<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcademicYearRequest;
use App\Http\Requests\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function index(AcademicYearService $service): View
    {
        $this->authorize('viewAny', AcademicYear::class);

        $years = $service->all();

        return view('admin.academic-years', compact('years'));
    }

    public function show(AcademicYear $academicYear): View
    {
        return view('admin.academic-years.show', compact('academicYear'));
    }

    public function edit(AcademicYear $academicYear): View
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    public function store(StoreAcademicYearRequest $request, AcademicYearService $service): RedirectResponse
    {
        $this->authorize('create', AcademicYear::class);

        $service->create($request->validated());

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun akademik berhasil ditambahkan.');
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear, AcademicYearService $service): RedirectResponse
    {
        $this->authorize('update', $academicYear);

        $service->update($academicYear, $request->validated());

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun akademik berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $this->authorize('delete', $academicYear);

        AcademicYear::destroy($academicYear->id);

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun akademik berhasil dihapus.');
    }
}
