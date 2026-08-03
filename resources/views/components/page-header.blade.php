@props(['title' => null, 'subtitle' => null, 'badge' => null])

<div {{ $attributes->merge(['class' => 'rounded-[32px] border border-slate-200/80 bg-white/85 p-6 shadow-[0_28px_70px_-35px_rgba(15,23,42,0.28)] backdrop-blur-xl sm:p-8']) }}>
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            @if ($title)
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h1>
            @endif
            @if ($subtitle)
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @if ($badge)
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">{{ $badge }}</span>
            @endif
            @isset($actions)
                {{ $actions }}
            @endisset
        </div>
    </div>
</div>
