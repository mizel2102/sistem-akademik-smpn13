# Project Standards

## Project Identity
- Nama aplikasi: Sistem Akademik SMPN 13
- Tujuan: Sistem informasi akademik untuk manajemen siswa, guru, kelas, jadwal, absensi, nilai, dan pengumuman.
- Domain: pendidikan, manajemen sekolah menengah pertama.
- Peran utama: admin, guru, siswa.

## Project Scope
- Fokus utama: frontend redesign dengan mempertahankan semua fungsi backend.
- Area perubahan: hanya `resources/views/**`, `resources/css/**`, dan `resources/js/**`.
- Tidak mengubah: logika controller, model, migration, business rule, authorization, atau database schema kecuali dokumentasi.
- Tujuan frontend: konsistensi komponen Blade, aksesibilitas, responsivitas, dan penggunaan Tailwind + Alpine.

## Technology Stack
- Backend: Laravel 13.8, PHP 8.3
- Frontend: Blade, Tailwind CSS 4.3.2, Alpine.js 3.15.12, Vite
- Database: MySQL / SQLite (Laravel-compatible DB)
- Authentication: Laravel auth flow custom + `laravel/sanctum`
- Authorization: `spatie/laravel-permission`, policies, middleware role-based
- Testing: Pest + PHPUnit
- Asset tooling: Vite, `@tailwindcss/vite`

## Coding Standard
- Ikuti PSR-12 untuk PHP dan aturan Laravel Pint.
- Gunakan nama variabel yang jelas dan bahasa Indonesia/Inggris konsisten sesuai konteks domain.
- Hindari duplikasi markup, gunakan komponen Blade reusable.
- Gunakan method chaining yang bersih dan single-responsibility pada controller.
- Dokumentasikan purpose setiap metode atau rule khusus jika tidak langsung jelas.

## Folder Structure
- `app/Models` → model Eloquent.
- `app/Http/Controllers` → controller web.
- `app/Http/Requests` → form request validation.
- `app/Policies` → policy authorization.
- `app/Http/Middleware` → middleware custom.
- `resources/views` → semua view Blade.
- `resources/css` → Tailwind entrypoint dan custom CSS.
- `resources/js` → Alpine/JS behavior.
- `routes/web.php` → route web utama.
- `database/migrations` → definisi skema.
- `database/seeders` → data awal.
- `database/factories` → factory model.

## MVC
- Model: fokus pada relationship, fillable, accessor, mutator, dan factory.
- View: gunakan Blade untuk layout, partial, dan komponen.
- Controller: hanya handle request, authorize, validasi, dan panggil model/service.
- Hindari menempatkan logika bisnis berat langsung di controller.
- Gunakan Route model binding dan resource-style route bila sesuai.

## Laravel Rules
- Semua form harus divalidasi dengan `FormRequest` (`app/Http/Requests`).
- Gunakan kebijakan (`policies`) dan `authorizeResource` atau `authorize` di controller.
- Register semua policy di `App\Providers\AuthServiceProvider`.
- Panggil `Auth::user()` atau helper `auth()->user()` secara aman.
- Gunakan middleware `auth` untuk route terproteksi.
- Gunakan `with()` atau eager loading untuk menghindari N+1 query.

## Tailwind Rules
- Struktur styling menggunakan utility class Tailwind.
- Hindari inline style CSS kecuali benar-benar diperlukan.
- Gunakan komponen Blade untuk wrapper form, card, tabel, tombol.
- Pastikan tampilan responsif dengan breakpoint Tailwind.
- Gunakan kelas warna dan spacing konsisten (misal `text-slate`, `bg-slate`, `p-4`, `gap-4`).
- Gunakan `@vite(['resources/css/app.css','resources/js/app.js'])` di layout.

## Database Rules
- Gunakan `migrations` untuk semua perubahan schema.
- Tetapkan foreign key di tabel relasional.
- Gunakan kolom `nullable` hanya ketika data benar-benar opsional.
- Gunakan `unique` di field seperti email jika harus unik.
- Gunakan tipe data yang tepat: `string`, `text`, `integer`, `date`, `boolean`.
- Hindari menyimpan data terstruktur dalam kolom teks kecuali diperlukan.

