<?php $__env->startSection('page-title', 'Dashboard Guru BK'); ?>
<?php $__env->startSection('breadcrumb', 'Guru BK › Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Dashboard Guru BK</h1>
        <p class="mt-1 text-sm text-slate-500">Pantau siswa yang membutuhkan perhatian dan tindak lanjut pembinaan.</p>
    </div>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-5">
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Perlu Perhatian</p>
            <p class="mt-2 text-3xl font-bold text-red-600"><?php echo e($statistics['students_needing_attention']); ?></p>
        </div>
        <?php $__currentLoopData = ['active_sp1' => 'SP1 Aktif', 'active_sp2' => 'SP2 Aktif', 'active_sp3' => 'SP3 Aktif']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-2xl bg-white p-5 shadow-sm">
                <p class="text-xs font-medium text-slate-500"><?php echo e($label); ?></p>
                <p class="mt-2 text-3xl font-bold text-amber-600"><?php echo e($statistics[$key]); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Pembinaan Bulan Ini</p>
            <p class="mt-2 text-3xl font-bold text-emerald-600"><?php echo e($statistics['counselings_this_month']); ?></p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-navy">Siswa dengan Alpha Tinggi</h2>
                <a href="<?php echo e(route('admin.counselings.index')); ?>" class="text-sm font-semibold text-navy hover:underline">Tindak lanjut</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 text-xs uppercase text-slate-500">
                        <tr><th class="px-2 py-3">Siswa</th><th class="px-2 py-3">Kelas</th><th class="px-2 py-3">Alpha</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $studentsNeedingAttention; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-slate-100 last:border-0">
                                <td class="px-2 py-3 font-medium text-slate-800"><?php echo e($student->user?->name ?? $student->student_number); ?></td>
                                <td class="px-2 py-3 text-slate-500"><?php echo e($student->academicClass?->name ?? '-'); ?></td>
                                <td class="px-2 py-3 font-semibold text-red-600"><?php echo e($student->alpha_count); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="px-2 py-6 text-center text-slate-500">Belum ada siswa yang melewati ambang alpha.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-navy">Pembinaan Terbaru</h2>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $recentCounselings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counseling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <p class="font-medium text-slate-800"><?php echo e($counseling->student?->user?->name ?? '-'); ?></p>
                        <p class="mt-1 text-sm text-slate-500"><?php echo e($counseling->session_at?->format('d M Y H:i') ?? 'Waktu belum ditentukan'); ?></p>
                        <?php if($counseling->notes): ?>
                            <p class="mt-2 text-sm text-slate-600"><?php echo e(Str::limit($counseling->notes, 120)); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="py-6 text-center text-slate-500">Belum ada riwayat pembinaan.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/bk/dashboard.blade.php ENDPATH**/ ?>