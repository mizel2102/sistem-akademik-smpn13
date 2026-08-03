<article class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition">
    <div class="bg-gradient-to-r from-gray-200 to-gray-300 h-40"></div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">{{ $category ?? 'Umum' }}</span>
            <time class="text-xs text-gray-500">{{ $date ?? now()->format('d M Y') }}</time>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-slate-700 cursor-pointer">{{ $title }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ $excerpt }}</p>
        <a href="#" class="text-blue-600 font-semibold text-sm hover:text-blue-700">Baca Selengkapnya →</a>
    </div>
</article>
