@extends('layouts.app')

@section('page-title', 'Terbitkan SP - Guru BK')
@section('breadcrumb', 'Guru BK › Surat Peringatan › Terbitkan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-navy mb-6">Terbitkan Surat Peringatan</h2>

        <form action="{{ route('bk.warning-letters.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Student Name Input (Text Input) -->
            <div>
                <label for="student_name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Siswa / NIS <span class="text-red-500">*</span></label>
                <input type="text" name="student_name" id="student_name" required
                       value="{{ old('student_name', request('student_name')) }}"
                       placeholder="Ketik Nama Siswa atau NIS (contoh: REYHAN LUBIS SAPUTRA atau 2502287)..."
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('student_name') border-red-500 @enderror @error('student_id') border-red-500 @enderror">
                @error('student_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                @error('student_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas (Class) -->
            <div>
                <label for="academic_class_id" class="block text-sm font-semibold text-slate-700 mb-1">Kelas Siswa</label>
                <select name="academic_class_id" id="academic_class_id"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('academic_class_id') border-red-500 @enderror">
                    <option value="">-- Pilih Kelas Siswa (Opsional) --</option>
                    @foreach ($academicClasses as $class)
                        <option value="{{ $class->id }}" {{ old('academic_class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} @if($class->room) ({{ $class->room }}) @endif
                        </option>
                    @endforeach
                </select>
                @error('academic_class_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- SP Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Surat Peringatan <span class="text-red-500">*</span></label>
                <select name="type" id="type" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('type') border-red-500 @enderror">
                    <option value="">Pilih Jenis SP</option>
                    <option value="SP1" {{ old('type') === 'SP1' ? 'selected' : '' }}>SP1 (Alpha 3-5)</option>
                    <option value="SP2" {{ old('type') === 'SP2' ? 'selected' : '' }}>SP2 (Alpha 6-8)</option>
                    <option value="SP3" {{ old('type') === 'SP3' ? 'selected' : '' }}>SP3 (Alpha 9+)</option>
                </select>
                @error('type')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reason -->
            <div>
                <label for="reason" class="block text-sm font-semibold text-slate-700 mb-1">Alasan Penerbitan</label>
                <textarea name="reason" id="reason" rows="4"
                          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none @error('reason') border-red-500 @enderror"
                          placeholder="Deskripsikan alasan penerbitan surat peringatan...">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Issued At -->
            <div>
                <label for="issued_at" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Terbit</label>
                <input type="datetime-local" name="issued_at" id="issued_at"
                       value="{{ old('issued_at') }}"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none">
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('bk.warning-letters.index') }}"
                   class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="rounded-lg bg-navy px-6 py-2 text-sm font-semibold text-white hover:bg-navy/90">
                    Terbitkan SP
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('student_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const alphaCount = selected.getAttribute('data-alpha');
    const info = document.getElementById('alpha-info');
    const count = document.getElementById('alpha-count');

    if (alphaCount !== null) {
        info.classList.remove('hidden');
        count.textContent = alphaCount;
    } else {
        info.classList.add('hidden');
    }
});
</script>
@endpush
@endsection
