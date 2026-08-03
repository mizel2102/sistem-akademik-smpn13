<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Grade;
use App\Services\TeacherAcademicService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GradeController extends Controller
{
    public function __construct(protected TeacherAcademicService $service)
    {
        $this->middleware('role:teacher');
    }

    public function grades(): View
    {
        $teacher = Auth::user()->teacher;

        $gradebook = $teacher ? $this->service->getGradebookForTeacher($teacher) : [];
        $classes = $teacher ? $this->service->getClassesForTeacher($teacher) : collect();
        $studentOptions = $teacher ? $this->service->getStudentOptionsForTeacher($teacher) : [];

        return view('teacher.grades', compact('gradebook', 'classes', 'studentOptions'));
    }

    public function storeGrade(StoreGradeRequest $request): RedirectResponse
    {
        $this->authorize('create', Grade::class);

        $teacher = Auth::user()->teacher;
        if (! $teacher) {
            return redirect()->back()->withErrors(['teacher' => 'Teacher profile not found.']);
        }

        try {
            $this->service->createGradeForTeacher($teacher, $request->validated());
        } catch (\RuntimeException $exception) {
            return redirect()->back()->withErrors(['grade' => $exception->getMessage()]);
        }

        return redirect()->route('teacher.grades.index')->with('success', 'Grade recorded.');
    }

    public function destroyGrade(string $id): RedirectResponse
    {
        $teacher = Auth::user()->teacher;

        if ($teacher) {
            $this->service->deleteGradeForTeacher($teacher, (int) $id);
        }

        return redirect()->route('teacher.grades.index');
    }

    public function updateGrade(StoreGradeRequest $request, string $id): RedirectResponse
    {
        $teacher = Auth::user()->teacher;
        if (! $teacher) {
            return redirect()->back()->withErrors(['teacher' => 'Teacher profile not found.']);
        }

        try {
            $this->service->updateGradeForTeacher($teacher, (int) $id, $request->validated());
        } catch (\RuntimeException $exception) {
            return redirect()->back()->withErrors(['grade' => $exception->getMessage()]);
        }

        return redirect()->route('teacher.grades.index')->with('success', 'Grade updated.');
    }
}
