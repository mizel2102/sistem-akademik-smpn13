<?php $__env->startSection('page-title', 'Data Kelas'); ?>
<?php $__env->startSection('breadcrumb', 'Admin › Data Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Data Kelas</h1>
            <p class="mt-1 text-slate-600">Kelola kelas dan informasi ruang belajar</p>
        </div>
        <a href="<?php echo e(route('admin.academic-classes.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg hover:bg-opacity-90 transition">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Kelas
        </a>
    </div>

    <!-- Class Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $classes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div x-data="{ showDeleteModal: false }" class="relative rounded-2xl bg-white p-5 shadow-sm transition hover:shadow-md border border-slate-100 flex flex-col justify-between">
                <div>
                    <!-- Top Section: Icon + Action Buttons -->
                    <div class="mb-4 flex items-start justify-between">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-navy/10">
                            <svg class="h-6 w-6 text-navy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1">
                            <!-- Edit Button -->
                            <a href="<?php echo e(route('admin.academic-classes.edit', $class)); ?>" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-navy" title="Edit Kelas">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <!-- Delete Button -->
                            <button
                                @click="showDeleteModal = true"
                                type="button"
                                class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                title="Hapus Kelas"
                            >
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                </svg>
                            </button>

                            <!-- Delete Modal -->
                            <div
                                x-show="showDeleteModal"
                                x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
                            >
                                <div @click.outside="showDeleteModal = false" class="rounded-2xl bg-white p-6 shadow-2xl max-w-sm w-full">
                                    <div class="mb-4 flex justify-center">
                                        <div class="rounded-full bg-red-100 p-3">
                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="mb-2 text-center text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                                    <p class="mb-6 text-center text-sm text-slate-600">Kelas <strong><?php echo e($class->name); ?></strong> akan dihapus secara permanen.</p>
                                    <div class="flex gap-3">
                                        <button type="button" @click="showDeleteModal = false" class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                                            Batal
                                        </button>
                                        <form method="POST" action="<?php echo e(route('admin.academic-classes.destroy', $class)); ?>" class="flex-1">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-2.5 font-semibold text-white transition hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Class Name -->
                    <h3 class="mb-2 text-lg font-bold text-navy"><?php echo e($class->name); ?></h3>

                    <!-- Room Info -->
                    <p class="mb-1 text-sm text-slate-600">
                        <span class="font-medium text-slate-700">Ruang:</span> <?php echo e($class->room ?? '-'); ?>

                    </p>

                    <!-- Wali Kelas -->
                    <p class="mb-4 text-sm text-slate-600">
                        <span class="font-medium text-slate-700">Wali Kelas:</span>
                        <?php echo e($class->teacher?->user?->name ?? 'Belum ada wali kelas'); ?>

                    </p>

                    <div class="mb-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Kapasitas: <?php echo e($class->capacity ?? 0); ?></span>
                        <?php
                            $statusMap = [
                                'active' => ['label' => 'Aktif', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
                                'inactive' => ['label' => 'Tidak Aktif', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
                                'archived' => ['label' => 'Arsip', 'bg' => 'bg-slate-100', 'text' => 'text-slate-600'],
                            ];
                            $status = $statusMap[$class->status] ?? ['label' => ucfirst($class->status ?? '-'), 'bg' => 'bg-slate-100', 'text' => 'text-slate-600'];
                        ?>
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($status['bg']); ?> <?php echo e($status['text']); ?>"><?php echo e($status['label']); ?></span>
                    </div>
                </div>

                <!-- Bottom Section: Student Count + Detail Link -->
                <div class="border-t border-slate-100 pt-3 flex items-center justify-between mt-2">
                    <span class="text-sm font-medium text-slate-600">
                        <?php echo e($class->students?->count() ?? 0); ?> siswa
                    </span>
                    <a href="<?php echo e(route('admin.academic-classes.show', $class)); ?>" class="inline-flex items-center gap-1 text-sm font-semibold text-navy transition hover:text-gold">
                        Detail
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State Card -->
            <div class="col-span-full rounded-2xl bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto mb-4 h-16 w-16 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
                <p class="mb-2 text-lg font-bold text-slate-900">Belum ada data kelas</p>
                <p class="text-slate-600">Tambahkan kelas baru untuk memulai manajemen kelas</p>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/academic-classes.blade.php ENDPATH**/ ?>