@unless(request()->routeIs('login') || request()->routeIs('register'))
<header x-data="{ open: false, scrolled: false }" x-init="scrolled = window.pageYOffset > 10"
    @scroll.window="scrolled = window.pageYOffset > 10"
    :class="scrolled ? 'shadow-2xl border border-white/10 bg-slate-950/95 backdrop-blur-3xl' : 'shadow-2xl border border-white/10 bg-slate-950/100'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-4 sm:px-6 lg:px-8 py-4">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-sm font-semibold uppercase tracking-[0.2em] text-white transition hover:opacity-90">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-white/10 text-base font-bold">AMIS</span>
            <div class="hidden sm:block">
                <div class="text-sm text-slate-100">SMPN 13</div>
                <div class="text-xs text-slate-400">Sungai Raya</div>
            </div>
        </a>

        <nav role="navigation" aria-label="Main navigation" class="hidden items-center gap-8 text-sm font-semibold text-slate-100 md:flex">
            <a href="{{ route('home') }}#home" class="transition duration-300 hover:text-white">Home</a>
            <a href="{{ route('home') }}#story" class="transition duration-300 hover:text-white">About</a>
            <a href="{{ route('home') }}#features" class="transition duration-300 hover:text-white">Features</a>
            <a href="{{ route('home') }}#academic" class="transition duration-300 hover:text-white">Academic</a>
            <a href="{{ route('home') }}#contact" class="transition duration-300 hover:text-white">Contact</a>
        </nav>

        <div class="flex items-center gap-3">
            @unless(request()->routeIs('login'))
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-300 hover:bg-white/20">Login</a>
            @endunless
            <button @click="open = !open" class="md:hidden inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/20 bg-transparent text-slate-100 shadow-lg transition hover:bg-white/10" aria-label="Toggle menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>

        <div x-show="open" x-transition.opacity x-cloak class="md:hidden mt-4 rounded-2xl border border-white/10 bg-slate-950/95 p-4 shadow-2xl shadow-slate-950/20 backdrop-blur-2xl">
        <a href="{{ route('home') }}#home" class="block rounded-lg px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800/80">Home</a>
        <a href="{{ route('home') }}#story" class="mt-1 block rounded-lg px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800/80">About</a>
        <a href="{{ route('home') }}#features" class="mt-1 block rounded-lg px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800/80">Features</a>
        <a href="{{ route('home') }}#academic" class="mt-1 block rounded-lg px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800/80">Academic</a>
        <a href="{{ route('home') }}#contact" class="mt-1 block rounded-lg px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800/80">Contact</a>
            @unless(request()->routeIs('login'))
                <a href="{{ route('login') }}" class="mt-3 block rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/15">Login</a>
            @endunless
    </div>
</header>
@endunless
