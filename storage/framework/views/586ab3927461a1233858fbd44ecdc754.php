<?php $__env->startSection('page-title', 'Terbitkan SP - Guru BK'); ?>
<?php $__env->startSection('breadcrumb', 'Guru BK › Surat Peringatan › Terbitkan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-navy mb-6">Terbitkan Surat Peringatan</h2>

        <form action="<?php echo e(route('bk.warning-letters.store')); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Student Name Input (Text Input) -->
            <div>
                <label for="student_name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Siswa / NIS <span class="text-red-500">*</span></label>
                <input type="text" name="student_name" id="student_name" required
                       value="<?php echo e(old('student_name', request('student_name'))); ?>"
                       placeholder="Ketik Nama Siswa atau NIS (contoh: REYHAN LUBIS SAPUTRA atau 2502287)..."
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none <?php $__errorArgs = ['student_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['student_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Kelas (Class) -->
            <div>
                <label for="academic_class_id" class="block text-sm font-semibold text-slate-700 mb-1">Kelas Siswa</label>
                <select name="academic_class_id" id="academic_class_id"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none <?php $__errorArgs = ['academic_class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
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
                    <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- SP Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Surat Peringatan <span class="text-red-500">*</span></label>
                <select name="type" id="type" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Pilih Jenis SP</option>
                    <option value="SP1" <?php echo e(old('type') === 'SP1' ? 'selected' : ''); ?>>SP1 (Alpha 3-5)</option>
                    <option value="SP2" <?php echo e(old('type') === 'SP2' ? 'selected' : ''); ?>>SP2 (Alpha 6-8)</option>
                    <option value="SP3" <?php echo e(old('type') === 'SP3' ? 'selected' : ''); ?>>SP3 (Alpha 9+)</option>
                </select>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Reason -->
            <div>
                <label for="reason" class="block text-sm font-semibold text-slate-700 mb-1">Alasan Penerbitan</label>
                <textarea name="reason" id="reason" rows="4"
                          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          placeholder="Deskripsikan alasan penerbitan surat peringatan..."><?php echo e(old('reason')); ?></textarea>
                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Issued At -->
            <div>
                <label for="issued_at" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Terbit</label>
                <input type="datetime-local" name="issued_at" id="issued_at"
                       value="<?php echo e(old('issued_at')); ?>"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none">
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="<?php echo e(route('bk.warning-letters.index')); ?>"
                   class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="rounded-lg bg-navy px-6 py-2 text-sm font-semibold text-white hover:bg-navy/90">
                    Terbitkan SP
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('student_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const alphaCount = selected.getAttribute('data-alpha');
    const info = document.getElementById('alpha-info');
    const count = document.getElementById('alpha-count');

    if (alphaCount !== null) {
        info.classList.remove('hidden');
        count.textContent = alphaCount;
    } else {
        info.classList.add('hidden');
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/bk/warning-letters/create.blade.php ENDPATH**/ ?>