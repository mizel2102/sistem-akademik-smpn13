@extends('layouts.app')

@section('page-title', 'Rapot Siswa')
@section('breadcrumb', 'Guru › Rapot')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-extrabold text-navy">Rapot Siswa</h1>
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <ul class="space-y-4">
            @forelse($students as $student)
                <li class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div>
                        <p class="font-medium text-slate-900">{{ $student->user->name ?? 'Anonim' }} - NIS: {{ $student->nis }}</p>
                        <p class="text-sm text-slate-600">Kelas: {{ $student->academicClass->name ?? '-' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('teacher.report-cards.pdf', $student->id) }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Ekspor PDF</a>
                    </div>
                </li>
            @empty
                <p class="text-slate-600">Tidak ada siswa di kelas Anda.</p>
            @endforelse
        </ul>
    </div>
</div>
@endsection
