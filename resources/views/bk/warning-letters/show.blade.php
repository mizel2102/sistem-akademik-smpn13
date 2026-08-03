@extends('layouts.app')

@section('page-title', 'Detail SP - Guru BK')
@section('breadcrumb', 'Guru BK › Surat Peringatan › Detail')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-navy">Detail Surat Peringatan</h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('bk.warning-letters.download-pdf', $letter->id) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Info Surat -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-medium text-slate-500">Jenis SP</p>
                    @php
                        $typeColors = ['SP1' => 'bg-amber-100 text-amber-700', 'SP2' => 'bg-orange-100 text-orange-700', 'SP3' => 'bg-red-100 text-red-700'];
                    @endphp
                    <span class="inline-block mt-1 rounded-full px-3 py-1 text-xs font-semibold {{ $typeColors[$letter->type] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ $letter->type }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Status</p>
                    @if ($letter->resolved_at === null)
                        <span class="inline-block mt-1 rounded-full px-3 py-1 text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                    @else
                        <span class="inline-block mt-1 rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-500">Dicabut</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Tanggal Terbit</p>
                    <p class="mt-1 text-sm font-medium text-slate-800">{{ $letter->issued_at?->format('d F Y H:i') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Penerbit</p>
                    <p class="mt-1 text-sm font-medium text-slate-800">{{ $letter->issuer?->name ?? '-' }}</p>
                </div>
            </div>

            <!-- Data Siswa -->
            <div class="border-t border-slate-200 pt-4">
                <h3 class="text-sm font-bold text-navy mb-3">Data Siswa</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Nama</p>
                        <p class="mt-1 text-sm font-medium text-slate-800">{{ $letter->student?->user?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">NIS</p>
                        <p class="mt-1 text-sm font-medium text-slate-800">{{ $letter->student?->student_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Kelas</p>
                        <p class="mt-1 text-sm font-medium text-slate-800">{{ $letter->student?->academicClass?->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Alasan -->
            <div class="border-t border-slate-200 pt-4">
                <h3 class="text-sm font-bold text-navy mb-3">Alasan Penerbitan</h3>
                <p class="text-sm text-slate-700">{{ $letter->reason ?? 'Tidak ada alasan yang dicatat.' }}</p>
            </div>

            <!-- Revoke Info -->
            @if ($letter->resolved_at !== null)
                <div class="border-t border-slate-200 pt-4">
                    <h3 class="text-sm font-bold text-navy mb-3">Informasi Pencabutan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-slate-500">Tanggal Dicabut</p>
                            <p class="mt-1 text-sm font-medium text-slate-800">{{ $letter->resolved_at->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500">Alasan Pencabutan</p>
                            <p class="mt-1 text-sm text-slate-700">{{ $letter->revoke_reason ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Revoke Action -->
            @if ($letter->resolved_at === null)
                <div class="border-t border-slate-200 pt-4">
                    <h3 class="text-sm font-bold text-red-600 mb-3">Cabut Surat Peringatan</h3>
                    <form action="{{ route('bk.warning-letters.revoke', $letter->id) }}" method="POST" class="space-y-3"
                          onsubmit="return confirm('Yakin ingin mencabut {{ $letter->type }} ini?')">
                        @csrf @method('PATCH')
                        <textarea name="reason" rows="2" required
                                  class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none"
                                  placeholder="Alasan pencabutan..."></textarea>
                        <button type="submit"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            Cabut SP
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
