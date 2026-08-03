<?php $__env->startSection('page-title', 'Buat Surat Pernyataan'); ?>
<?php $__env->startSection('breadcrumb', 'Guru › Surat Pernyataan › Buat'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Penerbitan Surat Pernyataan (SP)</h1>
        <p class="mt-2 text-slate-600">Terbitkan Surat Pernyataan untuk siswa yang melakukan pelanggaran disiplin di kelas Anda.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="rounded-xl bg-red-50 p-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <form action="<?php echo e(route('teacher.warning-letters.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Nama Siswa -->
            <div>
                <label for="student_name" class="mb-2 block text-sm font-semibold text-slate-900">Nama Siswa</label>
                <input
                    type="text"
                    id="student_name"
                    name="student_name"
                    value="<?php echo e(old('student_name', $prefill['name'] ?? '')); ?>"
                    required
                    placeholder="Masukkan nama lengkap siswa"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:bg-white focus:outline-none"
                >
            </div>

            <!-- Kelas Siswa -->
            <div>
                <label for="class_name" class="mb-2 block text-sm font-semibold text-slate-900">Kelas</label>
                <input
                    type="text"
                    id="class_name"
                    name="class_name"
                    value="<?php echo e(old('class_name', $prefill['class'] ?? '')); ?>"
                    required
                    placeholder="Contoh: Matematika Dasar, 7A, 8B"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:bg-white focus:outline-none"
                >
            </div>

            <!-- NISN Siswa -->
            <div>
                <label for="student_number" class="mb-2 block text-sm font-semibold text-slate-900">NISN / Nomor Induk Siswa</label>
                <input
                    type="text"
                    id="student_number"
                    name="student_number"
                    value="<?php echo e(old('student_number', $prefill['nisn'] ?? '')); ?>"
                    required
                    placeholder="Masukkan NISN siswa"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:bg-white focus:outline-none"
                >
            </div>

            <!-- Tipe SP -->
            <div>
                <label for="type" class="mb-2 block text-sm font-semibold text-slate-900">Tingkat Surat Pernyataan (SP)</label>
                <select
                    id="type"
                    name="type"
                    required
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 transition focus:border-navy focus:bg-white focus:outline-none"
                >
                    <option value="SP1" <?php echo e(old('type', $prefill['type'] ?? '') == 'SP1' ? 'selected' : ''); ?>>SP1 (Surat Peringatan Kesatu)</option>
                    <option value="SP2" <?php echo e(old('type', $prefill['type'] ?? '') == 'SP2' ? 'selected' : ''); ?>>SP2 (Surat Peringatan Kedua)</option>
                    <option value="SP3" <?php echo e(old('type', $prefill['type'] ?? '') == 'SP3' ? 'selected' : ''); ?>>SP3 (Surat Peringatan Ketiga)</option>
                </select>
            </div>

            <!-- Alasan Pelanggaran -->
            <div>
                <label for="reason" class="mb-2 block text-sm font-semibold text-slate-900">Alasan & Detail Pelanggaran Disiplin</label>
                <textarea
                    id="reason"
                    name="reason"
                    rows="5"
                    required
                    placeholder="Tuliskan secara detail pelanggaran disiplin yang dilakukan oleh siswa..."
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition focus:border-navy focus:bg-white focus:outline-none"
                ><?php echo e(old('reason')); ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-navy px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-opacity-95"
                >
                    Terbitkan SP
                </button>
                <a
                    href="<?php echo e(route('teacher.warning-letters.index')); ?>"
                    class="inline-flex items-center justify-center rounded-xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/teacher/warning-letters-create.blade.php ENDPATH**/ ?>