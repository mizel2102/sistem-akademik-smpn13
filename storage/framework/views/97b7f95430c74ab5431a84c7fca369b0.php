<?php $__env->startSection('page-title', 'Jadwal Pelajaran'); ?>
<?php $__env->startSection('breadcrumb', 'Siswa › Jadwal Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Jadwal Pelajaran</h1>
        <p class="mt-2 text-slate-600">Lihat jadwal pelajaran Anda dalam tampilan mingguan.</p>
    </div>

    <?php
        $dayOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
        $groupedByTime = $schedules->groupBy('start_time');
        $days = array_keys($dayOrder);
    ?>

    <?php if($schedules->isNotEmpty() && $groupedByTime->count() > 1): ?>
        <div class="overflow-x-auto rounded-2xl bg-white shadow-sm">
            <table class="w-full min-w-max border-collapse">
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-4 py-4 text-left text-sm font-semibold">Waktu</th>
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-4 text-left text-sm font-semibold"><?php echo e($day); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $groupedByTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time => $entries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $rowByDay = collect($entries)->keyBy(fn($item) => $item->day);
                        ?>
                        <tr class="border-t border-slate-200 hover:bg-slate-50">
                            <td class="px-4 py-4 text-sm font-semibold text-slate-900"><?php echo e($time); ?></td>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $entry = $rowByDay[$day] ?? null; ?>
                                <td class="w-48 px-4 py-4 align-top text-sm text-slate-900">
                                    <?php if($entry): ?>
                                        <div class="rounded-2xl bg-slate-50 p-3">
                                            <p class="font-semibold text-slate-900"><?php echo e($entry->subject?->name ?? '-'); ?></p>
                                            <p class="mt-1 text-xs text-slate-500"><?php echo e($entry->teacher?->user?->name ?? '-'); ?></p>
                                            <p class="mt-2 text-xs font-medium text-slate-700"><?php echo e($entry->room ?? '-'); ?></p>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-slate-400">-</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-navy text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Hari</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Guru</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Ruang</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $schedules->sortBy(fn($schedule) => [$dayOrder[$schedule->day] ?? 99, $schedule->start_time]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-slate-200 hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($schedule->day ?? '-'); ?></td>
                                <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($schedule->start_time); ?> - <?php echo e($schedule->end_time); ?></td>
                                <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($schedule->subject?->name ?? '-'); ?></td>
                                <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($schedule->teacher?->user?->name ?? '-'); ?></td>
                                <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($schedule->room ?? '-'); ?></td>
                                <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($schedule->academicClass?->name ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M8 7V3m8 4V3M4 11h16M5 20h14a2 2 0 0 0 2-2V7H3v11a2 2 0 0 0 2 2z" />
                                        </svg>
                                        <div>
                                            <p class="font-medium text-slate-900">Jadwal belum tersedia untuk Anda</p>
                                            <p class="text-sm text-slate-600">Jadwal akan muncul setelah data di input ke sistem.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/student/schedule.blade.php ENDPATH**/ ?>