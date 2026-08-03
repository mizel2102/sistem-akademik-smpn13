@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-12">
    <div class="mx-auto max-w-md rounded-3xl bg-white p-8 shadow-2xl shadow-slate-200/40">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-extrabold text-slate-900">Atur Ulang Kata Sandi</h1>
            <p class="mt-2 text-sm text-slate-600">Masukkan email dan kata sandi baru untuk mengatur ulang akun Anda.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $request->email) }}"
                    {{ old('email', $request->email) ? 'readonly' : '' }}
                    required
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 {{ $errors->has('email') ? 'border-red-500' : '' }}"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password Baru</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20 {{ $errors->has('password') ? 'border-red-500' : '' }}"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
                >
            </div>

            <button type="submit" class="w-full rounded-xl bg-navy py-3 text-sm font-semibold text-white transition hover:bg-opacity-90">Atur Ulang Kata Sandi</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="font-semibold text-navy hover:text-gold">Kembali ke Login</a>
        </p>
    </div>
</div>
@endsection
