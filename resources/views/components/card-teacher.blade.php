<tr class="border-b border-gray-200 hover:bg-blue-50 transition">
    <td class="px-4 py-3 text-gray-600">{{ $index }}</td>
    <td class="px-4 py-3 text-gray-900 font-medium">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600">{{ $teacher->initials ?? 'GS' }}</div>
            <span>{{ $teacher->name }}</span>
        </div>
    </td>
    <td class="px-4 py-3 text-gray-600">{{ $teacher->subject }}</td>
    <td class="px-4 py-3 text-gray-600 hidden md:table-cell text-xs">{{ $teacher->degree ?? '' }}</td>
</tr>
