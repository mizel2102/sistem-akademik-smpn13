<?php $__env->startSection('page-title', 'Ruang Kelas: ' . $class->name); ?>
<?php $__env->startSection('breadcrumb', 'Siswa › Kelas Saya › ' . $class->name); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ activeTab: 'grades' }" class="space-y-6">
    <!-- Header Kelas -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-navy text-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-navy sm:text-3xl"><?php echo e($class->name); ?></h1>
                    <p class="mt-0.5 text-sm text-slate-500">Ruang: <span class="font-semibold text-slate-800"><?php echo e($class->room ?? '-'); ?></span> • Jadwal: <span class="font-semibold text-slate-800"><?php echo e($class->schedule ?? '-'); ?></span></p>
                    <p class="mt-0.5 text-xs text-slate-400">Guru / Wali: <?php echo e($class->teacher->user->name ?? '-'); ?> (NIP: <?php echo e($class->teacher->nip ?? '-'); ?>)</p>
                </div>
            </div>
            <a
                href="<?php echo e(route('student.classes.index')); ?>"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
            >
                &larr; Kembali ke Daftar Kelas
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200">
        <nav class="flex gap-4" aria-label="Tabs">
            <button
                @click="activeTab = 'grades'"
                :class="activeTab === 'grades' ? 'border-navy text-navy font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="py-3 px-1 border-b-2 text-sm transition"
            >
                Nilai Saya (<?php echo e($myGrades->count()); ?>)
            </button>
            <button
                @click="activeTab = 'attendance'"
                :class="activeTab === 'attendance' ? 'border-navy text-navy font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="py-3 px-1 border-b-2 text-sm transition"
            >
                Riwayat Absensi (<?php echo e($myAttendances->count()); ?>)
            </button>
            <button
                @click="activeTab = 'classmates'"
                :class="activeTab === 'classmates' ? 'border-navy text-navy font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="py-3 px-1 border-b-2 text-sm transition"
            >
                Teman Sekelas (<?php echo e($classmates->count()); ?>)
            </button>
        </nav>
    </div>

    <!-- Tab 1: Nilai Saya -->
    <div x-show="activeTab === 'grades'" class="space-y-4">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-navy">Daftar Nilai Akademik Kelas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Mata Pelajaran</th>
                            <th class="px-6 py-4">Tugas / Keterangan</th>
                            <th class="px-6 py-4">Semester</th>
                            <th class="px-6 py-4 text-center">Nilai</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $myGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-bold text-slate-900"><?php echo e($grade->subject->name ?? '-'); ?></td>
                                <td class="px-6 py-4"><?php echo e($grade->assignment ?? 'Tugas Harian'); ?></td>
                                <td class="px-6 py-4"><?php echo e($grade->semester->name ?? '-'); ?></td>
                                <td class="px-6 py-4 text-center font-extrabold text-base text-navy"><?php echo e($grade->score); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($grade->status === 'passed' || $grade->score >= 75 ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'); ?>">
                                        <?php echo e(strtoupper($grade->status ?? 'Pass')); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Belum ada nilai yang diinput guru untuk Anda di kelas ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab 2: Absensi Saya -->
    <div x-show="activeTab === 'attendance'" x-cloak class="space-y-4">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-navy">Riwayat Kehadiran</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $myAttendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-semibold text-slate-900"><?php echo e($att->attendance_time->translatedFormat('l, d F Y')); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($att->status === 'present' ? 'bg-green-100 text-green-700' : ($att->status === 'sick' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')); ?>">
                                        <?php echo e(strtoupper($att->status)); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Belum ada catatan absensi untuk Anda di kelas ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab 3: Teman Sekelas -->
    <div x-show="activeTab === 'classmates'" x-cloak class="space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-navy mb-4">Teman Sekelas</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__empty_1 = true; $__currentLoopData = $classmates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-navy text-sm font-semibold text-white">
                            <?php echo e(strtoupper(substr($cm->user->name ?? "?", 0, 1))); ?>

                        </div>
                        <div>
                            <p class="font-semibold text-slate-900"><?php echo e($cm->user->name ?? '-'); ?></p>
                            <p class="text-xs text-slate-500">NIS: <?php echo e($cm->student_number ?? $cm->nis ?? '-'); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full py-6 text-center text-sm text-slate-500">
                        Tidak ada anggota lain di kelas ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/student/classes/show.blade.php ENDPATH**/ ?>