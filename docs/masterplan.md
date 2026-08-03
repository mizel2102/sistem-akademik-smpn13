# Analisis Mendalam, Prompting Guide & Masterplan
## Sistem Informasi Akademik SMPN 13 Sungai Raya

---

## BAGIAN 1 — ANALISIS MENDALAM SOURCE CODE

### 1.1 Inventarisasi Struktur Project

Berdasarkan analisis file listing RAR (269 file PHP/Blade/JS/CSS), berikut kondisi aktual project:

#### Controllers (25 file)
| Namespace | Controller | Status |
|---|---|---|
| Root | AcademicController, AcademicYearController, AnnouncementController, AttendanceController, AuthController, DashboardController, NotificationController, ProfileController, ScheduleController, SchoolController, SemesterController, SettingsController, SubjectController, UserController | ⚠️ Belum dipisah per role |
| Admin/ | AcademicClassController, CounselingController, ReportController, StudentController, TeacherController, WarningLetterController | ✅ Sudah dipisah |
| Teacher/ | AcademicController, ClassController, GradeController | ✅ Sudah dipisah |
| Student/ | AcademicController | ⚠️ Hanya 1 controller |
| — | CounselingBK/ | ❌ BELUM ADA |

**Temuan kritis:** Tidak ada namespace `CounselingBK/` atau `Guru BK/`. Modul Guru BK baru ada sebatas `CounselingController` di bawah Admin — belum berdiri sendiri sebagai role terpisah.

#### Models (14 model)
```
AcademicClass, AcademicYear, Announcement, Attendance,
Counseling, Grade, Schedule, Semester, Setting,
Student, Subject, Teacher, User, WarningLetter
```

**Yang belum ada:**
- `Notification` model (ada `NotificationController` tapi tidak ada model)
- `ActivityLog` model
- `SchoolProfile` model
- `News` / `Gallery` model
- `Report` model (laporan disimpan dinamis, tidak ada model)

#### Services Layer (15 service)
```
AcademicClassService, AcademicYearService, AnnouncementService,
AttendanceService, NotificationService, ScheduleService,
SchoolReportService, SemesterService, SettingsService,
StudentAcademicService, StudentService, SubjectService,
TeacherAcademicService, TeacherService
```

**Yang belum ada:**
- `CounselingService`
- `WarningLetterService`
- `GradeBKService` (monitoring nilai untuk BK)
- `ReportService` (abstraksi laporan PDF)
- `DashboardService` (aggregasi statistik)

#### Policies (12 policy)
```
AcademicClassAdminPolicy, AcademicClassPolicy, AcademicYearPolicy,
AnnouncementPolicy, AttendancePolicy, GradePolicy, SchedulePolicy,
SemesterPolicy, StudentPolicy, SubjectPolicy, TeacherPolicy, UserPolicy
```

**Yang belum ada:**
- `CounselingPolicy`
- `WarningLetterPolicy`
- `NotificationPolicy`

#### Database Migrations (17 migrasi)
```
users, cache, jobs, sessions, permission_tables,
personal_access_tokens, students, academic_classes, teachers,
grades, academic_class_student (pivot), attendances, subjects,
academic_years, semesters, schedules, announcements,
warning_letters, counselings, settings
```

Tambahan migrasi terbaru (Juli 2026):
- `add_student_missing_columns`
- `add_subject_semester_to_grades`
- `add_semester_to_attendances`
- `add_capacity_and_status_to_academic_classes`

**Yang belum ada sebagai tabel:**
- `notifications`
- `activity_logs`
- `school_profiles`
- `news`
- `galleries`
- `report_configs`

#### Views (Blade Templates)
**Admin:** academic-classes, academic-years, announcements, counselings, reports, roles, schedules, semesters, students, subjects, teachers, users, warning-letters + sub-views

**Teacher:** Tidak ditemukan folder `resources/views/teacher/` dalam listing → Views guru kemungkinan masih gabung atau belum lengkap

**Student:** Tidak ditemukan folder `resources/views/student/` dalam listing → Views siswa belum terpisah

