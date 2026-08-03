@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-page-header title="Semester" subtitle="Bagi periode akademik menjadi semester aktif dan terkelola." badge="{{ $semesters->count() }} semester" />

    <div class="rounded-[32px] border border-slate-200/80 bg-white/85 p-6 shadow-[0_28px_70px_-35px_rgba(15,23,42,0.28)] backdrop-blur-xl sm:p-8">
        <h2 class="text-lg font-semibold text-slate-900">Tambah Semester</h2>
        <form action="{{ route('admin.semesters.store') }}" method="POST" class="mt-6 grid gap-6 lg:grid-cols-[1fr_1.2fr_1fr_1fr_auto]">
            @csrf
            <x-input
                name="name"
                label="Nama Semester"
                placeholder="Ganjil/Genap"
                value="{{ old('name') }}"
                required
                error="{{ $errors->first('name') }}"
            />

            <x-select
                name="academic_year_id"
                label="Tahun Akademik"
                :options="$academicYears->mapWithKeys(fn($y) => [$y->id => $y->name])->toArray()"
                value="{{ old('academic_year_id') }}"
                placeholder="Pilih tahun akademik"
                required
                error="{{ $errors->first('academic_year_id') }}"
            />

            <x-input
                name="start_date"
                type="date"
                label="Tanggal Mulai"
                value="{{ old('start_date') }}"
                required
                error="{{ $errors->first('start_date') }}"
            />

            <x-input
                name="end_date"
                type="date"
                label="Tanggal Selesai"
                value="{{ old('end_date') }}"
                required
                error="{{ $errors->first('end_date') }}"
            />

            <div class="flex items-end">
                <button class="w-full rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5">Tambah</button>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_18px_60px_-35px_rgba(15,23,42,0.15)]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                <tr>
                    <th class="px-4 py-4">ID</th>
                    <th class="px-4 py-4">Nama</th>
                    <th class="px-4 py-4">Tahun</th>
                    <th class="px-4 py-4">Periode</th>
                    <th class="px-4 py-4">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white/70 text-slate-700">
                @foreach($semesters as $s)
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-4 py-4 text-slate-600">{{ $s->id }}</td>
                        <td class="px-4 py-4 font-medium text-slate-900">{{ $s->name }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ $s->academicYear?->name ?? '-' }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ $s->start_date }} - {{ $s->end_date }}</td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.semesters.show', $s) }}" class="rounded-full bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-200">Detail</a>
                                <a href="{{ route('admin.semesters.edit', $s) }}" class="rounded-full bg-amber-500 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-amber-600">Edit</a>
                                <form action="{{ route('admin.semesters.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus semester?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-full bg-red-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
