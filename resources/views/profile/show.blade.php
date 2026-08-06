@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')
@php
    $nameParts = preg_split('/\s+/', trim($user->name));
    $initials = collect($nameParts)->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->join('');
    $rawRole = strtolower($user->getRoleNames()->first() ?? 'user');
    $roleLabel = match ($rawRole) {
        'admin' => 'Admin',
        'guru' => 'Guru',
        'teacher' => 'Guru',
        'guru-bk' => 'Guru BK',
        'siswa' => 'Siswa',
        default => ucfirst($rawRole),
    };
    $roleClasses = match ($rawRole) {
        'admin' => 'bg-red-100 text-red-700',
        'teacher', 'guru', 'guru-bk' => 'bg-blue-100 text-blue-700',
        'siswa' => 'bg-emerald-100 text-emerald-700',
        default => 'bg-slate-100 text-slate-700',
    };
@endphp

<div class="mx-auto max-w-2xl space-y-6 py-8">
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
            @if($user->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-20 w-20 rounded-full object-cover ring-4 ring-navy/20">
            @else
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-navy text-3xl font-extrabold text-gold ring-4 ring-navy/20">
                    {{ $initials ?: 'US' }}
                </div>
            @endif
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide {{ $roleClasses }}">{{ $roleLabel }}</span>
                </div>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                <p class="text-sm text-slate-500">Bergabung sejak {{ $user->created_at->format('d F Y') }}</p>

                @if($user->student)
                    <div class="space-y-1 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                        <p class="font-semibold text-slate-900">Data Siswa</p>
                        <p>NIS: {{ $user->student->student_number ?? '-' }}</p>
                        <p>Kelas: {{ $user->student->academicClass?->name ?? '-' }}</p>
                    </div>
                @elseif($user->teacher)
                    <div class="space-y-1 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                        <p class="font-semibold text-slate-900">Data Guru</p>
                        <p>NIP: {{ $user->teacher->nip ?? '-' }}</p>
                        <p>Mapel: {{ $user->teacher->subject?->name ?? '-' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Edit Profil</h2>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="avatar" class="mb-2 block text-sm font-medium text-slate-700">Foto Profil (Semua Pengguna)</label>
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/*"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('avatar') border-red-400 ring-red-100 focus:border-red-400 @enderror"
                >
                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP (Maksimal 2MB).</p>
                @error('avatar')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('name') border-red-400 ring-red-100 focus:border-red-400 @enderror"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('email') border-red-400 ring-red-100 focus:border-red-400 @enderror"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm" id="password">
        <h2 class="text-lg font-semibold text-slate-900">Ganti Password</h2>
        <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="mb-2 block text-sm font-medium text-slate-700">Password Saat Ini</label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('current_password') border-red-400 ring-red-100 focus:border-red-400 @enderror"
                >
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password Baru</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 @error('password') border-red-400 ring-red-100 focus:border-red-400 @enderror"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
                >
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-600">
                Ganti Password
            </button>
        </form>
    </div>
</div>
@endsection
