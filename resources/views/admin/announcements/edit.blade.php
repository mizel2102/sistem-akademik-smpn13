@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl py-10">
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-[0_20px_70px_-30px_rgba(15,23,42,0.18)]">
        <h1 class="text-2xl font-extrabold text-slate-900">Edit Pengumuman</h1>
        <p class="mt-2 text-sm text-slate-600">Perbarui judul, konten, audience, dan tanggal terbit pengumuman.</p>

        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                <input
                    id="title"
                    name="title"
                    type="text"
                    value="{{ old('title', $announcement->title) }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('title') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="mb-2 block text-sm font-semibold text-slate-700">Konten</label>
                <textarea
                    id="content"
                    name="content"
                    rows="6"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('content') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                >{{ old('content', $announcement->content) }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <p class="mb-3 text-sm font-semibold text-slate-700">Audience</p>
                <div class="grid gap-3 sm:grid-cols-3">
                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-blue-300">
                        <input
                            type="radio"
                            name="audience"
                            value="all"
                            {{ old('audience', $announcement->audience) === 'all' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                            required
                        />
                        Semua
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-blue-300">
                        <input
                            type="radio"
                            name="audience"
                            value="teacher"
                            {{ old('audience', $announcement->audience) === 'teacher' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                        />
                        Guru
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-blue-300">
                        <input
                            type="radio"
                            name="audience"
                            value="student"
                            {{ old('audience', $announcement->audience) === 'student' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                        />
                        Siswa
                    </label>
                </div>
                @error('audience')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="published_at" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Terbit</label>
                <input
                    id="published_at"
                    name="published_at"
                    type="datetime-local"
                    value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 @error('published_at') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                    required
                />
                @error('published_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-700 sm:w-auto">Simpan Perubahan</button>
                <a href="{{ route('admin.announcements.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
