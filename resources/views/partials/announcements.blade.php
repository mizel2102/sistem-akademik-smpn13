<section class="section-bg style-1" style="background-image: url('{{ asset('images/hero_1.jpg') }}');">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] items-center py-20">
            <div>
                <h2 class="section-title-underline style-2 mb-5"><span>About Our University</span></h2>
                <p class="lead max-w-3xl text-white/90">SMPN 13 Sungai Raya memadukan pengajaran berkualitas, bimbingan siswa, dan dukungan teknologi untuk menciptakan pengalaman akademik yang efektif dan modern.</p>
                <p class="mt-6 max-w-2xl text-slate-200 leading-8">Kami berfokus pada layanan pendidikan yang lengkap, mulai dari nilai, absensi, sampai agenda sekolah untuk siswa, guru, dan orang tua.</p>
                <p class="mt-8"><a href="#" class="btn btn-primary">Read more</a></p>
            </div>
            <div class="rounded-[32px] border border-white/10 bg-white/10 p-8 shadow-2xl shadow-slate-950/10">
                <p class="text-sm uppercase tracking-[0.28em] text-sky-300">School Facts</p>
                <div class="mt-8 space-y-5">
                    <div class="rounded-3xl bg-slate-900/70 p-6">
                        <p class="text-lg font-semibold text-white">Fasilitas lengkap dan lingkungan nyaman</p>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Ruangan kelas berkualitas, laboratorium, perpustakaan, dan dukungan ekstrakurikuler untuk perkembangan siswa.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-900/70 p-6">
                        <p class="text-lg font-semibold text-white">Tim pengajar berdedikasi</p>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Guru profesional yang siap membimbing setiap siswa mencapai potensi terbaiknya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section bg-slate-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="mb-5">
            <h2 class="section-title-underline"><span>Testimonials</span></h2>
        </div>
        <div class="grid gap-6 lg:grid-cols-3">
            @php
                $testimonials = collect([
                    ['name' => 'Allison Holmes', 'role' => 'Siswa', 'quote' => 'Sistem ini memudahkan saya untuk melihat nilai, jadwal, dan tugas tanpa harus mencari ke banyak tempat.'],
                    ['name' => 'Bapak Adi', 'role' => 'Guru', 'quote' => 'Semua data absensi dan nilai tersaji rapi, sehingga proses administrasi jadi jauh lebih cepat.'],
                    ['name' => 'Ibu Wulan', 'role' => 'Orang Tua', 'quote' => 'Kami bisa mengikuti perkembangan anak secara mudah dan langsung dari rumah.'],
                ]);
            @endphp

            @foreach($testimonials as $item)
                <article class="ftco-testimonial-1">
                    <div class="ftco-testimonial-vcard mb-4">
                        <img src="https://via.placeholder.com/64" alt="{{ $item['name'] }}" class="img-fluid mr-4" />
                        <div>
                            <h3 class="text-lg font-semibold text-slate-950">{{ $item['name'] }}</h3>
                            <span class="text-sm text-slate-500">{{ $item['role'] }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-600 leading-7">“{{ $item['quote'] }}”</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-bg style-1 bg-white" style="background-image: url('{{ asset('images/hero_1.jpg') }}');">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid gap-6 lg:grid-cols-3">
            <div>
                <span class="icon text-sky-300">📘</span>
                <h3 class="mt-4 text-2xl font-semibold text-slate-950">Our Philosophy</h3>
                <p class="mt-3 text-slate-600 leading-7">Menciptakan dasar pendidikan yang kuat dengan prinsip belajar percaya diri dan konsisten.</p>
            </div>
            <div>
                <span class="icon text-sky-300">🎓</span>
                <h3 class="mt-4 text-2xl font-semibold text-slate-950">Academics Principle</h3>
                <p class="mt-3 text-slate-600 leading-7">Menjaga kualitas pembelajaran melalui teknik pengajaran yang terarah.</p>
            </div>
            <div>
                <span class="icon text-sky-300">✨</span>
                <h3 class="mt-4 text-2xl font-semibold text-slate-950">Key of Success</h3>
                <p class="mt-3 text-slate-600 leading-7">Menggabungkan teknologi, nilai karakter, dan dukungan guru untuk hasil terbaik.</p>
            </div>
        </div>
    </div>
</section>
