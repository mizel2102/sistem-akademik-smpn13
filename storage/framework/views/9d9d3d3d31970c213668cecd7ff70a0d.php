<?php $__env->startSection('page-title', 'Pengumuman'); ?>
<?php $__env->startSection('breadcrumb', 'Admin › Pengumuman'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-navy">Pengumuman</h1>
            <p class="mt-1 text-slate-600">Kelola pengumuman sekolah untuk guru dan siswa</p>
        </div>
    </div>

    <!-- Create Announcement Form (Collapsible) -->
    <div x-data="{ formOpen: false }">
        <button
            @click="formOpen = !formOpen"
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
        >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Buat Pengumuman
        </button>

        <!-- Form Card -->
        <div x-show="formOpen" class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-bold text-navy">Buat Pengumuman Baru</h3>
            <form method="POST" action="<?php echo e(route('admin.announcements.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <!-- Judul -->
                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-900">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="<?php echo e(old('title')); ?>"
                        placeholder="Masukkan judul pengumuman..."
                        class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    >
                    <?php $__errorArgs = ['title'];
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

                <!-- Konten -->
                <div>
                    <label for="content" class="mb-2 block text-sm font-semibold text-slate-900">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="5"
                        placeholder="Tulis konten pengumuman di sini..."
                        class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    ><?php echo e(old('content')); ?></textarea>
                    <?php $__errorArgs = ['content'];
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

                <!-- Audience (Radio Buttons) -->
                <div>
                    <label class="mb-3 block text-sm font-semibold text-slate-900">
                        Audience <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="radio"
                                name="audience"
                                value="all"
                                <?php echo e(old('audience') === 'all' ? 'checked' : ''); ?>

                                class="h-4 w-4 border-slate-300 text-navy focus:ring-navy"
                                required
                            >
                            <span class="text-sm text-slate-700">Semua (Guru & Siswa)</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="radio"
                                name="audience"
                                value="teacher"
                                <?php echo e(old('audience') === 'teacher' ? 'checked' : ''); ?>

                                class="h-4 w-4 border-slate-300 text-navy focus:ring-navy"
                            >
                            <span class="text-sm text-slate-700">Guru</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="radio"
                                name="audience"
                                value="student"
                                <?php echo e(old('audience') === 'student' ? 'checked' : ''); ?>

                                class="h-4 w-4 border-slate-300 text-navy focus:ring-navy"
                            >
                            <span class="text-sm text-slate-700">Siswa</span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['audience'];
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

                <!-- Tanggal Terbit -->
                <div>
                    <label for="published_at" class="mb-2 block text-sm font-semibold text-slate-900">
                        Tanggal Terbit <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="published_at"
                        name="published_at"
                        value="<?php echo e(old('published_at')); ?>"
                        class="w-full rounded-xl border-2 border-slate-200 px-4 py-2.5 text-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    >
                    <?php $__errorArgs = ['published_at'];
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

                <!-- Form Actions -->
                <div class="flex gap-3 border-t border-slate-200 pt-4">
                    <button
                        type="submit"
                        class="rounded-xl bg-navy px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-opacity-90"
                    >
                        Simpan Pengumuman
                    </button>
                    <button
                        @click="formOpen = false"
                        type="button"
                        class="rounded-xl border-2 border-slate-200 px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="space-y-3 rounded-2xl bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-bold text-navy">Daftar Pengumuman</h3>

        <?php $__empty_1 = true; $__currentLoopData = $announcements ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div
                <?php if($announcement->audience === 'all'): ?>
                    class="flex items-start gap-4 border-l-4 border-l-navy bg-slate-50 p-4 rounded-lg transition hover:shadow-md"
                <?php elseif($announcement->audience === 'teacher'): ?>
                    class="flex items-start gap-4 border-l-4 border-l-amber-500 bg-slate-50 p-4 rounded-lg transition hover:shadow-md"
                <?php elseif($announcement->audience === 'student'): ?>
                    class="flex items-start gap-4 border-l-4 border-l-green-500 bg-slate-50 p-4 rounded-lg transition hover:shadow-md"
                <?php else: ?>
                    class="flex items-start gap-4 border-l-4 border-l-slate-300 bg-slate-50 p-4 rounded-lg transition hover:shadow-md"
                <?php endif; ?>
            >
                <!-- Left Dot (Colored by Audience) -->
                <div class="flex-shrink-0 pt-1">
                    <?php if($announcement->audience === 'all'): ?>
                        <div class="h-3 w-3 rounded-full bg-navy"></div>
                    <?php elseif($announcement->audience === 'teacher'): ?>
                        <div class="h-3 w-3 rounded-full bg-amber-500"></div>
                    <?php elseif($announcement->audience === 'student'): ?>
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                    <?php else: ?>
                        <div class="h-3 w-3 rounded-full bg-slate-300"></div>
                    <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="mb-2 flex items-center gap-2 flex-wrap">
                        <h4 class="font-semibold text-slate-900"><?php echo e($announcement->title); ?></h4>
                        <!-- Audience Badge -->
                        <?php if($announcement->audience === 'all'): ?>
                            <span class="inline-block rounded-full bg-navy/10 px-3 py-1 text-xs font-medium text-navy">
                                Semua
                            </span>
                        <?php elseif($announcement->audience === 'teacher'): ?>
                            <span class="inline-block rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                                Guru
                            </span>
                        <?php elseif($announcement->audience === 'student'): ?>
                            <span class="inline-block rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                Siswa
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="mb-2 text-sm text-slate-600 line-clamp-2"><?php echo e($announcement->content); ?></p>
                    <p class="text-xs text-slate-500">
                        Dipublikasikan: <?php echo e($announcement->published_at ? $announcement->published_at->format('d M Y H:i') : '-'); ?>

                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-shrink-0 gap-2">
                    <!-- Edit Button -->
                    <a href="<?php echo e(route('admin.announcements.edit', $announcement)); ?>" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-200 hover:text-gold" title="Edit">
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
                            <p class="mb-6 text-center text-sm text-slate-600">Pengumuman <strong><?php echo e($announcement->title); ?></strong> akan dihapus permanen.</p>
                            <div class="flex gap-3">
                                <button @click="open = false" class="flex-1 rounded-lg border border-slate-200 px-4 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                                    Batal
                                </button>
                                <form method="POST" action="<?php echo e(route('admin.announcements.destroy', $announcement)); ?>" class="flex-1">
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
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State -->
            <div class="flex flex-col items-center gap-3 py-12 text-center">
                <svg class="h-12 w-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <div>
                    <p class="font-medium text-slate-900">Belum ada pengumuman</p>
                    <p class="text-sm text-slate-600">Buat pengumuman baru untuk mulai berkomunikasi dengan guru dan siswa</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination (if applicable) -->
    <?php if($announcements && method_exists($announcements, 'links')): ?>
        <div class="flex items-center justify-between pt-4">
            <p class="text-sm text-slate-600">
                Menampilkan <strong><?php echo e(($announcements->currentPage() - 1) * $announcements->perPage() + 1); ?></strong>–<strong><?php echo e(min($announcements->currentPage() * $announcements->perPage(), $announcements->total())); ?></strong> dari <strong><?php echo e($announcements->total()); ?></strong> pengumuman
            </p>
            <div>
                <?php echo e($announcements->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/announcements.blade.php ENDPATH**/ ?>