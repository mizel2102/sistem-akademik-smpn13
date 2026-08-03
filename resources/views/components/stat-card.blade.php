@props(['title' => null, 'value' => null, 'accent' => 'blue'])

@php
    $accentClasses = [
        'blue' => 'from-blue-600 to-indigo-600 text-white',
        'emerald' => 'from-emerald-500 to-green-600 text-white',
        'amber' => 'from-amber-500 to-orange-600 text-white',
        'slate' => 'from-slate-700 to-slate-900 text-white',
    ][$accent] ?? 'from-blue-600 to-indigo-600 text-white';
@endphp

<div {{ $attributes->merge(['class' => 'rounded-[28px] border border-slate-200/80 bg-white/90 p-6 shadow-[0_18px_60px_-35px_rgba(15,23,42,0.28)] backdrop-blur-xl']) }}>
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ $title }}</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $value }}</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br {{ $accentClasses }} px-3 py-2 text-sm font-semibold shadow-lg">
            {{ $slot }}
        </div>
    </div>
</div>
