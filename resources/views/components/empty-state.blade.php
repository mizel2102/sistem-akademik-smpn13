@props(['title' => 'Belum ada data', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-[28px] border border-dashed border-slate-300 bg-slate-50/70 px-6 py-12 text-center']) }}>
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-2xl shadow-sm">📭</div>
    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
    @endif
    @isset($actions)
        <div class="mt-6 flex justify-center">{{ $actions }}</div>
    @endisset
</div>
