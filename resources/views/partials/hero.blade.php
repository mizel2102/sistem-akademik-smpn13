<section id="beranda" x-data="heroSlider()" x-init="init()" @mouseenter="pause()" @mouseleave="resume()" class="relative overflow-hidden" style="min-height: 90vh;">
    <template x-for="(slide, index) in slides" :key="slide.tag">
        <div x-show="active === index" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="absolute inset-0 bg-cover bg-center"
            :style="`background-image: linear-gradient(rgba(15,23,42,0.56), rgba(15,23,42,0.35)), url('${slide.image}')`;">
            <div class="absolute inset-0 bg-slate-950/50"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(56,189,248,0.18),transparent_20%),radial-gradient(circle_at_bottom_right,rgba(59,130,246,0.12),transparent_25%)]"></div>
            <div class="relative mx-auto flex flex-col justify-center px-6 py-24 text-center text-white sm:px-8 lg:px-12 lg:text-left" style="min-height: 90vh;">
                <!-- Decorative blobs -->
                <div class="absolute top-1/4 left-10 h-72 w-72 rounded-full bg-sky-500/30 mix-blend-multiply blur-3xl filter animate-pulse"></div>
                <div class="absolute top-1/3 right-10 h-72 w-72 rounded-full bg-indigo-500/30 mix-blend-multiply blur-3xl filter animate-pulse" style="animation-delay: 2s;"></div>
                
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                    <div class="relative mx-auto w-full max-w-3xl lg:mr-auto lg:max-w-2xl rounded-3xl bg-white/5 backdrop-blur-md p-10 ring-1 ring-white/20 shadow-2xl">
                        <span class="inline-flex rounded-full border border-sky-400/30 bg-sky-400/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.3em] text-sky-300 shadow-sm shadow-sky-900/20 backdrop-blur-sm">
                            <span x-text="slide.tag"></span>
                        </span>
                        <h1 class="mt-8 font-sora text-5xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-100 to-sky-200 sm:text-6xl lg:text-7xl" x-text="slide.title"></h1>
                        <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-300 sm:text-lg font-light" x-text="slide.sub"></p>
                        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row sm:justify-start">
                            <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center rounded-full bg-gradient-to-r from-sky-500 to-blue-600 px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-sky-500/40 transition-all hover:scale-105 hover:shadow-sky-500/60 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                                <span class="relative z-10 flex items-center gap-2">
                                    Masuk ke Akun
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" /></svg>
                                </span>
                            </a>
                            <a href="#fitur" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 backdrop-blur-sm px-8 py-4 text-sm font-semibold text-white transition-all hover:bg-white/15 hover:scale-105">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden lg:block relative mx-auto w-full max-w-2xl rounded-[2rem] shadow-2xl overflow-hidden ring-1 ring-white/20 transform hover:-translate-y-2 transition-all duration-500">
                        <!-- Dashboard Preview Image/Mockup -->
                        <div class="bg-slate-900/80 p-3 flex items-center gap-2 border-b border-white/10 backdrop-blur-md">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            <div class="ml-4 text-xs text-slate-400 font-mono">sistem.smpn13sungairaya.sch.id/dashboard</div>
                        </div>
                        <div class="bg-white/95 p-4 backdrop-blur-md">
                            <img src="{{ asset('images/hero_2.jpg') }}" alt="Dashboard Preview" class="w-full h-80 object-cover rounded-xl shadow-inner opacity-90 mix-blend-multiply">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div class="absolute inset-y-0 left-0 z-20 flex items-center px-4 sm:px-6">
        <button @click="prev()" type="button" class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-sky-400">
            <span class="sr-only">Previous slide</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 4 6 10l6 6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
    <div class="absolute inset-y-0 right-0 z-20 flex items-center px-4 sm:px-6">
        <button @click="next()" type="button" class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-sky-400">
            <span class="sr-only">Next slide</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 4l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <div class="absolute bottom-24 left-1/2 z-20 flex -translate-x-1/2 items-center gap-3">
        <template x-for="(slide, index) in slides" :key="slide.tag">
            <button @click="go(index)" type="button"
                :class="[`h-2 rounded-full transition-all duration-300`, active === index ? 'w-10 bg-sky-400' : 'w-4 bg-white/50']">
            </button>
        </template>
    </div>

    <div class="absolute inset-x-0 bottom-0 z-20 h-1 bg-white/10">
        <div class="h-full bg-sky-400 transition-all duration-100" :style="`width: ${progress}%`"></div>
    </div>
</section>

<script>
    function heroSlider() {
        return {
            active: 0,
            progress: 0,
            duration: 5000,
            timer: null,
            progressTimer: null,
            playing: true,
            slides: [
                {
                    tag: 'Portal Akademik Digital',
                    title: 'SMPN 13 Sungai Raya',
                    sub: 'Menjadikan sekolah lebih modern dengan layanan nilai, jadwal, absensi, dan pengumuman dalam satu platform terpadu.',
                    image: "{{ asset('images/hero_1.jpg') }}",
                },
                {
                    tag: 'Prestasi & Keunggulan',
                    title: 'Cetak Generasi Unggul',
                    sub: 'Didukung tenaga pendidik bersertifikat dan program akademik berkualitas untuk mewujudkan potensi terbaik setiap siswa.',
                    image: "{{ asset('images/hero_2.jpg') }}",
                },
                {
                    tag: 'Bergabung Bersama Kami',
                    title: 'Masa Depan Dimulai di Sini',
                    sub: 'Fasilitas lengkap, lingkungan kondusif, dan sistem informasi akademik terintegrasi untuk pengalaman belajar yang optimal.',
                    image: "{{ asset('images/hero_3.jpg') }}",
                }
            ],
            init() {
                this.start();
            },
            start() {
                this.stop();
                this.playing = true;
                this.progress = 0;
                this.timer = setInterval(() => this.next(), this.duration);
                const step = 100 / (this.duration / 50);
                this.progressTimer = setInterval(() => {
                    if (!this.playing) return;
                    this.progress = Math.min(100, this.progress + step);
                }, 50);
            },
            stop() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
                if (this.progressTimer) {
                    clearInterval(this.progressTimer);
                    this.progressTimer = null;
                }
            },
            pause() {
                this.playing = false;
                this.stop();
            },
            resume() {
                if (!this.playing) {
                    this.playing = true;
                    this.start();
                }
            },
            prev() {
                this.active = (this.active - 1 + this.slides.length) % this.slides.length;
                this.start();
            },
            next() {
                this.active = (this.active + 1) % this.slides.length;
                this.start();
            },
            go(index) {
                this.active = index;
                this.start();
            }
        }
    }
</script>
