<section id="fitur" class="bg-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.35em] text-sky-500">Fitur Portal</p>
            <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">Layanan Digital untuk SMPN 13</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-8 text-slate-600">Portal akademik ini dirancang untuk membantu siswa, guru, dan orang tua mengakses informasi sekolah dengan cepat dan mudah.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-3xl bg-slate-50 p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-md">
                <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-2xl">📊</div>
                <h3 class="text-xl font-semibold text-slate-900">Nilai & Raport</h3>
                <p class="mt-4 text-slate-600">Akses nilai harian, ulangan, dan raport secara transparan untuk memantau kemajuan akademik siswa.</p>
            </article>
            <article class="rounded-3xl bg-slate-50 p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-md">
                <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-2xl">📅</div>
                <h3 class="text-xl font-semibold text-slate-900">Jadwal & Absensi</h3>
                <p class="mt-4 text-slate-600">Lihat jadwal pelajaran dan rekam absensi siswa secara digital yang terintegrasi dengan setiap kelas dan semester.</p>
            </article>
            <article class="rounded-3xl bg-slate-50 p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-md">
                <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-2xl">📣</div>
                <h3 class="text-xl font-semibold text-slate-900">Pengumuman Sekolah</h3>
                <p class="mt-4 text-slate-600">Terima pemberitahuan penting tentang kegiatan sekolah, ujian, dan acara dalam satu tampilan yang mudah diakses.</p>
            </article>
        </div>

        <div class="mt-20 rounded-[32px] bg-cover bg-center bg-slate-900/90" style="background-image: url('{{ asset('images/hero_2.jpg') }}');">
            <div class="bg-slate-950/80 px-6 py-16 sm:px-10 lg:px-16">
                <div class="grid gap-10 lg:grid-cols-2 items-center">
                    <div class="text-white">
                        <p class="text-sm font-semibold uppercase tracking-[0.35em] text-sky-300">Tentang Sekolah</p>
                        <h3 class="mt-4 text-3xl font-black sm:text-4xl">SMPN 13 Sungai Raya: Sekolah dengan Semangat Prestasi</h3>
                        <p class="mt-6 text-base leading-8 text-slate-200">SMPN 13 Sungai Raya memberikan lingkungan belajar yang aman, nyaman, dan inovatif, dengan dukungan tenaga pendidik profesional dan fasilitas lengkap.</p>
                    </div>
                    <div class="grid gap-4">
                        <div class="rounded-3xl bg-white/10 p-6 text-white ring-1 ring-white/10">
                            <h4 class="text-lg font-semibold">Laboratorium & Perpustakaan</h4>
                            <p class="mt-3 text-sm leading-7 text-slate-200">Fasilitas modern untuk mendukung pembelajaran dan minat baca siswa.</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-6 text-white ring-1 ring-white/10">
                            <h4 class="text-lg font-semibold">Ekstrakurikuler Aktif</h4>
                            <p class="mt-3 text-sm leading-7 text-slate-200">Banyak pilihan kegiatan yang membentuk karakter dan kemampuan sosial siswa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 rounded-[32px] bg-sky-600 p-12 text-white">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 text-center">
                <div>
                    <p class="text-4xl font-extrabold">{{ $statistics['students'] ?? 0 }}</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em]">Siswa Aktif</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold">{{ $statistics['teachers'] ?? 0 }}</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em]">Guru Profesional</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold">{{ $statistics['classes'] ?? 0 }}</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em]">Ekstrakurikuler</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold">100%</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em]">Layanan Digital</p>
                </div>
            </div>
        </div>
    </div>
</section>
