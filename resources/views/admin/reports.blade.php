@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900">Laporan Akademik</h1>
        <p class="mt-2 text-sm text-slate-600">Pilih siswa dan jenis laporan untuk melihat atau mengunduh hasil akademik.</p>
    </div>

    @php
        $selectedId = old('student_id', request('student_id'));
    @endphp

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label for="student_id" class="mb-2 block text-sm font-semibold text-slate-900">Pilih Siswa</label>
                @if(isset($students) && $students->isNotEmpty())
                    <select
                        id="student_id"
                        name="student_id"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Cari siswa...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $selectedId == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}{{ $student->user?->email ? ' — ' . $student->user->email : '' }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input
                        id="student_id"
                        name="student_id"
                        type="text"
                        value="{{ $selectedId }}"
                        placeholder="Masukkan ID siswa atau kirim $students dari controller"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    />
                    <p class="mt-2 text-xs text-slate-500">Gunakan variabel $students dari controller untuk menampilkan pilihan siswa.</p>
                @endif
            </div>

            <div>
                <p class="mb-2 text-sm font-semibold text-slate-900">Jenis Laporan</p>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                        <input type="radio" name="report_type" value="rapor" {{ old('report_type', request('report_type', 'rapor')) === 'rapor' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500" />
                        Rapor Siswa
                    </label>
                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                        <input type="radio" name="report_type" value="rekap" {{ old('report_type', request('report_type', 'rapor')) === 'rekap' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500" />
                        Rekap Nilai
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a
                href="{{ $selectedId ? route('admin.reports.rapor', ['student' => $selectedId]) : '#' }}"
                class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
                @if(!$selectedId) aria-disabled="true" @endif
            >
                Lihat Laporan
            </a>
            <a
                href="{{ $selectedId ? route('admin.reports.rapor.pdf', ['student' => $selectedId]) : '#' }}"
                class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
                @if(!$selectedId) aria-disabled="true" @endif
            >
                Download PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M6 9V2h12v7"></path>
                        <path d="M6 9a6 6 0 0 0 12 0"></path>
                        <path d="M6 9h12"></path>
                        <line x1="9" y1="14" x2="15" y2="14"></line>
                        <line x1="9" y1="18" x2="15" y2="18"></line>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-900">Laporan PDF tersedia</h3>
            </div>
            <p class="text-sm text-slate-600">Laporan PDF tersedia via tombol Download PDF setelah memilih siswa.</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-900">Rapor mencakup semua nilai</h3>
            </div>
            <p class="text-sm text-slate-600">Rapor mencakup semua nilai dan semester siswa.</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-900">Data diambil langsung</h3>
            </div>
            <p class="text-sm text-slate-600">Data diambil langsung dari database nilai dan data akademik siswa.</p>
        </div>
    </div>
</div>
@endsection
