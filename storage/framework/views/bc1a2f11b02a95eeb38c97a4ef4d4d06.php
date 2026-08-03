<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-7xl space-y-6 py-10">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Mata Pelajaran</h1>
            <p class="mt-1 text-slate-600">Kelola daftar mata pelajaran dan guru pengampu.</p>
        </div>
        <button
            @click.prevent="open = !open"
            class="inline-flex items-center justify-center rounded-2xl bg-gold px-5 py-3 text-sm font-semibold text-navy shadow-lg shadow-gold/20 transition hover:brightness-95"
        >
            + Tambah Mata Pelajaran
        </button>
    </div>

    <div x-data="{ open: false }" class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Buat Mata Pelajaran Baru</h2>
                    <p class="mt-1 text-sm text-slate-500">Tambahkan mata pelajaran beserta guru pengampunya.</p>
                </div>
                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                >
                    <span x-text="open ? 'Tutup' : '+ Tambah Mata Pelajaran'"></span>
                </button>
            </div>

            <form
                action="<?php echo e(route('admin.subjects.store')); ?>"
                method="POST"
                x-show="open"
                x-cloak
                class="mt-6 space-y-5"
            >
                <?php echo csrf_field(); ?>

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Mapel</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="<?php echo e(old('name')); ?>"
                        placeholder="Nama mapel"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    />
                    <?php $__errorArgs = ['name'];
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
                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">Kode Mapel</label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        value="<?php echo e(old('code')); ?>"
                        placeholder="MTK, BIN, IPA"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    />
                    <?php $__errorArgs = ['code'];
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
                    <label for="teacher_id" class="mb-2 block text-sm font-semibold text-slate-700">Guru Pengampu</label>
                    <select
                        id="teacher_id"
                        name="teacher_id"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 <?php $__errorArgs = ['teacher_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-400 focus:ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    >
                        <option value="">— Pilih guru pengampu —</option>
                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($teacher->id); ?>" <?php echo e(old('teacher_id') == $teacher->id ? 'selected' : ''); ?>>
                                <?php echo e($teacher->user?->name ?? 'Guru tanpa nama'); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['teacher_id'];
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

                <div class="pt-1">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gold px-5 py-3 text-sm font-semibold text-navy shadow-sm transition hover:brightness-95">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Mata Pelajaran</h2>
                <p class="mt-1 text-sm text-slate-500">Semua mata pelajaran aktif dan guru pengampu ditampilkan di bawah.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        <tr>
                            <th class="px-4 py-4">No</th>
                            <th class="px-4 py-4">Kode</th>
                            <th class="px-4 py-4">Nama Mapel</th>
                            <th class="px-4 py-4">Guru Pengampu</th>
                            <th class="px-4 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                        <?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-4 py-4"><?php echo e($loop->iteration); ?></td>
                                <td class="px-4 py-4">
                                    <code class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700"><?php echo e($subject->code ?? '-'); ?></code>
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-900"><?php echo e($subject->name); ?></td>
                                <td class="px-4 py-4 text-slate-600"><?php echo e($subject->teacher?->user?->name ?? '-'); ?></td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="<?php echo e(route('admin.subjects.edit', $subject)); ?>" class="rounded-full bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">Edit</a>
                                        <form action="<?php echo e(route('admin.subjects.destroy', $subject)); ?>" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="rounded-full bg-red-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada mata pelajaran.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/subjects.blade.php ENDPATH**/ ?>