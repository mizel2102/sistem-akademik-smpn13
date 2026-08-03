@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi - SMPN 13 Kota')

@section('content')
<div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl sm:p-10">

            <!-- Back Link -->
            <a href="{{ route('login') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-navy hover:text-gold transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Login
            </a>

            <!-- Lock Icon -->
            <div class="mb-6 flex justify-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                    <svg class="h-8 w-8 text-navy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
            </div>

            <!-- Heading -->
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-2xl font-extrabold text-navy">Lupa Kata Sandi?</h1>
                <p class="text-sm text-slate-600">
                    Masukkan email terdaftar Anda. Kami akan mengirim tautan untuk mengatur ulang kata sandi.
                </p>
            </div>

            <!-- Status Message -->
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                    <svg class="h-5 w-5 flex-shrink-0 text-green-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="nama@example.com"
                        class="w-full rounded-xl border-2 {{ $errors->has('email') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 transition focus:border-navy focus:bg-white focus:outline-none"
                    >
                    @error('email')
                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full rounded-xl bg-navy py-3 font-bold text-white shadow-lg transition hover:bg-opacity-90 focus:outline-none focus:ring-4 focus:ring-navy/20"
                >
                    Kirim Link Reset
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-3">
                <div class="flex-1 border-t border-slate-200"></div>
                <span class="text-xs text-slate-500">atau</span>
                <div class="flex-1 border-t border-slate-200"></div>
            </div>

            <!-- Login Link -->
            <p class="text-center text-sm text-slate-600">
                Ingat passwordmu?
                <a href="{{ route('login') }}" class="font-bold text-navy hover:text-gold transition">
                    Masuk di sini
                </a>
            </p>
</div>
@endsection
