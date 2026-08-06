<!-- Sidebar -->
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static">

    <!-- Sidebar Header -->
    <div class="flex flex-col items-center gap-3 border-b border-white/10 px-6 py-8">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 text-2xl font-bold text-white">
            13
        </div>
        <div class="text-center">
            <h1 class="text-sm font-bold text-white">SMPN 13</h1>
            <p class="text-xs text-slate-400">Sistem Akademik</p>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 space-y-8 overflow-y-auto px-4 py-8">
        @php
            $role = auth()->user()?->getRoleNames()->first();
        @endphp

        <!-- UTAMA Section -->
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Utama</p>
            <ul class="space-y-1">
                <li>
                    <x-nav-item route="dashboard" icon="grid">Dashboard</x-nav-item>
                </li>
                <li>
                    <x-nav-item route="profile.show" icon="user">Profil Saya</x-nav-item>
                </li>
            </ul>
        </div>

        @if($role === 'admin')
            <!-- AKADEMIK Section (Admin) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Akademik</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="admin.students.index" icon="users">Data Siswa</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.teachers.index" icon="user">Data Guru</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.academic-classes.index" icon="layers">Kelas</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.subjects.index" icon="book">Mata Pelajaran</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.schedules.index" icon="calendar">Jadwal</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.academic-years.index" icon="clock">Tahun Ajaran</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.semesters.index" icon="calendar">Semester</x-nav-item>
                    </li>
                </ul>
            </div>

            <!-- LAINNYA Section (Admin) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Lainnya</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="admin.announcements.index" icon="bell">Pengumuman</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.reports.index" icon="file-text">Laporan</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="admin.users.index" icon="users">Pengguna</x-nav-item>
                    </li>
                </ul>
            </div>

        @elseif($role === 'teacher')
            <!-- AKADEMIK Section (Teacher) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Akademik</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="teacher.classes.index" icon="layers">Kelas Saya</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="teacher.subjects.index" icon="book">Mata Pelajaran</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="teacher.students.index" icon="users">Data Siswa</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="teacher.report-cards.index" icon="file-text">Rapot</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="teacher.grades.index" icon="check-square">Input Data Nilai</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="teacher.attendance.index" icon="calendar">Absensi Tracking</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="teacher.warning-letters.index" icon="alert-triangle">Surat Pernyataan</x-nav-item>
                    </li>
                </ul>
            </div>

            <!-- LAINNYA Section (Teacher) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Lainnya</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="announcements.index" icon="bell">Pengumuman</x-nav-item>
                    </li>
                </ul>
            </div>

        @elseif($role === 'guru-bk' || $role === 'guru_bk')
            <!-- BK Section -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Bimbingan Konseling</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="bk.dashboard" icon="grid">Dashboard BK</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="bk.monitoring.alpha" icon="alert-triangle">Monitoring Alpha</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="bk.counselings.index" icon="message-square">Pembinaan</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="bk.warning-letters.index" icon="file-text">Surat Peringatan</x-nav-item>
                    </li>
                </ul>
            </div>

            <!-- LAINNYA Section (BK) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Lainnya</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="announcements.index" icon="bell">Pengumuman</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="settings.index" icon="settings">Pengaturan</x-nav-item>
                    </li>
                </ul>
            </div>

        @elseif($role === 'student')
            <!-- AKADEMIK Section (Student) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Akademik</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="student.classes.index" icon="book-open">Kelas Saya</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="student.records.index" icon="check-square">Nilai Saya</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="student.join-class" icon="plus-circle">Gabung Kelas</x-nav-item>
                    </li>
                    <li>
                        <x-nav-item route="student.attendance.index" icon="calendar">Absensi</x-nav-item>
                    </li>
                </ul>
            </div>

            <!-- LAINNYA Section (Student) -->
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Lainnya</p>
                <ul class="space-y-1">
                    <li>
                        <x-nav-item route="announcements.index" icon="bell">Pengumuman</x-nav-item>
                    </li>
                </ul>
            </div>
        @endif
    </nav>

    <!-- Sidebar Footer -->
    <div class="border-t border-white/10 px-4 py-6">
        @if(auth()->check())
            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 group transition hover:opacity-90">
                @if(auth()->user()?->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold transition-all">
                @else
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white group-hover:ring-2 group-hover:ring-gold transition-all">
                        {{ optional(auth()->user())->name ? substr(auth()->user()->name, 0, 2) : 'U' }}
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-white group-hover:text-gold transition-colors">{{ optional(auth()->user())->name }}</p>
                    <p class="truncate text-xs text-slate-400 capitalize">{{ $role ?? 'User' }}</p>
                </div>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit"
                        class="w-full rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/20 hover:text-white">
                    Keluar
                </button>
            </form>
        @else
            <div class="text-sm text-slate-400">Silakan masuk untuk melihat menu akun.</div>
        @endif
    </div>
</div>

<!-- Sidebar Overlay (Mobile) -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
     class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>
