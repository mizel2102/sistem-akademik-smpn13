@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 py-10" x-data="{ open: false }">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Tahun Ajaran</h1>
            <p class="mt-1 text-slate-600">Kelola periode akademik dan status aktif untuk setiap tahun ajaran.</p>
        </div>

        @can('create', App\Models\AcademicYear::class)
            <button
                @click.prevent="open = !open"
                class="inline-flex items-center justify-center rounded-2xl bg-gold px-5 py-3 text-sm font-semibold text-navy shadow-lg shadow-gold/20 transition hover:brightness-95"
            >
                <span x-text="open ? 'Tutup Form Tambah' : '+ Tambah'"></span>
            </button>
        @endcan
    </div>

    @can('create', App\Models\AcademicYear::class)
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" x-show="open" x-cloak>
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-slate-900">Tambah Tahun Ajaran</h2>
                <p class="mt-1 text-sm text-slate-500">Isi detail tahun ajaran baru dan pilih apakah statusnya aktif.</p>
            </div>

            <form action="{{ route('admin.academic-years.store') }}" method="POST" class="grid gap-6">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Tahun Ajaran</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        placeholder="2025/2026"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="start_date" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Mulai</label>
                        <input
                            id="start_date"
                            name="start_date"
                            type="date"
                            value="{{ old('start_date') }}"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('start_date') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        />
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Selesai</label>
                        <input
                            id="end_date"
                            name="end_date"
                            type="date"
                            value="{{ old('end_date') }}"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('end_date') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        />
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active') ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        />
                        Status Aktif
                    </label>
                    @error('is_active')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="rounded-2xl bg-gold px-5 py-3 text-sm font-semibold text-navy shadow-sm transition hover:brightness-95">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    @endcan

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">Daftar Tahun Ajaran</h2>
            <p class="mt-1 text-sm text-slate-500">Lihat semua tahun ajaran yang sudah terdaftar dan status aktifnya.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="px-4 py-4">No</th>
                        <th class="px-4 py-4">Nama Tahun Ajaran</th>
                        <th class="px-4 py-4">Tanggal Mulai</th>
                        <th class="px-4 py-4">Tanggal Selesai</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                    @forelse($years as $year)
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-4">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $year->name }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $year->start_date?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $year->end_date?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-4">
                                @if($year->is_active)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.academic-years.edit', $year) }}" class="rounded-full bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">Edit</a>
                                    <form action="{{ route('admin.academic-years.destroy', $year) }}" method="POST" onsubmit="return confirm('Hapus tahun ajaran ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full bg-red-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada tahun ajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
