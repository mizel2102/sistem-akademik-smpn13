<?php $__env->startSection('page-title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $nameParts = preg_split('/\s+/', trim($user->name));
    $initials = collect($nameParts)->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->join('');
    $rawRole = strtolower($user->getRoleNames()->first() ?? 'user');
    $roleLabel = match ($rawRole) {
        'admin' => 'Admin',
        'guru' => 'Guru',
        'teacher' => 'Guru',
        'guru-bk' => 'Guru BK',
        'siswa' => 'Siswa',
        default => ucfirst($rawRole),
    };
    $roleClasses = match ($rawRole) {
        'admin' => 'bg-red-100 text-red-700',
        'teacher', 'guru', 'guru-bk' => 'bg-blue-100 text-blue-700',
        'siswa' => 'bg-emerald-100 text-emerald-700',
        default => 'bg-slate-100 text-slate-700',
    };
?>

<div class="mx-auto max-w-2xl space-y-6 py-8">
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
            <?php if($user->avatar_url): ?>
                <img src="<?php echo e($user->avatar_url); ?>" alt="<?php echo e($user->name); ?>" class="h-20 w-20 rounded-full object-cover ring-4 ring-navy/20">
            <?php else: ?>
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-navy text-3xl font-extrabold text-gold ring-4 ring-navy/20">
                    <?php echo e($initials ?: 'US'); ?>

                </div>
            <?php endif; ?>
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-900"><?php echo e($user->name); ?></h1>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide <?php echo e($roleClasses); ?>"><?php echo e($roleLabel); ?></span>
                </div>
                <p class="text-sm text-slate-500"><?php echo e($user->email); ?></p>
                <p class="text-sm text-slate-500">Bergabung sejak <?php echo e($user->created_at->format('d F Y')); ?></p>

                <?php if($user->student): ?>
                    <div class="space-y-1 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                        <p class="font-semibold text-slate-900">Data Siswa</p>
                        <p>NIS: <?php echo e($user->student->student_number ?? '-'); ?></p>
                        <p>Kelas: <?php echo e($user->student->academicClass?->name ?? '-'); ?></p>
                    </div>
                <?php elseif($user->teacher): ?>
                    <div class="space-y-1 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                        <p class="font-semibold text-slate-900">Data Guru</p>
                        <p>NIP: <?php echo e($user->teacher->nip ?? '-'); ?></p>
                        <p>Mapel: <?php echo e($user->teacher->subject?->name ?? '-'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Edit Profil</h2>
        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="avatar" class="mb-2 block text-sm font-medium text-slate-700">Foto Profil (Semua Pengguna)</label>
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/*"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 ring-red-100 focus:border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP (Maksimal 2MB).</p>
                <?php $__errorArgs = ['avatar'];
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
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="<?php echo e(old('name', $user->name)); ?>"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 ring-red-100 focus:border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
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
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="<?php echo e(old('email', $user->email)); ?>"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 ring-red-100 focus:border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                <?php $__errorArgs = ['email'];
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

            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm" id="password">
        <h2 class="text-lg font-semibold text-slate-900">Ganti Password</h2>
        <form action="<?php echo e(route('password.update')); ?>" method="POST" class="mt-6 space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="current_password" class="mb-2 block text-sm font-medium text-slate-700">Password Saat Ini</label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 ring-red-100 focus:border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                <?php $__errorArgs = ['current_password'];
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
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password Baru</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 ring-red-100 focus:border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                <?php $__errorArgs = ['password'];
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
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
                >
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-600">
                Ganti Password
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/profile/show.blade.php ENDPATH**/ ?>