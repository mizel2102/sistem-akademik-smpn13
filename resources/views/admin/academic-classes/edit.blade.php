@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-page-header title="Edit Kelas Akademik" subtitle="Perbarui data kelas, guru pendamping, atau jadwal belajar." />

    <div class="rounded-[32px] border border-slate-200/80 bg-white/85 p-6 shadow-[0_28px_70px_-35px_rgba(15,23,42,0.28)] backdrop-blur-xl sm:p-8">
        <form action="{{ route('admin.academic-classes.update', $academicClass) }}" method="POST" class="grid gap-6 lg:grid-cols-2">
            @csrf
            @method('PUT')

            <x-input name="name" label="Nama Kelas" placeholder="Nama kelas" value="{{ old('name', $academicClass->name) }}" required error="{{ $errors->first('name') }}" />

            <x-select name="teacher_id" label="Guru" :options="$teachers->mapWithKeys(fn($teacher) => [$teacher->id => $teacher->user?->name ?? 'Guru tanpa user'])->toArray()" value="{{ old('teacher_id', $academicClass->teacher_id) }}" placeholder="Pilih guru" error="{{ $errors->first('teacher_id') }}" />

            <x-input name="room" label="Ruang" placeholder="Ruang" value="{{ old('room', $academicClass->room) }}" error="{{ $errors->first('room') }}" />
            <x-input name="schedule" label="Jadwal" placeholder="Senin, 07:00 - 08:30" value="{{ old('schedule', $academicClass->schedule) }}" error="{{ $errors->first('schedule') }}" />
            <x-input name="capacity" label="Kapasitas" type="number" placeholder="30" value="{{ old('capacity', $academicClass->capacity) }}" error="{{ $errors->first('capacity') }}" />
            <x-select
                name="status"
                label="Status Kelas"
                :options="['active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'archived' => 'Arsip']"
                value="{{ old('status', $academicClass->status) }}"
                placeholder="Pilih status kelas"
                error="{{ $errors->first('status') }}"
            />

            <div class="lg:col-span-2">
                <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5">Perbarui Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection
