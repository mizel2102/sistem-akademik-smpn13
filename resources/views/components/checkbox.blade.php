@props(['name', 'label' => '', 'value' => '1', 'checked' => false, 'error' => ''])

<div class="flex items-center gap-2.5">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if (old($name, $checked)) checked @endif
        {{ $attributes->merge(['class' => 'h-5 w-5 rounded border-2 border-slate-300 bg-white text-blue-600 transition duration-300 focus:ring-2 focus:ring-blue-100 cursor-pointer']) }}
    />

    @if ($label)
        <label for="{{ $name }}" class="text-sm font-medium text-slate-700 cursor-pointer">
            {{ $label }}
        </label>
    @endif
</div>

@if ($error)
    <p class="text-xs font-medium text-red-600 mt-1">{{ $error }}</p>
@endif
