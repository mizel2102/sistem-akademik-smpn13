<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counseling;
use App\Models\Student;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function index(Request $request)
    {
        $query = Counseling::with('student.user','counselor')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->whereHas('student.user', function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%");
            });
        }

        $counselings = $query->paginate(20);

        return view('admin.counselings.index', compact('counselings'));
    }

    public function create()
    {
        $students = Student::with('user')->orderBy('student_number')->get();
        return view('admin.counselings.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'notes' => 'nullable|string',
            'follow_up' => 'nullable|string',
            'session_at' => 'nullable|date',
        ]);

        $data['counselor_id'] = $request->user()->id;
        Counseling::create($data);

        return redirect()->route('admin.counselings.index')->with('success', 'Counseling record created.');
    }

    public function destroy(Counseling $counseling)
    {
        Counseling::destroy($counseling->id);
        return redirect()->route('admin.counselings.index')->with('success', 'Deleted.');
    }
}
