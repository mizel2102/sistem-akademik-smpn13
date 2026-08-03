<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function __construct(protected TeacherService $service)
    {
        $this->authorizeResource(Teacher::class, 'teacher');
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $query = Teacher::with(['user', 'subject', 'classes']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('subject') && ! $request->filled('search')) {
            $query->where('subject_id', '=', $request->input('subject'));
        }

        $teachers = $query->orderBy('id')->paginate(15)->withQueryString();
        $users = User::query()->whereDoesntHave('teacher')->orderBy('name', 'asc')->get();
        $subjects = Subject::query()->orderBy('name', 'asc')->get();

        return view('admin.teachers', compact('teachers', 'users', 'subjects'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('teacher')
            ->orWhere('id', Auth::id())
            ->orderBy('name')
            ->get();

        $subjects = Subject::query()->orderBy('name', 'asc')->get();

        return view('admin.teachers.create', compact('users', 'subjects'));
    }

    public function store(StoreTeacherRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher has been created successfully.');
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $users = User::whereDoesntHave('teacher')
            ->orWhere('id', $teacher->user_id)
            ->orderBy('name')
            ->get();

        $subjects = Subject::query()->orderBy('name', 'asc')->get();

        return view('admin.teachers.edit', compact('teacher', 'users', 'subjects'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $this->service->update($teacher, $request->validated());

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher has been updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $this->service->delete($teacher);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher has been deleted successfully.');
    }
}
