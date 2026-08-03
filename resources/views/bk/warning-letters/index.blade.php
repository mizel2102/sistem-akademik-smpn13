@extends('layouts.app')

@section('page-title', 'Surat Peringatan - Guru BK')
@section('breadcrumb', 'Guru BK › Surat Peringatan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Surat Peringatan (SP)</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola penerbitan dan pencabutan surat peringatan siswa.</p>
        </div>
        <a href="{{ route('bk.warning-letters.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-navy px-4 py-2 text-sm font-semibold text-white hover:bg-navy/90">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Terbitkan SP
        </a>
    </div>

    <!-- Filter -->
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama siswa..."
                       value="{{ request('search') }}"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
            </div>
            <div class="w-36">
                <select name="type"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="">Semua Jenis</option>
                    <option value="SP1" {{ request('type') === 'SP1' ? 'selected' : '' }}>SP1</option>
                    <option value="SP2" {{ request('type') === 'SP2' ? 'selected' : '' }}>SP2</option>
                    <option value="SP3" {{ request('type') === 'SP3' ? 'selected' : '' }}>SP3</option>
                </select>
            </div>
            <div class="w-36">
                <select name="status"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Dicabut</option>
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
                        <th class="px-4 py-3 font-semibold text-slate-600">Jenis SP</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Tanggal Terbit</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Penerbit</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($letters as $letter)
                        @php
                            $isActive = $letter->resolved_at === null;
                            $typeColors = [
                                'SP1' => 'bg-amber-100 text-amber-700',
                                'SP2' => 'bg-orange-100 text-orange-700',
                                'SP3' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">
                                {{ $letter->student?->user?->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $letter->student?->academicClass?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $typeColors[$letter->type] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $letter->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $letter->issued_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($isActive)
                                    <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-500">Dicabut</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $letter->issuer?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('bk.warning-letters.show', $letter->id) }}"
                                       class="rounded-lg px-3 py-1.5 text-xs font-medium text-navy hover:bg-navy/10">
                                        Detail
                                    </a>
                                    <a href="{{ route('bk.warning-letters.download-pdf', $letter->id) }}"
                                       class="rounded-lg px-3 py-1.5 text-xs font-medium text-emerald-600 hover:bg-emerald-50">
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                                Belum ada surat peringatan. <a href="{{ route('bk.warning-letters.create') }}" class="text-navy font-semibold hover:underline">Terbitkan sekarang</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($letters->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $letters->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
