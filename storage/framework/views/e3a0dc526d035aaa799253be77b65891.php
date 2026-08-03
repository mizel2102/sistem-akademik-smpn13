<?php $__env->startSection('title', 'SMPN 13 Sungai Raya - Portal Akademik'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section with Search -->
<section class="relative bg-slate-800 text-white py-32 overflow-hidden">
    <img src="<?php echo e(asset('images/sekolah/IMG_4903.JPG')); ?>" alt="SMPN 13 Sungai Raya" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-blue-900/70"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center z-10 mt-16">
        <h2 class="text-3xl md:text-5xl font-bold mb-8 uppercase tracking-widest text-yellow-400">SMPN 13 Sungai Raya</h2>
        <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm max-w-2xl mx-auto flex">
            <input type="text" placeholder="Apa yang ingin anda cari?" class="w-full px-6 py-4 rounded-l-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <button class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-8 py-4 rounded-r-lg transition">Cari</button>
        </div>
    </div>
</section>

<!-- Content Section: Pengumuman & Sambutan -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Galeri Carousel (Kiri) -->
            <div class="md:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden h-full flex flex-col">
                    <img src="<?php echo e(asset('images/sekolah/IMG_4904.JPG')); ?>" alt="Galeri" class="w-full h-64 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-lg text-slate-800">Galeri Kegiatan</h3>
                        <p class="text-sm text-slate-500 mt-2">Kumpulan dokumentasi kegiatan warga sekolah SMPN 13 Sungai Raya.</p>
                    </div>
                </div>
            </div>

            <!-- Pengumuman (Tengah) -->
            <div class="md:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 h-full">
                    <h3 class="text-xl font-bold text-blue-900 mb-6 border-b-2 border-yellow-400 pb-2 inline-block">Pengumuman</h3>
                    <div class="space-y-4">
                        <div class="flex gap-4 items-start border-b border-slate-100 pb-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0">INFO</div>
                            <div>
                                <a href="#" class="font-semibold text-slate-800 hover:text-blue-600 leading-tight">PENGUMUMAN SUSUNAN KELAS X (FASE E) T.P. 2026/2027</a>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start border-b border-slate-100 pb-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0">INFO</div>
                            <div>
                                <a href="#" class="font-semibold text-slate-800 hover:text-blue-600 leading-tight">PENGUMUMAN SUSUNAN KELAS XI (FASE F) T.P. 2026/2027</a>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0">INFO</div>
                            <div>
                                <a href="#" class="font-semibold text-slate-800 hover:text-blue-600 leading-tight">HASIL SELEKSI PENERIMAAN MURID BARU T.A 2026/2027</a>
                            </div>
                        </div>
                        <a href="#" class="block text-sm text-blue-600 font-semibold mt-4 hover:underline">Read More &raquo;</a>
                    </div>
                </div>
            </div>

            <!-- Sambutan (Kanan) -->
            <div class="md:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 h-full flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-blue-900 mb-6 border-b-2 border-yellow-400 pb-2 inline-block">Sambutan Kepala Sekolah</h3>
                        <div class="aspect-video bg-slate-900 rounded-lg mb-4 overflow-hidden relative">
                            <video class="w-full h-full object-cover" controls preload="metadata">
                                <source src="<?php echo e(asset('videos/sambutan.mp4')); ?>" type="video/mp4">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                        </div>
                        <p class="text-sm text-slate-600 italic">"Bismillahirrohmanirrahim. Segala puji hanya untuk Allah SWT dan shalawat serta salam..."</p>
                    </div>
                    <a href="#" class="block text-sm text-blue-600 font-semibold mt-4 hover:underline">Read More &raquo;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-blue-900 uppercase tracking-wide">Berita Terbaru</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto mt-4"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Berita Item -->
            <div class="bg-white rounded-xl shadow border border-slate-100 overflow-hidden group">
                <div class="h-48 bg-slate-200 overflow-hidden">
                    <img src="<?php echo e(asset('images/mpls/IMG_4389.jpeg')); ?>" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-6">
                    <p class="text-xs font-bold text-yellow-500 mb-2">23 JUL, 2026</p>
                    <h4 class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 hover:text-blue-600 cursor-pointer">SMPN 13 Sungai Raya Gelar Pendidikan Karakter</h4>
                    <p class="text-sm text-slate-600 line-clamp-3 mb-4">SMPN 13 Sungai Raya menyelenggarakan kegiatan kedisiplinan dan pendidikan karakter untuk para siswa...</p>
                    <div class="flex items-center text-xs text-slate-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Admin
                    </div>
                </div>
            </div>
            <!-- Berita Item -->
            <div class="bg-white rounded-xl shadow border border-slate-100 overflow-hidden group">
                <div class="h-48 bg-slate-200 overflow-hidden">
                    <img src="<?php echo e(asset('images/sekolah/IMG_4905.JPG')); ?>" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-6">
                    <p class="text-xs font-bold text-yellow-500 mb-2">20 JUL, 2026</p>
                    <h4 class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 hover:text-blue-600 cursor-pointer">Upacara Bendera Bersama Perwakilan Daerah</h4>
                    <p class="text-sm text-slate-600 line-clamp-3 mb-4">SMPN 13 Sungai Raya menyelenggarakan Upacara Bendera Hari Senin yang istimewa dengan kehadiran perwakilan pemerintah daerah...</p>
                    <div class="flex items-center text-xs text-slate-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Admin
                    </div>
                </div>
            </div>
            <!-- Berita Item -->
            <div class="bg-white rounded-xl shadow border border-slate-100 overflow-hidden group">
                <div class="h-48 bg-slate-200 overflow-hidden">
                    <img src="<?php echo e(asset('images/mpls/IMG_4897.JPG')); ?>" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-6">
                    <p class="text-xs font-bold text-yellow-500 mb-2">17 JUL, 2026</p>
                    <h4 class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 hover:text-blue-600 cursor-pointer">MPLS SMPN 13 Sungai Raya 2026 Berlangsung Seru</h4>
                    <p class="text-sm text-slate-600 line-clamp-3 mb-4">SMPN 13 Sungai Raya telah sukses melaksanakan kegiatan Masa Pengenalan Lingkungan Sekolah dengan berbagai agenda menarik...</p>
                    <div class="flex items-center text-xs text-slate-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Admin
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-10">
            <a href="<?php echo e(route('berita.index')); ?>" class="inline-block px-8 py-3 border-2 border-blue-900 text-blue-900 font-bold rounded-full hover:bg-blue-900 hover:text-white transition">Tampilkan Semua Berita</a>
        </div>
    </div>
</section>

<!-- Prestasi Section -->
<section id="prestasi" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-blue-900 uppercase tracking-wide">Prestasi Sekolah</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto mt-4"></div>
            <p class="mt-4 text-slate-600">Kebanggaan SMPN 13 Sungai Raya dari tingkat Nasional hingga Provinsi</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col group">
                <div class="h-64 bg-slate-200 overflow-hidden relative">
                    <img src="<?php echo e(asset('images/nasional/IMG_0153.jpeg')); ?>" alt="Prestasi Nasional" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 right-4 bg-yellow-500 text-blue-900 font-bold px-3 py-1 rounded shadow text-sm">Tingkat Nasional</div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-xl text-slate-800">Juara Nasional 2025</h3>
                    <p class="text-sm text-slate-500 mt-2">Prestasi gemilang siswa-siswi SMPN 13 Sungai Raya di ajang perlombaan tingkat nasional.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col group">
                <div class="h-64 bg-slate-200 overflow-hidden relative">
                    <img src="<?php echo e(asset('images/provinsi/IMG_4884.JPG')); ?>" alt="Prestasi Provinsi" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 right-4 bg-blue-600 text-white font-bold px-3 py-1 rounded shadow text-sm">Tingkat Provinsi</div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-xl text-slate-800">Juara Provinsi 2025</h3>
                    <p class="text-sm text-slate-500 mt-2">Pencapaian luar biasa dalam berbagai kompetisi di tingkat provinsi Kalimantan Barat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Guru Section -->
<section id="guru" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-blue-900 uppercase tracking-wide">Dewan Guru</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto mt-4"></div>
            <p class="mt-4 text-slate-600">Pendidik profesional yang berdedikasi membimbing generasi penerus bangsa</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Guru 1 -->
            <div class="text-center group">
                <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4 border-4 border-slate-100 shadow-md group-hover:border-yellow-400 transition-colors">
                    <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Guru" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg text-slate-800">Bpk. Ahmad, S.Pd</h4>
                <p class="text-sm text-slate-500">Guru Matematika</p>
            </div>
            <!-- Guru 2 -->
            <div class="text-center group">
                <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4 border-4 border-slate-100 shadow-md group-hover:border-yellow-400 transition-colors">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Guru" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg text-slate-800">Ibu Siti, M.Pd</h4>
                <p class="text-sm text-slate-500">Guru Bahasa Indonesia</p>
            </div>
            <!-- Guru 3 -->
            <div class="text-center group">
                <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4 border-4 border-slate-100 shadow-md group-hover:border-yellow-400 transition-colors">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Guru" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg text-slate-800">Bpk. Budi, S.Si</h4>
                <p class="text-sm text-slate-500">Guru IPA</p>
            </div>
            <!-- Guru 4 -->
            <div class="text-center group">
                <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4 border-4 border-slate-100 shadow-md group-hover:border-yellow-400 transition-colors">
                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Guru" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg text-slate-800">Ibu Ratna, S.Pd</h4>
                <p class="text-sm text-slate-500">Guru Bahasa Inggris</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/welcome.blade.php ENDPATH**/ ?>