**Guru BK:** Tidak ada folder `resources/views/bk/` → Modul BK hanya ada di sisi Admin, belum punya views sendiri

**Public:** alumni, berita, components (back-welcome, button, card-alumni, card-news, card-teacher, card, checkbox)

---

### 1.2 Temuan Kritis per Kategori

#### 🔴 CRITICAL — Harus diperbaiki sebelum go-live

1. **Role Guru BK belum independent.** Ada model `Counseling` dan `WarningLetter`, ada controller `Admin/CounselingController` dan `Admin/WarningLetterController`, tapi tidak ada:
   - Middleware role `guru_bk`
   - Route group `/bk/...`
   - Dashboard khusus BK
   - Views BK yang terpisah dari Admin

2. **NotificationController tanpa model.** `NotificationController` ada (778 bytes, kemungkinan stub), tapi tidak ada migration `notifications` table → notifikasi tidak akan persist.

3. **Route file sangat kecil.** `routes/web.php` gagal dibaca (file corrupt/encoding) tapi berdasarkan controller yang ada, routing kemungkinan belum menggunakan route grouping yang proper untuk 4 role.

4. **Database masih SQLite.** File `database.sqlite` dan `database.sqlite.bak` ada di repo — production seharusnya MySQL sesuai spesifikasi.

#### 🟡 MAJOR — Perlu diperbaiki dalam sprint pertama

5. **GradeController ada di Teacher/ tapi tidak ada Service-nya.** `Teacher/GradeController.php` ada tapi `GradeService` tidak ditemukan — logika nilai kemungkinan masih di controller.

6. **WarningLetter belum punya Service.** `Admin/WarningLetterController` ada tapi `WarningLetterService` tidak ada → bisnis logik SP1/SP2/SP3 belum terpisah.

7. **Student views belum ada namespace.** `Student/AcademicController` ada tapi tidak ada views di `resources/views/student/` → student mungkin belum bisa akses semua fiturnya.

8. **Teacher views tidak lengkap.** Ada `Teacher/ClassController` dan `Teacher/GradeController` tapi view folder teacher tidak muncul di listing.

#### 🟢 MINOR — Optimasi & polish

9. **Middleware hanya `EnsureStudentRole`.** Middleware lain (guru, admin, bk) tidak ditemukan — kemungkinan menggunakan Spatie Permission (`role:admin` etc) di route langsung, tapi perlu audit.

10. **SchoolReportService ada** (positif) tapi belum ada PDF template lengkap — hanya `rapor.blade.php` dan `rapor_pdf.blade.php`.

11. **Landing page sudah punya komponen dasar** (`card-teacher`, `card-news`, `back-welcome`) tapi belum ada komponen `hero`, `gallery`, `statistics`.

---

### 1.3 Pemetaan Gap antara Proposal vs Implementasi

| Fitur Proposal | Status Implementasi | Gap |
|---|---|---|
| Admin — Manajemen 4 Role | ⚠️ Parsial | Role BK belum full |
| Admin — Monitoring Absensi | ✅ Ada | Perlu grafik |
| Admin — Monitoring SP | ⚠️ Parsial | Hanya CRUD, belum dashboard |
| Guru — Input Absensi | ✅ Ada | |
| Guru — Input Nilai | ✅ Ada | |
| Guru — Input Rapor | ⚠️ Parsial | Service ada, view belum |
| Guru BK — Dashboard | ❌ Belum | |
| Guru BK — Monitoring Alpha | ❌ Belum | Logika auto-detect belum ada |
| Guru BK — SP1/SP2/SP3 | ⚠️ Parsial | Controller ada, urutan SP belum |
| Guru BK — Cetak SP PDF | ⚠️ Parsial | Template ada di Admin |
| Guru BK — Notifikasi | ❌ Belum | Model notification belum ada |
| Siswa — Rapor | ⚠️ Parsial | Service ada, view siswa belum |
| Siswa — SP Status | ❌ Belum | |
| Landing Page — Galeri | ❌ Belum | |
| Landing Page — Berita | ⚠️ Parsial | Route `berita/` ada |
| Landing Page — Alumni | ⚠️ Parsial | View ada, tapi data model? |

