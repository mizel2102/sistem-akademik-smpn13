@props(['title' => null, 'subtitle' => null])
<div {{ $attributes->merge(['class' => 'rounded-3xl border border-slate-200 bg-white p-6 shadow-sm']) }}>
    @if($title)
        <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
    @endif
    @if($subtitle)
        <p class="mt-2 text-sm text-slate-600">{{ $subtitle }}</p>
    @endif
    {{ $slot }}
</div>
