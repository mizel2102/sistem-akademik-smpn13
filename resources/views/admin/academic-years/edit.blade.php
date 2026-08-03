@extends('layouts.app')

@section('page-title', 'Edit Tahun Ajaran')
@section('breadcrumb', 'Admin › Tahun Ajaran › Edit')

@section('content')
<div class="mx-auto max-w-lg py-10">
    <div class="rounded-2xl bg-white p-6 shadow-lg">
        <div class="mb-6 border-b border-slate-200 pb-4">
            <h1 class="text-xl font-semibold text-slate-900">Edit Tahun Ajaran</h1>
        </div>

        <form action="{{ route('admin.academic-years.update', $academicYear) }}" method="POST" x-data="{ active: {{ $academicYear->is_active ? 'true' : 'false' }} }" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Tahun Ajaran</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $academicYear->name) }}"
                    placeholder="Contoh: 2025/2026"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('name') border-red-500 ring-red-100 focus:border-red-500 @enderror"
                >
                @error('name')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_date" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                <input
                    id="start_date"
                    name="start_date"
                    type="date"
                    value="{{ old('start_date', $academicYear->start_date?->format('Y-m-d')) }}"
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
                    value="{{ old('end_date', $academicYear->end_date?->format('Y-m-d')) }}"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('end_date') border-red-500 ring-red-100 focus:border-red-500 @enderror"
                >
                @error('end_date')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div>
                    <p class="text-sm font-medium text-slate-900">Status Aktif</p>
                    <p class="text-sm text-slate-500">Tandai apakah periode ini sedang aktif.</p>
                </div>
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" :value="active ? '1' : '0'">
                    <button type="button" @click="active = !active" class="relative inline-flex h-6 w-12 items-center rounded-full transition-colors" :class="active ? 'bg-navy' : 'bg-slate-300'">
                        <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform" :class="active ? 'translate-x-6' : 'translate-x-1'"></span>
                    </button>
                    <span class="text-sm font-semibold text-slate-900" x-text="active ? 'Aktif' : 'Tidak Aktif'"></span>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                <a href="{{ route('admin.academic-years.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
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
