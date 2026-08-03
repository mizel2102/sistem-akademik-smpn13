@extends('layouts.app')

@section('page-title', 'Pembinaan Siswa - Guru BK')
@section('breadcrumb', 'Guru BK › Pembinaan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Data Pembinaan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola sesi bimbingan dan konseling untuk siswa.</p>
        </div>
        <a href="{{ route('bk.counselings.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-navy px-4 py-2 text-sm font-semibold text-white hover:bg-navy/90">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Pembinaan
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama siswa..."
                       value="{{ request('search') }}"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
            </div>
            <div class="w-40">
                <select name="status"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-600">Siswa</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Kelas</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Konselor</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($counselings as $counseling)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">
                                {{ $counseling->student?->user?->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $counseling->student?->academicClass?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $counseling->session_at?->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'scheduled' => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusLabels = [
                                        'scheduled' => 'Terjadwal',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$counseling->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $statusLabels[$counseling->status] ?? $counseling->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $counseling->counselor?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('bk.counselings.edit', $counseling->id) }}"
                                       class="rounded-lg px-3 py-1.5 text-xs font-medium text-navy hover:bg-navy/10">
                                        Edit
                                    </a>
                                    <form action="{{ route('bk.counselings.destroy', $counseling->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus data pembinaan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                                Belum ada data pembinaan. <a href="{{ route('bk.counselings.create') }}" class="text-navy font-semibold hover:underline">Tambah sekarang</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($counselings->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $counselings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
