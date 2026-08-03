@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-page-header title="Edit Siswa" subtitle="Perbarui data siswa dan informasi akademik secara akurat." />

    <div class="rounded-[32px] border border-slate-200/80 bg-white/85 p-6 shadow-[0_28px_70px_-35px_rgba(15,23,42,0.28)] backdrop-blur-xl sm:p-8">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="grid gap-6 lg:grid-cols-2">
            @csrf
            @method('PUT')

            <x-select
                name="user_id"
                label="User"
                :options="$users->mapWithKeys(fn($user) => [$user->id => $user->name . ' (' . $user->email . ')'])->toArray()"
                value="{{ old('user_id', $student->user_id) }}"
                placeholder="Pilih user"
                required
                error="{{ $errors->first('user_id') }}"
            />

            <x-input
                name="nis"
                label="NIS"
                placeholder="NIS"
                value="{{ old('nis', $student->nis) }}"
                required
                error="{{ $errors->first('nis') }}"
            />

            <x-select
                name="academic_class_id"
                label="Kelas"
                :options="$classes->mapWithKeys(fn($class) => [$class->id => $class->name])->toArray()"
                value="{{ old('academic_class_id', $student->academic_class_id) }}"
                placeholder="Pilih kelas"
                required
                error="{{ $errors->first('academic_class_id') }}"
            />

            <x-select
                name="gender"
                label="Jenis Kelamin"
                :options="['male' => 'Laki-laki', 'female' => 'Perempuan']"
                value="{{ old('gender', $student->gender) }}"
                placeholder="Pilih jenis kelamin"
                required
                error="{{ $errors->first('gender') }}"
            />

            <x-input
                name="birthdate"
                type="date"
                label="Tanggal Lahir"
                value="{{ old('birthdate', $student->birthdate) }}"
                error="{{ $errors->first('birthdate') }}"
            />
            <x-input
                name="birthplace"
                label="Tempat Lahir"
                placeholder="Tempat lahir"
                value="{{ old('birthplace', $student->birthplace) }}"
                error="{{ $errors->first('birthplace') }}"
            />

            <x-input
                name="address"
                label="Alamat"
                placeholder="Alamat lengkap"
                value="{{ old('address', $student->address) }}"
                error="{{ $errors->first('address') }}"
                class="lg:col-span-2"
            />

            <div class="lg:col-span-2">
                <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5">Perbarui Siswa</button>
            </div>
        </form>
    </div>
</div>
@endsection
