<?php $__env->startSection('page-title', 'Mata Pelajaran Saya'); ?>
<?php $__env->startSection('breadcrumb', 'Guru › Mata Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <h1 class="text-3xl font-extrabold text-navy">Mata Pelajaran Saya</h1>
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <?php if($subject): ?>
            <p class="text-lg font-medium text-slate-900">Anda mengajar: <span class="font-bold text-blue-600"><?php echo e($subject->name); ?></span></p>
        <?php else: ?>
            <p class="text-slate-600">Belum ada mata pelajaran yang diampu.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/teacher/subjects.blade.php ENDPATH**/ ?>