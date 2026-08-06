<?php $__env->startSection('page-title', isset($student) ? 'Edit Siswa' : 'Tambah Siswa'); ?>
<?php $__env->startSection('breadcrumb', isset($student) ? 'Admin › Edit Siswa' : 'Admin › Tambah Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-2xl">
    <!-- Card Container -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <!-- Card Header -->
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
            <h1 class="text-xl font-bold text-navy">
                <?php echo e(isset($student) ? 'Edit Data Siswa' : 'Tambah Siswa Baru'); ?>

            </h1>
            <p class="mt-1 text-sm text-slate-600">
                <?php echo e(isset($student) ? 'Ubah informasi data siswa di bawah ini' : 'Isi formulir untuk menambahkan siswa baru ke sistem'); ?>

            </p>
        </div>

        <!-- Card Body - Form -->
        <form
            method="POST"
            action="<?php echo e(isset($student) ? route('admin.students.update', $student) : route('admin.students.store')); ?>"
            class="space-y-5 p-6"
        >
            <?php echo csrf_field(); ?>
            <?php if(isset($student)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <!-- 1. Data Akun Siswa -->
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-900">
                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo e(old('name', $student->user->name ?? '')); ?>"
                    placeholder="Contoh: ABDUL AZIZ"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['name'];
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

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-900">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo e(old('email', $student->user->email ?? '')); ?>"
                    placeholder="siswa@smpn13.sch.id"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['email'];
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

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-900">
                    Password <?php echo e(isset($student) ? '(Biarkan kosong jika tidak diubah)' : '*'); ?>

                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Min. 8 Karakter"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    <?php echo e(isset($student) ? '' : 'required'); ?>

                >
                <?php $__errorArgs = ['password'];
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

            <!-- 2. NIS -->
            <div>
                <label for="nis" class="mb-2 block text-sm font-semibold text-slate-900">
                    NIS <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="nis"
                    name="nis"
                    value="<?php echo e(old('nis', $student->nis ?? '')); ?>"
                    placeholder="Contoh: 20240001"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['nis'];
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

            <!-- 3. Tingkat -->
            <div>
                <label for="grade_level" class="mb-2 block text-sm font-semibold text-slate-900">
                    Tingkat <span class="text-red-500">*</span>
                </label>
                <select
                    id="grade_level"
                    name="grade_level"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['grade_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                    <option value="">-- Pilih Tingkat --</option>
                    <?php $__currentLoopData = ['7' => 'VII (Tujuh)', '8' => 'VIII (Delapan)', '9' => 'IX (Sembilan)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($value); ?>"
                            <?php if(old('grade_level') === $value || (isset($student) && $student->grade_level === $value)): ?> selected <?php endif; ?>
                        >
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['grade_level'];
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

            <!-- 4. Kelas -->
            <div>
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-900">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['academic_class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                    <option value="">-- Pilih Kelas --</option>
                    <?php $__currentLoopData = $classes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($class->id); ?>"
                            <?php if(old('academic_class_id') === $class->id || (isset($student) && $student->academic_class_id === $class->id)): ?> selected <?php endif; ?>
                        >
                            <?php echo e($class->name); ?>

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

            <!-- 5. Jenis Kelamin -->
            <div>
                <label for="gender" class="mb-2 block text-sm font-semibold text-slate-900">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select
                    id="gender"
                    name="gender"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <?php $__currentLoopData = ['male' => 'Laki-laki', 'female' => 'Perempuan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($value); ?>"
                            <?php if(old('gender') === $value || (isset($student) && $student->gender === $value)): ?> selected <?php endif; ?>
                        >
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['gender'];
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

            <!-- 6. Tempat Lahir -->
            <div>
                <label for="birthplace" class="mb-2 block text-sm font-semibold text-slate-900">
                    Tempat Lahir <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="birthplace"
                    name="birthplace"
                    value="<?php echo e(old('birthplace', $student->birthplace ?? '')); ?>"
                    placeholder="Contoh: Jakarta"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['birthplace'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['birthplace'];
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

            <!-- 7. Tanggal Lahir -->
            <div>
                <label for="birthdate" class="mb-2 block text-sm font-semibold text-slate-900">
                    Tanggal Lahir <span class="text-red-500">*</span>
                </label>
                <input
                    type="date"
                    id="birthdate"
                    name="birthdate"
                    value="<?php echo e(old('birthdate', isset($student) && $student->birthdate ? $student->birthdate->format('Y-m-d') : '')); ?>"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['birthdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['birthdate'];
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

            <!-- 8. Alamat -->
            <div>
                <label for="address" class="mb-2 block text-sm font-semibold text-slate-900">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    placeholder="Masukkan alamat lengkap siswa..."
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                ><?php echo e(old('address', $student->address ?? '')); ?></textarea>
                <?php $__errorArgs = ['address'];
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

            <!-- Action Buttons -->
            <div class="flex gap-3 border-t border-slate-200 pt-6">
                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
                >
                    <?php echo e(isset($student) ? 'Simpan Perubahan' : 'Tambah Siswa'); ?>

                </button>
                <a
                    href="<?php echo e(route('admin.students.index')); ?>"
                    class="flex-1 rounded-xl border-2 border-slate-200 px-6 py-3 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/students/create.blade.php ENDPATH**/ ?>