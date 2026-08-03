@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-slate-500">Semua notifikasi terbaru untuk akun Anda.</p>
        </div>

        <form action="{{ route('notifications.markAllRead') }}" method="POST" class="inline-flex">
            @csrf
            @method('PUT')
            <button type="submit" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div class="rounded-2xl bg-white shadow-sm">
        @forelse($notifications as $notif)
            <div class="flex items-start gap-3 border-b border-slate-100 px-5 py-4 transition-colors {{ $notif->read_at ? '' : 'bg-amber-50/40 border-l-4 border-gold hover:bg-slate-50' }}">
                <div class="mt-1">
                    @if($notif->read_at)
                        <span class="inline-flex h-3 w-3 rounded-full border border-slate-400 bg-white"></span>
                    @else
                        <span class="inline-flex h-3 w-3 rounded-full bg-navy"></span>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm {{ $notif->read_at ? 'text-slate-700' : 'font-semibold text-slate-900' }}">{{ $notif->data['message'] ?? 'Notifikasi' }}</p>
                    <p class="mt-1 text-xs text-slate-400">{{ $notif->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                <svg class="mx-auto mb-4 h-10 w-10 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z" />
                </svg>
                <p class="text-sm font-semibold">Tidak ada notifikasi saat ini</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
