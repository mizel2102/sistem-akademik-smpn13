@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-lg shadow-slate-200/20">
        <div class="mb-6 rounded-2xl bg-blue-50 px-4 py-4 text-sm text-blue-700">
            Surat Peringatan diterbitkan kepada siswa yang melanggar aturan sekolah.
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Buat Surat Peringatan</h1>
            <p class="mt-2 text-sm text-slate-600">Isi data siswa dan rincian surat peringatan.</p>
        </div>

        <form action="{{ route('admin.warning-letters.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="student_name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Siswa / NIS <span class="text-red-500">*</span></label>
                <input
                    id="student_name"
                    name="student_name"
                    type="text"
                    value="{{ old('student_name', request('student_name')) }}"
                    placeholder="Ketik Nama Siswa atau NIS (contoh: REYHAN LUBIS SAPUTRA atau 2502287)..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('student_name') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror @error('student_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                @error('student_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('student_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-700">Kelas Siswa</label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('academic_class_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                >
                    <option value="">-- Pilih Kelas Siswa (Opsional) --</option>
                    @foreach($academicClasses as $class)
                        <option value="{{ $class->id }}" {{ old('academic_class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} @if($class->room) ({{ $class->room }}) @endif
                        </option>
                    @endforeach
                </select>
                @error('academic_class_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">Jenis Surat</label>
                <select
                    id="type"
                    name="type"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('type') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="SP1" {{ old('type') === 'SP1' ? 'selected' : '' }}>SP1 (Surat Peringatan 1)</option>
                    <option value="SP2" {{ old('type') === 'SP2' ? 'selected' : '' }}>SP2 (Surat Peringatan 2)</option>
                    <option value="SP3" {{ old('type') === 'SP3' ? 'selected' : '' }}>SP3 (Surat Peringatan 3)</option>
                </select>
                @error('type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reason" class="mb-2 block text-sm font-semibold text-slate-700">Alasan / Pelanggaran</label>
                <textarea
                    id="reason"
                    name="reason"
                    rows="4"
                    placeholder="Jelaskan pelanggaran yang dilakukan..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('reason') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="issued_at" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Surat</label>
                <input
                    id="issued_at"
                    name="issued_at"
                    type="date"
                    value="{{ old('issued_at') }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('issued_at') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('issued_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.warning-letters.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                    Batal
                </a>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 sm:w-auto">
                    Buat Surat Peringatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
