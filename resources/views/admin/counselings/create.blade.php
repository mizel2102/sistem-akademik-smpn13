@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-lg shadow-slate-200/30">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Tambah Catatan BK</h1>
            <p class="mt-2 text-sm text-slate-600">Isi detail sesi bimbingan konseling untuk siswa.</p>
        </div>

        <form action="{{ route('admin.counselings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="student_id" class="mb-2 block text-sm font-semibold text-slate-700">Pilih Siswa</label>
                <select
                    id="student_id"
                    name="student_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('student_id') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->user?->name ?? 'Siswa #' . $student->id }} — {{ $student->student_number }}
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">Catatan</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Tuliskan catatan konseling..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('notes') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="follow_up" class="mb-2 block text-sm font-semibold text-slate-700">Tindak Lanjut</label>
                <textarea
                    id="follow_up"
                    name="follow_up"
                    rows="3"
                    placeholder="Rencana tindak lanjut..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('follow_up') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                >{{ old('follow_up') }}</textarea>
                @error('follow_up')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="session_at" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Sesi</label>
                <input
                    id="session_at"
                    name="session_at"
                    type="datetime-local"
                    value="{{ old('session_at') }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('session_at') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('session_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.counselings.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                    Batal
                </a>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-900 sm:w-auto">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
