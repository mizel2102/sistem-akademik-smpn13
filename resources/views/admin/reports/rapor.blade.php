@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl py-10">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Rapor Siswa — {{ $student->user?->name }}</h1>
            <p class="mt-2 text-sm text-slate-600">Lihat detail nilai dan ringkasan raport siswa.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('admin.reports.studentRaporPdf', $student->id) }}" target="_blank" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Download PDF</a>
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Kembali</a>
        </div>
    </div>

    <div class="mx-auto mt-8 max-w-3xl rounded-2xl bg-white p-8 shadow-lg">
        <div class="space-y-4 text-center">
            <h2 class="text-2xl font-extrabold text-navy">RAPOR SISWA</h2>
            <p class="text-lg font-bold text-slate-900">SMPN 13</p>
        </div>
        <div class="my-6 h-px bg-navy/10"></div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-500">Nama</p>
                <p class="text-base text-slate-900">{{ $student->user?->name ?? '-' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-500">NIS</p>
                <p class="text-base text-slate-900">{{ $student->student_number ?? '-' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-500">Kelas</p>
                <p class="text-base text-slate-900">{{ $student->academicClass?->name ?? '-' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-500">Tingkat</p>
                <p class="text-base text-slate-900">Kelas {{ $student->grade_level ?? '-' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-500">Jenis Kelamin</p>
                <p class="text-base text-slate-900">{{ $student->gender === 'female' ? 'Perempuan' : 'Laki-laki' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-500">Wali Kelas</p>
                <p class="text-base text-slate-900">{{ $student->academicClass?->teacher?->user?->name ?? '-' }}</p>
            </div>
        </div>

        @php
            $gradesBySemester = $student->grades->groupBy(fn($grade) => $grade->semester?->name ?? 'Tanpa Semester');
            $averageScore = $student->grades->avg('score');
            $predicate = match(true) {
                $averageScore >= 90 => 'Sangat Baik (A)',
                $averageScore >= 75 => 'Baik (B)',
                $averageScore >= 60 => 'Cukup (C)',
                default => 'Perlu Perbaikan (D)',
            };
        @endphp

        <div class="mt-8 space-y-8">
            @foreach($gradesBySemester as $semesterName => $grades)
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                    <div class="bg-navy-50 px-5 py-3 text-sm font-bold uppercase tracking-[0.2em] text-navy">{{ $semesterName }}</div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-700">
                            <thead class="bg-white text-xs uppercase tracking-[0.2em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Mata Pelajaran</th>
                                    <th class="px-4 py-3">Nilai</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach($grades as $grade)
                                    @php
                                        $score = $grade->score;
                                        if ($score >= 85) {
                                            $scoreClass = 'bg-emerald-100 text-emerald-700';
                                        } elseif ($score >= 75) {
                                            $scoreClass = 'bg-sky-100 text-sky-700';
                                        } elseif ($score >= 60) {
                                            $scoreClass = 'bg-amber-100 text-amber-700';
                                        } else {
                                            $scoreClass = 'bg-rose-100 text-rose-700';
                                        }
                                        $status = $score >= 60 ? 'Lulus' : 'Remedial';
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-4 align-top text-sm text-slate-600">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 align-top text-sm text-slate-900">{{ $grade->subject?->name ?? '-' }}</td>
                                        <td class="px-4 py-4 align-top">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $scoreClass }}">{{ $score }}</span>
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm text-slate-900">{{ $status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
            <p class="text-sm text-slate-500">Rata-rata Nilai</p>
            <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-3xl font-extrabold text-slate-900">{{ number_format($averageScore, 1) }}</p>
                <p class="rounded-2xl bg-navy/5 px-4 py-3 text-sm font-semibold text-navy">Predikat: {{ $predicate }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
