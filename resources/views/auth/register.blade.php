@extends('layouts.auth')

@section('title', 'Daftar - SMPN 13 Kota')

@section('content')
<div class="w-full max-w-3xl overflow-hidden rounded-2xl shadow-2xl">
            <div class="flex min-h-screen lg:min-h-[500px]">

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
                    <div class="space-y-6 overflow-y-auto max-h-[calc(100vh-200px)] lg:max-h-none">
                        <!-- Heading -->
                        <div>
                            <h2 class="mb-2 text-2xl font-extrabold text-navy">Daftar Akun</h2>
                            <p class="text-slate-500">Buat akun baru untuk akses ke portal akademik</p>
                        </div>

                        <!-- Register Form -->
                        <form action="{{ route('register') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Nama Lengkap Field -->
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    placeholder="Nama lengkap Anda"
                                    class="w-full rounded-xl border-2 {{ $errors->has('name') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 transition focus:border-navy focus:bg-white focus:outline-none"
                                >
                                @error('name')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="nama@example.com"
                                    class="w-full rounded-xl border-2 {{ $errors->has('email') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 transition focus:border-navy focus:bg-white focus:outline-none"
                                >
                                @error('email')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
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
                                        class="w-full rounded-xl border-2 {{ $errors->has('password') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 pr-12 transition focus:border-navy focus:bg-white focus:outline-none"
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
                                @error('password')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password Field -->
                            <div x-data="{ showPasswordConfirm: false }">
                                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input
                                        :type="showPasswordConfirm ? 'text' : 'password'"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        required
                                        placeholder="••••••••"
                                        class="w-full rounded-xl border-2 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 pr-12 transition focus:border-navy focus:bg-white focus:outline-none"
                                    >
                                    <button
                                        @click="showPasswordConfirm = !showPasswordConfirm"
                                        type="button"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                                    >
                                        <svg v-if="!showPasswordConfirm" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <svg v-else class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full rounded-xl bg-navy py-3 font-bold text-white shadow-lg transition hover:bg-opacity-90 focus:outline-none focus:ring-4 focus:ring-navy/20"
                            >
                                Daftar Sekarang
                            </button>
                        </form>

                        <!-- Login Link -->
                        <p class="text-center text-sm text-slate-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-bold text-navy hover:text-gold transition">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
</div>
@endsection
