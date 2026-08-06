<?php $__env->startSection('page-title', 'Mata Pelajaran Saya - Portal Guru'); ?>
<?php $__env->startSection('breadcrumb', 'Guru › Mata Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Mata Pelajaran Saya</h1>
            <p class="mt-1 text-sm text-slate-500">Rincian mata pelajaran utama yang diampu dan daftar kelas mengajar.</p>
        </div>
    </div>

    <!-- Primary Subject Banner -->
    <div class="rounded-2xl bg-navy p-6 text-white shadow-lg border border-slate-800">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-block rounded-full bg-amber-400/20 px-3.5 py-1 text-xs font-bold text-amber-400 tracking-wider uppercase mb-2 border border-amber-400/30">
                    Mata Pelajaran Utama
                </span>
                <h2 class="text-3xl font-extrabold text-white">
                    <?php echo e($primarySubject?->name ?? 'Matematika'); ?>

                </h2>
                <p class="mt-2 text-sm text-slate-200">
                    Kode Mapel: <span class="font-mono text-amber-400 font-bold px-2 py-0.5 bg-slate-800/80 rounded"><?php echo e($primarySubject?->code ?? 'MTK'); ?></span> | Pengampu: <strong class="text-white"><?php echo e(Auth::user()->name); ?></strong>
                </p>
            </div>
            <div class="rounded-xl bg-white/10 backdrop-blur-md p-4 border border-white/10 text-center min-w-[160px]">
                <p class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Total Kelas Ampuhan</p>
                <p class="text-3xl font-extrabold text-amber-400 mt-1"><?php echo e($classes->count()); ?></p>
            </div>
        </div>
    </div>

    <!-- Classes Taught Grid -->
    <div class="space-y-4">
        <h3 class="text-lg font-bold text-navy">Daftar Kelas Mengajar Mata Pelajaran Ini</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                            <?php echo e($class->room ?? 'Ruang Kelas'); ?>

                        </span>
                        <span class="text-xs font-mono text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                            Token: <?php echo e($class->access_token ?? '-'); ?>

                        </span>
                    </div>
                    <h4 class="mt-4 text-xl font-bold text-slate-900"><?php echo e($class->name); ?></h4>
                    <p class="mt-1 text-xs text-slate-500">Jadwal: <?php echo e($class->schedule ?? 'Belum Diatur'); ?></p>
                    
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                        <span>Total Siswa: <strong class="text-navy font-bold"><?php echo e($class->students_count ?? $class->students()->count()); ?></strong></span>
                        <a href="<?php echo e(route('teacher.grades.index', ['class_id' => $class->id])); ?>" class="font-semibold text-blue-600 hover:underline">
                            Input Nilai &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full rounded-2xl bg-white p-8 text-center text-slate-500 shadow-sm border border-slate-100">
                    <p class="font-medium text-slate-700">Belum ada kelas yang didaftarkan untuk mata pelajaran ini.</p>
                    <p class="mt-1 text-xs text-slate-400">Anda dapat membuat kelas baru melalui menu <strong>Kelas Saya</strong>.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/teacher/subjects.blade.php ENDPATH**/ ?>