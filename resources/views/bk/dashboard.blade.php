@extends('layouts.app')

@section('page-title', 'Dashboard Guru BK')
@section('breadcrumb', 'Guru BK › Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Dashboard Guru BK</h1>
        <p class="mt-1 text-sm text-slate-500">Pantau siswa yang membutuhkan perhatian dan tindak lanjut pembinaan.</p>
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
</div>
@endsection
