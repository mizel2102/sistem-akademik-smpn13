# TODO — Pengembangan Modul Guru BK (Fase 6)

## ✅ SEMUA SELESAI — Status: Complete

### Step 1: Event & Listener Pipeline ✅
- [x] `app/Events/AlphaThresholdReached.php` — created
- [x] `app/Listeners/NotifyGuruBK.php` — created
- [x] Daftarkan event/listener di AppServiceProvider — done

### Step 2: Perluas AttendanceService ✅
- [x] `checkAlphaThreshold(Student $student, Semester $semester)` — alpha threshold check + trigger event
- [x] `storeAttendances(array $attendances, Teacher $teacher)` — bulk store + threshold check per student
- [x] `getMonthlyRecap(AcademicClass $class, int $month, int $year)` — rekap bulanan

### Step 3: Perluas Attendance Model ✅
- [x] Scope `alpha()` — filter status alpha
- [x] Scope `byStudent($studentId)` — filter by student
- [x] Scope `bySemester($semesterId)` — filter by semester
- [x] Static method `countAlpha(Student $student, Semester $semester)` — count alpha
- [x] Method `isExceedingAlphaLimit(int $limit = 3)` — exceeding check

### Step 4: BK/CounselingController ✅
- [x] Controller — CRUD pembinaan dengan filter search
- [x] View `bk/counselings/index.blade.php` — tabel + search
- [x] View `bk/counselings/create.blade.php` — form dengan student selector

### Step 5: BK/MonitoringController ✅
- [x] Controller — alpha monitoring dengan filter semester + min alpha
- [x] View `bk/monitoring/alpha.blade.php` — stat cards, chart, filter, tabel, status update

### Step 6: BK/WarningLetterController ✅
- [x] Controller — CRUD + revoke + download PDF (reuse WarningLetterService)
- [x] View `bk/warning-letters/index.blade.php` — tabel + filter (type, status, search)
- [x] View `bk/warning-letters/create.blade.php` — form + alpha info per student
- [x] View `bk/warning-letters/show.blade.php` — detail + revoke action
- [x] View `bk/warning-letters/pdf.blade.php` — template PDF resmi format surat dinas

### Step 7: Update Routes ✅
- [x] Route grup `/bk/` — dashboard, counseling, monitoring, warning-letters

### Step 8: Update Sidebar Navigation ✅
- [x] Sidebar BK menu di app.blade.php — 4 menu (Dashboard BK, Monitoring Alpha, Pembinaan, Surat Peringatan)

### Step 9: DashboardService ✅
- [x] `app/Services/DashboardService.php` — statistics, alpha trend, SP distribution
