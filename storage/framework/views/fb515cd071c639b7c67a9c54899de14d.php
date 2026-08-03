<?php $__env->startSection('page-title', 'Data Absensi'); ?>
<?php $__env->startSection('breadcrumb', 'Guru › Data Absensi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Data Absensi Siswa & Indikasi Kedisiplinan</h1>
        <p class="mt-2 text-slate-600">Pantau tingkat ketidakhadiran (Alpa) siswa Anda dan terbitkan Surat Pernyataan (SP) secara langsung jika diperlukan.</p>
    </div>

    <!-- Lokasi Pusat Absensi Sekolah -->
    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="font-bold text-slate-800">📍 Lokasi Absensi Sekolah (5CM Coffee & Eatery Cabang Pancasila)</h4>
            <p class="text-xs text-slate-500">Koordinat absensi resmi yang digunakan untuk verifikasi kehadiran digital.</p>
        </div>
        <a
            href="https://www.google.com/maps/place/5CM+Coffee+%26+Eatery+(Cabang+Pancasila)/@-0.0268033,109.3167872,17z/data=!3m1!4b1!4m6!3m5!1s0x2e1d59007178ab37:0x2159dd29619903b9!8m2!3d-0.0268033!4d109.3193675!16s%2Fg%2F11lckf45j1?entry=ttu&g_ep=EgoyMDI2MDcyOS4wIKXMDSoASAFQAw%3D%3D"
            target="_blank"
            class="inline-flex items-center justify-center rounded-xl bg-navy px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-opacity-95"
        >
            Buka di Google Maps
        </a>
    </div>

    <!-- Section 1: Rekap Ketidakdisiplinan / Alpa Siswa -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-slate-800">Rekap Kehadiran & Rekomendasi SP</h2>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 font-semibold">NISN</th>
                            <th class="px-6 py-4 font-semibold">Kelas</th>
                            <th class="px-6 py-4 font-semibold text-center">Hadir</th>
                            <th class="px-6 py-4 font-semibold text-center">Terlambat</th>
                            <th class="px-6 py-4 font-semibold text-center">Sakit / Izin</th>
                            <th class="px-6 py-4 font-semibold text-center text-rose-600">Alpa</th>
                            <th class="px-6 py-4 font-semibold">Indikasi Pelanggaran</th>
                            <th class="px-6 py-4 font-semibold text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php $__empty_1 = true; $__currentLoopData = $studentStats ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900">
                                    <?php echo e($stat->user->name ?? '-'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500">
                                    <?php echo e($stat->student_number ?? $stat->nis ?? '-'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <?php echo e($stat->academicClass->name ?? '-'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-emerald-600">
                                    <?php echo e($stat->present_count); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-amber-600">
                                    <?php echo e($stat->late_count); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-blue-600">
                                    <?php echo e($stat->sick_count + $stat->permission_count); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold text-rose-600 bg-rose-50/30">
                                    <?php echo e($stat->alpha_count); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <?php if($stat->rec_sp): ?>
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-800 animate-pulse">
                                            <span class="h-2 w-2 rounded-full bg-rose-600"></span>
                                            Rekomendasi <?php echo e($stat->rec_sp); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-800">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            Disiplin Baik
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <?php if($stat->rec_sp): ?>
                                        <a
                                            href="<?php echo e(route('teacher.warning-letters.create', [
                                                'name' => $stat->user->name ?? '',
                                                'class' => $stat->academicClass->name ?? '',
                                                'nisn' => $stat->student_number ?? $stat->nis ?? '',
                                                'type' => $stat->rec_sp
                                            ])); ?>"
                                            class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-3.5 py-1.5 text-xs font-bold text-white transition hover:bg-rose-700 shadow-sm"
                                        >
                                            Terbitkan <?php echo e($stat->rec_sp); ?>

                                        </a>
                                    <?php else: ?>
                                        <a
                                            href="<?php echo e(route('teacher.warning-letters.create', [
                                                'name' => $stat->user->name ?? '',
                                                'class' => $stat->academicClass->name ?? '',
                                                'nisn' => $stat->student_number ?? $stat->nis ?? '',
                                                'type' => 'SP1'
                                            ])); ?>"
                                            class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Buat SP
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data siswa untuk rekap kehadiran.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 2: Log Kehadiran Terbaru -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-slate-800">Log Aktivitas Kehadiran Terbaru</h2>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 font-semibold">Kelas</th>
                            <th class="px-6 py-4 font-semibold">Waktu Absen</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php $__empty_1 = true; $__currentLoopData = $attendances ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900">
                                    <?php echo e($attendance->student->user->name ?? '-'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <?php echo e($attendance->academicClass->name ?? '-'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <?php echo e($attendance->attendance_time ? $attendance->attendance_time->format('d M Y H:i') : '-'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <?php
                                        $statusColor = match($attendance->status) {
                                            'present' => 'bg-emerald-100 text-emerald-600',
                                            'late' => 'bg-amber-100 text-amber-600',
                                            'sick' => 'bg-blue-100 text-blue-600',
                                            'permission' => 'bg-purple-100 text-purple-600',
                                            default => 'bg-rose-100 text-rose-600',
                                        };
                                        $statusText = match($attendance->status) {
                                            'present' => 'Hadir',
                                            'late' => 'Terlambat',
                                            'sick' => 'Sakit',
                                            'permission' => 'Izin',
                                            default => 'Alpa',
                                        };
                                    ?>
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusColor); ?>">
                                        <?php echo e($statusText); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada log absensi terbaru.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(isset($attendances) && $attendances->hasPages()): ?>
                <div class="mt-6 border-t border-slate-200 pt-6">
                    <?php echo e($attendances->appends(['student_page' => request('student_page')])->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/teacher/attendance.blade.php ENDPATH**/ ?>