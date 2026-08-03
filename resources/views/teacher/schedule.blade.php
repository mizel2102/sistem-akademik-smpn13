@extends('layouts.app')

@section('page-title', 'Jadwal Mengajar')
@section('breadcrumb', 'Guru › Jadwal Mengajar')

@section('content')
@php
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $scheduleCollection = collect($schedules);
    $grouped = $scheduleCollection->groupBy('day');
    $uniqueClasses = $scheduleCollection->pluck('academicClass.name')->filter()->unique()->count();
    $uniqueDays = $scheduleCollection->pluck('day')->filter()->unique()->count();
@endphp

<div class="space-y-6 py-8">
    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Total Jadwal</p>
            <p class="mt-4 text-3xl font-extrabold text-slate-900">{{ $scheduleCollection->count() }}</p>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas Diajar</p>
            <p class="mt-4 text-3xl font-extrabold text-slate-900">{{ $uniqueClasses }}</p>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Hari Aktif</p>
            <p class="mt-4 text-3xl font-extrabold text-slate-900">{{ $uniqueDays }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-navy text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 6h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Jadwal Minggu Ini</h2>
                    <p class="text-sm text-slate-500">Rincian jadwal mengajar per hari.</p>
                </div>
            </div>
        </div>

        @if($scheduleCollection->isEmpty())
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-10 text-center text-slate-500">
                <svg class="mx-auto mb-4 h-10 w-10 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 6h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <p class="text-sm font-semibold">Belum ada jadwal mengajar</p>
            </div>
        @else
            @foreach($days as $dayLabel)
                @if($grouped->has($dayLabel) && $grouped[$dayLabel]->isNotEmpty())
                    <div class="mb-4 overflow-hidden rounded-2xl border border-slate-200">
                        <div class="bg-navy-50 px-5 py-2 text-xs font-bold uppercase tracking-wide text-navy">{{ $dayLabel }}</div>
                        <div>
                            @foreach($grouped[$dayLabel]->sortBy('start_time') as $s)
                                <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 last:border-0 sm:flex-row sm:items-center sm:justify-between hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <span class="font-mono text-sm text-slate-500">{{ $s->start_time }} – {{ $s->end_time }}</span>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $s->subject?->name ?? '-' }}</p>
                                            <p class="text-xs text-slate-400">Ruang: {{ $s->room ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <span class="rounded-full bg-navy px-3 py-1 text-xs font-semibold text-white">{{ $s->academicClass?->name ?? '-' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection
