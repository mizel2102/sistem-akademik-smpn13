@extends('layouts.app')

@section('page-title', $academicYear->name)
@section('breadcrumb', 'Admin › Tahun Ajaran › Detail')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 py-8">
    <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">{{ $academicYear->name }}</h1>
            <div class="mt-3 flex flex-wrap items-center gap-3 text-sm">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $academicYear->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $academicYear->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
        </div>

        <a href="{{ route('admin.academic-years.edit', $academicYear) }}" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            Edit
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <path d="M16 2v4M8 2v4M3 10h18" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Mulai</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $academicYear->start_date?->format('d F Y') ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <path d="M16 2v4M8 2v4M3 10h18" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Selesai</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $academicYear->end_date?->format('d F Y') ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Jumlah Semester</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $academicYear->semesters->count() }} Semester</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Semester dalam Tahun Ajaran Ini</h2>
                <p class="mt-1 text-sm text-slate-500">Rincian semua semester yang terdaftar pada periode ini.</p>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($academicYear->semesters as $semester)
                <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $semester->name }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $semester->start_date?->format('d M Y') ?? '-'}} – {{ $semester->end_date?->format('d M Y') ?? '-' }}</p>
                    </div>
                    <a href="{{ route('admin.semesters.show', $semester) }}" class="inline-flex items-center justify-center rounded-2xl bg-navy px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Lihat
                    </a>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 text-center text-sm text-slate-500">
                    Belum ada semester yang terdaftar.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
