<section id="faq" class="bg-slate-50 py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
        <div class="mb-16 text-center reveal-item">
            <p class="text-sm font-bold uppercase tracking-[0.3em] text-[#0369a1]">FAQ</p>
            <h2 class="mt-4 text-3xl font-extrabold text-slate-900 sm:text-4xl">Pertanyaan yang Sering Diajukan</h2>
            <p class="mt-4 text-lg text-slate-600">Jawaban cepat seputar penggunaan Portal Akademik Digital SMPN 13 Sungai Raya.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            
            <!-- FAQ 1 -->
            <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-shadow hover:shadow-md reveal-item">
                <button @click="active = (active === 1 ? null : 1)" class="flex w-full items-center justify-between px-6 py-5 text-left font-semibold text-slate-900 focus:outline-none">
                    <span class="text-lg">1. Bagaimana cara mendapatkan akun portal?</span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-[#0369a1]': active === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 1" x-collapse x-cloak class="px-6 pb-5 text-slate-600">
                    Akun portal untuk siswa dibuatkan secara otomatis oleh administrator pada saat pendaftaran ulang atau awal semester. Anda akan menerima username (NISN) dan password standar dari wali kelas masing-masing.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-shadow hover:shadow-md reveal-item">
                <button @click="active = (active === 2 ? null : 2)" class="flex w-full items-center justify-between px-6 py-5 text-left font-semibold text-slate-900 focus:outline-none">
                    <span class="text-lg">2. Siapa saja yang bisa menggunakan portal ini?</span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-[#0369a1]': active === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 2" x-collapse x-cloak class="px-6 pb-5 text-slate-600">
                    Portal ini didesain khusus untuk Siswa (memantau nilai & absensi), Guru (menginput nilai & kehadiran), serta Staf/Admin Sekolah (manajemen master data dan surat menyurat).
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-shadow hover:shadow-md reveal-item">
                <button @click="active = (active === 3 ? null : 3)" class="flex w-full items-center justify-between px-6 py-5 text-left font-semibold text-slate-900 focus:outline-none">
                    <span class="text-lg">3. Apakah portal bisa diakses dari HP?</span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-[#0369a1]': active === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 3" x-collapse x-cloak class="px-6 pb-5 text-slate-600">
                    Tentu saja! Portal akademik kami sepenuhnya responsif. Anda dapat membukanya melalui browser di *smartphone* Android maupun iOS dengan tampilan yang disesuaikan secara otomatis.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-shadow hover:shadow-md reveal-item">
                <button @click="active = (active === 4 ? null : 4)" class="flex w-full items-center justify-between px-6 py-5 text-left font-semibold text-slate-900 focus:outline-none">
                    <span class="text-lg">4. Bagaimana jika lupa password?</span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-[#0369a1]': active === 4 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 4" x-collapse x-cloak class="px-6 pb-5 text-slate-600">
                    Bagi guru dan admin, fitur reset password tersedia di halaman login (fitur pemulihan email). Bagi siswa, mohon hubungi Wali Kelas atau pihak Tata Usaha untuk mereset password akun Anda secara manual demi keamanan.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-shadow hover:shadow-md reveal-item">
                <button @click="active = (active === 5 ? null : 5)" class="flex w-full items-center justify-between px-6 py-5 text-left font-semibold text-slate-900 focus:outline-none">
                    <span class="text-lg">5. Apakah orang tua bisa melihat nilai anak?</span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-[#0369a1]': active === 5 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 5" x-collapse x-cloak class="px-6 pb-5 text-slate-600">
                    Bisa. Orang tua dapat meminjam akun siswa atau masuk menggunakan akses siswa (karena login menggunakan NISN siswa) untuk memantau nilai ulangan, tugas harian, serta jumlah ketidakhadiran (alpha/izin/sakit).
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-shadow hover:shadow-md reveal-item">
                <button @click="active = (active === 6 ? null : 6)" class="flex w-full items-center justify-between px-6 py-5 text-left font-semibold text-slate-900 focus:outline-none">
                    <span class="text-lg">6. Kapan nilai diperbarui di sistem?</span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-[#0369a1]': active === 6 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 6" x-collapse x-cloak class="px-6 pb-5 text-slate-600">
                    Nilai diperbarui oleh masing-masing Guru Mata Pelajaran. Biasanya, nilai ulangan akan tampil selambat-lambatnya 1 minggu setelah ujian dilaksanakan. Rapor akhir semester akan terbuka setelah masa ujian usai.
                </div>
            </div>
            
        </div>
    </div>
</section>
