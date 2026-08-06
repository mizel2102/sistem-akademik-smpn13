<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-lg shadow-slate-200/20">
        <div class="mb-6 rounded-2xl bg-blue-50 px-4 py-4 text-sm text-blue-700">
            Surat Peringatan diterbitkan kepada siswa yang melanggar aturan sekolah.
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Buat Surat Peringatan</h1>
            <p class="mt-2 text-sm text-slate-600">Isi data siswa dan rincian surat peringatan.</p>
        </div>

        <form action="<?php echo e(route('admin.warning-letters.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div>
                <label for="student_name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Siswa / NIS <span class="text-red-500">*</span></label>
                <input
                    id="student_name"
                    name="student_name"
                    type="text"
                    value="<?php echo e(old('student_name', request('student_name'))); ?>"
                    placeholder="Ketik Nama Siswa atau NIS (contoh: REYHAN LUBIS SAPUTRA atau 2502287)..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['student_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['student_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-700">Kelas Siswa</label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['academic_class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="">-- Pilih Kelas Siswa (Opsional) --</option>
                    <?php $__currentLoopData = $academicClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($class->id); ?>" <?php echo e(old('academic_class_id') == $class->id ? 'selected' : ''); ?>>
                            <?php echo e($class->name); ?> <?php if($class->room): ?> (<?php echo e($class->room); ?>) <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['academic_class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">Jenis Surat</label>
                <select
                    id="type"
                    name="type"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="SP1" <?php echo e(old('type') === 'SP1' ? 'selected' : ''); ?>>SP1 (Surat Peringatan 1)</option>
                    <option value="SP2" <?php echo e(old('type') === 'SP2' ? 'selected' : ''); ?>>SP2 (Surat Peringatan 2)</option>
                    <option value="SP3" <?php echo e(old('type') === 'SP3' ? 'selected' : ''); ?>>SP3 (Surat Peringatan 3)</option>
                </select>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="reason" class="mb-2 block text-sm font-semibold text-slate-700">Alasan / Pelanggaran</label>
                <textarea
                    id="reason"
                    name="reason"
                    rows="4"
                    placeholder="Jelaskan pelanggaran yang dilakukan..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                ><?php echo e(old('reason')); ?></textarea>
                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="issued_at" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Surat</label>
                <input
                    id="issued_at"
                    name="issued_at"
                    type="date"
                    value="<?php echo e(old('issued_at')); ?>"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['issued_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                />
                <?php $__errorArgs = ['issued_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="<?php echo e(route('admin.warning-letters.index')); ?>" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                    Batal
                </a>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 sm:w-auto">
                    Buat Surat Peringatan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/warning-letters/create.blade.php ENDPATH**/ ?>