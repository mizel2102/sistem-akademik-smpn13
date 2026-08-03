<!doctype html>
<!-- Reference: https://www.sman1yogya.sch.id/id
    USAGE: This external site is used only as a visual/reference guide.
    Do NOT copy content, images, or other assets from the site into this repository
    without explicit permission. Any assets used must be added manually with
    proper license/permission and documented in REFERENCE.md. -->
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Sistem Akademik SMPN 13'); ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Portal Akademik Digital SMPN 13 Sungai Raya — Akses nilai, jadwal, absensi, dan pengumuman sekolah dalam satu platform terpadu.'); ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="SMPN 13 Sungai Raya - Portal Akademik Digital">
    <meta property="og:description" content="Akses nilai, jadwal, absensi, dan pengumuman sekolah dalam satu platform terpadu.">
    <meta property="og:image" content="<?php echo e(asset('images/logo_academics.jpg')); ?>">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Load Inter font for SaaS Minimalist look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased text-zinc-900 bg-[#fcfcfc]">
    <a href="#main-content" class="skip-link sr-only focus:not-sr-only fixed top-4 left-4 z-50 bg-zinc-950 text-white px-3 py-2 rounded shadow">Langsung ke konten</a>
    
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 
    <main class="min-h-screen">
        <div id="main-content"></div>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
 
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
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
<?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/layouts/public.blade.php ENDPATH**/ ?>