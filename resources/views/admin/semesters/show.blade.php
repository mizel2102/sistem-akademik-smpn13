@extends('layouts.app')

@section('page-title', $semester->name)
@section('breadcrumb', 'Admin › Semester › Detail')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 py-8">
    <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">{{ $semester->name }}</h1>
        </div>
        <a href="{{ route('admin.semesters.edit', $semester) }}" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            Edit
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16M4 10h16M4 14h16" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Tahun Ajaran</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $semester->academicYear?->name ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M8 7V3m8 4V3m-9 8h10m-12 6h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Mulai</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $semester->start_date?->format('d F Y') ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M8 7V3m8 4V3m-9 8h10m-12 6h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Selesai</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $semester->end_date?->format('d F Y') ?? '-' }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Semester</h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Nama</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $semester->name }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Tahun Ajaran</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $semester->academicYear?->name ?? '-' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Periode</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $semester->start_date?->format('d M Y') ?? '-' }} – {{ $semester->end_date?->format('d M Y') ?? '-' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Durasi</p>
                <p class="mt-2 font-semibold text-slate-900">
                    {{ $semester->start_date && $semester->end_date ? $semester->start_date->diffInDays($semester->end_date) . ' hari' : '-' }}
                </p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.semesters.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                Kembali ke Daftar Semester
            </a>
        </div>
    </div>
</div>
@endsection
