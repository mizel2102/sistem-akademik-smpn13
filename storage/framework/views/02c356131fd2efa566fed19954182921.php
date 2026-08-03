<?php $__env->startSection('page-title', 'Data Siswa'); ?>
<?php $__env->startSection('breadcrumb', 'Guru › Data Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <h1 class="text-3xl font-extrabold text-navy">Data Siswa di Kelas Anda</h1>
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <ul class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="border-b border-slate-200 pb-4">
                    <p class="font-medium text-slate-900"><?php echo e($student->user->name ?? 'Anonim'); ?> - NIS: <?php echo e($student->nis); ?></p>
                    <p class="text-sm text-slate-600">Kelas: <?php echo e($student->academicClass->name ?? '-'); ?></p>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-slate-600">Tidak ada siswa yang terdaftar di kelas Anda.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/teacher/students.blade.php ENDPATH**/ ?>