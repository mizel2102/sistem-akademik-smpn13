<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRequest;
use App\Models\AcademicClass;
use App\Services\TeacherAcademicService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function __construct(protected TeacherAcademicService $service)
    {
        $this->middleware('role:teacher');
        $this->authorizeResource(AcademicClass::class, 'academic_class');
    }

    public function classes(): View
    {
        $teacher = Auth::user()->teacher;
        $classes = $teacher ? $this->service->getClassesForTeacher($teacher) : [];

        return view('teacher.classes', compact('classes'));
    }

    public function storeClass(StoreClassRequest $request): RedirectResponse
    {
        $this->authorize('create', AcademicClass::class);

        $teacher = Auth::user()->teacher;
        if (! $teacher) {
            return redirect()->back()->withErrors(['teacher' => 'Profil guru tidak ditemukan.']);
        }

        $class = $this->service->createClassForTeacher($teacher, $request->validated());

        return redirect()->route('teacher.classes.index')->with('success', "Kelas '{$class->name}' berhasil dibuat dengan Token: {$class->access_token}");
    }

    public function updateClass(StoreClassRequest $request, string $id): RedirectResponse
    {
        $teacher = Auth::user()->teacher;
        if (! $teacher) {
            return redirect()->back()->withErrors(['teacher' => 'Profil guru tidak ditemukan.']);
        }

        try {
            $class = $this->service->updateClassForTeacher($teacher, (int) $id, $request->validated());
            return redirect()->route('teacher.classes.index')->with('success', "Data kelas '{$class->name}' berhasil diperbarui.");
        } catch (\RuntimeException $e) {
            return redirect()->back()->withErrors(['class' => $e->getMessage()]);
        }
    }

    public function destroyClass(string $id): RedirectResponse
    {
        $teacher = Auth::user()->teacher;

        if ($teacher) {
            $success = $this->service->deleteClassForTeacher($teacher, (int) $id);
            if ($success) {
                return redirect()->route('teacher.classes.index')->with('success', 'Kelas berhasil dihapus.');
            }
        }

        return redirect()->route('teacher.classes.index')->withErrors(['class' => 'Gagal menghapus kelas. Anda hanya dapat menghapus kelas yang Anda buat.']);
    }

    public function regenerateToken(string $id): RedirectResponse
    {
        $teacher = Auth::user()->teacher;

        if ($teacher) {
            $newToken = $this->service->regenerateTokenForTeacher($teacher, (int) $id);
            if ($newToken) {
                return redirect()->route('teacher.classes.index')->with('success', "Kode Token Akses diperbarui: {$newToken}");
            }
        }

        return redirect()->route('teacher.classes.index')->withErrors(['class' => 'Gagal memperbarui token kelas.']);
    }
}
