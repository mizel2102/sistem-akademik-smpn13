@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Bimbingan Konseling (BK)</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola catatan bimbingan dan tindak lanjut siswa.</p>
        </div>
        <a href="{{ route('admin.counselings.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            + Tambah Catatan
        </a>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="px-4 py-4">No</th>
                        <th class="px-4 py-4">Nama Siswa</th>
                        <th class="px-4 py-4">Konselor</th>
                        <th class="px-4 py-4">Catatan</th>
                        <th class="px-4 py-4">Tindak Lanjut</th>
                        <th class="px-4 py-4">Sesi</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ $item->student?->user?->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ $item->counselor?->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ \Illuminate\Support\Str::limit($item->notes ?? '-', 80) }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ \Illuminate\Support\Str::limit($item->follow_up ?? '-', 60) }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ $item->session_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-4 text-center">
                                <form action="{{ route('admin.counselings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?');" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-500">Belum ada catatan bimbingan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col items-center justify-between gap-4 py-4 sm:flex-row">
        <p class="text-sm text-slate-600">Menampilkan {{ $items->count() }} catatan</p>
        <div>
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
