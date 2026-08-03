@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Surat Peringatan</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola surat peringatan siswa dengan cepat dan jelas.</p>
        </div>
        <a href="{{ route('admin.warning-letters.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
            + Buat Surat
        </a>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="px-4 py-4">No</th>
                        <th class="px-4 py-4">Nama Siswa</th>
                        <th class="px-4 py-4">Jenis SP</th>
                        <th class="px-4 py-4">Alasan</th>
                        <th class="px-4 py-4">Tanggal</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                    @forelse($letters as $letter)
                        @php
                            $badgeClasses = match($letter->type) {
                                'SP1' => 'bg-amber-100 text-amber-700',
                                'SP2' => 'bg-orange-100 text-orange-700',
                                'SP3' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $loop->iteration + ($letters->currentPage() - 1) * $letters->perPage() }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ $letter->student?->user?->name ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">{{ $letter->type ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4 text-slate-900">{{ \Illuminate\Support\Str::limit($letter->reason ?? '-', 60) }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ $letter->issued_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.warning-letters.show', $letter) }}" class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">Detail</a>
                                    <form action="{{ route('admin.warning-letters.destroy', $letter) }}" method="POST" onsubmit="return confirm('Hapus surat peringatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-500">Belum ada surat peringatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col items-center justify-between gap-4 py-4 sm:flex-row">
        <p class="text-sm text-slate-600">Menampilkan {{ $letters->count() }} surat</p>
        <div>
            {{ $letters->links() }}
        </div>
    </div>
</div>
@endsection
