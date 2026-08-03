@props(['headers' => [], 'actions' => true])

<div class="overflow-x-auto rounded-[20px] border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-sm">
        <thead class="border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold uppercase tracking-[0.1em] text-slate-600">
                        {{ $header }}
                    </th>
                @endforeach
                @if ($actions)
                    <th class="px-4 sm:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm font-semibold uppercase tracking-[0.1em] text-slate-600">
                        Aksi
                    </th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
