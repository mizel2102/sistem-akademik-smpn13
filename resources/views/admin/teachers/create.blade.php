@extends('layouts.app')

@section('page-title', 'Tambah Guru')

@section('content')
<div class="mx-auto max-w-2xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Tambah Guru</h1>
        <p class="mt-2 text-sm text-slate-600">Tambahkan guru baru dengan detail akun pengguna dan mata pelajaran yang sesuai.</p>

        @include('admin.teachers._form', [
            'action' => route('admin.teachers.store'),
            'method' => 'POST',
            'submitLabel' => 'Tambah Guru',
            'teacher' => null,
        ])
    </div>
</div>
@endsection
