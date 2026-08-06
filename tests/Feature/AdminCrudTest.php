<?php

namespace Tests\Feature;

use App\Models\AcademicClass;
use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\WarningLetter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Ensure roles table exists for spatie
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'teacher']);
        Role::firstOrCreate(['name' => 'student']);
        Role::firstOrCreate(['name' => 'guru-bk', 'guard_name' => 'web']);
    }

    private function createUserWithRole(string $role, array $attributes = []): User
    {
        $user = User::factory()->create($attributes);
        $user->assignRole($role);

        return $user;
    }

    public function test_admin_can_create_academic_year_and_semester_and_subject_schedule_and_announcement()
    {
        /** @var User $admin */
        $admin = $this->createUserWithRole('admin', ['email' => 'admin@example.com']);

        // Create teacher and class
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-001',
            'phone' => '081234567890',
        ]);
        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7A',
            'room' => 'A1',
            'schedule' => 'Senin, 08:00 - 09:30',
        ]);

        $this->actingAs($admin);

        // Academic Year
        $yearData = [
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
        ];

        $response = $this->post(route('admin.academic-years.store'), $yearData);
        $response->assertRedirect(route('admin.academic-years.index'));
        $this->assertDatabaseHas('academic_years', ['name' => '2026/2027']);

        $year = AcademicYear::query()->where('name', '2026/2027')->first();

        // Semester
        $semData = [
            'academic_year_id' => $year->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ];
        $response = $this->post(route('admin.semesters.store'), $semData);
        $response->assertRedirect(route('admin.semesters.index'));
        $this->assertDatabaseHas('semesters', ['name' => 'Ganjil']);

        $semester = Semester::query()->where('name', 'Ganjil')->first();

        // Subject
        $subjectData = [
            'name' => 'Matematika',
            'code' => 'MATH-01',
            'teacher_id' => $teacher->id,
        ];
        $response = $this->post(route('admin.subjects.store'), $subjectData);
        $response->assertRedirect(route('admin.subjects.index'));
        $this->assertDatabaseHas('subjects', ['name' => 'Matematika']);

        $subject = Subject::query()->where('name', 'Matematika')->first();

        // Schedule
        $scheduleData = [
            'academic_class_id' => $class->id,
            'academic_year_id' => $year->id,
            'semester_id' => $semester->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'day' => 'Monday',
            'start_time' => '08:00',
            'end_time' => '09:30',
        ];

        $response = $this->post(route('admin.schedules.store'), $scheduleData);
        $response->assertRedirect(route('admin.schedules.index'));
        $this->assertDatabaseHas('schedules', ['day' => 'Monday']);

        // Announcement
        $announcementData = [
            'title' => 'Pengumuman Ujian',
            'content' => 'Jadwal ujian semester akan segera diumumkan.',
            'audience' => 'all',
            'published_at' => now()->toDateTimeString(),
        ];

        $response = $this->post(route('admin.announcements.store'), $announcementData);
        $response->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', [
            'title' => 'Pengumuman Ujian',
            'user_id' => $admin->id,
        ]);
    }

    public function test_admin_cannot_create_conflicting_class_schedule(): void
    {
        /** @var User $admin */
        $admin = $this->createUserWithRole('admin');

        [$teacher, $class, $year, $semester, $subject] = $this->scheduleDependencies();

        Schedule::create([
            'academic_class_id' => $class->id,
            'academic_year_id' => $year->id,
            'semester_id' => $semester->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'day' => 'Monday',
            'start_time' => '08:00',
            'end_time' => '09:30',
        ]);

        $otherTeacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-002',
            'phone' => '081234567891',
        ]);
        $otherSubject = Subject::create([
            'name' => 'Bahasa Indonesia',
            'code' => 'BIN-01',
            'teacher_id' => $otherTeacher->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.schedules.store'), [
            'academic_class_id' => $class->id,
            'academic_year_id' => $year->id,
            'semester_id' => $semester->id,
            'subject_id' => $otherSubject->id,
            'teacher_id' => $otherTeacher->id,
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:00',
        ]);

        $response->assertSessionHasErrors('start_time');
        $this->assertDatabaseCount('schedules', 1);
    }

    public function test_admin_cannot_create_conflicting_teacher_schedule(): void
    {
        /** @var User $admin */
        $admin = $this->createUserWithRole('admin');

        [$teacher, $class, $year, $semester, $subject] = $this->scheduleDependencies();

        Schedule::create([
            'academic_class_id' => $class->id,
            'academic_year_id' => $year->id,
            'semester_id' => $semester->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'day' => 'Tuesday',
            'start_time' => '08:00',
            'end_time' => '09:30',
        ]);

        $otherClass = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7B',
            'room' => 'B1',
            'schedule' => 'Selasa, 09:00 - 10:30',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.schedules.store'), [
            'academic_class_id' => $otherClass->id,
            'academic_year_id' => $year->id,
            'semester_id' => $semester->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'day' => 'Tuesday',
            'start_time' => '09:00',
            'end_time' => '10:00',
        ]);

        $response->assertSessionHasErrors('start_time');
        $this->assertDatabaseCount('schedules', 1);
    }

    public function test_admin_can_view_teacher_create_page(): void
    {
        $admin = $this->createUserWithRole('admin', ['email' => 'admin2@example.com']);

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-005',
            'phone' => '081234567894',
        ]);

        $subject = Subject::create([
            'name' => 'Fisika',
            'code' => 'PHYS-01',
            'teacher_id' => $teacher->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.teachers.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Guru');
    }

    public function test_admin_can_view_student_create_page(): void
    {
        $admin = $this->createUserWithRole('admin', ['email' => 'admin3@example.com']);

        $teacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-003',
            'phone' => '081234567892',
        ]);
        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7C',
            'room' => 'C1',
            'schedule' => 'Rabu, 10:00 - 11:30',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.students.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Siswa');
        $response->assertSeeText($class->name);
    }

    public function test_admin_can_access_student_report_page_from_student_details(): void
    {
        $admin = $this->createUserWithRole('admin', ['email' => 'admin6@example.com']);

        $teacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-006',
            'phone' => '081234567896',
        ]);
        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '8B',
            'room' => 'B2',
            'schedule' => 'Kamis, 10:00 - 11:30',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-006',
            'grade_level' => '8',
            'academic_class_id' => $class->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.students.show', $student));

        $response->assertStatus(200);
        $response->assertSeeText('Lihat Rapor');
        $response->assertSeeText('Unduh PDF Rapor');
        $response->assertSeeText($student->user->name);
        $response->assertSeeText($class->name);

        $reportResponse = $this->actingAs($admin)->get(route('admin.reports.rapor', $student));
        $reportResponse->assertStatus(200);
        $reportResponse->assertSeeText('RAPOR SISWA');
    }

    public function test_admin_student_list_has_direct_pdf_report_link(): void
    {
        $admin = $this->createUserWithRole('admin', ['email' => 'admin8@example.com']);

        $teacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-008',
            'phone' => '081234567898',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '8D',
            'room' => 'D1',
            'schedule' => 'Senin, 14:00 - 15:30',
        ]);

        $student = Student::create([
            'user_id' => $this->createUserWithRole('student')->id,
            'student_number' => 'S-008',
            'grade_level' => '8',
            'academic_class_id' => $class->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.students.index'));

        $response->assertStatus(200);
        $response->assertSee(route('admin.reports.rapor', $student));
        $response->assertSee(route('admin.reports.rapor.pdf', $student));
    }

    public function test_guru_bk_can_access_counseling_and_warning_letter_pages(): void
    {
        $bkUser = $this->createUserWithRole('guru-bk');

        $response = $this->actingAs($bkUser)->get(route('admin.counselings.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Konseling');

        $response = $this->actingAs($bkUser)->get(route('admin.warning-letters.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Surat Peringatan');
    }

    public function test_guru_bk_can_create_counseling_record(): void
    {
        $bkUser = $this->createUserWithRole('guru-bk');

        $teacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-010',
            'phone' => '081234567899',
        ]);
        $academicClass = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '9A',
            'room' => 'A1',
            'schedule' => 'Senin, 10:00 - 11:30',
        ]);

        $student = Student::create([
            'user_id' => $this->createUserWithRole('student')->id,
            'student_number' => 'S-010',
            'grade_level' => '9',
            'academic_class_id' => $academicClass->id,
        ]);

        $response = $this->actingAs($bkUser)->post(route('admin.counselings.store'), [
            'student_id' => $student->id,
            'session_at' => '2026-08-01 10:00:00',
            'notes' => 'Diskusi mengenai motivasi belajar',
            'follow_up' => 'Anjurkan jadwal belajar mingguan',
        ]);

        $response->assertRedirect(route('admin.counselings.index'));
        $this->assertDatabaseHas('counselings', [
            'student_id' => $student->id,
            'counselor_id' => $bkUser->id,
            'notes' => 'Diskusi mengenai motivasi belajar',
        ]);
    }

    public function test_guru_bk_can_create_warning_letter(): void
    {
        $bkUser = $this->createUserWithRole('guru-bk');

        $teacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-011',
            'phone' => '081234567900',
        ]);
        $academicClass = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '9B',
            'room' => 'B1',
            'schedule' => 'Selasa, 11:00 - 12:30',
        ]);

        $student = Student::create([
            'user_id' => $this->createUserWithRole('student')->id,
            'student_number' => 'S-011',
            'grade_level' => '9',
            'academic_class_id' => $academicClass->id,
        ]);

        $response = $this->actingAs($bkUser)->post(route('admin.warning-letters.store'), [
            'student_id' => $student->id,
            'type' => 'SP1',
            'reason' => 'Sering terlambat datang',
            'issued_at' => '2026-08-01',
        ]);

        $response->assertRedirect(route('admin.warning-letters.index'));
        $this->assertDatabaseHas('warning_letters', [
            'student_id' => $student->id,
            'issued_by' => $bkUser->id,
            'type' => 'SP1',
            'reason' => 'Sering terlambat datang',
        ]);
    }

    public function test_guru_bk_can_download_warning_letter_pdf(): void
    {
        $bkUser = $this->createUserWithRole('guru-bk');

        $teacher = Teacher::create([
            'user_id' => $this->createUserWithRole('teacher')->id,
            'nip' => 'T-012',
            'phone' => '081234567901',
        ]);
        $academicClass = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '9C',
            'room' => 'C1',
            'schedule' => 'Rabu, 08:00 - 09:30',
        ]);

        $student = Student::create([
            'user_id' => $this->createUserWithRole('student')->id,
            'student_number' => 'S-012',
            'grade_level' => '9',
            'academic_class_id' => $academicClass->id,
        ]);

        $letter = WarningLetter::create([
            'student_id' => $student->id,
            'type' => 'SP1',
            'reason' => 'Test PDF export',
            'issued_at' => '2026-08-01',
            'issued_by' => $bkUser->id,
        ]);

        $response = $this->actingAs($bkUser)->get(route('admin.warning-letters.pdf', $letter));
        $response->assertStatus(200);
        $this->assertStringContainsString('attachment', $response->headers->get('content-disposition'));
    }

    public function test_guru_bk_can_view_counseling_create_page(): void
    {
        $bkUser = $this->createUserWithRole('guru-bk');

        $response = $this->actingAs($bkUser)->get(route('admin.counselings.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Konseling');
        $response->assertSeeText('Simpan Catatan');
        $response->assertSeeText('Siswa');
    }

    public function test_guru_bk_can_view_warning_letter_create_page(): void
    {
        $bkUser = $this->createUserWithRole('guru-bk');

        $response = $this->actingAs($bkUser)->get(route('admin.warning-letters.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Surat Peringatan');
        $response->assertSeeText('Jenis Surat');
        $response->assertSeeText('Buat Surat Peringatan');
    }

    public function test_admin_can_view_academic_class_create_page(): void
    {
        $admin = $this->createUserWithRole('admin', ['email' => 'admin4@example.com']);

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-004',
            'phone' => '081234567893',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.academic-classes.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Kelas Akademik');
    }

    public function test_removed_admin_create_routes_return_not_found(): void
    {
        $admin = $this->createUserWithRole('admin', ['email' => 'admin5@example.com']);

        $this->actingAs($admin)->get('admin/academic-years/create')->assertNotFound();
        $this->actingAs($admin)->get('admin/subjects/create')->assertNotFound();
        $this->actingAs($admin)->get('admin/semesters/create')->assertNotFound();
        $this->actingAs($admin)->get('admin/schedules/create')->assertNotFound();
        $this->actingAs($admin)->get('admin/announcements/create')->assertNotFound();
    }

    private function scheduleDependencies(): array
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create(['user_id' => $teacherUser->id, 'nip' => 'T-001', 'phone' => '081234567890']);
        $class = AcademicClass::create(['teacher_id' => $teacher->id, 'name' => '7A', 'room' => 'A1', 'schedule' => 'Senin, 08:00 - 09:30']);
        $year = AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
        ]);
        $semester = Semester::create([
            'academic_year_id' => $year->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ]);
        $subject = Subject::create([
            'name' => 'Matematika',
            'code' => 'MATH-01',
            'teacher_id' => $teacher->id,
        ]);

        return [$teacher, $class, $year, $semester, $subject];
    }
}
