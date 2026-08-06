<header x-data="{ mobileOpen: false, scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 20" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 shadow-lg" :class="scrolled ? 'bg-blue-900/95 backdrop-blur-md py-2' : 'bg-blue-900 py-4'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group" aria-label="Beranda SMPN 13 Sungai Raya">
                <div class="h-12 w-12 rounded-full bg-white flex items-center justify-center text-blue-900 font-bold text-xl shadow-sm group-hover:scale-105 transition-transform">
                    13
                </div>
                <div>
                    <h1 class="text-xl font-bold uppercase tracking-widest text-white">SMPN 13 Sungai Raya</h1>
                    <p class="text-xs text-blue-200">Portal Digital Akademik</p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:block flex-1">
                <ul class="flex items-center justify-end gap-6 text-sm font-semibold uppercase text-white">
                    <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition {{ request()->routeIs('home') ? 'text-yellow-400' : '' }}">Beranda</a></li>
                    <li><a href="{{ auth()->check() ? route('profile.show') : route('login') }}" class="hover:text-yellow-400 transition {{ request()->routeIs('profile.show') ? 'text-yellow-400' : '' }}">Profil</a></li>
                    <li><a href="{{ Route::has('berita.index') ? route('berita.index') : '#' }}" class="hover:text-yellow-400 transition {{ request()->routeIs('berita.index') ? 'text-yellow-400' : '' }}">Berita</a></li>
                    <li><a href="{{ Route::has('prestasi.index') ? route('prestasi.index') : route('home') . '#prestasi' }}" class="hover:text-yellow-400 transition {{ request()->routeIs('prestasi.index') ? 'text-yellow-400' : '' }}">Prestasi</a></li>
                    <li><a href="{{ Route::has('guru.index') ? route('guru.index') : route('home') . '#guru' }}" class="hover:text-yellow-400 transition {{ request()->routeIs('guru.index') ? 'text-yellow-400' : '' }}">Guru</a></li>
                </ul>
            </nav>

            {{-- Actions --}}
            <div class="hidden lg:flex items-center gap-5 ml-4">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-yellow-500 px-5 py-2 text-sm font-bold text-blue-900 transition-all hover:bg-yellow-400 hover:scale-105">
                    Login SIAKAD
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-800 text-white hover:bg-blue-700 transition-colors" aria-label="Toggle menu">
                <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileOpen" @click.outside="mobileOpen = false" x-cloak x-transition.opacity.duration.300ms class="fixed inset-0 top-[76px] z-40 bg-blue-900/95 backdrop-blur-xl lg:hidden h-screen overflow-y-auto border-t border-blue-800">
        <div class="flex flex-col px-6 py-8 space-y-6 text-white uppercase font-semibold">
            <a href="{{ route('home') }}" @click="mobileOpen = false" class="text-xl tracking-tight hover:text-yellow-400">Beranda</a>
            <a href="{{ auth()->check() ? route('profile.show') : route('login') }}" @click="mobileOpen = false" class="text-xl tracking-tight hover:text-yellow-400">Profil</a>
            <a href="{{ Route::has('berita.index') ? route('berita.index') : '#' }}" @click="mobileOpen = false" class="text-xl tracking-tight hover:text-yellow-400">Berita</a>
            <a href="{{ Route::has('prestasi.index') ? route('prestasi.index') : route('home') . '#prestasi' }}" @click="mobileOpen = false" class="text-xl tracking-tight hover:text-yellow-400">Prestasi</a>
            <a href="{{ Route::has('guru.index') ? route('guru.index') : route('home') . '#guru' }}" @click="mobileOpen = false" class="text-xl tracking-tight hover:text-yellow-400">Guru</a>
            
            <div class="pt-8 mt-4 border-t border-blue-800">
                <a href="{{ route('login') }}" class="flex w-full h-12 items-center justify-center rounded-full bg-yellow-500 px-4 text-sm font-bold text-blue-900 shadow-sm transition hover:bg-yellow-400">
                    Login SIAKAD
                </a>
            </div>
        </div>
    </div>
</header>
