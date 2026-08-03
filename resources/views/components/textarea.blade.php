@props(['name', 'label' => '', 'value' => '', 'placeholder' => '', 'rows' => 4, 'required' => false, 'error' => ''])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-900 placeholder-slate-400 transition duration-300 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:bg-slate-100 disabled:text-slate-500 disabled:cursor-not-allowed resize-vertical' . ($error ? ' border-red-400 focus:border-red-400 focus:ring-red-100' : '')]) }}
    >{{ old($name, $value) }}</textarea>

    @if ($error)
        <p class="text-xs font-medium text-red-600">{{ $error }}</p>
    @endif
</div>
