<section class="relative bg-[#0f172a] text-white pt-36 pb-16 overflow-hidden">
    <!-- Background overlay elements -->
    <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a] via-[#1e293b]/95 to-sky-900/30"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left flex flex-col items-center md:items-start">
        <span class="inline-block px-3.5 py-1.5 mb-4 text-[0.65rem] font-bold tracking-[0.2em] text-sky-300 uppercase bg-sky-500/10 border border-sky-500/20 rounded-full backdrop-blur-sm shadow-sm">
            <?php echo e($subtitle ?? 'Portal Akademik SMPN 13'); ?>

        </span>
        <h1 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-4 leading-tight"><?php echo e($title); ?></h1>
        <p class="text-base md:text-lg text-slate-300 max-w-2xl leading-relaxed"><?php echo e($description); ?></p>
    </div>
</section>
<?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/partials/page-hero.blade.php ENDPATH**/ ?>