## Migration Rules
- Penamaan file migration harus deskriptif, misal `create_students_table`.
- Buat migration baru untuk setiap perubahan schema, jangan edit migration yang sudah dijalankan di produksi.
- Sertakan `foreignId()->constrained()` untuk relasi.
- Gunakan `up()` dan `down()` untuk rollback jelas.
- Jika perlu, gunakan foreign key cascade dengan hati-hati.

## Seeder Rules
- Gunakan `database/seeders/DatabaseSeeder.php` sebagai entrypoint utama.
- Buat seeder khusus untuk data referensi: role, permission, academic years, semesters, subjects.
- Seeder hanya untuk data development / initial seed, jangan untuk data produksi sensitif.
- Pastikan seeder dapat dijalankan ulang tanpa duplikasi yang merusak.

## Factory Rules
- Tempatkan factory di `database/factories`.
- Gunakan Faker untuk data uji yang realistis.
- Definisikan state jika diperlukan untuk kondisi khusus.
- Gunakan factory dalam test untuk membuat data secara konsisten.

## Authentication Rules
- Gunakan flow login/registrasi/reset password yang sudah tersedia di `AuthController`.
- Semua route yang membutuhkan login harus berada di middleware `auth`.
- Gunakan CSRF token pada setiap form (`@csrf`).
- Jika menggunakan token API, pastikan `sanctum` dikonfigurasi dengan benar.

## Authorization Rules
- Gunakan middleware role-based: `role:admin`, `role:teacher`, `student`.
- Gunakan policies untuk CRUD model yang sensitif.
- Jangan izinkan akses data jika user tidak berwenang.
- Validation harus dijalankan sebelum aksi penyimpanan/ubah/hapus.

## Dashboard Rules
- Dashboard harus menampilkan ringkasan role-aware.
- Gunakan card statistik, grafik ringkas, dan link action penting.
- Pastikan dashboard tetap sederhana dan mudah dibaca.
- Jangan menampilkan data yang tidak relevan untuk peran user.

## Landing Page Rules
- Landing page `/` harus sederhana dan fokus pada informasi umum.
- Tidak menampilkan data internal sensitif.
- Memuat tautan login/registrasi jika belum authenticated.
- Pastikan layout konsisten dengan tema aplikasi.

## Route Rules
- Kelompokkan route berdasarkan middleware dan role.
- Gunakan nama route konsisten seperti `admin.users.index`, `teacher.grades.store`.
- Gunakan route HTTP yang tepat: `GET` untuk tampilan, `POST` untuk create, `PUT` untuk update, `DELETE` untuk delete.
- Putuskan route resource-style bila sesuai.

## Middleware Rules
- `auth` harus membungkus semua route yang memerlukan login.
- `role:admin` untuk akses admin panel.
- `role:teacher` untuk halaman guru.
- `student` custom middleware untuk akses siswa.
- Tambahkan middleware lain hanya jika logika cross-cutting diperlukan.

## Controller Rules
- Controller hanya melakukan: authorize, validasi, pemanggilan model/service, redirect/view.
- Hindari query builder kompleks di controller; gunakan model atau repository jika perlu.
- Gunakan dependency injection untuk service bila diperlukan.
- Pastikan controller mengembalikan view dengan data yang cukup dan ringkas.

## Model Rules
- Deklarasikan relasi `hasMany`, `belongsTo`, `belongsToMany` secara eksplisit.
- Gunakan `$fillable` untuk proteksi mass assignment pada model.
- Gunakan trait `HasFactory` pada model yang memiliki factory.
- Tambahkan accessor/mutator hanya jika perlu transformasi data.

