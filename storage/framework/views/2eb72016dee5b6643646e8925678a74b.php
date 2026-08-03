<?php $__env->startSection('page-title', 'Tambah Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-2xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Tambah Guru</h1>
        <p class="mt-2 text-sm text-slate-600">Tambahkan guru baru dengan detail akun pengguna dan mata pelajaran yang sesuai.</p>

        <?php echo $__env->make('admin.teachers._form', [
            'action' => route('admin.teachers.store'),
            'method' => 'POST',
            'submitLabel' => 'Tambah Guru',
            'teacher' => null,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/teachers/create.blade.php ENDPATH**/ ?>