@extends('layouts.app')

@section('page-title', $subject->name)
@section('breadcrumb', 'Admin › Mata Pelajaran › Detail')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 py-8">
    <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">{{ $subject->name }}</h1>
            <p class="mt-2 text-sm text-slate-500">Detail mata pelajaran dan pengampu.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <span class="rounded-full bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">{{ $subject->code ?? 'No Code' }}</span>
            <a href="{{ route('admin.subjects.edit', $subject) }}" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Edit
            </a>
        </div>
    </div>

    <div class="mx-auto max-w-lg rounded-2xl bg-white p-6 shadow-lg">
        <div class="flex flex-col items-center gap-4 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-purple-50 text-2xl text-purple-700">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-6-6h12" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">{{ $subject->name }}</h2>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold tracking-wide text-slate-700">{{ $subject->code ?? '-' }}</span>
        </div>

        <div class="my-6 border-t border-slate-200"></div>

        <div class="space-y-4">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Guru Pengampu</p>
                <div class="mt-3 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-700 font-semibold">G</span>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $subject->teacher?->user?->name ?? 'Belum ditentukan' }}</p>
                            @if($subject->teacher)
                                <a href="{{ route('admin.teachers.show', $subject->teacher) }}" class="text-sm font-semibold text-navy hover:text-gold">Lihat Profil Guru</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Kode Mapel</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $subject->code ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-between">
            <a href="{{ route('admin.subjects.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Kembali
            </a>
            <a href="{{ route('admin.subjects.edit', $subject) }}" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Edit Mata Pelajaran
            </a>
        </div>
    </div>
</div>
@endsection
