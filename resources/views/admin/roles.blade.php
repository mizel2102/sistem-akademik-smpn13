@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900">Manajemen Role &amp; Izin</h1>
        <p class="mt-2 text-sm text-slate-600">Tinjau semua role dan izin yang tersimpan di sistem.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @forelse($roles as $role)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold capitalize text-slate-900">{{ ucfirst($role->name) }}</h2>
                        <p class="mt-2 text-sm text-slate-500">Role system untuk level akses ini.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $role->permissions->count() }} Izin</span>
                </div>

                <div class="mt-5 flex flex-wrap gap-2">
                    @forelse($role->permissions->take(8) as $perm)
                        <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-mono">{{ $perm->name }}</span>
                    @empty
                        <span class="text-sm text-slate-500">Tidak ada izin ditetapkan.</span>
                    @endforelse

                    @if($role->permissions->count() > 8)
                        <span class="text-xs text-slate-500">dan {{ $role->permissions->count() - 8 }} lainnya</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="sm:col-span-3 rounded-2xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">
                Belum ada role yang didefinisikan.
            </div>
        @endforelse
    </div>
</div>
@endsection
