<?php $__env->startSection('page-title', 'Nilai Saya'); ?>
<?php $__env->startSection('breadcrumb', 'Siswa › Nilai Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Nilai Saya</h1>
        <p class="mt-2 text-slate-600">Ringkasan nilai dan laporan akademik Anda.</p>
    </div>

    <!-- Filters -->
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <form method="GET" class="grid gap-4 md:grid-cols-3 md:items-end">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Filter Semester</p>
                <p class="mt-1 text-sm text-slate-600">Pilih semester untuk menampilkan nilai yang relevan.</p>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-900" for="semester_id">Semester</label>
                <select
                    id="semester_id"
                    name="semester_id"
                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                >
                    <option value="">Semua Semester</option>
                    <?php $__currentLoopData = $semesters ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($semester->id); ?>" <?php echo e(request('semester_id') == $semester->id ? 'selected' : ''); ?>>
                            <?php echo e($semester->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-900" for="subject_id">Mapel</label>
                <select
                    id="subject_id"
                    name="subject_id"
                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                >
                    <option value="">Semua Mapel</option>
                    <?php $__currentLoopData = $subjects ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subject->id); ?>" <?php echo e(request('subject_id') == $subject->id ? 'selected' : ''); ?>>
                            <?php echo e($subject->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-navy px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-opacity-90">
                    Terapkan
                </button>
                <a href="<?php echo e(route('student.records.index')); ?>" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Stats Row -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Rata-rata Nilai</p>
            <p class="mt-4 text-3xl font-bold text-navy"><?php echo e(number_format($grades->avg('score') ?? 0, 1)); ?></p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Nilai Tertinggi</p>
            <p class="mt-4 text-3xl font-bold text-navy"><?php echo e($grades->max('score') ?? 0); ?></p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Nilai Terendah</p>
            <p class="mt-4 text-3xl font-bold text-navy"><?php echo e($grades->min('score') ?? 0); ?></p>
        </div>
    </div>

    <!-- Grade Distribution Chart -->
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Grafik Nilai per Mata Pelajaran</p>
                <p class="mt-1 text-sm text-slate-600">Menampilkan rata-rata nilai untuk setiap mata pelajaran.</p>
            </div>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">Total mapel: <?php echo e($grades->groupBy(fn($grade) => $grade->subject?->name ?? 'Tanpa Mapel')->count()); ?></span>
        </div>

        <div class="mt-6 space-y-4">
            <?php $__currentLoopData = $grades->groupBy(fn($grade) => $grade->subject?->name ?? 'Tanpa Mapel'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject => $subjectGrades): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $average = $subjectGrades->avg('score') ?? 0;
                    $width = min(max($average, 5), 100);
                ?>
                <div>
                    <div class="flex items-center justify-between text-sm text-slate-700">
                        <span class="font-medium text-slate-900"><?php echo e($subject); ?></span>
                        <span class="text-slate-600"><?php echo e(number_format($average, 1)); ?></span>
                    </div>
                    <div class="mt-2 h-3 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-navy" style="width: <?php echo e($width); ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Semester</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tugas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nilai</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $score = $grade->score ?? 0;
                            if ($score >= 75) {
                                $scoreClass = 'text-green-600';
                            } elseif ($score >= 60) {
                                $scoreClass = 'text-amber-600';
                            } else {
                                $scoreClass = 'text-red-600';
                            }
                            $statusMap = [
                                'pass' => ['label' => 'Lulus', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                'fail' => ['label' => 'Tidak Lulus', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                'remedial' => ['label' => 'Remedial', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
                            ];
                            $status = $statusMap[$grade->status] ?? ['label' => ucfirst($grade->status ?? '-'), 'bg' => 'bg-slate-100', 'text' => 'text-slate-600'];
                        ?>
                        <tr class="border-t border-slate-200 <?php echo e($loop->even ? 'bg-slate-50' : ''); ?> hover:bg-slate-100">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?php echo e($i + 1); ?></td>
                            <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($grade->subject?->name ?? '-'); ?></td>
                            <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($grade->semester?->name ?? '-'); ?></td>
                            <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($grade->assignment ?? '-'); ?></td>
                            <td class="px-6 py-4 text-2xl font-bold <?php echo e($scoreClass); ?>"><?php echo e($score); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium <?php echo e($status['bg']); ?> <?php echo e($status['text']); ?>">
                                    <?php echo e($status['label']); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 4h12v16H6z" />
                                        <path d="M9 8h6" />
                                        <path d="M9 12h6" />
                                        <path d="M9 16h3" />
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-900">Belum ada nilai yang tercatat untuk Anda</p>
                                        <p class="text-sm text-slate-600">Nilai Anda akan muncul di halaman ini setelah dimasukkan.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/student/records.blade.php ENDPATH**/ ?>