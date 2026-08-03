<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\AcademicClass;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class StudentController extends Controller
{
    public function __construct(protected StudentService $service)
    {
        $this->authorizeResource(Student::class, 'student');
    }

    public function index()
    {
        $students = Student::with(['user', 'academicClass'])
            ->orderBy('id')
            ->paginate(15);
        $users = User::query()->whereDoesntHave('student')->orderBy('name', 'asc')->get();
        $classes = AcademicClass::query()->orderBy('name', 'asc')->get();

        return view('admin.students', compact('students', 'users', 'classes'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('student')
            ->orWhere('id', Auth::id())
            ->orderBy('name')
            ->get();

        $classes = AcademicClass::query()->orderBy('name', 'asc')->get();

        return view('admin.students.create', compact('users', 'classes'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = $this->service->create($request->validated());

        $user = User::query()->find($request->user_id);
        if ($user) {
            $studentRole = Role::findOrCreate('student', 'web');
            $user->assignRole($studentRole);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student has been created successfully.');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $users = User::whereDoesntHave('student')
            ->orWhere('id', $student->user_id)
            ->orderBy('name')
            ->get();

        $classes = AcademicClass::query()->orderBy('name', 'asc')->get();

        return view('admin.students.edit', compact('student', 'users', 'classes'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $this->service->update($student, $request->validated());

        return redirect()->route('admin.students.index')
            ->with('success', 'Student has been updated successfully.');
    }

    public function destroy(Student $student)
    {
        $this->service->delete($student);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student has been deleted successfully.');
    }
}
