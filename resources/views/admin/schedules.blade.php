@extends('layouts.app')

@section('page-title', 'Jadwal Pelajaran')
@section('breadcrumb', 'Admin › Jadwal Pelajaran')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Jadwal Pelajaran</h1>
            <p class="mt-1 text-slate-600">Kelola jadwal pembelajaran sekolah</p>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="rounded-2xl bg-white p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <!-- Academic Year Filter -->
            <div class="flex-1 min-w-48">
                <label for="academic_year_id" class="mb-2 block text-sm font-medium text-slate-700">Tahun Akademik</label>
                <select
                    id="academic_year_id"
                    name="academic_year_id"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm transition focus:border-navy focus:bg-white focus:outline-none"
                >
                    <option value="">Semua Tahun</option>
                    @foreach($academicYears ?? [] as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Semester Filter -->
            <div class="flex-1 min-w-48">
                <label for="semester_id" class="mb-2 block text-sm font-medium text-slate-700">Semester</label>
                <select
                    id="semester_id"
                    name="semester_id"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm transition focus:border-navy focus:bg-white focus:outline-none"
                >
                    <option value="">Semua Semester</option>
                    @foreach($semesters ?? [] as $semester)
                        <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                            {{ $semester->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Class Filter -->
            <div class="flex-1 min-w-48">
                <label for="class_id" class="mb-2 block text-sm font-medium text-slate-700">Kelas</label>
                <select
                    id="class_id"
                    name="class_id"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm transition focus:border-navy focus:bg-white focus:outline-none"
                >
                    <option value="">Semua Kelas</option>
                    @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <button type="submit" class="rounded-lg bg-navy px-6 py-2.5 font-medium text-white transition hover:bg-opacity-90">
                Saring
            </button>

            <!-- Reset Link -->
            @if(request()->hasAny(['academic_year_id', 'semester_id', 'class_id']))
                <a href="{{ route('admin.schedules.index') }}" class="rounded-lg border border-slate-200 px-6 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Add Schedule Form (Collapsible) -->
    <div x-data="{ formOpen: false }">
        <button
            @click="formOpen = !formOpen"
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-gold px-6 py-3 font-semibold text-navy shadow-lg transition hover:bg-opacity-90"
        >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Jadwal
        </button>

        <!-- Form Card -->
        <div x-show="formOpen" class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-bold text-navy">Tambah Jadwal Pelajaran</h3>
            <form method="POST" action="{{ route('admin.schedules.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Academic Year -->
                    <div>
                        <label for="form_academic_year_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Tahun Akademik <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="form_academic_year_id"
                            name="academic_year_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('academic_year_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Tahun Akademik --</option>
                            @foreach($academicYears ?? [] as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="form_semester_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="form_semester_id"
                            name="semester_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('semester_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Semester --</option>
                            @foreach($semesters ?? [] as $semester)
                                <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Academic Class -->
                    <div>
                        <label for="form_academic_class_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="form_academic_class_id"
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

                    <!-- Subject -->
                    <div>
                        <label for="form_subject_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="form_subject_id"
                            name="subject_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('subject_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects ?? [] as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teacher -->
                    <div>
                        <label for="form_teacher_id" class="mb-2 block text-sm font-semibold text-slate-900">
                            Guru <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="form_teacher_id"
                            name="teacher_id"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('teacher_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Guru --</option>
                            @foreach($teachers ?? [] as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Day -->
                    <div>
                        <label for="form_day" class="mb-2 block text-sm font-semibold text-slate-900">
                            Hari <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="form_day"
                            name="day"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('day') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu'] as $value => $label)
                                <option value="{{ $value }}" {{ old('day') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('day')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="form_start_time" class="mb-2 block text-sm font-semibold text-slate-900">
                            Jam Mulai <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="time"
                            id="form_start_time"
                            name="start_time"
                            value="{{ old('start_time') }}"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('start_time') border-red-500 @enderror"
                            required
                        >
                        @error('start_time')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="form_end_time" class="mb-2 block text-sm font-semibold text-slate-900">
                            Jam Selesai <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="time"
                            id="form_end_time"
                            name="end_time"
                            value="{{ old('end_time') }}"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('end_time') border-red-500 @enderror"
                            required
                        >
                        @error('end_time')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room -->
                    <div>
                        <label for="form_room" class="mb-2 block text-sm font-semibold text-slate-900">
                            Ruang <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="form_room"
                            name="room"
                            value="{{ old('room') }}"
                            placeholder="Contoh: Ruang 101"
                            class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('room') border-red-500 @enderror"
                            required
                        >
                        @error('room')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 border-t border-slate-200 pt-4">
                    <button
                        type="submit"
                        class="rounded-xl bg-gold px-6 py-3 font-semibold text-navy shadow-lg transition hover:bg-opacity-90"
                    >
                        Simpan Jadwal
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

    <!-- Data Table -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <!-- Table Header -->
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Guru</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Hari</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Ruang</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($schedules ?? [] as $i => $schedule)
                        <tr class="{{ $i % 2 === 1 ? 'bg-slate-50' : '' }} border-t border-slate-200 transition hover:bg-slate-100">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $i + 1 }}
                            </td>

                            <!-- Kelas -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $schedule->academicClass->name ?? '-' }}
                            </td>

                            <!-- Mata Pelajaran -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $schedule->subject->name ?? '-' }}
                            </td>

                            <!-- Guru -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $schedule->teacher?->user?->name ?? '-' }}
                            </td>

                            <!-- Hari -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                @php
                                    $dayMap = [
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu'
                                    ];
                                @endphp
                                {{ $dayMap[$schedule->day] ?? $schedule->day }}
                            </td>

                            <!-- Waktu -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '-' }} – {{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '-' }}
                            </td>

                            <!-- Ruang -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $schedule->room ?? '-' }}
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-gold" title="Edit">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <button
                                        x-data="{ open: false }"
                                        @click="open = true"
                                        type="button"
                                        class="rounded-lg p-2 text-slate-600 transition hover:bg-red-100 hover:text-red-600"
                                        title="Hapus"
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div
                                        x-data="{ open: false }"
                                        x-show="open"
                                        @click.outside="open = false"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                                    >
                                        <div class="rounded-2xl bg-white p-6 shadow-2xl max-w-sm mx-4">
                                            <div class="mb-4 flex justify-center">
                                                <div class="rounded-full bg-red-100 p-3">
                                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <h3 class="mb-2 text-center text-lg font-bold text-slate-900">Yakin ingin menghapus?</h3>
                                            <p class="mb-6 text-center text-sm text-slate-600">Jadwal <strong>{{ $schedule->subject->name }}</strong> akan dihapus permanen.</p>
                                            <div class="flex gap-3">
                                                <button @click="open = false" class="flex-1 rounded-lg border border-slate-200 px-4 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                                                    Batal
                                                </button>
                                                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2.5 font-medium text-white transition hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-900">Belum ada jadwal</p>
                                        <p class="text-sm text-slate-600">Tambahkan jadwal baru untuk memulai</p>
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

@endsection
