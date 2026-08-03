@extends('layouts.app')

@section('page-title', 'Data Siswa')
@section('breadcrumb', 'Guru › Data Siswa')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-extrabold text-navy">Data Siswa di Kelas Anda</h1>
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <ul class="space-y-4">
            @forelse($students as $student)
                <li class="border-b border-slate-200 pb-4">
                    <p class="font-medium text-slate-900">{{ $student->user->name ?? 'Anonim' }} - NIS: {{ $student->nis }}</p>
                    <p class="text-sm text-slate-600">Kelas: {{ $student->academicClass->name ?? '-' }}</p>
                </li>
            @empty
                <p class="text-slate-600">Tidak ada siswa yang terdaftar di kelas Anda.</p>
            @endforelse
        </ul>
    </div>
</div>
@endsection
