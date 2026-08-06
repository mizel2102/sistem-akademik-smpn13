<?php $__env->startSection('page-title', 'Monitoring Alpha - Guru BK'); ?>
<?php $__env->startSection('breadcrumb', 'Guru BK › Monitoring Alpha'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Monitoring Alpha Siswa</h1>
        <p class="mt-1 text-sm text-slate-500">Pantau siswa yang melebihi ambang batas alpha dan tentukan tindak lanjut.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Total Siswa Alpha &ge; 3</p>
            <p class="mt-2 text-3xl font-bold text-red-600"><?php echo e($students->total()); ?></p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">SP1 Aktif</p>
            <p class="mt-2 text-3xl font-bold text-amber-600"><?php echo e($spDistribution['SP1'] ?? 0); ?></p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">SP2 Aktif</p>
            <p class="mt-2 text-3xl font-bold text-orange-600"><?php echo e($spDistribution['SP2'] ?? 0); ?></p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">SP3 Aktif</p>
            <p class="mt-2 text-3xl font-bold text-red-800"><?php echo e($spDistribution['SP3'] ?? 0); ?></p>
        </div>
    </div>

    <!-- Chart: Alpha Trend -->
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-navy mb-4">Tren Alpha (4 Minggu Terakhir)</h2>
        <div class="flex items-end gap-3 h-40">
            <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full rounded-t-lg bg-red-500 transition-all"
                         style="height: <?php echo e(max($week['count'] * 10, 4)); ?>px;">
                    </div>
                    <span class="text-xs text-slate-500"><?php echo e($week['label']); ?></span>
                    <span class="text-xs font-semibold text-slate-700"><?php echo e($week['count']); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Filter -->
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="w-48">
                <select name="semester_id"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="">Semua Semester</option>
                    <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($semester->id); ?>" <?php echo e($semesterId == $semester->id ? 'selected' : ''); ?>>
                            <?php echo e($semester->name ?? $semester->semester); ?> - <?php echo e($semester->academicYear?->name ?? ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="w-32">
                <select name="min_alpha"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-navy focus:outline-none">
                    <option value="3" <?php echo e($minAlpha === 3 ? 'selected' : ''); ?>>Min. 3 Alpha</option>
                    <option value="6" <?php echo e($minAlpha === 6 ? 'selected' : ''); ?>>Min. 6 Alpha</option>
                    <option value="9" <?php echo e($minAlpha === 9 ? 'selected' : ''); ?>>Min. 9 Alpha</option>
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-navy px-4 py-2 text-sm font-medium text-white hover:bg-navy/90">
                Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Students Table -->
    <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-600">Siswa</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Kelas</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Total Alpha</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Status SP</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Status Monitoring</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $activeSP = $student->warningLetters()->active()->latest('issued_at')->first();
                            $spBadge = match ($activeSP?->type) {
                                'SP1' => 'bg-amber-100 text-amber-700',
                                'SP2' => 'bg-orange-100 text-orange-700',
                                'SP3' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-500',
                            };
                            $monitoringBadge = match ($student->monitoring_status ?? null) {
                                'perlu_dipanggil' => 'bg-red-100 text-red-700',
                                'sudah_dipanggil' => 'bg-blue-100 text-blue-700',
                                'dalam_pembinaan' => 'bg-purple-100 text-purple-700',
                                default => 'bg-slate-100 text-slate-500',
                            };
                            $monitoringLabel = match ($student->monitoring_status ?? null) {
                                'perlu_dipanggil' => 'Perlu Dipanggil',
                                'sudah_dipanggil' => 'Sudah Dipanggil',
                                'dalam_pembinaan' => 'Dalam Pembinaan',
                                default => 'Belum Dimonitor',
                            };
                        ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-slate-800"><?php echo e($student->user?->name ?? 'N/A'); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($student->student_number); ?></p>
                            </td>
                            <td class="px-4 py-3 text-slate-500"><?php echo e($student->academicClass?->name ?? '-'); ?></td>
                            <td class="px-4 py-3">
                                <span class="font-semibold <?php echo e($student->alpha_count >= 9 ? 'text-red-600' : ($student->alpha_count >= 6 ? 'text-orange-600' : 'text-amber-600')); ?>">
                                    <?php echo e($student->alpha_count); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <?php if($activeSP): ?>
                                    <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold <?php echo e($spBadge); ?>">
                                        <?php echo e($activeSP->type); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-slate-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold <?php echo e($monitoringBadge); ?>">
                                    <?php echo e($monitoringLabel); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <form action="<?php echo e(route('bk.monitoring.update-status', $student->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <select name="monitoring_status" onchange="this.form.submit()"
                                                class="rounded-lg border border-slate-300 px-2 py-1 text-xs focus:border-navy focus:outline-none">
                                            <option value="perlu_dipanggil" <?php echo e(($student->monitoring_status ?? '') === 'perlu_dipanggil' ? 'selected' : ''); ?>>Perlu Dipanggil</option>
                                            <option value="sudah_dipanggil" <?php echo e(($student->monitoring_status ?? '') === 'sudah_dipanggil' ? 'selected' : ''); ?>>Sudah Dipanggil</option>
                                            <option value="dalam_pembinaan" <?php echo e(($student->monitoring_status ?? '') === 'dalam_pembinaan' ? 'selected' : ''); ?>>Dalam Pembinaan</option>
                                        </select>
                                    </form>
                                    <a href="<?php echo e(route('bk.counselings.create', ['student_id' => $student->id])); ?>"
                                       class="rounded-lg px-2 py-1 text-xs font-medium text-navy hover:bg-navy/10">
                                        Pembinaan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                                Tidak ada siswa yang melebihi ambang batas alpha.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($students->hasPages()): ?>
            <div class="border-t border-slate-200 px-4 py-3">
                <?php echo e($students->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/bk/monitoring/alpha.blade.php ENDPATH**/ ?>