@extends('layouts.app')

@section('page-title', 'Edit Semester')
@section('breadcrumb', 'Admin › Semester › Edit')

@section('content')
<div class="mx-auto max-w-lg py-10">
    <div class="rounded-2xl bg-white p-6 shadow-lg">
        <div class="mb-6 border-b border-slate-200 pb-4">
            <h1 class="text-xl font-semibold text-slate-900">Edit Semester</h1>
        </div>

        <form action="{{ route('admin.semesters.update', $semester) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Semester</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $semester->name) }}"
                    placeholder="Contoh: Semester Ganjil, Semester Genap"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('name') border-red-500 ring-red-100 focus:border-red-500 @enderror"
                >
                @error('name')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="academic_year_id" class="mb-2 block text-sm font-medium text-slate-700">Tahun Ajaran</label>
                <select
                    id="academic_year_id"
                    name="academic_year_id"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('academic_year_id') border-red-500 ring-red-100 focus:border-red-500 @enderror"
                >
                    <option value="">— Pilih Tahun Ajaran —</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id', $semester->academic_year_id) == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_date" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                <input
                    id="start_date"
                    name="start_date"
                    type="date"
                    value="{{ old('start_date', $semester->start_date?->format('Y-m-d')) }}"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('start_date') border-red-500 ring-red-100 focus:border-red-500 @enderror"
                >
                @error('start_date')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_date" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Selesai</label>
                <input
                    id="end_date"
                    name="end_date"
                    type="date"
                    value="{{ old('end_date', $semester->end_date?->format('Y-m-d')) }}"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('end_date') border-red-500 ring-red-100 focus:border-red-500 @enderror"
                >
                @error('end_date')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                <a href="{{ route('admin.semesters.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
