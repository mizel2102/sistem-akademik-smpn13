@extends('layouts.app')

@section('page-title', 'Input Nilai')
@section('breadcrumb', 'Guru › Input Nilai')

@section('content')
<div class="space-y-6" x-data="{
    formOpen: false,
    editOpen: false,
    editData: { id: '', student_id: '', academic_class_id: '', assignment: '', score: '', status: '' }
}">
    <!-- Page Header with Class Selector -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Input Nilai</h1>
            <p class="mt-1 text-slate-600">Kelola nilai dan tugas siswa</p>
        </div>
        <div class="w-48">
            <label for="class_filter" class="mb-2 block text-sm font-medium text-slate-700">Filter Kelas</label>
            <select
                id="class_filter"
                name="class_filter"
                class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm transition focus:border-navy focus:bg-white focus:outline-none"
            >
                <option value="">Semua Kelas</option>
                @foreach($classes ?? [] as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Add Grade Form (Collapsible) -->
    <div x-show="true">
        <button
            @click="formOpen = !formOpen"
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
        >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Nilai
        </button>

        <!-- Form Card -->
        <div x-show="formOpen" class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-bold text-navy">Tambah Nilai Baru</h3>
            <form method="POST" action="{{ route('teacher.grades.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pilih Siswa -->
                    <div>
                        <label for="student_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Pilih Siswa <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="student_id"
                            name="student_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('student_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($studentOptions ?? [] as $option)
                                <option value="{{ $option['id'] }}" {{ old('student_id') == $option['id'] ? 'selected' : '' }}>
                                    {{ $option['name'] ?? $option['label'] ?? 'Siswa Tidak Diketahui' }} ({{ $option['class'] ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Kelas -->
                    <div>
                        <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Pilih Kelas <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="academic_class_id"
                            name="academic_class_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('academic_class_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes ?? [] as $class)
                                <option value="{{ $class->id }}" {{ old('academic_class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_class_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tugas (Assignment) -->
                    <div>
                        <label for="assignment" class="mb-2 block text-sm font-semibold text-slate-900">
                            Tugas <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="assignment"
                            name="assignment"
                            value="{{ old('assignment') }}"
                            placeholder="Contoh: Ulangan Harian 1"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('assignment') border-red-500 @enderror"
                            required
                        >
                        @error('assignment')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nilai (Score) -->
                    <div>
                        <label for="score" class="mb-2 block text-sm font-semibold text-slate-900">
                            Nilai <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="score"
                            name="score"
                            value="{{ old('score') }}"
                            min="0"
                            max="100"
                            step="0.5"
                            placeholder="0-100"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('score') border-red-500 @enderror"
                            required
                        >
                        @error('score')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label for="status" class="mb-2 block text-sm font-semibold text-slate-900">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('status') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Status --</option>
                            <option value="pass" {{ old('status') === 'pass' ? 'selected' : '' }}>Lulus</option>
                            <option value="fail" {{ old('status') === 'fail' ? 'selected' : '' }}>Tidak Lulus</option>
                            <option value="remedial" {{ old('status') === 'remedial' ? 'selected' : '' }}>Remedial</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 border-t border-slate-200 pt-4">
                    <button
                        type="submit"
                        class="rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
                    >
                        Simpan Nilai
                    </button>
                    <button
                        @click="formOpen = false"
                        type="button"
                        class="rounded-xl border-2 border-slate-200 px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Gradebook Table -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <!-- Table Header -->
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tugas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nilai</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($gradebook ?? [] as $i => $entry)
                        <tr class="{{ $i % 2 === 1 ? 'bg-slate-50' : '' }} border-t border-slate-200 transition hover:bg-slate-100">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $i + 1 }}
                            </td>

                            <!-- Nama Siswa -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $entry['student_name'] ?? '-' }}
                            </td>

                            <!-- Kelas -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $entry['class_name'] ?? '-' }}
                            </td>

                            <!-- Tugas -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $entry['assignment'] ?? '-' }}
                            </td>

                            <!-- Nilai (Color-coded) -->
                            <td class="px-6 py-4 text-sm font-semibold">
                                @php
                                    $score = $entry['score'] ?? 0;
                                    if ($score >= 75) {
                                        $color = 'text-green-600 bg-green-100';
                                    } elseif ($score >= 60) {
                                        $color = 'text-amber-600 bg-amber-100';
                                    } else {
                                        $color = 'text-red-600 bg-red-100';
                                    }
                                @endphp
                                <span class="inline-block rounded px-3 py-1 {{ $color }}">
                                    {{ $score }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $statusMap = [
                                        'pass' => ['label' => 'Lulus', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                        'fail' => ['label' => 'Tidak Lulus', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                        'remedial' => ['label' => 'Remedial', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
                                    ];
                                    $status = $statusMap[$entry['status']] ?? $statusMap['fail'];
                                @endphp
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <button
                                        type="button"
                                        @click="
                                            editData.id = '{{ $entry['id'] ?? '' }}';
                                            editData.student_id = '{{ $entry['student_id'] ?? '' }}';
                                            editData.academic_class_id = '{{ $entry['academic_class_id'] ?? '' }}';
                                            editData.assignment = '{{ addslashes($entry['assignment'] ?? '') }}';
                                            editData.score = '{{ $entry['score'] ?? '' }}';
                                            editData.status = '{{ $entry['status'] ?? '' }}';
                                            editOpen = true;
                                        "
                                        class="rounded-lg p-2 text-slate-600 transition hover:bg-amber-100 hover:text-amber-600"
                                        title="Edit"
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('teacher.grades.destroy', $entry['id'] ?? '') }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-600 transition hover:bg-red-100 hover:text-red-600"
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus nilai ini?');"
                                        >
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-900">Belum ada nilai yang diinput</p>
                                        <p class="text-sm text-slate-600">Mulai dengan menambahkan nilai baru untuk siswa</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Edit Grade Modal -->
    <div
        x-show="editOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm"
        x-transition
        x-cloak
    >
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl" @click.away="editOpen = false">
            <h3 class="mb-4 text-xl font-bold text-navy">Edit Nilai Siswa</h3>
            <form method="POST" :action="'/teacher/grades/' + editData.id" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pilih Siswa -->
                    <div>
                        <label for="edit_student_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Pilih Siswa <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="edit_student_id"
                            name="student_id"
                            x-model="editData.student_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                            required
                        >
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($studentOptions ?? [] as $option)
                                <option value="{{ $option['id'] }}">
                                    {{ $option['name'] ?? $option['label'] ?? 'Siswa Tidak Diketahui' }} ({{ $option['class'] ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Kelas -->
                    <div>
                        <label for="edit_academic_class_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Pilih Kelas <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="edit_academic_class_id"
                            name="academic_class_id"
                            x-model="editData.academic_class_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                            required
                        >
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes ?? [] as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tugas (Assignment) -->
                    <div>
                        <label for="edit_assignment" class="mb-2 block text-sm font-semibold text-slate-900">
                            Tugas <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="edit_assignment"
                            name="assignment"
                            x-model="editData.assignment"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                            required
                        >
                    </div>

                    <!-- Nilai (Score) -->
                    <div>
                        <label for="edit_score" class="mb-2 block text-sm font-semibold text-slate-900">
                            Nilai <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="edit_score"
                            name="score"
                            x-model="editData.score"
                            min="0"
                            max="100"
                            step="0.5"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                            required
                        >
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label for="edit_status" class="mb-2 block text-sm font-semibold text-slate-900">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="edit_status"
                            name="status"
                            x-model="editData.status"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                            required
                        >
                            <option value="">-- Pilih Status --</option>
                            <option value="pass">Lulus</option>
                            <option value="fail">Tidak Lulus</option>
                            <option value="remedial">Remedial</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 border-t border-slate-200 pt-4">
                    <button
                        type="submit"
                        class="rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
                    >
                        Simpan Perubahan
                    </button>
                    <button
                        @click="editOpen = false"
                        type="button"
                        class="rounded-xl border-2 border-slate-200 px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
