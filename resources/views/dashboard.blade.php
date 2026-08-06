@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Beranda › Dashboard')

@section('content')
@php
    $role = $role ?? auth()->user()?->getRoleNames()->first();
@endphp

<!-- Tambahkan ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@if($role === 'admin')
    <!-- Admin Dashboard -->
    <div class="space-y-6">
        
        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('admin.students.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 7a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM12 11h6M15 14h3"></path>
                </svg>
                + Tambah Siswa
            </a>
            <a href="{{ route('admin.teachers.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 1 0 8 4 4 0 0 1 0-8z"></path>
                </svg>
                + Tambah Guru
            </a>
            <a href="{{ route('admin.academic-classes.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5v-14a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14M4 19.5h16"></path>
                </svg>
                + Buat Kelas Baru
            </a>
            <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-amber-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line>
                </svg>
                Atur Jadwal
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-200 transition border border-slate-200">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                Pengumuman Baru
            </a>
        </div>

        <!-- Statistics Grid (TailAdmin Style) -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
            <!-- Total Siswa -->
            <a href="{{ route('admin.students.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-blue-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-blue-600 mb-4 w-12 h-12 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M16 11a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM23 21v-2a4 4 0 0 0-3-3.87"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-blue-600 transition">{{ number_format($statistics['students'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Total Siswa ›</span>
                    </div>
                </div>
            </a>

            <!-- Total Guru -->
            <a href="{{ route('admin.teachers.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-amber-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-amber-600 mb-4 w-12 h-12 group-hover:bg-amber-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 1 0 8 4 4 0 0 1 0-8z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-amber-600 transition">{{ number_format($statistics['teachers'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Total Guru ›</span>
                    </div>
                </div>
            </a>

            <!-- Kelas Aktif -->
            <a href="{{ route('admin.academic-classes.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-emerald-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-emerald-600 mb-4 w-12 h-12 group-hover:bg-emerald-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5v-14a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14M4 19.5h16"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-emerald-600 transition">{{ number_format($statistics['classes'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Kelas Aktif ›</span>
                    </div>
                </div>
            </a>

            <!-- Mata Pelajaran -->
            <a href="{{ route('admin.subjects.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-purple-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-purple-600 mb-4 w-12 h-12 group-hover:bg-purple-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 4h16M4 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2M4 4v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-purple-600 transition">{{ number_format($statistics['subjects'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Mata Pelajaran ›</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Charts Area -->
        <div class="mt-4 grid grid-cols-1 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5 xl:grid-cols-3">
            <!-- Chart 1: Area (Spans 2 cols on xl) -->
            <div class="col-span-1 rounded-xl border border-slate-200 bg-white px-5 pt-7 pb-5 shadow-sm sm:px-7 xl:col-span-2">
                <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap">
                    <div>
                        <h4 class="text-xl font-bold text-slate-800">Tren Kehadiran (Dummy)</h4>
                    </div>
                </div>
                <div>
                    <div id="adminChartOne" class="-ml-5"></div>
                </div>
            </div>

            <!-- Chart 2: Bar -->
            <div class="col-span-1 rounded-xl border border-slate-200 bg-white px-5 pt-7 pb-5 shadow-sm sm:px-7">
                <div>
                    <h4 class="text-xl font-bold text-slate-800">Kinerja Siswa (Dummy)</h4>
                </div>
                <div>
                    <div id="adminChartTwo" class="-ml-5 -mb-9"></div>
                </div>
            </div>
        </div>

        <!-- Table Area -->
        <div class="mt-4 grid grid-cols-1 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5 lg:grid-cols-2">
            <!-- Recent Announcements -->
            <div class="rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7">
                <h4 class="mb-6 text-xl font-bold text-slate-800">Pengumuman Terbaru</h4>
                <div class="flex flex-col">
                    @forelse($recentAnnouncements ?? [] as $ann)
                        <div class="grid border-b border-slate-200 py-4 last:border-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-semibold text-slate-800">{{ $ann->title }}</h5>
                                    <p class="text-xs text-slate-500 mt-1">{{ $ann->created_at?->format('d M Y H:i') }}</p>
                                </div>
                                <span class="inline-block rounded bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-600">{{ $ann->target_audience ?? 'Umum' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center">
                            <p class="text-sm text-slate-500">Belum ada pengumuman</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- System Summary Table -->
            <div class="rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7">
                <h4 class="mb-6 text-xl font-bold text-slate-800">Ringkasan Sistem</h4>
                <div class="flex flex-col space-y-4 pb-4">
                    <!-- Users -->
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700">Pengguna Terdaftar</span>
                            <span class="text-sm font-bold text-slate-900">{{ number_format($statistics['users'] ?? 0) }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-blue-600" <?php echo 'style="width: ' . min(($statistics['users'] ?? 0) / 100 * 100, 100) . '%;"'; ?>></div>
                        </div>
                    </div>
                    <!-- Schedules -->
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700">Jadwal Pelajaran</span>
                            <span class="text-sm font-bold text-slate-900">{{ number_format($statistics['schedules'] ?? 0) }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-emerald-500" <?php echo 'style="width: ' . min(($statistics['schedules'] ?? 0) / 100 * 100, 100) . '%;"'; ?>></div>
                        </div>
                    </div>
                    <!-- Grades -->
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700">Total Nilai Diinput</span>
                            <span class="text-sm font-bold text-slate-900">{{ number_format($statistics['grades'] ?? 0) }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-amber-500" <?php echo 'style="width: ' . min(($statistics['grades'] ?? 0) / 100 * 100, 100) . '%;"'; ?>></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Admin Chart 1
            const adminChartOneOptions = {
                series: [{ name: 'Hadir', data: [85, 87, 86, 92, 95, 91, 88, 93, 94, 96, 95, 98] }],
                colors: ['#3C50E0'],
                chart: { fontFamily: 'inherit', height: 335, type: 'area', toolbar: { show: false } },
                stroke: { curve: 'smooth', width: 2 },
                dataLabels: { enabled: false },
                xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'] },
            };
            new ApexCharts(document.querySelector('#adminChartOne'), adminChartOneOptions).render();

            // Admin Chart 2
            const adminChartTwoOptions = {
                series: [{ name: 'KKM Tercapai', data: [75, 80, 85, 78, 90, 82, 88] }],
                colors: ['#10B981'],
                chart: { type: 'bar', height: 335, toolbar: { show: false } },
                plotOptions: { bar: { borderRadius: 4, columnWidth: '40%' } },
                dataLabels: { enabled: false },
                xaxis: { categories: ['7A', '7B', '8A', '8B', '9A', '9B', '9C'] },
            };
            new ApexCharts(document.querySelector('#adminChartTwo'), adminChartTwoOptions).render();
        });
    </script>

@elseif($role === 'teacher')
    <!-- Teacher Dashboard -->
    <div class="space-y-6">
        <!-- Quick Actions for Teacher -->
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('teacher.grades.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"></path></svg>
                + Input Nilai
            </a>
            <a href="{{ route('teacher.classes.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                + Kelola Kelas
            </a>
            <a href="{{ route('teacher.schedule.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                Jadwal Mengajar
            </a>
            <a href="{{ route('teacher.warning-letters.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-700 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                Surat Peringatan (SP)
            </a>
        </div>

        <!-- Statistics Grid (TailAdmin Style) -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4 md:gap-6 2xl:gap-7.5">
            <!-- Kelas Saya -->
            <a href="{{ route('teacher.classes.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-blue-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-blue-600 mb-4 w-12 h-12 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-blue-600 transition">{{ number_format($personalStats['classes'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Kelas Saya ›</span>
                    </div>
                </div>
            </a>

            <!-- Total Siswa -->
            <a href="{{ route('teacher.students.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-amber-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-amber-600 mb-4 w-12 h-12 group-hover:bg-amber-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M16 11a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-amber-600 transition">{{ number_format($personalStats['students'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Siswa Diajar ›</span>
                    </div>
                </div>
            </a>

            <!-- Nilai Diinput -->
            <a href="{{ route('teacher.grades.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-emerald-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-emerald-600 mb-4 w-12 h-12 group-hover:bg-emerald-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-emerald-600 transition">{{ number_format($personalStats['grades'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Nilai Diinput ›</span>
                    </div>
                </div>
            </a>

            <!-- Absensi Hari Ini -->
            <a href="{{ route('teacher.attendance.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-indigo-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-indigo-600 mb-4 w-12 h-12 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-indigo-600 transition">{{ number_format($personalStats['today_attendances'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Absensi Hari Ini ›</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Charts Area -->
        <div class="mt-4 grid grid-cols-1 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5 xl:grid-cols-3">
            <!-- Recent Attendances (Spans 2 cols on xl) -->
            <div class="col-span-1 rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7 xl:col-span-2">
                <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap mb-6">
                    <div>
                        <h4 class="text-xl font-bold text-slate-800">Absensi Terbaru (Siswa Anda)</h4>
                    </div>
                </div>
                <div class="flex flex-col">
                    @forelse($recentAttendances ?? [] as $attendance)
                        <div class="grid border-b border-slate-200 py-3 last:border-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-semibold text-slate-800">{{ $attendance->student->user->name ?? 'Siswa' }}</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">Kelas: {{ $attendance->academicClass->name ?? '-' }} • {{ $attendance->attendance_time?->format('d M Y H:i') }}</p>
                                </div>
                                
                                @php
                                    $statusColor = match($attendance->status) {
                                        'present' => 'bg-emerald-100 text-emerald-600',
                                        'late' => 'bg-amber-100 text-amber-600',
                                        'sick' => 'bg-blue-100 text-blue-600',
                                        'permission' => 'bg-purple-100 text-purple-600',
                                        default => 'bg-rose-100 text-rose-600',
                                    };
                                    $statusText = match($attendance->status) {
                                        'present' => 'Hadir',
                                        'late' => 'Terlambat',
                                        'sick' => 'Sakit',
                                        'permission' => 'Izin',
                                        default => 'Alpa',
                                    };
                                @endphp
                                <span class="inline-block rounded {{ $statusColor }} px-2.5 py-1 text-xs font-medium">{{ $statusText }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center">
                            <p class="text-sm text-slate-500">Belum ada absensi hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Access Table Area -->
            <div class="col-span-1 rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7">
                <h4 class="mb-6 text-xl font-bold text-slate-800">Akses Cepat</h4>
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('teacher.grades.index') }}" class="group flex items-center gap-4 rounded-lg border border-slate-200 p-3 hover:border-blue-500 hover:bg-blue-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 group-hover:text-blue-700">Input Nilai</p>
                            <p class="text-xs text-slate-500">Masukkan nilai evaluasi</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('teacher.classes.index') }}" class="group flex items-center gap-4 rounded-lg border border-slate-200 p-3 hover:border-amber-500 hover:bg-amber-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded bg-amber-100 text-amber-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5v-14a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14M4 19.5h16"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 group-hover:text-amber-700">Kelas Saya</p>
                            <p class="text-xs text-slate-500">Kelola daftar kelas</p>
                        </div>
                    </a>

                    <a href="{{ route('teacher.schedule.index') }}" class="group flex items-center gap-4 rounded-lg border border-slate-200 p-3 hover:border-emerald-500 hover:bg-emerald-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded bg-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 group-hover:text-emerald-700">Jadwal Mengajar</p>
                            <p class="text-xs text-slate-500">Lihat jadwal harian</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Surat Pernyataan Terbaru (SP) -->
            <div class="col-span-1 rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7 xl:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-xl font-bold text-slate-800">Surat Pernyataan Terbaru (SP)</h4>
                    <a href="{{ route('teacher.warning-letters.index') }}" class="text-sm font-semibold text-navy hover:underline">Lihat Semua</a>
                </div>
                <div class="flex flex-col">
                    @forelse($recentWarningLetters ?? [] as $wl)
                        <div class="grid border-b border-slate-200 py-3 last:border-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-semibold text-slate-800">{{ $wl->student->user->name ?? 'Siswa' }}</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">Tingkat: <span class="font-bold text-rose-600">{{ $wl->type }}</span> • Alasan: {{ $wl->reason }}</p>
                                </div>
                                <span class="inline-block rounded px-2.5 py-1 text-xs font-semibold {{ $wl->resolved_at ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                    {{ $wl->resolved_at ? 'Dicabut' : 'Aktif' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center">
                            <p class="text-sm text-slate-500">Belum ada Surat Pernyataan (SP) yang diterbitkan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>



@elseif($role === 'student')
    <!-- Student Dashboard (Also adapted to TailAdmin Style) -->
    <div class="space-y-6">
        @if($activeSp)
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 shadow-sm flex items-start gap-4 animate-pulse">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <h3 class="text-lg font-bold text-rose-800">⚠️ PEMBERITAHUAN SURAT PERNYATAAN AKTIF ({{ $activeSp->type }})</h3>
                        <span class="text-xs font-semibold bg-rose-200 text-rose-800 px-2.5 py-0.5 rounded-full">Status: Aktif</span>
                    </div>
                    <p class="mt-1 text-sm text-rose-700">
                        Anda telah menerima **{{ $activeSp->type }}** pada tanggal **{{ \Carbon\Carbon::parse($activeSp->issued_at)->translatedFormat('d F Y') }}**.
                    </p>
                    <div class="mt-3 text-sm text-rose-800 bg-white/70 p-4 rounded-xl border border-rose-100 shadow-sm">
                        <span class="font-bold block text-rose-900 mb-1">Alasan Penerbitan:</span>
                        <p class="italic text-slate-700">{{ $activeSp->reason }}</p>
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <p class="text-sm font-semibold text-rose-900">
                            📢 Silakan segera menghubungi Guru Bimbingan Konseling (BK) Anda untuk proses pembinaan.
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-6 2xl:gap-7.5">
            <a href="{{ route('student.attendance.history') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-blue-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-blue-600 mb-4 w-12 h-12 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-blue-600 transition">{{ $personalStats['attendanceRate'] ?? 0 }}</h4>
                        <span class="text-sm font-medium text-slate-500">Tingkat Kehadiran ›</span>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('student.records.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-amber-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-amber-600 mb-4 w-12 h-12 group-hover:bg-amber-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-amber-600 transition">{{ number_format($personalStats['grades'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Nilai Tercatat ›</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('student.classes.index') }}" class="group block rounded-xl border border-slate-200 bg-white px-7 py-6 shadow-sm hover:border-emerald-500 hover:shadow-md transition">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-slate-100 text-emerald-600 mb-4 w-12 h-12 group-hover:bg-emerald-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-slate-800 text-2xl group-hover:text-emerald-600 transition">{{ number_format($personalStats['classes'] ?? 0) }}</h4>
                        <span class="text-sm font-medium text-slate-500">Kelas Diikuti ›</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7">
                <h4 class="mb-6 text-xl font-bold text-slate-800">Akses Cepat</h4>
                <div class="flex flex-col space-y-3 pb-4">
                    <a href="{{ route('student.records.index') }}" class="group flex items-center gap-4 rounded-lg border border-slate-200 p-3 hover:border-blue-500 hover:bg-blue-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 group-hover:text-blue-700">Nilai Saya</p>
                            <p class="text-xs text-slate-500">Lihat nilai rapor</p>
                        </div>
                    </a>
                    <a href="{{ route('student.attendance.index') }}" class="group flex items-center gap-4 rounded-lg border border-slate-200 p-3 hover:border-amber-500 hover:bg-amber-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded bg-amber-100 text-amber-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 group-hover:text-amber-700">Absensi Hari Ini</p>
                            <p class="text-xs text-slate-500">Cek atau catat kehadiran</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- Default/Fallback Dashboard -->
    <div class="rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <svg class="mx-auto mb-4 h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        <p class="text-lg font-semibold text-slate-900">Role tidak dikenali</p>
        <p class="text-sm text-slate-600">Silakan hubungi administrator untuk bantuan</p>
    </div>
@endif

@endsection
