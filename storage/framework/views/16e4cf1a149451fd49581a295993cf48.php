<?php $__env->startSection('page-title', 'Gabung Kelas'); ?>
<?php $__env->startSection('breadcrumb', 'Siswa › Gabung Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Gabung Kelas Baru</h1>
        <p class="mt-2 text-slate-600">Masukkan Kode Token Akses yang diberikan oleh Guru Anda untuk bergabung ke kelas.</p>
    </div>

    <!-- Form Input Token -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="<?php echo e(route('student.join-class.process')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label for="access_token" class="block text-sm font-semibold text-slate-800">Kode Token Akses Kelas</label>
                <div class="mt-2 flex gap-3">
                    <input
                        type="text"
                        name="access_token"
                        id="access_token"
                        value="<?php echo e(old('access_token')); ?>"
                        placeholder="Contoh: PJOK7A"
                        class="block w-full rounded-xl border border-slate-300 px-4 py-3 font-mono text-lg font-bold tracking-widest text-slate-900 uppercase focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                        required
                    />
                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center justify-center rounded-xl bg-navy px-6 py-3 font-semibold text-white transition hover:bg-opacity-90 shadow-sm"
                    >
                        Gabung Kelas
                    </button>
                </div>
                <?php $__errorArgs = ['access_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600 font-medium"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </form>
    </div>

    <!-- Daftar Kelas Saya -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-navy mb-4">Kelas Yang Diikuti</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <?php $__empty_1 = true; $__currentLoopData = $myClasses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg"><?php echo e($class->name); ?></h3>
                        <p class="text-xs text-slate-500 mt-1">Ruang: <?php echo e($class->room ?? '-'); ?> • Wali/Guru: <?php echo e($class->teacher->user->name ?? '-'); ?></p>
                    </div>
                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terdaftar</span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-8 text-center text-sm text-slate-500">
                    Anda belum terdaftar di kelas manapun. Masukkan kode token kelas dari guru di atas.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/student/join-class.blade.php ENDPATH**/ ?>