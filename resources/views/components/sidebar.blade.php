@props(['user'])
<aside class="flex flex-col flex-shrink-0 w-full lg:w-72 min-h-screen bg-[#0F172A] border-r border-white/10 shadow-2xl sticky top-0 z-30 overflow-hidden lg:overflow-y-auto text-slate-200">
    <!-- Logo Section -->
    <div class="border-b border-white/10 px-4 py-4 lg:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white">AMIS</span>
            <div>
                <p class="text-sm font-bold text-white leading-tight">SMPN 13</p>
                <p class="text-xs text-slate-400">Portal Akademik</p>
            </div>
        </a>
    </div>

    <!-- User Info Card -->
    <div class="border-b border-white/10 px-6 py-5">
        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-4 space-y-3">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-sm font-bold text-white flex-shrink-0">
                    {{ substr($user->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ ucfirst($user->role ?? 'user') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs text-slate-300">
                <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Online</span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav role="navigation" aria-label="Main navigation" class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
        {{ $slot }}
    </nav>

    <!-- Logout Section -->
    <div class="border-t border-white/10 px-6 py-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-200 transition duration-300 hover:bg-red-600/15 hover:text-red-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
