<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Sistem Akademik SMPN 13'); ?></title>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    
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
<?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/layouts/auth.blade.php ENDPATH**/ ?>