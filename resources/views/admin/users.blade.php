@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Manajemen Pengguna</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola akun pengguna dan peran di sistem sekolah.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.users.export') }}" class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700 transition">
                Export Excel
            </a>
            <div x-data="{ modalOpen: false }">
                <button @click="modalOpen = true" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                    Import Excel
                </button>

                <!-- Import Modal -->
                <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="modalOpen = false">
                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl mx-4">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900">Import Data Pengguna</h3>
                            <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>
                        <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File Excel (.xlsx, .xls)</label>
                                <input type="file" name="file" required accept=".xlsx,.xls" class="w-full rounded-lg border border-slate-200 p-2 text-sm">
                            </div>
                            <div class="flex gap-3">
                                <button type="button" @click="modalOpen = false" class="flex-1 rounded-lg border border-slate-200 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">Batal</button>
                                <button type="submit" class="flex-1 rounded-lg bg-navy py-2.5 font-medium text-white transition hover:bg-opacity-90">Upload & Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }">
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center gap-2 rounded-xl bg-navy px-4 py-2 text-sm font-semibold text-white shadow hover:bg-opacity-90 transition"
                >
                    + Tambah
                </button>
            </div>
        </div>
    </div>

    <div x-data="{ open: false }" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <button
                type="button"
                @click="open = !open"
                class="flex w-full items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:border-slate-300"
            >
                <span>Buat Pengguna Baru</span>
                <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 8l4 4 4-4"></path>
                </svg>
            </button>
        </div>

        <div x-show="open" x-cloak class="border-t border-slate-200 px-6 py-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        required
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('email') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        required
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('password') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        required
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">Role</label>
                    <select
                        id="role"
                        name="role"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('role') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        required
                    >
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-700">Simpan Pengguna</button>
            </form>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto px-6 py-6">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Ubah Role</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                    @forelse($users as $user)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-4 py-4 align-top text-sm text-slate-600">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-sm font-semibold text-slate-900">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 align-top">
                                @foreach($user->roles as $role)
                                    @php
                                        $roleClass = match($role->name) {
                                            'admin' => 'bg-red-100 text-red-700',
                                            'teacher' => 'bg-blue-100 text-blue-700',
                                            'student' => 'bg-emerald-100 text-emerald-700',
                                            default => 'bg-slate-100 text-slate-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $roleClass }}">{{ ucfirst($role->name) }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-4 align-top">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                    @csrf
                                    @method('PUT')
                                    <select
                                        name="role"
                                        class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                        required
                                    >
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-800">Simpan</button>
                                </form>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-500">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
