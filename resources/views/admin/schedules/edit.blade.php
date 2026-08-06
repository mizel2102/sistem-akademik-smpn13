@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl py-10">
    <div class="mx-auto max-w-2xl rounded-2xl bg-white p-8 shadow-[0_20px_80px_-30px_rgba(15,23,42,0.25)] border border-slate-200">
        <h1 class="text-2xl font-extrabold text-slate-900">Edit Jadwal Pelajaran</h1>
        <p class="mt-2 text-sm text-slate-600">Perbarui detail jadwal untuk kelas, mata pelajaran, guru, dan waktu.</p>

        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="mt-8 grid gap-6 lg:grid-cols-2">
            @csrf
            @method('PUT')

            <div>
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-700">Kelas</label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('academic_class_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('academic_class_id', $schedule->academic_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
                @error('academic_class_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="subject_id" class="mb-2 block text-sm font-semibold text-slate-700">Mata Pelajaran</label>
                <select
                    id="subject_id"
                    name="subject_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('subject_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="teacher_id" class="mb-2 block text-sm font-semibold text-slate-700">Guru</label>
                <select
                    id="teacher_id"
                    name="teacher_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('teacher_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->user?->name ?? 'Guru #' . $teacher->id }}</option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="academic_year_id" class="mb-2 block text-sm font-semibold text-slate-700">Tahun Ajaran</label>
                <select
                    id="academic_year_id"
                    name="academic_year_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('academic_year_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id', $schedule->academic_year_id) == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                    @endforeach
                </select>
                @error('academic_year_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="semester_id" class="mb-2 block text-sm font-semibold text-slate-700">Semester</label>
                <select
                    id="semester_id"
                    name="semester_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('semester_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Semester --</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ old('semester_id', $schedule->semester_id) == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                    @endforeach
                </select>
                @error('semester_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="day" class="mb-2 block text-sm font-semibold text-slate-700">Hari</label>
                <select
                    id="day"
                    name="day"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('day') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'] as $value => $label)
                        <option value="{{ $value }}" {{ old('day', $schedule->day) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('day')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_time" class="mb-2 block text-sm font-semibold text-slate-700">Jam Mulai</label>
                <input
                    id="start_time"
                    name="start_time"
                    type="time"
                    value="{{ old('start_time', $schedule->start_time) }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('start_time') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('start_time')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_time" class="mb-2 block text-sm font-semibold text-slate-700">Jam Selesai</label>
                <input
                    id="end_time"
                    name="end_time"
                    type="time"
                    value="{{ old('end_time', $schedule->end_time) }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('end_time') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('end_time')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="room" class="mb-2 block text-sm font-semibold text-slate-700">Ruang</label>
                <input
                    id="room"
                    name="room"
                    type="text"
                    value="{{ old('room', $schedule->room) }}"
                    placeholder="Contoh: Ruang 101"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('room') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('room')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="lg:col-span-2 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-gold px-5 py-3 text-sm font-semibold text-navy shadow-sm transition hover:brightness-95 sm:w-auto">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
