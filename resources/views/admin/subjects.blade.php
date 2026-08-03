@extends('layouts.app')

@section('content')
<div x-data="{ open: false }" class="mx-auto max-w-7xl space-y-6 py-10">
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Mata Pelajaran</h1>
            <p class="mt-1 text-slate-600">Kelola daftar mata pelajaran dan guru pengampu.</p>
        </div>
        <button
            @click="open = !open"
            type="button"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-navy px-5 py-3 font-semibold text-white shadow-md transition hover:bg-opacity-90"
        >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span x-text="open ? 'Tutup Form' : 'Tambah Mata Pelajaran'"></span>
        </button>
    </div>

    <div class="space-y-6">
        <!-- Form Section -->
        <div x-show="open" x-cloak class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 border-b border-slate-100 pb-3">
                <h2 class="text-lg font-bold text-navy">Buat Mata Pelajaran Baru</h2>
                <p class="text-sm text-slate-500">Isi formulir di bawah untuk menambah mata pelajaran baru.</p>
            </div>

            <form
                action="{{ route('admin.subjects.store') }}"
                method="POST"
                class="mt-4 space-y-5"
            >
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Mapel</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        placeholder="Nama mapel"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">Kode Mapel</label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        value="{{ old('code') }}"
                        placeholder="MTK, BIN, IPA"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('code') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    />
                    @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="teacher_id" class="mb-2 block text-sm font-semibold text-slate-700">Guru Pengampu</label>
                    <select
                        id="teacher_id"
                        name="teacher_id"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('teacher_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    >
                        <option value="">— Pilih guru pengampu —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user?->name ?? 'Guru tanpa nama' }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-1">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gold px-5 py-3 text-sm font-semibold text-navy shadow-sm transition hover:brightness-95">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Mata Pelajaran</h2>
                <p class="mt-1 text-sm text-slate-500">Semua mata pelajaran aktif dan guru pengampu ditampilkan di bawah.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        <tr>
                            <th class="px-4 py-4">No</th>
                            <th class="px-4 py-4">Kode</th>
                            <th class="px-4 py-4">Nama Mapel</th>
                            <th class="px-4 py-4">Guru Pengampu</th>
                            <th class="px-4 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                        @forelse($subjects as $subject)
                            <tr class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-4 py-4">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4">
                                    <code class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $subject->code ?? '-' }}</code>
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-900">{{ $subject->name }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $subject->teacher?->user?->name ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="rounded-full bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">Edit</a>
                                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full bg-red-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada mata pelajaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
