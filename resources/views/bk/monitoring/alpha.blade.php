@extends('layouts.app')

@section('page-title', 'Monitoring Alpha - Guru BK')
@section('breadcrumb', 'Guru BK › Monitoring Alpha')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Monitoring Alpha Siswa</h1>
        <p class="mt-1 text-sm text-slate-500">Pantau siswa yang melebihi ambang batas alpha dan tentukan tindak lanjut.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Total Siswa Alpha &ge; 3</p>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ $students->total() }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">SP1 Aktif</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $spDistribution['SP1'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">SP2 Aktif</p>
            <p class="mt-2 text-3xl font-bold text-orange-600">{{ $spDistribution['SP2'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">SP3 Aktif</p>
            <p class="mt-2 text-3xl font-bold text-red-800">{{ $spDistribution['SP3'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Chart: Alpha Trend -->
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-navy mb-4">Tren Alpha (4 Minggu Terakhir)</h2>
        <div class="flex items-end gap-3 h-40">
            @foreach ($weeks as $week)
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full rounded-t-lg bg-red-500 transition-all"
                         style="height: {{ max($week['count'] * 10, 4) }}px;">
                    </div>
                    <span class="text-xs text-slate-500">{{ $week['label'] }}</span>
                    <span class="text-xs font-semibold text-slate-700">{{ $week['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Filter -->
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="w-48">
                <select name="semester_id"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="">Semua Semester</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ $semesterId == $semester->id ? 'selected' : '' }}>
                            {{ $semester->name ?? $semester->semester }} - {{ $semester->academicYear?->name ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-32">
                <select name="min_alpha"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="3" {{ $minAlpha === 3 ? 'selected' : '' }}>Min. 3 Alpha</option>
                    <option value="6" {{ $minAlpha === 6 ? 'selected' : '' }}>Min. 6 Alpha</option>
                    <option value="9" {{ $minAlpha === 9 ? 'selected' : '' }}>Min. 9 Alpha</option>
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-navy px-4 py-2 text-sm font-medium text-white hover:bg-navy/90">
                Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Students Table -->
    <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-600">Siswa</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Kelas</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Total Alpha</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Status SP</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Status Monitoring</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $student)
                        @php
                            $activeSP = $student->warningLetters()->active()->latest('issued_at')->first();
                            $spBadge = match ($activeSP?->type) {
                                'SP1' => 'bg-amber-100 text-amber-700',
                                'SP2' => 'bg-orange-100 text-orange-700',
                                'SP3' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-500',
                            };
                            $monitoringBadge = match ($student->monitoring_status ?? null) {
                                'perlu_dipanggil' => 'bg-red-100 text-red-700',
                                'sudah_dipanggil' => 'bg-blue-100 text-blue-700',
                                'dalam_pembinaan' => 'bg-purple-100 text-purple-700',
                                default => 'bg-slate-100 text-slate-500',
                            };
                            $monitoringLabel = match ($student->monitoring_status ?? null) {
                                'perlu_dipanggil' => 'Perlu Dipanggil',
                                'sudah_dipanggil' => 'Sudah Dipanggil',
                                'dalam_pembinaan' => 'Dalam Pembinaan',
                                default => 'Belum Dimonitor',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-slate-800">{{ $student->user?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ $student->student_number }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $student->academicClass?->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold {{ $student->alpha_count >= 9 ? 'text-red-600' : ($student->alpha_count >= 6 ? 'text-orange-600' : 'text-amber-600') }}">
                                    {{ $student->alpha_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($activeSP)
                                    <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $spBadge }}">
                                        {{ $activeSP->type }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $monitoringBadge }}">
                                    {{ $monitoringLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('bk.monitoring.update-status', $student->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <select name="monitoring_status" onchange="this.form.submit()"
                                                class="rounded-lg border border-slate-300 px-2 py-1 text-xs focus:border-navy focus:outline-none">
                                            <option value="perlu_dipanggil" {{ ($student->monitoring_status ?? '') === 'perlu_dipanggil' ? 'selected' : '' }}>Perlu Dipanggil</option>
                                            <option value="sudah_dipanggil" {{ ($student->monitoring_status ?? '') === 'sudah_dipanggil' ? 'selected' : '' }}>Sudah Dipanggil</option>
                                            <option value="dalam_pembinaan" {{ ($student->monitoring_status ?? '') === 'dalam_pembinaan' ? 'selected' : '' }}>Dalam Pembinaan</option>
                                        </select>
                                    </form>
                                    <a href="{{ route('bk.counselings.create', ['student_id' => $student->id]) }}"
                                       class="rounded-lg px-2 py-1 text-xs font-medium text-navy hover:bg-navy/10">
                                        Pembinaan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                                Tidak ada siswa yang melebihi ambang batas alpha.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($students->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
