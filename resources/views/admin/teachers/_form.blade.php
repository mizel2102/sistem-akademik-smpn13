@props([
    'action',
    'submitLabel',
    'method' => 'POST',
    'teacher' => null,
])

<form action="{{ $action }}" method="POST" class="mt-8 space-y-6">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap Guru *</label>
        <input
            id="name"
            name="name"
            type="text"
            required
            placeholder="Contoh: ADNANSYAH, S.Pd.MM"
            value="{{ old('name', $teacher->user->name ?? '') }}"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email *</label>
        <input
            id="email"
            name="email"
            type="email"
            required
            placeholder="guru@smpn13.sch.id"
            value="{{ old('email', $teacher->user->email ?? '') }}"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password {{ isset($teacher) ? '(Biarkan kosong jika tidak diubah)' : '*' }}</label>
        <input
            id="password"
            name="password"
            type="password"
            {{ isset($teacher) ? '' : 'required' }}
            placeholder="Min. 8 Karakter"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nip" class="mb-2 block text-sm font-medium text-slate-700">NIP *</label>
        <input
            id="nip"
            name="nip"
            type="text"
            required
            placeholder="Nomor Induk Pegawai"
            value="{{ old('nip', $teacher->nip ?? '') }}"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        @error('nip')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="subject_name" class="mb-2 block text-sm font-medium text-slate-700">Mata Pelajaran</label>
        <input
            id="subject_name"
            name="subject_name"
            type="text"
            placeholder="Contoh: PJOK / Matematika / Bahasa Indonesia"
            value="{{ old('subject_name', $teacher->subject->name ?? '') }}"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        @error('subject_name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="started_at" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Mulai Mengajar</label>
        <input
            id="started_at"
            name="started_at"
            type="date"
            value="{{ old('started_at', (isset($teacher) && $teacher->started_at) ? $teacher->started_at->format('Y-m-d') : '') }}"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        @error('started_at')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90">{{ $submitLabel }}</button>
        <a href="{{ route('admin.teachers.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
    </div>
</form>
