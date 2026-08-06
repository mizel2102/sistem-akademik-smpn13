<?php $__env->startSection('page-title', 'Data Siswa'); ?>
<?php $__env->startSection('breadcrumb', 'Admin › Data Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Data Siswa</h1>
            <p class="mt-1 text-slate-600">Kelola data siswa sekolah</p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('admin.students.export')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700 transition">
                Export Excel
            </a>
            <div x-data="{ modalOpen: false }">
                <button @click="modalOpen = true" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                    Import Excel
                </button>

                <!-- Import Modal -->
                <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="modalOpen = false">
                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl mx-4">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900">Import Data Siswa</h3>
                            <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>
                        <form action="<?php echo e(route('admin.students.import')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File Excel (.xlsx, .xls)</label>
                                <input type="file" name="file" required accept=".xlsx,.xls" class="w-full rounded-lg border border-slate-200 p-2 text-sm">
                            </div>
                            <div class="flex gap-3">
                                <button type="button" @click="modalOpen = false" class="flex-1 rounded-lg border border-slate-200 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">Batal</button>
                                <button type="submit" class="flex-1 rounded-lg bg-navy py-2.5 font-medium text-white transition hover:bg-opacity-90">Upload & Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('admin.students.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-navy px-4 py-2 text-sm font-semibold text-white shadow hover:bg-opacity-90 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" class="rounded-2xl bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Cari</label>
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="<?php echo e(request('search')); ?>"
                        placeholder="Cari nama atau NIS..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-12 pr-4 text-sm transition focus:border-navy focus:bg-white focus:outline-none"
                    >
                </div>
            </div>

            <!-- Class Filter -->
            <div class="lg:w-48">
                <label for="class" class="mb-2 block text-sm font-medium text-slate-700">Kelas</label>
                <select
                    id="class"
                    name="class"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm transition focus:border-navy focus:bg-white focus:outline-none"
                >
                    <option value="">Semua Kelas</option>
                    <?php $__currentLoopData = $classes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($class->id); ?>" <?php echo e(request('class') == $class->id ? 'selected' : ''); ?>>
                            <?php echo e($class->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Filter Submit Button -->
            <button type="submit" class="rounded-lg bg-navy px-6 py-2.5 font-medium text-white transition hover:bg-opacity-90">
                Saring
            </button>

            <!-- Reset Link -->
            <?php if(request()->hasAny(['search', 'class'])): ?>
                <a href="<?php echo e(route('admin.students.index')); ?>" class="rounded-lg border border-slate-200 px-6 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                    Reset
                </a>
            <?php endif; ?>

            <!-- Export PDF Button -->
            <a href="#" class="rounded-lg border-2 border-navy px-6 py-2.5 font-medium text-navy transition hover:bg-navy/5 lg:ml-auto">
                Ekspor PDF
            </a>
        </div>
    </form>

    <!-- Data Table -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <!-- Table Header -->
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">NIS</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tingkat</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $students ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="<?php echo e($i % 2 === 1 ? 'bg-slate-50' : ''); ?> border-t border-slate-200 transition hover:bg-slate-100">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                <?php echo e(($students->currentPage() - 1) * $students->perPage() + $i + 1); ?>

                            </td>

                            <!-- NIS -->
                            <td class="px-6 py-4 text-sm">
                                <code class="rounded bg-slate-100 px-2.5 py-1 font-mono text-xs font-medium text-slate-700">
                                    <?php echo e($student->nis ?? 'N/A'); ?>

                                </code>
                            </td>

                            <!-- Nama Siswa -->
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gold text-xs font-bold text-navy">
                                        <?php echo e(substr($student->user->name ?? '', 0, 2)); ?>

                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900"><?php echo e($student->user->name ?? '-'); ?></p>
                                        <p class="text-xs text-slate-500"><?php echo e($student->user->email ?? '-'); ?></p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                <?php echo e($student->academicClass->name ?? '-'); ?>

                            </td>

                            <!-- Jenis Kelamin -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                <?php if($student->gender === 'male'): ?>
                                    <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Laki-laki</span>
                                <?php elseif($student->gender === 'female'): ?>
                                    <span class="inline-block rounded-full bg-pink-100 px-3 py-1 text-xs font-medium text-pink-700">Perempuan</span>
                                <?php else: ?>
                                    <span class="text-slate-500">-</span>
                                <?php endif; ?>
                            </td>

                            <!-- Tingkat -->
                            <td class="px-6 py-4 text-sm text-slate-900">
                                <?php echo e($student->grade_level ?? '-'); ?>

                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Detail Button -->
                                    <a href="<?php echo e(route('admin.students.show', $student)); ?>" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-navy" title="Detail">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>

                                    <!-- View Report -->
                                    <a href="<?php echo e(route('admin.reports.rapor', $student)); ?>" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-blue-600" title="Lihat Rapor">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </a>

                                    <!-- Download Report PDF -->
                                    <a href="<?php echo e(route('admin.reports.rapor.pdf', $student)); ?>" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-green-600" title="Unduh PDF Rapor">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="<?php echo e(route('admin.students.edit', $student)); ?>" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-gold" title="Edit">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <button
                                        x-data="{ open: false }"
                                        @click="open = true"
                                        type="button"
                                        class="rounded-lg p-2 text-slate-600 transition hover:bg-red-100 hover:text-red-600"
                                        title="Hapus"
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div
                                        x-data="{ open: false }"
                                        x-show="open"
                                        @click.outside="open = false"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                                    >
                                        <div class="rounded-2xl bg-white p-6 shadow-2xl max-w-sm mx-4">
                                            <div class="mb-4 flex justify-center">
                                                <div class="rounded-full bg-red-100 p-3">
                                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <h3 class="mb-2 text-center text-lg font-bold text-slate-900">Yakin ingin menghapus?</h3>
                                            <p class="mb-6 text-center text-sm text-slate-600">Data siswa <strong><?php echo e($student->user->name ?? 'ini'); ?></strong> akan dihapus permanen.</p>
                                            <div class="flex gap-3">
                                                <button @click="open = false" class="flex-1 rounded-lg border border-slate-200 px-4 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                                                    Batal
                                                </button>
                                                <form method="POST" action="<?php echo e(route('admin.students.destroy', $student)); ?>" class="flex-1">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2.5 font-medium text-white transition hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M16 11a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-900">Belum ada data siswa</p>
                                        <p class="text-sm text-slate-600">Tambahkan siswa baru untuk memulai</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($students && $students->total() > 0): ?>
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-600">
                Menampilkan <strong><?php echo e(($students->currentPage() - 1) * $students->perPage() + 1); ?></strong>–<strong><?php echo e(min($students->currentPage() * $students->perPage(), $students->total())); ?></strong> dari <strong><?php echo e($students->total()); ?></strong> siswa
            </p>
            <div>
                <?php echo e($students->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/students.blade.php ENDPATH**/ ?>