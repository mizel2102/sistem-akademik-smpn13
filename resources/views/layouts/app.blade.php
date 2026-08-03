<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard - SMPN 13 Sungai Raya')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">

    @stack('styles')
</head>

<body class="font-sans bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex flex-1 flex-col overflow-hidden">
            @include('partials.topbar')

            <!-- Flash Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)"
                     x-show="show" x-transition x-cloak
                     class="m-6 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                    <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                    </svg>
                    <span class="flex-1 text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-600 hover:text-green-900">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div x-data="{ show: true }"
                     x-show="show" x-transition x-cloak
                     class="m-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 flex-shrink-0 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div class="flex-1">
                            <p class="font-medium text-red-900">{{ session('error') ?? 'Terjadi kesalahan' }}</p>
                            @if($errors->any())
                                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-800">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-900">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-slate-200 bg-white px-6 py-4 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} SMPN 13 &middot; Sistem Informasi Akademik
            </footer>
        </div>
    </div>

    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service worker registered.', reg))
                    .catch(err => console.log('Service worker registration failed: ', err));
            });
        }
    </script>
</body>
</html>
