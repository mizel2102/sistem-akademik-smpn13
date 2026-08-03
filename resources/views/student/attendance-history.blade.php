@extends('layouts.app')

@section('page-title', 'Riwayat Absensi')
@section('breadcrumb', 'Siswa › Riwayat Absensi')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Riwayat Absensi</h1>
        <p class="mt-2 text-slate-600">Lihat riwayat absensi Anda dalam satu tampilan.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Total Absensi</p>
            <p class="mt-4 text-3xl font-bold text-navy">{{ $totalAttendance }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Hadir</p>
            <p class="mt-4 text-3xl font-bold text-navy">{{ $presentCount }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Tidak Hadir</p>
            <p class="mt-4 text-3xl font-bold text-navy">{{ $absentCount }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <form method="GET" action="{{ request()->url() }}" class="grid gap-4 lg:grid-cols-4 lg:items-end">
            <div class="lg:col-span-1">
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Filter Tanggal</p>
                <p class="mt-1 text-sm text-slate-600">Pilih rentang tanggal untuk melihat riwayat.</p>
            </div>
            <div>
                <label for="start_date" class="mb-2 block text-sm font-medium text-slate-900">Dari</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="w-full rounded-2xl border-2 border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                >
            </div>
            <div>
                <label for="end_date" class="mb-2 block text-sm font-medium text-slate-900">Sampai</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="w-full rounded-2xl border-2 border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                >
            </div>
            <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                <button type="submit" class="rounded-xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90">
                    Terapkan
                </button>
                <a href="{{ request()->url() }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $i => $attendance)
                        @php
                            $statusMap = [
                                'present' => ['label' => 'Hadir', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                'late' => ['label' => 'Terlambat', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
                                'absent' => ['label' => 'Tidak Hadir', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                'sick' => ['label' => 'Sakit', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                'permission' => ['label' => 'Izin', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                            ];
                            $status = $statusMap[$attendance->status] ?? ['label' => ucfirst($attendance->status ?? '-'), 'bg' => 'bg-slate-100', 'text' => 'text-slate-600'];
                        @endphp
                        <tr class="border-t border-slate-200 {{ $loop->even ? 'bg-slate-50' : '' }} hover:bg-slate-100">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $attendances->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $attendance->academicClass?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $attendance->attendance_time?->format('d M Y H:i') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $attendance->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-900">Belum ada riwayat absensi</p>
                                        <p class="text-sm text-slate-600">Absensi Anda akan muncul setelah melakukan kehadiran.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col items-center justify-between gap-4 py-4 sm:flex-row">
        <p class="text-sm text-slate-600">Menampilkan {{ $attendances->count() }} catatan</p>
        <div>
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
