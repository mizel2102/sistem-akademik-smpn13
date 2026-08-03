<?php $__env->startSection('page-title', 'Kelas Saya'); ?>
<?php $__env->startSection('breadcrumb', 'Guru › Kelas Saya'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ createModal: false, editModal: false, editClassData: { id: null, name: '', room: '', schedule: '' } }" class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Kelas Saya</h1>
            <p class="mt-1 text-slate-600">Kelola kelas, lihat daftar siswa, dan atur token akses kelas.</p>
        </div>
        <button
            @click="createModal = true"
            type="button"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-navy px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-opacity-90"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kelas Baru
        </button>
    </div>

    <!-- Grid Kelas -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $classes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div x-data="{ openStudents: false }" class="flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                <div class="p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-navy/10 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="flex items-center gap-1">
                            <button
                                @click="editClassData = { id: <?php echo e($class->id); ?>, name: '<?php echo e(addslashes($class->name)); ?>', room: '<?php echo e(addslashes($class->room ?? '')); ?>', schedule: '<?php echo e(addslashes($class->schedule ?? '')); ?>' }; editModal = true"
                                type="button"
                                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-navy"
                                title="Edit Kelas"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="<?php echo e(route('teacher.classes.destroy', $class->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas \'<?php echo e(addslashes($class->name)); ?>\'?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button
                                    type="submit"
                                    class="rounded-lg p-2 text-slate-500 hover:bg-red-50 hover:text-red-600"
                                    title="Hapus Kelas"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-navy"><?php echo e($class->name); ?></h2>
                    <p class="mt-1 text-sm text-slate-500">Ruang: <span class="font-semibold text-slate-700"><?php echo e($class->room ?? '-'); ?></span></p>
                    <p class="mt-0.5 text-sm text-slate-500">Jadwal: <span class="font-semibold text-slate-700"><?php echo e($class->schedule ?? '-'); ?></span></p>
                    
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-700">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-navy">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V8H2v12h5m10 0V10a3 3 0 0 0-6 0v10m6 0H7" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium"><?php echo e($class->students->count()); ?> siswa</span>
                        </div>
                        <button
                            @click="openStudents = !openStudents"
                            type="button"
                            class="text-xs font-semibold text-blue-600 hover:underline"
                        >
                            <span x-text="openStudents ? 'Sembunyikan Siswa' : 'Daftar Siswa'"></span>
                        </button>
                    </div>

                    <!-- Token Akses Kelas -->
                    <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50/60 p-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Token Akses Kelas</span>
                                <p class="text-lg font-mono font-extrabold text-blue-900"><?php echo e($class->access_token ?? 'N/A'); ?></p>
                            </div>
                            <div class="flex items-center gap-1">
                                <button
                                    type="button"
                                    onclick="navigator.clipboard.writeText('<?php echo e($class->access_token); ?>'); alert('Token <?php echo e($class->access_token); ?> berhasil disalin!');"
                                    class="rounded-lg bg-white px-2.5 py-1.5 text-xs font-semibold text-blue-700 shadow-sm border border-blue-200 hover:bg-blue-50 transition"
                                    title="Salin Token"
                                >
                                    Salin
                                </button>
                                <form action="<?php echo e(route('teacher.classes.regenerate-token', $class->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui kode token kelas ini? Token lama tidak akan berlaku lagi.');">
                                    <?php echo csrf_field(); ?>
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-600 shadow-sm border border-slate-200 hover:bg-slate-100 transition"
                                        title="Reset Token"
                                    >
                                        Reset
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="openStudents" x-cloak class="border-t border-slate-200 bg-slate-50 p-6">
                    <h3 class="mb-3 text-sm font-semibold text-slate-800">Daftar Siswa Terdaftar</h3>
                    <ul class="space-y-3 max-h-60 overflow-y-auto">
                        <?php $__empty_2 = true; $__currentLoopData = $class->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <li class="flex items-center gap-3 rounded-xl bg-white px-4 py-3 shadow-sm border border-slate-100">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-navy text-xs font-semibold text-white">
                                    <?php echo e(strtoupper(substr($student->user->name ?? "?", 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 text-sm"><?php echo e($student->user->name ?? '-'); ?></p>
                                    <p class="text-xs text-slate-500">NIS: <?php echo e($student->student_number ?? $student->nis ?? '-'); ?></p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <li class="rounded-xl bg-white px-4 py-6 text-center text-sm text-slate-500 shadow-sm">
                                Belum ada siswa di kelas ini. Bagikan token di atas kepada siswa.
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                    <a
                        href="<?php echo e(route('teacher.grades.index', ['class' => $class->id])); ?>"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-navy px-4 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk Kelas & Input Nilai
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Belum Ada Kelas</h3>
                <p class="mt-1 text-sm text-slate-500">Klik tombol Tambah Kelas Baru di atas untuk membuat kelas pertama Anda.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Tambah Kelas -->
    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="createModal = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xl font-bold text-navy">Tambah Kelas Baru</h3>
                <button @click="createModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="<?php echo e(route('teacher.classes.store')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-semibold text-slate-800">Nama Kelas</label>
                    <input type="text" name="name" placeholder="Contoh: 7A atau PJOK Kelas 7" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800">Ruang</label>
                    <input type="text" name="room" placeholder="Contoh: Ruang A1" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800">Jadwal</label>
                    <input type="text" name="schedule" placeholder="Contoh: Senin, 08:00 - 09:30" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20" required />
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="createModal = false" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-navy px-5 py-2.5 text-sm font-semibold text-white hover:bg-opacity-90">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kelas -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="editModal = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xl font-bold text-navy">Edit Data Kelas</h3>
                <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form :action="'<?php echo e(url('teacher/classes')); ?>/' + editClassData.id" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-sm font-semibold text-slate-800">Nama Kelas</label>
                    <input type="text" name="name" x-model="editClassData.name" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800">Ruang</label>
                    <input type="text" name="room" x-model="editClassData.room" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800">Jadwal</label>
                    <input type="text" name="schedule" x-model="editClassData.schedule" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20" required />
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="editModal = false" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-navy px-5 py-2.5 text-sm font-semibold text-white hover:bg-opacity-90">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/teacher/classes.blade.php ENDPATH**/ ?>