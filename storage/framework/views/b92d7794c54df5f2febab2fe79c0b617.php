<?php $__env->startSection('page-title', 'Kelas Saya'); ?>
<?php $__env->startSection('breadcrumb', 'Siswa › Kelas Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Kelas Saya</h1>
            <p class="mt-1 text-slate-600">Pilih kelas yang Anda ikuti untuk masuk ke ruang kelas digital.</p>
        </div>
        <a
            href="<?php echo e(route('student.join-class')); ?>"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-navy px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-opacity-90"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Gabung Kelas Baru via Token
        </a>
    </div>

    <!-- Quick Token Input Banner -->
    <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm">
        <form action="<?php echo e(route('student.join-class.process')); ?>" method="POST" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <?php echo csrf_field(); ?>
            <div class="flex-1">
                <label for="access_token" class="block text-xs font-semibold uppercase tracking-wider text-blue-700">Punya Token Kelas dari Guru?</label>
                <input
                    type="text"
                    name="access_token"
                    id="access_token"
                    placeholder="Masukkan Kode Token (Contoh: PJOK7A)"
                    class="mt-1 block w-full rounded-xl border border-blue-200 bg-white px-4 py-2.5 font-mono text-sm font-bold uppercase tracking-wider text-slate-900 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                    required
                />
            </div>
            <button
                type="submit"
                class="inline-flex shrink-0 items-center justify-center rounded-xl bg-blue-600 px-6 py-2.5 font-semibold text-white transition hover:bg-blue-700 shadow-sm sm:mt-5"
            >
                Gabung Kelas
            </button>
        </form>
    </div>

    <!-- Grid Kelas Yang Diikuti -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $myClasses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                <div class="p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-navy/10 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terdaftar</span>
                    </div>

                    <h2 class="text-xl font-bold text-navy"><?php echo e($class->name); ?></h2>
                    <p class="mt-1 text-sm text-slate-500">Ruang: <span class="font-semibold text-slate-700"><?php echo e($class->room ?? '-'); ?></span></p>
                    <p class="mt-0.5 text-sm text-slate-500">Wali/Guru: <span class="font-semibold text-slate-700"><?php echo e($class->teacher->user->name ?? '-'); ?></span></p>
                    <p class="mt-0.5 text-sm text-slate-500">Jadwal: <span class="font-semibold text-slate-700"><?php echo e($class->schedule ?? '-'); ?></span></p>

                    <div class="mt-4 flex items-center gap-2 text-sm text-slate-600">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <span class="text-xs font-medium"><?php echo e($class->students->count()); ?> Teman Sekelas</span>
                    </div>
                </div>

                <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                    <a
                        href="<?php echo e(route('student.classes.show', $class->id)); ?>"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-navy px-4 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk Kelas
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Belum Mengikuti Kelas</h3>
                <p class="mt-1 text-sm text-slate-500">Masukkan kode token kelas dari guru Anda pada form di atas untuk bergabung ke kelas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/student/classes/index.blade.php ENDPATH**/ ?>