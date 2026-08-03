@extends('layouts.app')

@section('page-title', 'Surat Pernyataan')
@section('breadcrumb', 'Guru › Surat Pernyataan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Surat Pernyataan Siswa</h1>
            <p class="mt-1 text-slate-600">Daftar surat peringatan/pernyataan (SP) kedisiplinan siswa di kelas Anda.</p>
        </div>
        <div>
            <a
                href="{{ route('teacher.warning-letters.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-navy px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-opacity-95"
            >
                Buat Surat Pernyataan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl bg-emerald-50 p-4 text-sm text-emerald-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-slate-50 text-slate-700">
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tingkat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Alasan Pelanggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Rilis</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($warningLetters as $index => $wl)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $wl->student->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">
                                <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700">
                                    {{ $wl->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $wl->reason }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $wl->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($wl->resolved_at)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">
                                        Dicabut
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                Tidak ada data surat pernyataan untuk siswa di kelas Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
