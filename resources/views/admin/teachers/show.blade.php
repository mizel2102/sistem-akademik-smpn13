@extends('layouts.app')

@section('page-title', 'Detail Guru')
@section('breadcrumb', 'Admin › Data Guru › Detail')

@section('content')
<div class="mx-auto max-w-7xl py-10">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            @php
                $nameParts = preg_split('/\s+/', trim($teacher->user?->name ?? ''));
                $initials = collect($nameParts)->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->join('');
            @endphp

            <div class="flex flex-col items-center gap-4 text-center">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-amber-100 text-4xl font-extrabold text-amber-700">
                    {{ $initials ?: 'GU' }}
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">{{ $teacher->user?->name ?? '-' }}</h1>
                    <p class="mt-1 text-sm text-slate-500">{{ $teacher->user?->email ?? '-' }}</p>
                </div>
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-amber-700">Guru</span>
            </div>

            <div class="my-6 h-px bg-slate-200"></div>

            <div class="space-y-4 text-sm text-slate-600">
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">NIP</span>
                    <span>{{ $teacher->nip ?? '-' }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Mata Pelajaran</span>
                    <span>{{ $teacher->subject?->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Mulai Mengajar</span>
                    <span>{{ $teacher->started_at?->format('d F Y') ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="block rounded-2xl bg-navy px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-opacity-90">Edit</a>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Kelas yang Diajar</h2>
                        <p class="text-sm text-slate-500">Total kelas: {{ $teacher->classes->count() }}</p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse($teacher->classes as $class)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900">{{ $class->name }}</h3>
                                    <p class="text-sm text-slate-500">Ruang: {{ $class->room ?? '-' }}</p>
                                </div>
                                <span class="rounded-full bg-navy-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-navy">{{ $class->students->count() }} siswa</span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Guru belum mengajar kelas manapun</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
