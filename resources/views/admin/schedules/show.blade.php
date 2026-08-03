@extends('layouts.app')

@section('page-title', 'Detail Jadwal')
@section('breadcrumb', 'Admin › Jadwal › Detail')

@section('content')
@php
    $dayLabels = [
        'monday' => 'Senin',
        'tuesday' => 'Selasa',
        'wednesday' => 'Rabu',
        'thursday' => 'Kamis',
        'friday' => 'Jumat',
        'saturday' => 'Sabtu',
        'sunday' => 'Minggu',
    ];
    $dayLabel = $dayLabels[strtolower($schedule->day ?? '')] ?? ($schedule->day ? ucfirst($schedule->day) : '-');
@endphp

<div class="mx-auto max-w-7xl space-y-6 py-8">
    <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Detail Jadwal</h1>
            <p class="mt-2 text-sm text-slate-500">Lihat informasi lengkap jadwal kelas ini.</p>
        </div>
        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            Edit
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 6h6M12 12h6M12 18h6M6 6h.01M6 12h.01M6 18h.01" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Mata Pelajaran</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $schedule->subject?->name ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.835.66 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Guru</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $schedule->teacher?->user?->name ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 11h16M4 15h16" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Kelas</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $schedule->academicClass?->name ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 text-slate-500">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z" />
                </svg>
                <span class="text-sm font-semibold text-slate-900">Ruang</span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-900">{{ $schedule->room ?? '-' }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-slate-900">Waktu & Periode</h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Hari</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $dayLabel }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Jam</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $schedule->start_time }} – {{ $schedule->end_time }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Tahun Ajaran</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $schedule->academicYear?->name ?? '-' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Semester</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $schedule->semester?->name ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Kembali ke Daftar Jadwal
            </a>
        </div>
    </div>
</div>
@endsection
