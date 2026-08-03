<?php

namespace App\Providers;

use App\Events\AlphaThresholdReached;
use App\Listeners\NotifyGuruBK;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            AlphaThresholdReached::class,
            NotifyGuruBK::class,
        );

        try {
            // Berita: 6 items — tanggal dibuat/diatur relatif ke Juli 2026
            View::share('berita', collect([
                ['title' => 'Upacara Pembukaan Pekan Kreativitas Sekolah', 'excerpt' => 'Siswa menampilkan pameran poster pendidikan dan lomba seni tradisional khas Kalbar.', 'date' => '14 Juli 2026', 'category' => 'Kegiatan', 'image' => null],
                ['title' => 'Kunjungan Edukatif ke Museum Provinsi', 'excerpt' => 'Kelas 8 mengadakan kunjungan untuk mempelajari sejarah dan budaya lokal.', 'date' => '10 Juli 2026', 'category' => 'Kunjungan', 'image' => null],
                ['title' => 'Pelatihan Literasi Digital untuk Guru', 'excerpt' => 'Workshop penguatan perangkat pembelajaran daring dan penilaian formatif.', 'date' => '05 Juli 2026', 'category' => 'Pendidikan', 'image' => null],
                ['title' => 'Tim Robotika Lolos Final Regional', 'excerpt' => 'Tim sekolah melaju ke final regional setelah presentasi prototipe edukatif.', 'date' => '28 Juni 2026', 'category' => 'Teknologi', 'image' => null],
                ['title' => 'Bakti Sosial dan Penanaman Pohon', 'excerpt' => 'Program lingkungan oleh OSIS bekerja sama dengan masyarakat setempat.', 'date' => '22 Juni 2026', 'category' => 'Kegiatan', 'image' => null],
                ['title' => 'Pameran Karya Seni Rupa Siswa', 'excerpt' => 'Karya menampilkan tema budaya Kalimantan Barat dan kearifan lokal.', 'date' => '02 Mei 2026', 'category' => 'Seni', 'image' => null],
            ]));

            // Prestasi: 6 items
            View::share('prestasi', collect([
                ['title' => 'Juara 1 Lomba Karya Tulis Ilmiah Kabupaten', 'date' => '30 Juni 2026', 'level' => 'Kabupaten', 'student_name' => 'Fauzan Maulana'],
                ['title' => 'Juara 2 Lomba Robotika Provinsi', 'date' => '18 Juni 2026', 'level' => 'Provinsi', 'student_name' => 'Riska Novita'],
                ['title' => 'Peringkat 3 Olimpiade Matematika Kabupaten', 'date' => '12 Mei 2026', 'level' => 'Kabupaten', 'student_name' => 'Dedi Prasetyo'],
                ['title' => 'Medali Perak Kejuaraan Basket Antar Sekolah', 'date' => '02 Mei 2026', 'level' => 'Provinsi', 'student_name' => 'Tim Basket SMPN 13'],
                ['title' => 'Penghargaan Karya Seni Terbaik Festival Budaya', 'date' => '28 April 2026', 'level' => 'Kabupaten', 'student_name' => 'Maya Kusumawati'],
                ['title' => 'Sertifikat Inovasi Pembelajaran Digital Tingkat Nasional', 'date' => '10 April 2026', 'level' => 'Nasional', 'student_name' => 'Ahmad Rasyid'],
            ]));

            // Alumni: 4 items (tokoh fiktif relevan untuk Kalimantan Barat)
            View::share('alumni', collect([
                ['name' => 'Anton Hidayat', 'description' => 'Pengusaha lokal di bidang pertanian yang aktif membuka peluang magang bagi siswa.', 'photo' => null],
                ['name' => 'Lestari Putri, S.H.', 'description' => 'Pejabat pemerintahan daerah yang memfasilitasi program beasiswa bagi pelajar berprestasi.', 'photo' => null],
                ['name' => 'Rian Setiawan, S.Kom', 'description' => 'Praktisi TI yang kembali melakukan pelatihan literasi digital untuk sekolah-sekolah di Kubu Raya.', 'photo' => null],
                ['name' => 'Siti Rahmah, M.Pd', 'description' => 'Penggerak pendidikan inklusif yang mendirikan pusat bimbingan belajar di daerah pesisir.', 'photo' => null],
            ]));

            // Agenda: 3 upcoming events (format "d F Y")
            View::share('agenda', collect([
                ['title' => 'Rapat Persiapan Pekan Kreativitas Sekolah', 'date' => '17 Juli 2026'],
                ['title' => 'Workshop Penguatan Literasi Digital', 'date' => '05 Agustus 2026'],
                ['title' => 'Rapat Orang Tua/Wali - Evaluasi Semester', 'date' => '28 November 2026'],
            ]));

            // Kepala Sekolah
            View::share('kepalaSekolah', ['name' => 'Drs. H. Ahmad Fikri, M.M.', 'jabatan' => 'Kepala SMPN 13 Sungai Raya', 'photo' => null]);

            // Sambutan kepala sekolah (2 kalimat formal)
            View::share('sambutan', 'Selamat datang di SMPN 13 Sungai Raya. Kami berkomitmen memberikan pendidikan bermutu dan membentuk karakter generasi muda yang berakhlak dan berprestasi.');

            // Teachers scaffold (keperluan tampilan)
            View::share('teachers', collect([
                (object)['name' => 'Budi Santoso, S.Pd', 'subject' => 'Matematika', 'role_label' => 'Wali Kelas 9A', 'image' => null],
                (object)['name' => 'Siti Nurhaliza, M.Pd', 'subject' => 'Bahasa Indonesia', 'role_label' => 'Wali Kelas 8B', 'image' => null],
                (object)['name' => 'Ahmad Rasyid, S.T', 'subject' => 'IPA & Fisika', 'role_label' => 'Koordinator Sains', 'image' => null],
                (object)['name' => 'Dewi Wulandari, S.Pd', 'subject' => 'Bahasa Inggris', 'role_label' => 'Wali Kelas 7C', 'image' => null],
                (object)['name' => 'Eka Prasetyo, S.Pd', 'subject' => 'IPS', 'role_label' => 'Guru', 'image' => null],
                (object)['name' => 'Maya Kusumawati, S.Sn', 'subject' => 'Seni Rupa', 'role_label' => 'Guru', 'image' => null],
            ]));
        } catch (\Throwable $e) {
            // If something goes wrong (DB not ready etc.), fail gracefully without breaking views
        }
    }
}
