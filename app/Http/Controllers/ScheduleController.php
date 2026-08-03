<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\AcademicClass;
use App\Models\AcademicYear;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Services\ScheduleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(ScheduleService $service): View
    {
        $this->authorize('viewAny', Schedule::class);

        $schedules = $service->all();
        $classes = AcademicClass::query()->orderBy('name', 'asc')->get();
        $academicYears = AcademicYear::query()->orderByDesc('start_date')->get();
        $semesters = Semester::query()->orderBy('name', 'asc')->get();
        $subjects = Subject::query()->with('teacher.user')->orderBy('name', 'asc')->get();
        $teachers = Teacher::query()->with('user')->orderBy('id', 'asc')->get();

        return view('admin.schedules', compact('schedules', 'classes', 'academicYears', 'semesters', 'subjects', 'teachers'));
    }

    public function show(Schedule $schedule): View
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule): View
    {
        $classes = AcademicClass::query()->orderBy('name', 'asc')->get();
        $academicYears = AcademicYear::query()->orderByDesc('start_date')->get();
        $semesters = Semester::query()->orderBy('name', 'asc')->get();
        $subjects = Subject::query()->orderBy('name', 'asc')->get();
        $teachers = Teacher::query()->with('user')->orderBy('id', 'asc')->get();

        return view('admin.schedules.edit', compact('schedule', 'classes', 'academicYears', 'semesters', 'subjects', 'teachers'));
    }

    public function store(StoreScheduleRequest $request, ScheduleService $service): RedirectResponse
    {
        $this->authorize('create', Schedule::class);

        $service->create($request->validated());

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule, ScheduleService $service): RedirectResponse
    {
        $this->authorize('update', $schedule);

        $service->update($schedule, $request->validated());

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $this->authorize('delete', $schedule);

        Schedule::destroy($schedule->id);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
