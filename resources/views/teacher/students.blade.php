@extends('layouts.app')

@section('page-title', 'Data Siswa - Portal Guru')
@section('breadcrumb', 'Guru › Data Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Data Siswa yang Diajar</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar seluruh siswa terdaftar di kelas binaan/ampuhan Anda.</p>
        </div>
        <div class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
            Total Siswa Terdaftar: {{ $students instanceof \Illuminate\Pagination\LengthAwarePaginator ? $students->total() : $students->count() }} Siswa
        </div>
    </div>

    <!-- Filter Card -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-slate-100">
        <form method="GET" action="{{ route('teacher.students.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[240px]">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari Nama Siswa atau NIS..."
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
            </div>
            <div class="w-48">
                <select name="class_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-navy px-5 py-2 text-sm font-semibold text-white hover:bg-navy/90">
                Filter
            </button>
            @if(request()->hasAny(['search', 'class_id']))
                <a href="{{ route('teacher.students.index') }}" class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-200">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">No</th>
                        <th class="px-5 py-3.5">Siswa</th>
                        <th class="px-5 py-3.5">NIS / Nomor Induk</th>
                        <th class="px-5 py-3.5">Kelas Utama</th>
                        <th class="px-5 py-3.5">Tingkat</th>
                        <th class="px-5 py-3.5 text-center">Status Akses</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($students as $index => $student)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-5 py-4 text-slate-500 font-medium">
                                {{ $students instanceof \Illuminate\Pagination\LengthAwarePaginator ? $students->firstItem() + $index : $index + 1 }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-full bg-navy/10 flex items-center justify-center font-bold text-navy text-sm">
                                        {{ strtoupper(substr($student->user?->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $student->user?->name ?? 'Siswa Tanpa Nama' }}</p>
                                        <p class="text-xs text-slate-500">{{ $student->user?->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-mono text-slate-700">
                                {{ $student->student_number ?? $student->nis ?? '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                    {{ $student->academicClass?->name ?? ($student->classes->first()?->name ?? 'Belum Ada Kelas') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-600 font-medium">
                                Kelas {{ $student->grade_level ?? '7' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-500">
                                <div class="max-w-xs mx-auto text-center">
                                    <p class="font-medium text-slate-700">Tidak ada siswa ditemukan.</p>
                                    <p class="mt-1 text-xs text-slate-400">Pastikan kelas ampuhan telah dibuat dan siswa telah terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students instanceof \Illuminate\Pagination\LengthAwarePaginator && $students->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
