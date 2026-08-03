<section id="team" class="bg-slate-50 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.35em] text-sky-500">Tenaga Pendidik</p>
            <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">Guru Profesional dan Berpengalaman</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-8 text-slate-600">Bertemu dengan guru-guru terbaik yang mendidik siswa dengan perhatian penuh dan standar akademik tinggi.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-3xl bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-md">
                <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-2xl">👩‍🏫</div>
                <h3 class="text-xl font-semibold text-slate-900">Bapak Ahmad</h3>
                <p class="mt-3 text-slate-600">Wakil Kepala Sekolah Bidang Kurikulum dengan pengalaman mengelola program pembelajaran inovatif.</p>
            </article>
            <article class="rounded-3xl bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-md">
                <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-2xl">👩‍💻</div>
                <h3 class="text-xl font-semibold text-slate-900">Ibu Siti</h3>
                <p class="mt-3 text-slate-600">Guru Matematika yang menggabungkan metode pembelajaran interaktif dan dukungan pribadi untuk siswa.</p>
            </article>
            <article class="rounded-3xl bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-md">
                <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-2xl">🎨</div>
                <h3 class="text-xl font-semibold text-slate-900">Bapak Dedi</h3>
                <p class="mt-3 text-slate-600">Guru Seni Budaya yang membantu siswa mengembangkan kreativitas dan rasa percaya diri.</p>
            </article>
        </div>

        @if(isset($teachers) && $teachers->count())
            <div class="mt-16 rounded-[32px] bg-white p-8 shadow-sm">
                <h3 class="text-2xl font-bold text-slate-900">Guru Unggulan</h3>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($teachers as $teacher)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                            <p class="text-lg font-semibold text-slate-900">{{ $teacher->user?->name ?? 'Guru SMPN 13' }}</p>
                            <p class="mt-2 text-sm text-slate-600">{{ $teacher->subject?->name ?? 'Guru Mata Pelajaran' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
