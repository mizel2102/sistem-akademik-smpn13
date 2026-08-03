@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl py-10">
    <div class="mx-auto max-w-lg rounded-2xl bg-white p-8 shadow-[0_20px_80px_-30px_rgba(15,23,42,0.25)] border border-slate-200">
        <h1 class="text-2xl font-extrabold text-slate-900">Edit Mata Pelajaran</h1>
        <p class="mt-2 text-sm text-slate-600">Perbarui nama mapel, kode, atau guru pengampu.</p>

        <form action="{{ route('admin.subjects.update', $subject) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Mapel</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $subject->name) }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">Kode Mapel</label>
                <input
                    id="code"
                    name="code"
                    type="text"
                    value="{{ old('code', $subject->code) }}"
                    placeholder="MTK, BIN, IPA"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('code') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                />
                @error('code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="teacher_id" class="mb-2 block text-sm font-semibold text-slate-700">Guru Pengampu</label>
                <select
                    id="teacher_id"
                    name="teacher_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('teacher_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                >
                    <option value="">— Tidak ada guru —</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user?->name ?? 'Guru tanpa nama' }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700 sm:w-auto">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.subjects.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
