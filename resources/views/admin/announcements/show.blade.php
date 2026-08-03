@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl py-10">
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-[0_20px_70px_-30px_rgba(15,23,42,0.18)]">
        <div class="space-y-6">
            <div>
                @php
                    $badgeText = match ($announcement->audience) {
                        'teacher' => 'Guru',
                        'student' => 'Siswa',
                        default => 'Semua',
                    };
                    $badgeClasses = match ($announcement->audience) {
                        'teacher' => 'bg-blue-100 text-blue-700',
                        'student' => 'bg-emerald-100 text-emerald-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp

                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $badgeClasses }}">{{ $badgeText }}</span>
            </div>

            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">{{ $announcement->title }}</h1>
                <p class="mt-3 text-sm text-slate-500">Oleh {{ $announcement->user?->name ?? 'Sistem' }} · {{ $announcement->published_at?->format('d F Y, H:i') }}</p>
            </div>

            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
                {!! nl2br(e($announcement->content)) !!}
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Kembali</a>
        </div>
    </div>
</div>
@endsection
