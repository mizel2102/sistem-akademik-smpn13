@props(['name', 'label' => '', 'options' => [], 'value' => '', 'placeholder' => '-- Pilih --', 'required' => false, 'error' => ''])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-900 transition duration-300 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:bg-slate-100 disabled:text-slate-500 disabled:cursor-not-allowed' . ($error ? ' border-red-400 focus:border-red-400 focus:ring-red-100' : '')]) }}
    >
        <option value="">{{ $placeholder }}</option>
        {{ $slot }}
        @foreach ($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @if (old($name, $value) == $optValue) selected @endif>
                {{ $optLabel }}
            </option>
        @endforeach
    </select>

    @if ($error)
        <p class="text-xs font-medium text-red-600">{{ $error }}</p>
    @endif
</div>
