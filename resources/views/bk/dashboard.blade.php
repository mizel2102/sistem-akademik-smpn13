@extends('layouts.app')

@section('page-title', 'Dashboard Guru BK')
@section('breadcrumb', 'Guru BK › Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Dashboard Guru BK</h1>
        <p class="mt-1 text-sm text-slate-500">Pantau siswa yang membutuhkan perhatian dan tindak lanjut pembinaan.</p>
    </div>

    <!-- Class Filter -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
        <form method="GET" action="{{ route('bk.dashboard') }}" class="flex flex-wrap items-end gap-4">
            <div class="w-full sm:w-72">
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-700">Filter Berdasarkan Kelas</label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                    onchange="this.form.submit()"
                >
                    <option value="">Semua Kelas</option>
                    @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}" {{ ($selectedClassId ?? null) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($selectedClassId ?? null)
                <a href="{{ route('bk.dashboard') }}" class="inline-flex h-[42px] items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-5">
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Perlu Perhatian</p>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ $statistics['students_needing_attention'] }}</p>
        </div>
        @foreach (['active_sp1' => 'SP1 Aktif', 'active_sp2' => 'SP2 Aktif', 'active_sp3' => 'SP3 Aktif'] as $key => $label)
            <div class="rounded-2xl bg-white p-5 shadow-sm">
                <p class="text-xs font-medium text-slate-500">{{ $label }}</p>
                <p class="mt-2 text-3xl font-bold text-amber-600">{{ $statistics[$key] }}</p>
            </div>
        @endforeach
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Pembinaan Bulan Ini</p>
            <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $statistics['counselings_this_month'] }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-navy">Siswa dengan Alpha Tinggi</h2>
                <a href="{{ route('admin.counselings.index') }}" class="text-sm font-semibold text-navy hover:underline">Tindak lanjut</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 text-xs uppercase text-slate-500">
                        <tr><th class="px-2 py-3">Siswa</th><th class="px-2 py-3">Kelas</th><th class="px-2 py-3">Alpha</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($studentsNeedingAttention as $student)
                            <tr class="border-b border-slate-100 last:border-0">
                                <td class="px-2 py-3 font-medium text-slate-800">{{ $student->user?->name ?? $student->student_number }}</td>
                                <td class="px-2 py-3 text-slate-500">{{ $student->academicClass?->name ?? '-' }}</td>
                                <td class="px-2 py-3 font-semibold text-red-600">{{ $student->alpha_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-2 py-6 text-center text-slate-500">Belum ada siswa yang melewati ambang alpha.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-navy">Pembinaan Terbaru</h2>
            <div class="space-y-4">
                @forelse ($recentCounselings as $counseling)
                    <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <p class="font-medium text-slate-800">{{ $counseling->student?->user?->name ?? '-' }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $counseling->session_at?->format('d M Y H:i') ?? 'Waktu belum ditentukan' }}</p>
                        @if ($counseling->notes)
                            <p class="mt-2 text-sm text-slate-600">{{ Str::limit($counseling->notes, 120) }}</p>
                        @endif
                    </div>
                @empty
                    <p class="py-6 text-center text-slate-500">Belum ada riwayat pembinaan.</p>
                @endforelse
            </div>
        </section>
    </div>

    <!-- Log Kehadiran Siswa (Crosscheck Absensi) -->
    <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 mt-6">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-lg font-bold text-navy">Log Kehadiran Siswa (Crosscheck Absensi)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar kehadiran riil-time untuk memverifikasi absensi siswa.</p>
            </div>
            <a href="{{ route('bk.monitoring.alpha') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-navy hover:underline">
                Lihat Monitoring Alpha &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="border-b border-slate-200 bg-slate-50/50 text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Nama Siswa</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Waktu Presensi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentAttendances ?? [] as $att)
                        @php
                            $statusMap = [
                                'present' => ['label' => 'Hadir', 'bg' => 'bg-green-100 text-green-700'],
                                'late' => ['label' => 'Terlambat', 'bg' => 'bg-amber-100 text-amber-700'],
                                'absent' => ['label' => 'Tidak Hadir', 'bg' => 'bg-red-100 text-red-700'],
                                'sick' => ['label' => 'Sakit', 'bg' => 'bg-blue-100 text-blue-700'],
                                'permission' => ['label' => 'Izin', 'bg' => 'bg-purple-100 text-purple-700'],
                                'alpha' => ['label' => 'Tanpa Keterangan', 'bg' => 'bg-rose-100 text-rose-700'],
                            ];
                            $status = $statusMap[$att->status] ?? ['label' => ucfirst($att->status ?? '-'), 'bg' => 'bg-slate-100 text-slate-600'];
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $att->student?->user?->name ?? 'N/A' }}
                                <span class="block text-[10px] text-slate-400 font-normal">{{ $att->student?->student_number ?? '' }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $att->academicClass?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500 text-xs">{{ $att->attendance_time?->format('d M Y, H:i') ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $status['bg'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-400 text-xs font-mono">{{ $att->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                Belum ada log absensi siswa yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
