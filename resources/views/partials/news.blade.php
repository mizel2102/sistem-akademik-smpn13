<section id="berita" class="bg-white py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-16 reveal-item">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.3em] text-[#0369a1]">Informasi Sekolah</p>
                <h2 class="mt-4 text-3xl font-extrabold text-slate-900 sm:text-4xl">Pengumuman Terbaru</h2>
            </div>
            <a href="{{ Route::has('berita.index') ? route('berita.index') : '#' }}" class="inline-flex items-center text-sm font-bold text-[#0369a1] hover:text-[#0284c7] transition-colors">
                Lihat Semua Berita 
                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>

        @php
            $newsList = $berita ?? collect([
                ['title' => 'Pendaftaran Semester Baru Telah Dimulai', 'date' => '2026-07-01', 'category' => 'Pendaftaran', 'excerpt' => 'Pendaftaran siswa baru untuk tahun pelajaran mendatang dibuka mulai hari ini. Segera lengkapi berkas Anda di portal akademik.'],
                ['title' => 'Libur Hari Kemerdekaan', 'date' => '2026-08-17', 'category' => 'Pengumuman', 'excerpt' => 'Sekolah tutup untuk memperingati Hari Kemerdekaan Republik Indonesia. Aktivitas sekolah dilanjutkan setelah tanggal tersebut.'],
                ['title' => 'Rapat Koordinasi Orang Tua', 'date' => '2026-09-05', 'category' => 'Agenda', 'excerpt' => 'Rapat antara guru dan orang tua untuk membahas perkembangan belajar dan kegiatan siswa.'],
            ]);
        @endphp

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($newsList->take(3) as $index => $item)
                @php
                    $newsDate = $item['date'] ?? $item->date ?? '';
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $newsDate)) {
                        $formattedNewsDate = \Carbon\Carbon::createFromFormat('Y-m-d', $newsDate)->isoFormat('D MMMM Y');
                    } else {
                        $formattedNewsDate = $newsDate;
                    }
                    $excerpt = Str::limit(strip_tags($item['excerpt'] ?? $item->content ?? ''), 120);
                @endphp
                
                <article class="flex flex-col rounded-2xl bg-white border-l-[6px] border-[#0369a1] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.1)] p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_30px_-10px_rgba(0,0,0,0.15)] reveal-item" {!! 'style="transition-delay: ' . ($index * 100) . 'ms;"' !!}>
                    <div class="mb-4 flex items-center justify-between text-xs font-semibold text-slate-500">
                        <span class="inline-block rounded-full bg-slate-100 px-3 py-1 text-[#0369a1] uppercase tracking-wider">
                            {{ $item['category'] ?? 'Berita' }}
                        </span>
                        <span>{{ $formattedNewsDate }}</span>
                    </div>
                    <h3 class="mb-3 text-xl font-bold leading-tight text-slate-900 line-clamp-2">
                        {{ $item['title'] ?? 'Judul Pengumuman' }}
                    </h3>
                    <p class="mb-6 flex-1 text-sm leading-relaxed text-slate-600 line-clamp-3">
                        {{ $excerpt }}
                    </p>
                    <a href="{{ $item['link'] ?? '#' }}" class="mt-auto inline-flex items-center text-sm font-bold text-[#0369a1] hover:text-[#0284c7] transition-colors">
                        Baca selengkapnya 
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
