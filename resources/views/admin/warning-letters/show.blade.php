@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-6 py-10">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Surat Peringatan {{ $letter->type }}</h1>
            <p class="mt-2 text-sm text-slate-600">Detail surat resmi dan riwayat pelanggaran siswa.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.warning-letters.pdf', $letter) }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Download PDF
            </a>
            <a href="{{ route('admin.warning-letters.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Kembali
            </a>
        </div>
    </div>

    <div class="mx-auto max-w-2xl rounded-2xl bg-white p-10 shadow-lg">
        <div class="flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-900 text-xl font-extrabold text-white">13</div>
                <div>
                    <p class="text-xl font-extrabold text-slate-900">SMP NEGERI 13</p>
                    <p class="text-sm text-slate-500">Sistem Akademik</p>
                </div>
            </div>

            <div class="border-b-2 border-slate-900"></div>

            <div class="text-center">
                <h2 class="text-xl font-extrabold uppercase tracking-[0.16em] text-slate-900">Surat Peringatan {{ $letter->type }}</h2>
                <p class="mt-4 text-sm text-slate-600">Tanggal: {{ $letter->issued_at?->format('d F Y') ?? '-' }}</p>
            </div>

            <div class="space-y-4 text-sm leading-7 text-slate-700">
                <p>Yang bertanda tangan di bawah ini, pihak sekolah memberikan surat peringatan kepada:</p>

                <div class="space-y-2 rounded-2xl bg-slate-50 p-5 text-slate-700">
                    <p><span class="font-semibold">Nama:</span> {{ $letter->student?->user?->name ?? '-' }}</p>
                    <p><span class="font-semibold">NIS:</span> {{ $letter->student?->student_number ?? '-' }}</p>
                    <p><span class="font-semibold">Kelas:</span> {{ $letter->student?->academicClass?->name ?? '-' }}</p>
                </div>

                <p>Dengan alasan:</p>
                <blockquote class="rounded-2xl border-l-4 border-blue-500 bg-blue-50 px-5 py-4 text-slate-700">
                    {{ $letter->reason ?? '-' }}
                </blockquote>
            </div>

            <div class="mt-10 text-sm text-slate-700">
                <div class="flex flex-col gap-1">
                    <p>Diterbitkan oleh: <span class="font-semibold">{{ $letter->issuer?->name ?? '-' }}</span></p>
                    <p>Tanggal: <span class="font-semibold">{{ $letter->issued_at?->format('d F Y') ?? '-' }}</span></p>
                </div>

                <div class="mt-8 inline-flex flex-col items-start gap-2">
                    <div class="h-0.5 w-48 bg-slate-400"></div>
                    <p class="text-sm font-semibold text-slate-900">Kepala Sekolah / Administrator</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
