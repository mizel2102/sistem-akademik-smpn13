<?php $__env->startSection('title', 'Masuk - SMPN 13 Kota'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full max-w-3xl overflow-hidden rounded-2xl shadow-2xl">
            <div class="flex min-h-[500px]">

                <!-- Left Panel (Desktop only) -->
                <div class="relative hidden flex-[1.4] bg-navy p-12 text-white lg:flex lg:flex-col lg:justify-between">
                    <!-- Decorative Circles -->
                    <div class="absolute top-10 right-10 h-32 w-32 rounded-full bg-gold/10"></div>
                    <div class="absolute bottom-20 left-10 h-40 w-40 rounded-full bg-white/5"></div>
                    <div class="absolute right-1/4 top-1/2 h-48 w-48 rounded-full bg-gold/5"></div>

                    <!-- Content -->
                    <div class="relative z-10 space-y-6">
                        <!-- Logo Circle -->
                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gold text-center">
                            <span class="text-3xl font-extrabold text-navy">13</span>
                        </div>

                        <!-- School Name -->
                        <div>
                            <h1 class="mb-2 text-3xl font-extrabold text-white">SMPN 13 Kota</h1>
                            <p class="text-sm text-white/60">Sistem Informasi Akademik</p>
                        </div>

                        <!-- Gold Divider -->
                        <div class="h-1 w-12 rounded-full bg-gold"></div>

                        <!-- Description -->
                        <p class="text-sm leading-relaxed text-white/50">
                            Platform manajemen akademik terpadu untuk siswa, guru, dan orang tua dalam memantau perkembangan pendidikan dengan lebih efisien dan transparan.
                        </p>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="flex flex-1 flex-col justify-center bg-white px-8 py-12 sm:px-10">
                    <!-- Mobile Logo (visible on mobile) -->
                    <div class="mb-8 flex lg:hidden flex-col items-center space-y-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gold">
                            <span class="text-2xl font-extrabold text-navy">13</span>
                        </div>
                        <div class="text-center">
                            <h2 class="text-2xl font-extrabold text-navy">SMPN 13 Kota</h2>
                            <p class="text-xs text-slate-500">Sistem Informasi Akademik</p>
                        </div>
                    </div>

                    <!-- Form Container -->
                    <div class="space-y-6">
                        <!-- Heading -->
                        <div>
                            <h2 class="mb-2 text-2xl font-extrabold text-navy">Selamat Datang</h2>
                            <p class="text-slate-500">Masuk ke akun Anda untuk melanjutkan</p>
                        </div>

                        <!-- Login Form -->
                        <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-4">
                            <?php echo csrf_field(); ?>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email / NIP / NISN</label>
                                <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    value="<?php echo e(old('email')); ?>"
                                    required
                                    autofocus
                                    placeholder="Masukkan Email, NIP, atau NISN"
                                    class="w-full rounded-xl border-2 <?php echo e($errors->has('email') ? 'border-red-500' : 'border-slate-200'); ?> bg-slate-50 px-4 py-3 transition focus:border-navy focus:bg-white focus:outline-none"
                                >
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm font-medium text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Password Field with Show/Hide -->
                            <div x-data="{ showPassword: false }">
                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Kata Sandi</label>
                                <div class="relative">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        id="password"
                                        name="password"
                                        required
                                        placeholder="••••••••"
                                        class="w-full rounded-xl border-2 <?php echo e($errors->has('password') ? 'border-red-500' : 'border-slate-200'); ?> bg-slate-50 px-4 py-3 pr-12 transition focus:border-navy focus:bg-white focus:outline-none"
                                    >
                                    <button
                                        @click="showPassword = !showPassword"
                                        type="button"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                                    >
                                        <svg v-if="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <svg v-else class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm font-medium text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2">
                                    <input
                                        type="checkbox"
                                        name="remember"
                                        <?php echo e(old('remember') ? 'checked' : ''); ?>

                                        class="h-4 w-4 rounded border-slate-300 bg-slate-50 text-navy focus:ring-navy"
                                    >
                                    <span class="text-sm font-medium text-slate-700">Ingat saya</span>
                                </label>
                                <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-semibold text-navy hover:text-gold transition">
                                    Lupa kata sandi?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full rounded-xl bg-navy py-3 font-bold text-white shadow-lg transition hover:bg-opacity-90 focus:outline-none focus:ring-4 focus:ring-navy/20"
                            >
                                Masuk
                            </button>
                        </form>

                        <!-- Register Link -->
                        <?php if(Route::has('register')): ?>
                            <p class="text-center text-sm text-slate-600">
                                Belum punya akun?
                                <a href="<?php echo e(route('register')); ?>" class="font-bold text-navy hover:text-gold transition">
                                    Daftar di sini
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/auth/login.blade.php ENDPATH**/ ?>