## Blade Rules
- Gunakan layout utama `resources/views/layouts/app.blade.php`.
- Pisahkan bagian UI ke komponen Blade reusable.
- Gunakan directive Blade `@csrf`, `@error`, `@foreach`, `@if` dengan benar.
- Kelola pesan error validasi di sekitar input.
- Hindari markup HTML berulang dengan komponen `x-input`, `x-select`, `x-textarea`, `x-button`.

## Component Rules
- Komponen Blade harus reusable, menerima props dan attribute bag.
- Tempatkan komponen di `resources/views/components`.
- Gunakan komponen untuk field form, card, tabel, footer, header, tombol.
- Komponen harus mendukung slot dan default value bila cocok.

## Security Rules
- Selalu validasi input dengan `FormRequest`.
- Gunakan CSRF protection pada form.
- Gunakan policy dan middleware untuk otorisasi.
- Escape output Blade default untuk mencegah XSS.
- Jangan mengungkap data sensitif di view.
- Pastikan file upload dan akses file dienforce dengan benar jika ada.

## Performance Rules
- Gunakan eager loading pada relasi yang sering diakses.
- Minify asset via Vite build untuk produksi.
- Gunakan cache query bila perlu untuk halaman yang berat.
- Hindari query N+1 pada view tabel dan daftar.

## Git Workflow
- Branch feature untuk setiap perubahan: `feature/<deskripsi>`, `fix/<deskripsi>`, `chore/<deskripsi>`.
- Commit message jelas dan ringkas.
- Pull request harus review sebelum merge.
- Gunakan `git pull --rebase` saat sinkronisasi branch.
- Jangan commit file vendor atau environment secrets.

## Naming Convention
- Class / model: PascalCase.
- Controller: `SomethingController`.
- Policy: `SomethingPolicy`.
- FormRequest: `StoreSomethingRequest`, `UpdateSomethingRequest`.
- Blade file: snake_case dengan folder sesuai area, misal `admin/users.blade.php`.
- Route name: dot notation `admin.users.index`.
- CSS/JS asset: `resources/css/app.css`, `resources/js/app.js`.

## Testing Standard
- Gunakan Pest untuk fitur dan unit test.
- Buat test untuk route utama, otorisasi, validasi form, dan operasi CRUD.
- Gunakan factory untuk membuat data test.
- Pastikan test dapat dijalankan dengan `composer test`.
- Jangan gunakan `dd()` di test.

## Deployment Standard
- Gunakan `.env` terpisah untuk environment production.
- Jalankan `composer install --optimize-autoloader --no-dev`.
- Jalankan `npm install` dan `npm run build` untuk asset.
- Jalankan migration dengan `php artisan migrate --force`.
- Pastikan permission storage dan bootstrap/cache dapat ditulis.
- Jangan commit `.env` ke repo.

## Anti Hallucination Rules
- Jangan membuat asumsi kode backend baru tanpa memeriksa repo.
- Gunakan file dan konfigurasi yang ada sebagai sumber kebenaran.
- Validasi fakta dengan `composer.json`, `package.json`, `routes/web.php`, dan struktur folder.
- Jangan menambah atau mengubah logika backend kecuali diminta eksplisit.
- Tulis aturan yang dapat diverifikasi terhadap kode riil.

## Checklist
- [ ] Project Identity ditentukan
- [ ] Scope dan batasan ditetapkan
- [ ] Tech stack sesuai repo
- [ ] Coding standard jelas
- [ ] Struktur folder dijelaskan
- [ ] MVC dipetakan
- [ ] Laravel rules diterapkan
- [ ] Tailwind rules diterapkan
- [ ] Database/migration/seeder/factory rule ditulis
- [ ] Auth/authorization rule dipastikan
- [ ] Dashboard/landing page rule ditentukan
- [ ] Route/middleware/controller/model/blade/component rule dibuat
- [ ] Security and performance rule ditulis
- [ ] Git workflow dan naming convention dicantumkan
- [ ] Testing dan deployment standard dicantumkan
- [ ] Anti-hallucination rule tersedia
- [ ] Dokumen ini siap dijadikan panduan pengembangan
