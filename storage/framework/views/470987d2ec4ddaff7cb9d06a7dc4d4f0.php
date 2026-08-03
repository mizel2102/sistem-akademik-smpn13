<?php $__env->startSection('page-title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-xl py-10">
    <div class="rounded-2xl bg-white p-8 shadow-lg shadow-slate-200/30">
        <h1 class="text-2xl font-extrabold text-slate-900">Pengaturan</h1>
        <p class="mt-2 text-sm text-slate-600">Sesuaikan tampilan, notifikasi, dan keamanan akun Anda.</p>

        <form action="<?php echo e(route('settings.update')); ?>" method="POST" class="mt-8 space-y-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <section class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h2 class="text-lg font-semibold text-slate-900">Tampilan</h2>

                <div class="space-y-4">
                    <div>
                        <label for="locale" class="mb-2 block text-sm font-medium text-slate-700">Bahasa</label>
                        <select id="locale" name="locale" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
                            <option value="id" <?php echo e(old('locale', $settings['locale'] ?? 'id') === 'id' ? 'selected' : ''); ?>>Bahasa Indonesia</option>
                            <option value="en" <?php echo e(old('locale', $settings['locale'] ?? 'id') === 'en' ? 'selected' : ''); ?>>English</option>
                        </select>
                    </div>

                    <div>
                        <label for="timezone" class="mb-2 block text-sm font-medium text-slate-700">Zona Waktu</label>
                        <select id="timezone" name="timezone" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
                            <option value="Asia/Jakarta" <?php echo e(old('timezone', $settings['timezone'] ?? 'Asia/Jakarta') === 'Asia/Jakarta' ? 'selected' : ''); ?>>Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar" <?php echo e(old('timezone', $settings['timezone'] ?? 'Asia/Jakarta') === 'Asia/Makassar' ? 'selected' : ''); ?>>Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura" <?php echo e(old('timezone', $settings['timezone'] ?? 'Asia/Jakarta') === 'Asia/Jayapura' ? 'selected' : ''); ?>>Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h2 class="text-lg font-semibold text-slate-900">Notifikasi</h2>

                <div x-data="{ on: <?php echo e(($settings['email_notifications'] ?? true) ? 'true' : 'false'); ?> }" class="space-y-5">
                    <div class="flex items-center justify-between rounded-3xl bg-white p-4 shadow-sm">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Notifikasi Email</p>
                            <p class="text-sm text-slate-500">Terima pemberitahuan melalui email.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="hidden" name="email_notifications" :value="on ? 1 : 0">
                            <button type="button" @click="on = !on" class="relative inline-flex h-10 w-16 items-center rounded-full transition-colors" :class="on ? 'bg-navy' : 'bg-slate-300'">
                                <span class="inline-block h-8 w-8 transform rounded-full bg-white shadow transition-transform" :class="on ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-3xl bg-white p-4 shadow-sm">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Notifikasi Browser</p>
                            <p class="text-sm text-slate-500">Terima notifikasi melalui browser Anda.</p>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" name="browser_notifications" class="peer sr-only" value="1" <?php echo e(old('browser_notifications', $settings['browser_notifications'] ?? false) ? 'checked' : ''); ?>>
                            <div class="h-10 w-16 rounded-full bg-slate-300 transition-all duration-300 peer-checked:bg-navy"></div>
                            <span class="pointer-events-none absolute left-1 top-1 inline-block h-8 w-8 rounded-full bg-white shadow transition-transform duration-300 peer-checked:translate-x-6"></span>
                        </label>
                    </div>
                </div>
            </section>

            <section class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h2 class="text-lg font-semibold text-slate-900">Keamanan</h2>
                <a href="<?php echo e(route('profile.show')); ?>#password" class="text-navy font-semibold transition hover:underline">Ganti Password</a>
            </section>

            <button type="submit" class="w-full rounded-xl bg-navy py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Pengaturan</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/settings/index.blade.php ENDPATH**/ ?>