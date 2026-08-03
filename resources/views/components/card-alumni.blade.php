<div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition">
    <div class="grid grid-cols-3">
        <div class="col-span-1 h-48 overflow-hidden">
            <div class="h-full w-full bg-gray-100 flex items-center justify-center text-6xl">{{ $alumnus['emoji'] ?? '👩‍🎓' }}</div>
        </div>
        <div class="col-span-2 p-6 flex flex-col justify-between">
            <div>
                <span class="inline-block text-xs font-semibold px-2 py-1 rounded mb-2 {{ $alumnus['tag_bg_class'] ?? 'bg-gray-100' }} {{ $alumnus['tag_text_class'] ?? 'text-gray-700' }}">{{ $alumnus['sector'] }}</span>
                <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $alumnus['name'] }}</h3>
                <p class="text-sm text-gray-600 font-semibold">{{ $alumnus['role'] }}</p>
            </div>
            <p class="text-xs text-gray-500 mt-2">Lulusan {{ $alumnus['year'] }} • {{ $alumnus['note'] }}</p>
        </div>
    </div>
    <div class="px-6 pb-6 border-t border-gray-200">
        <p class="text-sm text-gray-600">{{ $alumnus['summary'] }}</p>
    </div>
</div>
