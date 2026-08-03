@extends('layouts.app')

@section('page-title', 'Mata Pelajaran Saya')
@section('breadcrumb', 'Guru › Mata Pelajaran')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-extrabold text-navy">Mata Pelajaran Saya</h1>
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        @if($subject)
            <p class="text-lg font-medium text-slate-900">Anda mengajar: <span class="font-bold text-blue-600">{{ $subject->name }}</span></p>
        @else
            <p class="text-slate-600">Belum ada mata pelajaran yang diampu.</p>
        @endif
    </div>
</div>
@endsection
