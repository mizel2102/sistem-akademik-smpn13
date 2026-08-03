@extends('layouts.app')

@section('page-title', isset($student) ? 'Edit Siswa' : 'Tambah Siswa')
@section('breadcrumb', isset($student) ? 'Admin › Edit Siswa' : 'Admin › Tambah Siswa')

@section('content')
<div class="mx-auto max-w-2xl">
    <!-- Card Container -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <!-- Card Header -->
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
            <h1 class="text-xl font-bold text-navy">
                {{ isset($student) ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                {{ isset($student) ? 'Ubah informasi data siswa di bawah ini' : 'Isi formulir untuk menambahkan siswa baru ke sistem' }}
            </p>
        </div>

        <!-- Card Body - Form -->
        <form
            method="POST"
            action="{{ isset($student) ? route('admin.students.update', $student) : route('admin.students.store') }}"
            class="space-y-5 p-6"
        >
            @csrf
            @if(isset($student))
                @method('PUT')
            @endif

            <!-- 1. Data Akun Siswa -->
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-900">
                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $student->user->name ?? '') }}"
                    placeholder="Contoh: ABDUL AZIZ"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-900">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $student->user->email ?? '') }}"
                    placeholder="siswa@smpn13.sch.id"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('email') border-red-500 @enderror"
                    required
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-900">
                    Password {{ isset($student) ? '(Biarkan kosong jika tidak diubah)' : '*' }}
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Min. 8 Karakter"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('password') border-red-500 @enderror"
                    {{ isset($student) ? '' : 'required' }}
                >
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. NIS -->
            <div>
                <label for="nis" class="mb-2 block text-sm font-semibold text-slate-900">
                    NIS <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="nis"
                    name="nis"
                    value="{{ old('nis', $student->nis ?? '') }}"
                    placeholder="Contoh: 20240001"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('nis') border-red-500 @enderror"
                    required
                >
                @error('nis')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 3. Tingkat -->
            <div>
                <label for="grade_level" class="mb-2 block text-sm font-semibold text-slate-900">
                    Tingkat <span class="text-red-500">*</span>
                </label>
                <select
                    id="grade_level"
                    name="grade_level"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('grade_level') border-red-500 @enderror"
                    required
                >
                    <option value="">-- Pilih Tingkat --</option>
                    @foreach(['7' => 'VII (Tujuh)', '8' => 'VIII (Delapan)', '9' => 'IX (Sembilan)'] as $value => $label)
                        <option
                            value="{{ $value }}"
                            @if(old('grade_level') === $value || (isset($student) && $student->grade_level === $value)) selected @endif
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('grade_level')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 4. Kelas -->
            <div>
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-900">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('academic_class_id') border-red-500 @enderror"
                    required
                >
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes ?? [] as $class)
                        <option
                            value="{{ $class->id }}"
                            @if(old('academic_class_id') === $class->id || (isset($student) && $student->academic_class_id === $class->id)) selected @endif
                        >
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('academic_class_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 5. Jenis Kelamin -->
            <div>
                <label for="gender" class="mb-2 block text-sm font-semibold text-slate-900">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select
                    id="gender"
                    name="gender"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('gender') border-red-500 @enderror"
                    required
                >
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    @foreach(['male' => 'Laki-laki', 'female' => 'Perempuan'] as $value => $label)
                        <option
                            value="{{ $value }}"
                            @if(old('gender') === $value || (isset($student) && $student->gender === $value)) selected @endif
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('gender')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 6. Tempat Lahir -->
            <div>
                <label for="birthplace" class="mb-2 block text-sm font-semibold text-slate-900">
                    Tempat Lahir <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="birthplace"
                    name="birthplace"
                    value="{{ old('birthplace', $student->birthplace ?? '') }}"
                    placeholder="Contoh: Jakarta"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('birthplace') border-red-500 @enderror"
                    required
                >
                @error('birthplace')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 7. Tanggal Lahir -->
            <div>
                <label for="birthdate" class="mb-2 block text-sm font-semibold text-slate-900">
                    Tanggal Lahir <span class="text-red-500">*</span>
                </label>
                <input
                    type="date"
                    id="birthdate"
                    name="birthdate"
                    value="{{ old('birthdate', isset($student) && $student->birthdate ? $student->birthdate->format('Y-m-d') : '') }}"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('birthdate') border-red-500 @enderror"
                    required
                >
                @error('birthdate')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- 8. Alamat -->
            <div>
                <label for="address" class="mb-2 block text-sm font-semibold text-slate-900">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    placeholder="Masukkan alamat lengkap siswa..."
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('address') border-red-500 @enderror"
                    required
                >{{ old('address', $student->address ?? '') }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 border-t border-slate-200 pt-6">
                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
                >
                    {{ isset($student) ? 'Simpan Perubahan' : 'Tambah Siswa' }}
                </button>
                <a
                    href="{{ route('admin.students.index') }}"
                    class="flex-1 rounded-xl border-2 border-slate-200 px-6 py-3 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
