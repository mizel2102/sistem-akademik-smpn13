<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-7xl py-10">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy"><?php echo e($academicClass->name); ?></h1>
            <p class="mt-1 text-slate-600">Detail kelas dan daftar siswa untuk wali kelas ini.</p>
        </div>
        <a href="<?php echo e(route('admin.academic-classes.edit', $academicClass)); ?>" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">
            Edit Kelas
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">Wali Kelas</p>
            <p class="mt-3 text-lg font-semibold text-slate-900"><?php echo e($academicClass->teacher?->user?->name ?? 'Belum ditentukan'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">Ruang</p>
            <p class="mt-3 text-lg font-semibold text-slate-900"><?php echo e($academicClass->room ?? '-'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">Jumlah Siswa</p>
            <p class="mt-3 text-lg font-semibold text-slate-900"><?php echo e($academicClass->students->count()); ?></p>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-slate-900">Daftar Siswa di Kelas Ini</h2>
            <p class="mt-1 text-sm text-slate-500">Semua siswa yang terdaftar di kelas ini ditampilkan di bawah.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 font-semibold uppercase tracking-[0.12em]">No</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-[0.12em]">NIS</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-[0.12em]">Nama</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-[0.12em]">Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $academicClass->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-4 text-slate-700"><?php echo e($loop->iteration); ?></td>
                            <td class="whitespace-nowrap px-4 py-4 text-slate-700"><?php echo e($student->nis ?? '-'); ?></td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-semibold text-slate-700">
                                        <?php echo e(strtoupper(substr($student->user?->name ?? '-', 0, 1))); ?>

                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900"><?php echo e($student->user?->name ?? 'Nama tidak tersedia'); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-700"><?php echo e(ucfirst($student->gender ?? '-')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada siswa di kelas ini</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/academic-classes/show.blade.php ENDPATH**/ ?>