<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use App\Models\Teacher;
use App\Services\SubjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(SubjectService $service): View
    {
        $this->authorize('viewAny', Subject::class);

        $subjects = $service->all();
        $teachers = Teacher::with('user')->orderBy('id')->get();

        return view('admin.subjects', compact('subjects', 'teachers'));
    }

    public function show(Subject $subject): View
    {
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject): View
    {
        $teachers = Teacher::query()->with('user')->orderBy('id', 'asc')->get();

        return view('admin.subjects.edit', compact('subject', 'teachers'));
    }

    public function store(StoreSubjectRequest $request, SubjectService $service): RedirectResponse
    {
        $this->authorize('create', Subject::class);

        $service->create($request->validated());

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(UpdateSubjectRequest $request, Subject $subject, SubjectService $service): RedirectResponse
    {
        $this->authorize('update', $subject);

        $service->update($subject, $request->validated());

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $this->authorize('delete', $subject);

        Subject::destroy($subject->id);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
