<?php

namespace Tests\Feature;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AcademicFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'teacher']);
        Role::firstOrCreate(['name' => 'student']);
    }

    private function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_teacher_can_record_grade_for_enrolled_student(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-100',
            'phone' => '081234567800',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-100',
            'grade_level' => '7',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7A',
            'room' => 'A1',
            'schedule' => 'Senin, 08:00 - 09:30',
        ]);

        $student->classes()->attach($class->id);

        $response = $this->actingAs($teacherUser)->get(route('teacher.grades.index'));
        $response->assertStatus(200);
        $response->assertSee('Input Nilai');

        $response = $this->actingAs($teacherUser)->post(route('teacher.grades.store'), [
            'academic_class_id' => $class->id,
            'student_id' => $student->id,
            'assignment' => 'Ulangan Matematika',
            'score' => 85,
            'status' => 'passed',
        ]);

        $response->assertRedirect(route('teacher.grades.index'));
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'assignment' => 'Ulangan Matematika',
            'score' => 85,
            'status' => 'passed',
        ]);
    }

    public function test_student_can_submit_attendance_and_view_history(): void
    {
        Storage::fake('public');

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-101',
            'grade_level' => '7',
        ]);

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-101',
            'phone' => '081234567801',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7B',
            'room' => 'B1',
            'schedule' => 'Selasa, 10:00 - 11:30',
        ]);

        $student->classes()->attach($class->id);

        config([
            'app.school_latitude' => -6.2000000,
            'app.school_longitude' => 106.8166667,
        ]);

        $response = $this->actingAs($studentUser)->post(route('student.attendance.store'), [
            'academic_class_id' => $class->id,
            'latitude' => -6.2000000,
            'longitude' => 106.8166667,
            'distance' => 10,
            'attendance_time' => now()->toIso8601String(),
            'status' => 'present',
            'selfie' => UploadedFile::fake()->create('selfie.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('student.attendance.history'));
        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'status' => 'present',
            'distance' => 0,
        ]);

        $response = $this->actingAs($studentUser)->get(route('student.attendance.history'));
        $response->assertStatus(200);
        $response->assertSee('Riwayat Absensi');
        $response->assertSee('Hadir');
    }

    public function test_student_records_page_shows_attendance_percentage(): void
    {
        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-102',
            'grade_level' => '8',
        ]);

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-102',
            'phone' => '081234567802',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '8A',
            'room' => 'A2',
            'schedule' => 'Rabu, 11:00 - 12:30',
        ]);

        $student->classes()->attach($class->id);

        Attendance::create([
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'latitude' => -6.2,
            'longitude' => 106.8,
            'distance' => 20,
            'status' => 'present',
            'attendance_time' => now(),
        ]);

        $response = $this->actingAs($studentUser)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Kehadiran');
        $response->assertSee('100%');
    }

    public function test_teacher_can_delete_grade(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-103',
            'phone' => '081234567803',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-103',
            'grade_level' => '9',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '9A',
            'room' => 'A3',
            'schedule' => 'Kamis, 08:00 - 09:30',
        ]);

        $student->classes()->attach($class->id);

        $grade = Grade::create([
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'assignment' => 'Tugas IPA',
            'score' => 90,
            'status' => 'passed',
        ]);

        $response = $this->actingAs($teacherUser)->delete(route('teacher.grades.destroy', $grade->id));
        $response->assertRedirect(route('teacher.grades.index'));

        $this->assertDatabaseMissing('grades', ['id' => $grade->id]);
    }

    public function test_teacher_dashboard_shows_personal_summary(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-104',
            'phone' => '081234567804',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '10A',
            'room' => 'A4',
            'schedule' => 'Jumat, 09:00 - 10:30',
        ]);

        $student = Student::create([
            'user_id' => $this->createUserWithRole('student')->id,
            'student_number' => 'S-104',
            'grade_level' => '10',
        ]);
        $student->classes()->attach($class->id);

        Grade::create([
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'assignment' => 'Ulangan Fisika',
            'score' => 88,
            'status' => 'passed',
        ]);

        $response = $this->actingAs($teacherUser)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Kelas');
        $response->assertSee('Nilai');
        $response->assertSee('Siswa');
    }

    public function test_student_dashboard_shows_attendance_rate(): void
    {
        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-105',
            'grade_level' => '10',
        ]);

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-105',
            'phone' => '081234567805',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '10B',
            'room' => 'B2',
            'schedule' => 'Senin, 10:00 - 11:30',
        ]);
        $student->classes()->attach($class->id);

        Attendance::create([
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'latitude' => -6.2,
            'longitude' => 106.8,
            'distance' => 15,
            'status' => 'present',
            'attendance_time' => now(),
        ]);

        $response = $this->actingAs($studentUser)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Tingkat Kehadiran');
        $response->assertSee('Nilai Saya');
        $response->assertSee('Jadwal Saya');
    }

    public function test_admin_reports_page_shows_academic_overview_counts(): void
    {
        $adminUser = $this->createUserWithRole('admin');

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-110',
            'phone' => '081234567810',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-110',
            'grade_level' => '9',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '9C',
            'room' => 'C1',
            'schedule' => 'Jumat, 13:00 - 14:30',
        ]);

        $student->classes()->attach($class->id);

        $response = $this->actingAs($adminUser)->get(route('admin.reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Akademik');
        $response->assertSee('Data diambil langsung');
        $response->assertSee('Pilih Siswa');
        $response->assertSee('Jenis Laporan');
        $response->assertSee('Laporan PDF tersedia');
        $response->assertSee('Rapor mencakup semua nilai');
    }

    public function test_admin_can_download_reports_pdf(): void
    {
        $adminUser = $this->createUserWithRole('admin');

        $response = $this->actingAs($adminUser)->get(route('admin.reports.pdf'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('content-disposition');
    }

    public function test_admin_can_download_student_rapor_pdf(): void
    {
        $adminUser = $this->createUserWithRole('admin');

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-200',
            'phone' => '081234567820',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '8A',
            'room' => 'A2',
            'schedule' => 'Rabu, 08:00 - 09:30',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-200',
            'grade_level' => '8',
            'academic_class_id' => $class->id,
        ]);

        $semester = \App\Models\Semester::create([
            'academic_year_id' => \App\Models\AcademicYear::create([
                'name' => '2026/2027',
                'start_date' => '2026-07-01',
                'end_date' => '2027-06-30',
            ])->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ]);

        $subject = \App\Models\Subject::create([
            'name' => 'Biologi',
            'code' => 'BIO-01',
            'teacher_id' => $teacher->id,
        ]);

        \App\Models\Grade::create([
            'student_id' => $student->id,
            'academic_class_id' => $class->id,
            'subject_id' => $subject->id,
            'semester_id' => $semester->id,
            'assignment' => 'Ulangan IPA',
            'score' => 92,
            'status' => 'passed',
        ]);

        $response = $this->actingAs($adminUser)->get(route('admin.reports.rapor.pdf', $student));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('content-disposition');
        $this->assertNotEmpty($response->getContent());
    }

    public function test_teacher_dashboard_shows_sp2_recommendation_when_student_has_six_alphas(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-200',
            'phone' => '081234567888',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'NISN-6ALPHAS',
            'grade_level' => '7',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7B',
            'room' => 'B1',
            'schedule' => 'Senin, 08:00 - 09:30',
        ]);

        $student->classes()->attach($class->id);
        $student->update(['academic_class_id' => $class->id]);

        $academicYear = \App\Models\AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
        ]);
        $semester = \App\Models\Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ]);

        \App\Models\Schedule::create([
            'teacher_id' => $teacher->id,
            'academic_class_id' => $class->id,
            'academic_year_id' => $academicYear->id,
            'semester_id' => $semester->id,
            'subject_id' => \App\Models\Subject::create(['name' => 'Fisika', 'code' => 'FIS-01', 'teacher_id' => $teacher->id])->id,
            'day' => 'Monday',
            'start_time' => '08:00:00',
            'end_time' => '09:30:00',
        ]);

        for ($i = 0; $i < 6; $i++) {
            Attendance::create([
                'student_id' => $student->id,
                'academic_class_id' => $class->id,
                'status' => 'alpha',
                'latitude' => -0.0268033,
                'longitude' => 109.3193675,
                'distance' => 0,
                'attendance_time' => now()->subDays($i),
            ]);
        }

        $response = $this->actingAs($teacherUser)->get(route('teacher.attendance.index'));

        $response->assertStatus(200);
        $response->assertSee('Rekomendasi SP2');
        $response->assertSee($studentUser->name);
        $response->assertSee('7B');
    }

    public function test_teacher_can_see_issued_warning_letters_for_their_students(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-300',
            'phone' => '081234567899',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'NISN-SP-STUDENT',
            'grade_level' => '7',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7C',
            'room' => 'C1',
            'schedule' => 'Senin, 08:00 - 09:30',
        ]);

        $student->classes()->attach($class->id);
        $student->update(['academic_class_id' => $class->id]);

        $academicYear = \App\Models\AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
        ]);
        $semester = \App\Models\Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ]);

        \App\Models\Schedule::create([
            'teacher_id' => $teacher->id,
            'academic_class_id' => $class->id,
            'academic_year_id' => $academicYear->id,
            'semester_id' => $semester->id,
            'subject_id' => \App\Models\Subject::create(['name' => 'Biologi', 'code' => 'BIO-02', 'teacher_id' => $teacher->id])->id,
            'day' => 'Monday',
            'start_time' => '08:00:00',
            'end_time' => '09:30:00',
        ]);

        \App\Models\WarningLetter::create([
            'student_id' => $student->id,
            'issued_by' => $teacherUser->id,
            'semester_id' => $semester->id,
            'type' => 'SP1',
            'reason' => 'Sering terlambat dan tidak disiplin',
            'issued_at' => now(),
        ]);

        $response = $this->actingAs($teacherUser)->get(route('teacher.warning-letters.index'));

        $response->assertStatus(200);
        $response->assertSee('SP1');
        $response->assertSee('Sering terlambat dan tidak disiplin');
        $response->assertSee($studentUser->name);
    }

    public function test_teacher_privacy_assigned_classes_and_subjects(): void
    {
        // Teacher A (Math)
        $teacherUserA = $this->createUserWithRole('teacher');
        $subjectMath = \App\Models\Subject::create(['name' => 'Math', 'code' => 'MTH', 'teacher_id' => null]);
        $teacherA = Teacher::create([
            'user_id' => $teacherUserA->id,
            'nip' => 'T-301',
            'phone' => '081234567831',
            'subject_id' => $subjectMath->id,
        ]);
        $subjectMath->update(['teacher_id' => $teacherA->id]);

        // Teacher B (English)
        $teacherUserB = $this->createUserWithRole('teacher');
        $subjectEng = \App\Models\Subject::create(['name' => 'English', 'code' => 'ENG', 'teacher_id' => null]);
        $teacherB = Teacher::create([
            'user_id' => $teacherUserB->id,
            'nip' => 'T-302',
            'phone' => '081234567832',
            'subject_id' => $subjectEng->id,
        ]);
        $subjectEng->update(['teacher_id' => $teacherB->id]);

        // Class A (Teacher A is homeroom, Teacher B teaches English here via schedule)
        $classA = AcademicClass::create([
            'teacher_id' => $teacherA->id,
            'name' => '7A',
            'room' => 'A1',
            'schedule' => 'Senin, 08:00 - 09:30',
        ]);

        // Class B (Teacher B is homeroom, Teacher A has no schedule here)
        $classB = AcademicClass::create([
            'teacher_id' => $teacherB->id,
            'name' => '7B',
            'room' => 'B1',
            'schedule' => 'Selasa, 10:00 - 11:30',
        ]);

        $academicYear = \App\Models\AcademicYear::firstOrCreate([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
        ]);
        $semester = \App\Models\Semester::firstOrCreate([
            'academic_year_id' => $academicYear->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ]);

        // Teacher B has schedule in Class A
        \App\Models\Schedule::create([
            'teacher_id' => $teacherB->id,
            'academic_class_id' => $classA->id,
            'academic_year_id' => $academicYear->id,
            'semester_id' => $semester->id,
            'subject_id' => $subjectEng->id,
            'day' => 'Monday',
            'start_time' => '10:00:00',
            'end_time' => '11:30:00',
        ]);

        // 1. Check classes page for Teacher A: should see 7A, but NOT 7B
        $response = $this->actingAs($teacherUserA)->get(route('teacher.classes.index'));
        $response->assertStatus(200);
        $response->assertSee('7A');
        $response->assertDontSee('7B');

        // 2. Check classes page for Teacher B: should see 7A (schedule) and 7B (homeroom)
        $response = $this->actingAs($teacherUserB)->get(route('teacher.classes.index'));
        $response->assertStatus(200);
        $response->assertSee('7A');
        $response->assertSee('7B');

        // 3. Test grade operations and privacy
        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-301',
            'grade_level' => '7',
        ]);
        $student->classes()->attach($classA->id);

        // Grade created by Teacher B for English in Class A
        $grade = Grade::create([
            'student_id' => $student->id,
            'academic_class_id' => $classA->id,
            'subject_id' => $subjectEng->id,
            'semester_id' => $semester->id,
            'assignment' => 'English Homework',
            'score' => 88,
            'status' => 'passed',
        ]);

        // Teacher A (homeroom of 7A, but teaches Math) trying to delete English grade: should fail/not delete
        $response = $this->actingAs($teacherUserA)->delete(route('teacher.grades.destroy', $grade->id));
        $this->assertDatabaseHas('grades', ['id' => $grade->id]);

        // Teacher B (teaches English in 7A via schedule) trying to delete English grade: should succeed
        $response = $this->actingAs($teacherUserB)->delete(route('teacher.grades.destroy', $grade->id));
        $this->assertDatabaseMissing('grades', ['id' => $grade->id]);
    }

    public function test_student_can_join_class_using_valid_access_token(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-TOKEN-01',
            'phone' => '081234567899',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => '7D Token Test',
            'room' => 'D1',
            'schedule' => 'Senin, 08:00 - 09:30',
            'access_token' => 'SECRET',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-TOKEN-01',
            'grade_level' => '7',
        ]);

        // Attempt invalid token
        $response = $this->actingAs($studentUser)->post(route('student.join-class.process'), [
            'access_token' => 'WRONG1',
        ]);
        $response->assertSessionHasErrors(['access_token']);

        // Attempt valid token
        $response = $this->actingAs($studentUser)->post(route('student.join-class.process'), [
            'access_token' => 'SECRET',
        ]);
        $response->assertRedirect(route('student.join-class'));
        $response->assertSessionHas('success');

        $this->assertTrue($student->classes()->where('academic_class_id', $class->id)->exists());

        // Test token regeneration by teacher
        $response = $this->actingAs($teacherUser)->post(route('teacher.classes.regenerate-token', $class->id));
        $response->assertRedirect(route('teacher.classes.index'));
        $response->assertSessionHas('success');

        $class->refresh();
        $this->assertNotEquals('SECRET', $class->access_token);
        $this->assertEquals(6, strlen($class->access_token));
    }

    public function test_teacher_can_create_update_and_delete_class(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-CRUD-01',
            'phone' => '081234567890',
        ]);

        // 1. Create Class
        $response = $this->actingAs($teacherUser)->post(route('teacher.classes.store'), [
            'name' => 'PJOK 7A Baru',
            'room' => 'Ruang Olahraga 1',
            'schedule' => 'Selasa, 08:00 - 09:30',
        ]);
        $response->assertRedirect(route('teacher.classes.index'));
        $response->assertSessionHas('success');

        $class = AcademicClass::query()->where('name', '=', 'PJOK 7A Baru')->first();
        $this->assertNotNull($class);
        $this->assertEquals($teacher->id, $class->teacher_id);
        $this->assertNotEmpty($class->access_token);

        // 2. Update Class
        $response = $this->actingAs($teacherUser)->put(route('teacher.classes.update', $class->id), [
            'name' => 'PJOK 7A Update',
            'room' => 'Ruang Olahraga Utama',
            'schedule' => 'Selasa, 09:00 - 10:30',
        ]);
        $response->assertRedirect(route('teacher.classes.index'));
        $response->assertSessionHas('success');

        $class->refresh();
        $this->assertEquals('PJOK 7A Update', $class->name);

        // 3. Delete Class
        $response = $this->actingAs($teacherUser)->delete(route('teacher.classes.destroy', $class->id));
        $response->assertRedirect(route('teacher.classes.index'));
        $this->assertDatabaseMissing('academic_classes', ['id' => $class->id]);
    }

    public function test_student_can_view_enrolled_classes_and_enter_class_detail(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-STUDENT-CLASS-01',
            'phone' => '081234567891',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => 'Kelas IPA 7B',
            'room' => 'Lab IPA 2',
            'schedule' => 'Rabu, 08:00 - 09:30',
            'access_token' => 'IPA7B1',
        ]);

        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-ENTRANCE-01',
            'grade_level' => '7',
        ]);
        $student->classes()->attach($class->id);

        // 1. Visit Student Classes Index
        $response = $this->actingAs($studentUser)->get(route('student.classes.index'));
        $response->assertOk();
        $response->assertSee('Kelas IPA 7B');
        $response->assertSee('Masuk Kelas');

        // 2. Visit Student Class Detail (Show)
        $response = $this->actingAs($studentUser)->get(route('student.classes.show', $class->id));
        $response->assertOk();
        $response->assertSee('Ruang Kelas: Kelas IPA 7B');
        $response->assertSee('Lab IPA 2');
    }

    public function test_manual_student_join_class_via_token_per_grade_level(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-MANUAL-01',
            'phone' => '081234567892',
        ]);

        $studentUserA = $this->createUserWithRole('student');
        $studentA = Student::create([
            'user_id' => $studentUserA->id,
            'student_number' => 'S-G7-01',
            'grade_level' => '7',
        ]);

        $studentUserB = $this->createUserWithRole('student');
        $studentB = Student::create([
            'user_id' => $studentUserB->id,
            'student_number' => 'S-G8-01',
            'grade_level' => '8',
        ]);

        // Teacher creates a class for Grade VII (7)
        $response = $this->actingAs($teacherUser)->post(route('teacher.classes.store'), [
            'name' => 'Kelas VII A - PJOK',
            'room' => 'Lapangan Utama',
            'schedule' => 'Senin, 07:30 - 09:00',
        ]);
        $response->assertRedirect(route('teacher.classes.index'));

        $class = AcademicClass::query()->where('name', '=', 'Kelas VII A - PJOK')->first();
        $this->assertNotNull($class);

        // Grade 7 student joins via token -> succeeds
        $this->actingAs($studentUserA)->post(route('student.join-class.process'), [
            'access_token' => $class->access_token,
        ]);
        $this->assertTrue($class->students()->where('student_id', $studentA->id)->exists());

        // Grade 8 student tries joining Grade 7 class via token -> fails due to grade level mismatch
        $this->actingAs($studentUserB)->post(route('student.join-class.process'), [
            'access_token' => $class->access_token,
        ]);
        $this->assertFalse($class->students()->where('student_id', $studentB->id)->exists());
    }

    public function test_student_cannot_join_class_of_different_grade_level(): void
    {
        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-LEVEL-01',
            'phone' => '081234567893',
        ]);

        $classG8 = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => 'Kelas VIII B',
            'room' => 'Ruang 8B',
            'schedule' => 'Rabu, 09:00 - 10:30',
            'access_token' => 'TOK8B',
        ]);

        $studentUserG7 = $this->createUserWithRole('student');
        $studentG7 = Student::create([
            'user_id' => $studentUserG7->id,
            'student_number' => 'S-G7-MISMATCH',
            'grade_level' => '7',
        ]);

        // Grade 7 student trying to join Grade 8 class via token -> should fail
        $response = $this->actingAs($studentUserG7)->post(route('student.join-class.process'), [
            'access_token' => 'TOK8B',
        ]);
        $response->assertSessionHasErrors(['access_token']);
    }

    public function test_attendance_late_status_tracking(): void
    {
        $studentUser = $this->createUserWithRole('student');
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S-LATE-TEST',
            'grade_level' => '7',
        ]);

        $teacherUser = $this->createUserWithRole('teacher');
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => 'T-LATE-TEST',
            'phone' => '081234567899',
        ]);

        $class = AcademicClass::create([
            'teacher_id' => $teacher->id,
            'name' => 'Kelas VII A',
            'room' => 'Ruang 7A',
            'schedule' => 'Senin, 07:00 - 08:30',
        ]);

        $schoolLat = (float) config('app.school_latitude');
        $schoolLng = (float) config('app.school_longitude');

        // 1. Attendance at 06:55 (within 06:45 + 15m tolerance = 07:00 cutoff) -> 'present'
        $responseOnTime = $this->actingAs($studentUser)->post(route('student.attendance.store'), [
            'academic_class_id' => $class->id,
            'latitude' => $schoolLat,
            'longitude' => $schoolLng,
            'distance' => 0,
            'attendance_time' => now()->format('Y-m-d') . ' 06:55:00',
            'status' => 'present',
        ]);
        $responseOnTime->assertRedirect(route('student.attendance.history'));
        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'status' => 'present',
        ]);

        // 2. Attendance at 07:05 (after 07:00 cutoff) -> automatically marked 'late'
        $responseLate = $this->actingAs($studentUser)->post(route('student.attendance.store'), [
            'academic_class_id' => $class->id,
            'latitude' => $schoolLat,
            'longitude' => $schoolLng,
            'distance' => 0,
            'attendance_time' => now()->format('Y-m-d') . ' 07:05:00',
            'status' => 'present',
        ]);
        $responseLate->assertRedirect(route('student.attendance.history'));
        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'status' => 'late',
        ]);
    }
}
