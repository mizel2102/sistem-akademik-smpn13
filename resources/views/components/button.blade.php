@props(['type' => 'button', 'variant' => 'primary', 'as' => 'button'])

@php
$classes = $variant === 'primary' ? 'inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition shadow-sm' : 'inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-sm';
@endphp

@if($as === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
