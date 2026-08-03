<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcademicClassRequest;
use App\Http\Requests\UpdateAcademicClassRequest;
use App\Models\AcademicClass;
use App\Models\Teacher;
use App\Services\AcademicClassService;

class AcademicClassController extends Controller
{
    public function __construct(protected AcademicClassService $service)
    {
        $this->authorizeResource(AcademicClass::class, 'academic_class');
    }

    public function index()
    {
        $classes = $this->service->all();
        $teachers = Teacher::with('user')->orderBy('id')->get();

        return view('admin.academic-classes', compact('classes', 'teachers'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->orderBy('id')->get();

        return view('admin.academic-classes.create', compact('teachers'));
    }

    public function store(StoreAcademicClassRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('admin.academic-classes.index')
            ->with('success', 'Academic class has been created successfully.');
    }

    public function show(AcademicClass $academicClass)
    {
        return view('admin.academic-classes.show', compact('academicClass'));
    }

    public function edit(AcademicClass $academicClass)
    {
        $teachers = Teacher::with('user')->orderBy('id')->get();

        return view('admin.academic-classes.edit', compact('academicClass', 'teachers'));
    }

    public function update(UpdateAcademicClassRequest $request, AcademicClass $academicClass)
    {
        $this->service->update($academicClass, $request->validated());

        return redirect()->route('admin.academic-classes.index')
            ->with('success', 'Academic class has been updated successfully.');
    }

    public function destroy(AcademicClass $academicClass)
    {
        $this->service->delete($academicClass);

        return redirect()->route('admin.academic-classes.index')
            ->with('success', 'Academic class has been deleted successfully.');
    }
}
