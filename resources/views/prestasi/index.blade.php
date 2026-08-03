@extends('layouts.public')

@section('title', 'Prestasi - SMPN 13 Sungai Raya | Portal Akademik Digital')

@section('content')
    @include('partials.page-hero', [
        'subtitle' => 'KEBANGGAAN SEKOLAH',
        'title' => 'Prestasi & Penghargaan',
        'description' => 'Deretan pencapaian luar biasa siswa dan sekolah SMPN 13 Sungai Raya di berbagai bidang akademik maupun non-akademik.'
    ])

    <!-- FILTER SECTION -->
    <section class="py-6 px-4 sm:px-6 lg:px-8 border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-slate-800">Daftar Prestasi</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <select class="px-4 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 shadow-sm bg-white text-slate-700 w-full sm:w-auto">
                    <option>Semua Kategori</option>
                    <option>Akademik</option>
                    <option>Olahraga</option>
                    <option>Seni & Budaya</option>
                    <option>Teknologi & Inovasi</option>
                </select>
                <select class="px-4 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 shadow-sm bg-white text-slate-700 w-full sm:w-auto">
                    <option>Semua Tingkat</option>
                    <option>Internasional</option>
                    <option>Nasional</option>
                    <option>Provinsi</option>
                    <option>Kabupaten/Kota</option>
                </select>
            </div>
        </div>
    </section>

    <!-- CONTENT SECTION (Card Grid) -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-[50vh]">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Achievement 1 -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col relative overflow-hidden">
                    <div class="h-48 bg-slate-200 overflow-hidden relative">
                        <img src="{{ asset('images/nasional/IMG_4507.jpeg') }}" alt="Sains Matematika" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 right-4 bg-yellow-500 text-blue-900 font-bold px-2.5 py-1 rounded shadow text-xs uppercase tracking-wider">Nasional</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col relative z-10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-sm">
                                <span class="text-xl">🥇</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 group-hover:text-amber-600 transition-colors">Juara 1 Kompetisi Sains Nasional Matematika</h3>
                        <p class="text-sm text-slate-600 mb-4 flex-1">Diwakili oleh 3 siswa terpilih di bawah bimbingan Ibu Siti Nurhaliza.</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 border-t border-slate-100 pt-4 mt-auto">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Tahun 2025</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Akademik</span>
                        </div>
                    </div>
                </div>

                <!-- Achievement 2 -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col relative overflow-hidden">
                    <div class="h-48 bg-slate-200 overflow-hidden relative">
                        <img src="{{ asset('images/nasional/IMG_4645.jpeg') }}" alt="Robotics" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 right-4 bg-purple-600 text-white font-bold px-2.5 py-1 rounded shadow text-xs uppercase tracking-wider">Internasional</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col relative z-10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-sm">
                                <span class="text-xl">🥇</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 group-hover:text-amber-600 transition-colors">Gold Medal Robotics Olympiad Asia Tenggara</h3>
                        <p class="text-sm text-slate-600 mb-4 flex-1">Tim yang terdiri dari 5 siswa inovatif bersama Bapak Rudi Hartono.</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 border-t border-slate-100 pt-4 mt-auto">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Tahun 2024</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Teknologi</span>
                        </div>
                    </div>
                </div>

                <!-- Achievement 3 -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col relative overflow-hidden">
                    <div class="h-48 bg-slate-200 overflow-hidden relative">
                        <img src="{{ asset('images/nasional/IMG_4695.jpeg') }}" alt="Seni Rupa" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 right-4 bg-yellow-500 text-blue-900 font-bold px-2.5 py-1 rounded shadow text-xs uppercase tracking-wider">Nasional</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col relative z-10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-sm">
                                <span class="text-xl">🥇</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 group-hover:text-amber-600 transition-colors">Juara 1 Festival Seni Rupa Pelajar Indonesia</h3>
                        <p class="text-sm text-slate-600 mb-4 flex-1">Diwakili 2 siswa berbakat dari kelas IX didampingi Ibu Maya Safitri.</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 border-t border-slate-100 pt-4 mt-auto">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Tahun 2024</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Seni Budaya</span>
                        </div>
                    </div>
                </div>

                <!-- Achievement 4 -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col relative overflow-hidden">
                    <div class="h-48 bg-slate-200 overflow-hidden relative">
                        <img src="{{ asset('images/provinsi/IMG_4885.JPG') }}" alt="Debat Bahasa" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 right-4 bg-sky-600 text-white font-bold px-2.5 py-1 rounded shadow text-xs uppercase tracking-wider">Provinsi</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col relative z-10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-slate-300 to-slate-400 flex items-center justify-center text-white shadow-sm">
                                <span class="text-xl">🥈</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 group-hover:text-slate-600 transition-colors">Perak Kompetisi Debat Bahasa Indonesia</h3>
                        <p class="text-sm text-slate-600 mb-4 flex-1">Tim debat yang beranggotakan 4 siswa bersama Bapak Budi Santoso.</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 border-t border-slate-100 pt-4 mt-auto">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Tahun 2023</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Akademik</span>
                        </div>
                    </div>
                </div>

                <!-- Achievement 5 -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col relative overflow-hidden">
                    <div class="h-48 bg-slate-200 overflow-hidden relative">
                        <img src="{{ asset('images/nasional/IMG_0153.jpeg') }}" alt="Wirausaha" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 right-4 bg-yellow-500 text-blue-900 font-bold px-2.5 py-1 rounded shadow text-xs uppercase tracking-wider">Nasional</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col relative z-10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-sm">
                                <span class="text-xl">🏆</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 group-hover:text-amber-600 transition-colors">Penghargaan Inovasi Program Usaha Muda Mandiri</h3>
                        <p class="text-sm text-slate-600 mb-4 flex-1">Diwakili oleh kelompok wirausaha siswa bersama Bapak Ahmad Wijaya.</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 border-t border-slate-100 pt-4 mt-auto">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Tahun 2023</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Sosial</span>
                        </div>
                    </div>
                </div>

                <!-- Achievement 6 -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col relative overflow-hidden">
                    <div class="h-48 bg-slate-200 overflow-hidden relative">
                        <img src="{{ asset('images/provinsi/IMG_4887.JPG') }}" alt="Musik" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 right-4 bg-yellow-500 text-blue-900 font-bold px-2.5 py-1 rounded shadow text-xs uppercase tracking-wider">Nasional</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col relative z-10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-500 flex items-center justify-center text-white shadow-sm">
                                <span class="text-xl">🥉</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 group-hover:text-orange-600 transition-colors">Perunggu Kompetisi Seni Musik Nasional</h3>
                        <p class="text-sm text-slate-600 mb-4 flex-1">Grup paduan suara beranggotakan 10 orang dibimbing oleh Bapak Eka Prasetyo.</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 border-t border-slate-100 pt-4 mt-auto">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Tahun 2022</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Seni Budaya</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- PAGINATION -->
            <div class="flex items-center justify-between mt-12 border-t border-slate-200 pt-6">
                <p class="text-sm text-slate-500">Menampilkan 6 dari 24 prestasi</p>
                <div class="flex gap-2">
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors disabled:opacity-50" disabled>Sebelumnnya</button>
                    <button class="px-3.5 py-2 text-sm bg-sky-600 text-white rounded-lg font-bold shadow-md shadow-sky-600/20">1</button>
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors">2</button>
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors">3</button>
                    <button class="px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 bg-white font-medium transition-colors">Selanjutnya</button>
                </div>
            </div>
        </div>
    </section>

@endsection