---

## BAGIAN 2 — PROMPTING GUIDE

Panduan ini dirancang untuk digunakan bersama AI assistant (Claude, GPT, Cursor, Copilot) dalam proses pengembangan. Setiap prompt dikategorikan per phase dan dirancang agar hasilnya langsung bisa diimplementasikan.

---

### 2.1 Template Prompt Universal (Selalu Dipakai)

Tempelkan konteks ini di awal setiap sesi baru:

```
KONTEKS PROJECT:
- Aplikasi: Sistem Informasi Akademik SMPN 13 Sungai Raya
- Framework: Laravel 11, Tailwind CSS, Alpine.js, Chart.js, DomPDF
- Database: MySQL
- Auth: Spatie Laravel Permission (multi-role)
- Role yang ada: admin, guru, guru_bk, siswa
- Arsitektur: Controller → Service → Model (Clean Architecture)
- Semua controller HARUS tipis — logika bisnis di Service layer
- Semua query HARUS menggunakan Eloquent Relationship + Eager Loading
- Semua validasi HARUS menggunakan Form Request
- Authorization menggunakan Policy + Middleware role
```

---

## BAGIAN 3 — MASTERPLAN PENGEMBANGAN DETAIL

### Overview Timeline

```
Phase 1  ████░░░░░░  Audit & Setup         (Minggu 1)
Phase 2  ░████░░░░░  Database & Models     (Minggu 1-2)
Phase 3  ░░████░░░░  Auth & Roles          (Minggu 2)
Phase 4  ░░░████░░░  Data Master           (Minggu 2-3)
Phase 5  ░░░░████░░  Modul Akademik        (Minggu 3-4)
Phase 6  ░░░░░████░  Modul Guru BK         (Minggu 4-5)
Phase 7  ░░░░░░███░  Dashboard             (Minggu 5-6)
Phase 8  ░░░░░░░███  Landing Page          (Minggu 6)
Phase 9  ░░░░░░░░██  PDF Reports           (Minggu 6-7)
Phase 10 ░░░░░░░░░█  Testing & Deploy      (Minggu 7-8)
```

---

### PHASE 1 — Audit & Environment Setup (3-5 hari)

**Tujuan:** Fondasi yang solid sebelum menulis kode baru.

**Checklist:**
- [ ] Clone repo, setup environment lokal (PHP 8.2+, MySQL 8)
- [ ] Jalankan migration dan seeder
- [ ] Audit semua route yang ada (`php artisan route:list`)
- [ ] Audit semua model relationship (buat ERD menggunakan `laravel-erd` package)
- [ ] Identifikasi N+1 query dengan Laravel Debugbar
- [ ] Audit semua view yang ada (list halaman yang bisa diakses)
- [ ] Dokumentasikan semua temuan dalam issue tracker (GitHub Issues)
- [ ] Setup code style (Laravel Pint)
- [ ] Setup PHPStan level 5 untuk static analysis

---

## LAMPIRAN — Prioritas Perbaikan Segera

Jika waktu terbatas, fokuskan energi di sini terlebih dahulu:

### 🔴 Prioritas 1 (Minggu 1) — Blocker
1. Buat route grup untuk 4 role dengan middleware
2. Buat seeder role + permission guru_bk
3. Buat BK/DashboardController + view dasar
4. Migration `notifications` table
5. Pindahkan SQLite → MySQL di konfigurasi

### 🟡 Prioritas 2 (Minggu 2) — Core Feature
6. WarningLetterService dengan logika SP1/SP2/SP3
7. Event AlphaThresholdReached + Listener NotifyGuruBK
8. Student views lengkap (dashboard, absensi, nilai)
9. Teacher views lengkap (dashboard, input absensi, input nilai)

### 🟢 Prioritas 3 (Minggu 3+) — Polish
10. Landing page redesign
11. Dashboard statistik dengan Chart.js
12. PDF template yang lebih profesional
13. Unit test coverage
14. Optimasi query dan caching
