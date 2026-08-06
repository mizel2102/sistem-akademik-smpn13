<!-- Top Bar -->
<div class="flex h-[60px] items-center border-b border-slate-200 bg-white shadow-sm">
    <!-- Left: Hamburger + Title -->
    <div class="flex flex-1 items-center gap-4 px-6">
        <button @click="sidebarOpen = !sidebarOpen"
                class="inline-flex lg:hidden p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
        <div>
            <h1 class="text-lg font-semibold text-slate-900">@yield('page-title', 'Dashboard')</h1>
            <p class="text-xs text-slate-500">@yield('breadcrumb', '')</p>
        </div>
    </div>

    <!-- Right: Notifications + User Menu -->
    <div class="flex items-center gap-4 px-6">
        <!-- Notification Bell -->
        <button class="relative p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="absolute top-1.5 right-1.5 inline-flex h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>

        <!-- User Dropdown -->
        <div x-data="{ userOpen: false }" class="relative">
            <button @click="userOpen = !userOpen"
                    class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-slate-100 transition-colors">
                @if(auth()->user()?->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover ring-2 ring-blue-600">
                @else
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold text-white">
                        {{ optional(auth()->user())->name ? substr(auth()->user()->name, 0, 2) : 'U' }}
                    </div>
                @endif
                <span class="hidden text-sm font-medium text-slate-700 sm:inline">{{ optional(auth()->user())->name ?? 'Guest' }}</span>
                <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <div x-show="userOpen" @click.outside="userOpen = false" x-transition x-cloak
                 class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white shadow-lg z-50">
                @if(auth()->check())
                    <a href="{{ route('profile.show') }}"
                       class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 border-b border-slate-100 transition-colors">
                        Profil Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 rounded-b-lg transition-colors">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-b-lg transition-colors">
                        Masuk
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
