<?php $__env->startSection('page-title', 'Detail Siswa'); ?>
<?php $__env->startSection('breadcrumb', 'Admin › Data Siswa › Detail'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $nameParts = preg_split('/\s+/', trim($student->user?->name ?? ''));
    $initials = collect($nameParts)->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->join('');
    $genderLabel = match ($student->gender) {
        'male' => 'Laki-laki',
        'female' => 'Perempuan',
        default => '-',
    };
?>

<div class="mx-auto max-w-7xl">
    <div x-data="{
            tab: ['grades', 'attendance', 'address'].includes(window.location.hash.replace('#', '')) ? window.location.hash.replace('#', '') : 'grades'
        }"
        x-init="window.addEventListener('hashchange', () => {
            const hashTab = window.location.hash.replace('#', '');
            if (['grades', 'attendance', 'address'].includes(hashTab)) {
                tab = hashTab;
            }
        })"
        class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex flex-col items-center gap-4 text-center">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-navy text-4xl font-extrabold text-gold">
                    <?php echo e($initials ?: 'SS'); ?>

                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900"><?php echo e($student->user?->name ?? '-'); ?></h2>
                    <p class="mt-1 text-sm text-slate-500"><?php echo e($student->user?->email ?? '-'); ?></p>
                </div>
                <span class="rounded-full bg-navy-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-navy">Siswa</span>
            </div>

            <div class="my-6 h-px bg-slate-200"></div>

            <div class="space-y-4 text-sm text-slate-600">
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">NIS</span>
                    <span><?php echo e($student->student_number ?? '-'); ?></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Kelas</span>
                    <span><?php echo e($student->academicClass?->name ?? '-'); ?></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Tingkat</span>
                    <span><?php echo e($student->grade_level ? 'Kelas ' . $student->grade_level : '-'); ?></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Jenis Kelamin</span>
                    <span><?php echo e($genderLabel); ?></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Tempat Lahir</span>
                    <span><?php echo e($student->birthplace ?? '-'); ?></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="font-semibold text-slate-800">Tanggal Lahir</span>
                    <span><?php echo e($student->birthdate?->format('d F Y') ?? '-'); ?></span>
                </div>
            </div>

            <div class="my-6 h-px bg-slate-200"></div>

            <div class="space-y-3">
                <a href="<?php echo e(route('admin.reports.rapor', $student)); ?>" class="block rounded-2xl border border-navy px-5 py-3 text-center text-sm font-semibold text-navy transition hover:bg-navy/5">
                    Lihat Rapor
                </a>
                <a href="<?php echo e(route('admin.reports.rapor.pdf', $student)); ?>" class="block rounded-2xl border border-navy px-5 py-3 text-center text-sm font-semibold text-navy transition hover:bg-navy/5">
                    Unduh PDF Rapor
                </a>
            </div>

            <div class="mt-6">
                <a href="<?php echo e(route('admin.students.edit', $student)); ?>" class="block rounded-2xl bg-navy px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-opacity-90">
                    Edit Data
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl bg-white p-4 shadow-sm">
                <div class="flex flex-wrap gap-3 border-b border-slate-200 pb-3">
                    <button @click="tab='grades'; window.location.hash = 'grades'" :class="tab === 'grades' ? 'border-b-2 border-navy text-navy font-bold' : 'text-slate-500'" class="pb-3 text-sm transition">Nilai</button>
                    <button @click="tab='attendance'; window.location.hash = 'attendance'" :class="tab === 'attendance' ? 'border-b-2 border-navy text-navy font-bold' : 'text-slate-500'" class="pb-3 text-sm transition">Absensi</button>
                    <button @click="tab='address'; window.location.hash = 'address'" :class="tab === 'address' ? 'border-b-2 border-navy text-navy font-bold' : 'text-slate-500'" class="pb-3 text-sm transition">Alamat</button>
                </div>

                <div class="mt-6">
                    <div x-show="tab==='grades'" x-cloak class="space-y-4">
                        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white p-3">
                            <table class="min-w-full text-left text-sm text-slate-700">
                                <thead>
                                    <tr class="border-b border-slate-200 text-slate-900">
                                        <th class="px-4 py-3">No</th>
                                        <th class="px-4 py-3">Mata Pelajaran</th>
                                        <th class="px-4 py-3">Semester</th>
                                        <th class="px-4 py-3">Tugas</th>
                                        <th class="px-4 py-3">Nilai</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    <?php $__empty_1 = true; $__currentLoopData = $student->grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $score = $grade->assignment;
                                            $scoreClass = $score >= 75 ? 'text-emerald-700' : ($score >= 60 ? 'text-amber-700' : 'text-red-700');
                                            $status = $score >= 75 ? 'Lulus' : ($score >= 60 ? 'Perbaikan' : 'Tidak Lulus');
                                        ?>
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-slate-700"><?php echo e($index + 1); ?></td>
                                            <td class="px-4 py-3"><?php echo e($grade->subject?->name ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($grade->semester?->name ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($grade->assignment ?? '-'); ?></td>
                                            <td class="px-4 py-3 font-semibold <?php echo e($scoreClass); ?>"><?php echo e($score ?? '-'); ?></td>
                                            <td class="px-4 py-3">
                                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-700"><?php echo e($status); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada data nilai</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="tab==='attendance'" x-cloak class="space-y-4">
                        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white p-3">
                            <table class="min-w-full text-left text-sm text-slate-700">
                                <thead>
                                    <tr class="border-b border-slate-200 text-slate-900">
                                        <th class="px-4 py-3">No</th>
                                        <th class="px-4 py-3">Kelas</th>
                                        <th class="px-4 py-3">Waktu</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">IP Address</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    <?php $__empty_1 = true; $__currentLoopData = $student->attendances->sortByDesc('attendance_time'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $statusMap = [
                                                'present' => ['label' => 'Hadir', 'class' => 'bg-emerald-100 text-emerald-700'],
                                                'late' => ['label' => 'Terlambat', 'class' => 'bg-amber-100 text-amber-700'],
                                                'absent' => ['label' => 'Tidak Hadir', 'class' => 'bg-red-100 text-red-700'],
                                            ];
                                            $attendanceStatus = $statusMap[$att->status] ?? ['label' => ucfirst($att->status), 'class' => 'bg-slate-100 text-slate-700'];
                                        ?>
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-slate-700"><?php echo e($index + 1); ?></td>
                                            <td class="px-4 py-3"><?php echo e($student->academicClass?->name ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($att->attendance_time?->format('d M Y H:i') ?? '-'); ?></td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($attendanceStatus['class']); ?>"><?php echo e($attendanceStatus['label']); ?></span>
                                            </td>
                                            <td class="px-4 py-3"><?php echo e($att->ip_address ?? '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada data absensi</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="tab==='address'" x-cloak>
                        <div class="rounded-3xl bg-white p-6 text-sm leading-relaxed text-slate-700">
                            <?php echo e($student->address ?? 'Alamat belum diisi'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/students/show.blade.php ENDPATH**/ ?>