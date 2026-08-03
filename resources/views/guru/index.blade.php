@extends('layouts.public')

@section('title', 'Profil Guru - SMPN 13 Sungai Raya | Portal Akademik Digital')

@section('content')
    @include('partials.page-hero', [
        'subtitle' => 'PROFIL TENAGA PENGAJAR',
        'title' => 'Guru & Tenaga Kependidikan',
        'description' => 'Mengenal lebih dekat para pendidik berdedikasi yang membimbing siswa-siswi SMPN 13 Sungai Raya meraih prestasi terbaik.'
    ])

    <!-- FILTER SECTION -->
    <section class="py-6 px-4 sm:px-6 lg:px-8 border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-slate-800">Daftar Pengajar</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Cari nama guru..." class="w-full pl-9 pr-3 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-shadow shadow-sm">
                </div>
                <select class="px-4 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm bg-white text-slate-700 w-full sm:w-auto">
                    <option>Semua Bidang Studi</option>
                    <option>Bahasa Indonesia</option>
                    <option>Matematika</option>
                    <option>Bahasa Inggris</option>
                    <option>Ilmu Pengetahuan Alam</option>
                    <option>Ilmu Pengetahuan Sosial</option>
                    <option>Seni & Budaya</option>
                    <option>Pendidikan Jasmani</option>
                </select>
            </div>
        </div>
    </section>

    <!-- TABLE SECTION -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-[50vh]">
        <div class="max-w-7xl mx-auto">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-100/80 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold text-[0.7rem]">
                            <tr>
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Profil Guru</th>
                                <th class="px-6 py-4">Bidang Studi</th>
                                <th class="px-6 py-4 hidden md:table-cell">Gelar Akademik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($teachers as $i => $t)
                                <tr class="hover:bg-sky-50/50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-slate-500 text-center">{{ $i+1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 bg-sky-100 rounded-full flex items-center justify-center text-sky-600 font-bold text-xs ring-2 ring-white shadow-sm">{{ $t->initials ?? 'GS' }}</div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $t->name }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">NIP: {{ $t->nip ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 font-medium">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $t->subject }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell text-slate-600 text-xs">{{ $t->degree ?? 'S1 Pendidikan' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            <p class="text-base font-medium text-slate-600">Belum ada data guru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAGINATION -->
            @if(count($teachers) > 0)
            <div class="flex items-center justify-between mt-8">
                <p class="text-sm text-slate-500">Menampilkan 1 hingga {{ count($teachers) }} dari total pengajar</p>
                <div class="flex gap-2">
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors disabled:opacity-50">Sebelumnnya</button>
                    <button class="px-3.5 py-2 text-sm bg-sky-600 text-white rounded-lg font-bold shadow-md shadow-sky-600/20">1</button>
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors">2</button>
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors">Selanjutnya</button>
                </div>
            </div>
            @endif
        </div>
    </section>

@endsection
