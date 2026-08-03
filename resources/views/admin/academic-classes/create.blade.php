@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl py-10">
    <div class="mx-auto max-w-lg rounded-2xl bg-white p-8 shadow-[0_20px_80px_-30px_rgba(15,23,42,0.25)] border border-slate-200">
        <h1 class="text-2xl font-extrabold text-slate-900">{{ isset($academicClass) ? 'Edit Kelas Akademik' : 'Tambah Kelas Akademik' }}</h1>
        <p class="mt-2 text-sm text-slate-600">Lengkapi data kelas untuk manajemen siswa dan wali kelas.</p>

        <form
            action="{{ isset($academicClass) ? route('admin.academic-classes.update', $academicClass) : route('admin.academic-classes.store') }}"
            method="POST"
            class="mt-8 space-y-6"
        >
            @csrf
            @if(isset($academicClass))
                @method('PUT')
            @endif

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Kelas</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $academicClass->name ?? '') }}"
                    placeholder="Contoh: 7A, 8B, 9C"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="grade_level" class="mb-2 block text-sm font-semibold text-slate-700">Tingkat</label>
                <select
                    id="grade_level"
                    name="grade_level"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('grade_level') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                >
                    <option value="">Pilih tingkat</option>
                    @foreach(['7', '8', '9'] as $level)
                        <option value="{{ $level }}" {{ old('grade_level', $academicClass->grade_level ?? '') === $level ? 'selected' : '' }}>{{ $level }}</option>
                    @endforeach
                </select>
                @error('grade_level')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="room" class="mb-2 block text-sm font-semibold text-slate-700">Ruang</label>
                <input
                    id="room"
                    name="room"
                    type="text"
                    value="{{ old('room', $academicClass->room ?? '') }}"
                    placeholder="Contoh: Ruang 101"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('room') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                />
                @error('room')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="teacher_name" class="mb-2 block text-sm font-semibold text-slate-700">Wali Kelas</label>
                <input
                    id="teacher_name"
                    name="teacher_name"
                    type="text"
                    value="{{ old('teacher_name', $academicClass->teacher->user->name ?? '') }}"
                    placeholder="Contoh: ANDRIANTO, S.Pd"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('teacher_name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                />
                @error('teacher_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="capacity" class="mb-2 block text-sm font-semibold text-slate-700">Kapasitas</label>
                <input
                    id="capacity"
                    name="capacity"
                    type="number"
                    value="{{ old('capacity', $academicClass->capacity ?? '') }}"
                    placeholder="Jumlah maksimal siswa"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('capacity') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                />
                @error('capacity')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto">
                        {{ isset($academicClass) ? 'Simpan Perubahan' : 'Buat Kelas' }}
                    </button>
                </div>
                <a href="{{ route('admin.academic-classes.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
