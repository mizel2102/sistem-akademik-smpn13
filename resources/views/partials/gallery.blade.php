<section id="galeri" class="bg-white py-24" x-data="{ lightboxOpen: false, currentImage: '', currentTitle: '' }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16 text-center reveal-item">
            <p class="text-sm font-bold uppercase tracking-[0.3em] text-[#0369a1]">Galeri Sekolah</p>
            <h2 class="mt-4 text-3xl font-extrabold text-slate-900 sm:text-4xl">Momen Pembelajaran & Kegiatan</h2>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            
            <!-- Gallery Item 1 -->
            <div class="group relative cursor-pointer overflow-hidden rounded-[2rem] bg-slate-100 shadow-sm reveal-item" 
                 @click="lightboxOpen = true; currentImage = '{{ asset('images/hero_1.jpg') }}'; currentTitle = 'Fasilitas Sekolah'">
                <div class="aspect-[4/3] w-full overflow-hidden">
                    <img src="{{ asset('images/hero_1.jpg') }}" alt="Fasilitas Sekolah" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <!-- Overlay -->
                <div class="absolute inset-0 flex items-center justify-center bg-[#0369a1]/0 opacity-0 transition-all duration-300 group-hover:bg-[#0369a1]/40 group-hover:opacity-100">
                    <div class="translate-y-4 rounded-full bg-white/30 p-4 text-white backdrop-blur-md transition-transform duration-300 group-hover:translate-y-0">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                </div>
                <!-- Content -->
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                        <span class="inline-block rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#0369a1]">Fasilitas</span>
                        <h3 class="mt-2 text-xl font-bold text-white drop-shadow-md">Gedung Sekolah Utama</h3>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="group relative cursor-pointer overflow-hidden rounded-[2rem] bg-slate-100 shadow-sm reveal-item" style="transition-delay: 100ms;"
                 @click="lightboxOpen = true; currentImage = '{{ asset('images/hero_2.jpg') }}'; currentTitle = 'Kegiatan Belajar'">
                <div class="aspect-[4/3] w-full overflow-hidden">
                    <img src="{{ asset('images/hero_2.jpg') }}" alt="Kegiatan Belajar" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div class="absolute inset-0 flex items-center justify-center bg-[#0369a1]/0 opacity-0 transition-all duration-300 group-hover:bg-[#0369a1]/40 group-hover:opacity-100">
                    <div class="translate-y-4 rounded-full bg-white/30 p-4 text-white backdrop-blur-md transition-transform duration-300 group-hover:translate-y-0">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                        <span class="inline-block rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#0369a1]">Akademik</span>
                        <h3 class="mt-2 text-xl font-bold text-white drop-shadow-md">Kelas Interaktif</h3>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="group relative cursor-pointer overflow-hidden rounded-[2rem] bg-slate-100 shadow-sm reveal-item" style="transition-delay: 200ms;"
                 @click="lightboxOpen = true; currentImage = '{{ asset('images/hero_3.jpg') }}'; currentTitle = 'Ekstrakurikuler'">
                <div class="aspect-[4/3] w-full overflow-hidden">
                    <img src="{{ asset('images/hero_3.jpg') }}" alt="Ekstrakurikuler" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div class="absolute inset-0 flex items-center justify-center bg-[#0369a1]/0 opacity-0 transition-all duration-300 group-hover:bg-[#0369a1]/40 group-hover:opacity-100">
                    <div class="translate-y-4 rounded-full bg-white/30 p-4 text-white backdrop-blur-md transition-transform duration-300 group-hover:translate-y-0">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                        <span class="inline-block rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#0369a1]">Ekskul</span>
                        <h3 class="mt-2 text-xl font-bold text-white drop-shadow-md">Kegiatan Olahraga</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Lightbox -->
    <div x-show="lightboxOpen" style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 p-4 sm:p-8"
         @click="lightboxOpen = false"
         @keydown.escape.window="lightboxOpen = false">
        
        <button @click="lightboxOpen = false" class="absolute right-6 top-6 rounded-full bg-white/10 p-3 text-white backdrop-blur-md transition hover:bg-white/20">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>

        <div class="relative max-h-full max-w-5xl" @click.stop>
            <img :src="currentImage" :alt="currentTitle" class="max-h-[85vh] w-auto rounded-xl shadow-2xl">
            <div class="mt-4 text-center">
                <p class="text-lg font-medium text-white" x-text="currentTitle"></p>
            </div>
        </div>
    </div>
</section>
