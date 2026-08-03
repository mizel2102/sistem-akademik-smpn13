@extends('layouts.app')

@section('page-title', 'Tambah Pembinaan - Guru BK')
@section('breadcrumb', 'Guru BK › Pembinaan › Tambah')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-navy mb-6">Form Pembinaan Siswa</h2>

        <form action="{{ route('bk.counselings.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Student -->
            <div>
                <label for="student_id" class="block text-sm font-semibold text-slate-700 mb-1">Siswa <span class="text-red-500">*</span></label>
                <select name="student_id" id="student_id" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('student_id') border-red-500 @enderror">
                    <option value="">Pilih Siswa</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->student_number }} - {{ $student->user?->name ?? 'N/A' }}
                            @if ($student->academicClass)
                                ({{ $student->academicClass->name }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Session Date -->
            <div>
                <label for="session_at" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Sesi</label>
                <input type="datetime-local" name="session_at" id="session_at"
                       value="{{ old('session_at') }}"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('session_at') border-red-500 @enderror">
                @error('session_at')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                <select name="status" id="status"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none">
                    <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1">Catatan Pembinaan</label>
                <textarea name="notes" id="notes" rows="4"
                          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('notes') border-red-500 @enderror"
                          placeholder="Deskripsikan hasil pembinaan...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Follow Up -->
            <div>
                <label for="follow_up" class="block text-sm font-semibold text-slate-700 mb-1">Tindak Lanjut</label>
                <textarea name="follow_up" id="follow_up" rows="3"
                          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('follow_up') border-red-500 @enderror"
                          placeholder="Rencana tindak lanjut...">{{ old('follow_up') }}</textarea>
                @error('follow_up')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recommendation -->
            <div>
                <label for="recommendation" class="block text-sm font-semibold text-slate-700 mb-1">Rekomendasi</label>
                <textarea name="recommendation" id="recommendation" rows="3"
                          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('recommendation') border-red-500 @enderror"
                          placeholder="Rekomendasi untuk siswa...">{{ old('recommendation') }}</textarea>
                @error('recommendation')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('bk.counselings.index') }}"
                   class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="rounded-lg bg-navy px-6 py-2 text-sm font-semibold text-white hover:bg-navy/90">
                    Simpan Pembinaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
