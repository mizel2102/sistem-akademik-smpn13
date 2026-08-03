@extends('layouts.app')

@section('page-title', 'Edit Guru')

@section('content')
<div class="mx-auto max-w-2xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Edit Guru</h1>
        <p class="mt-2 text-sm text-slate-600">Perbarui informasi guru dan penugasan mata pelajaran.</p>

        @include('admin.teachers._form', [
            'action' => route('admin.teachers.update', $teacher),
            'method' => 'PUT',
            'submitLabel' => 'Simpan Perubahan',
            'teacher' => $teacher,
        ])
    </div>
</div>
@endsection
