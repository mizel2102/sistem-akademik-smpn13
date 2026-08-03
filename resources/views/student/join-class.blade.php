@extends('layouts.app')

@section('page-title', 'Gabung Kelas')
@section('breadcrumb', 'Siswa › Gabung Kelas')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Gabung Kelas Baru</h1>
        <p class="mt-2 text-slate-600">Masukkan Kode Token Akses yang diberikan oleh Guru Anda untuk bergabung ke kelas.</p>
    </div>

    <!-- Form Input Token -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('student.join-class.process') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="access_token" class="block text-sm font-semibold text-slate-800">Kode Token Akses Kelas</label>
                <div class="mt-2 flex gap-3">
                    <input
                        type="text"
                        name="access_token"
                        id="access_token"
                        value="{{ old('access_token') }}"
                        placeholder="Contoh: PJOK7A"
                        class="block w-full rounded-xl border border-slate-300 px-4 py-3 font-mono text-lg font-bold tracking-widest text-slate-900 uppercase focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                        required
                    />
                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center justify-center rounded-xl bg-navy px-6 py-3 font-semibold text-white transition hover:bg-opacity-90 shadow-sm"
                    >
                        Gabung Kelas
                    </button>
                </div>
                @error('access_token')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </div>

    <!-- Daftar Kelas Saya -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-navy mb-4">Kelas Yang Diikuti</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @forelse($myClasses ?? [] as $class)
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg">{{ $class->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">Ruang: {{ $class->room ?? '-' }} • Wali/Guru: {{ $class->teacher->user->name ?? '-' }}</p>
                    </div>
                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terdaftar</span>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-sm text-slate-500">
                    Anda belum terdaftar di kelas manapun. Masukkan kode token kelas dari guru di atas.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
