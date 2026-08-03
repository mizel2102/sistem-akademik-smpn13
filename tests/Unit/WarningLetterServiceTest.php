<?php

namespace Tests\Unit;

use App\Exceptions\WarningLetterException;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use App\Models\WarningLetter;
use App\Services\NotificationService;
use App\Services\WarningLetterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WarningLetterServiceTest extends TestCase
{
    use RefreshDatabase;

    private WarningLetterService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(WarningLetterService::class);
        Role::firstOrCreate(['name' => 'guru-bk', 'guard_name' => 'web']);
    }

    public function test_determine_level_is_null_below_alpha_threshold(): void
    {
        [$student, $semester] = $this->studentWithSemester(2);

        $this->assertNull($this->service->determineSpLevel($student, $semester));
    }

    public function test_determine_level_returns_sp1_for_three_to_five_alpha(): void
    {
        [$student, $semester] = $this->studentWithSemester(3);

        $this->assertSame(1, $this->service->determineSpLevel($student, $semester));
    }

    public function test_sp2_requires_an_active_sp1(): void
    {
        [$student, $semester] = $this->studentWithSemester(6);

        $this->assertNull($this->service->determineSpLevel($student, $semester));

        $issuer = User::factory()->create();
        WarningLetter::create([
            'student_id' => $student->id,
            'issued_by' => $issuer->id,
            'type' => 'SP1',
            'reason' => 'Alpha berulang',
            'issued_at' => now(),
        ]);

        $this->assertSame(2, $this->service->determineSpLevel($student->fresh(), $semester));
    }

    public function test_sp3_requires_an_active_sp2(): void
    {
        [$student, $semester] = $this->studentWithSemester(9);
        $issuer = User::factory()->create();

        WarningLetter::create([
            'student_id' => $student->id,
            'issued_by' => $issuer->id,
            'type' => 'SP1',
            'reason' => 'Alpha berulang',
            'issued_at' => now(),
        ]);

        $this->assertNull($this->service->determineSpLevel($student->fresh(), $semester));

        WarningLetter::create([
            'student_id' => $student->id,
            'issued_by' => $issuer->id,
            'type' => 'SP2',
            'reason' => 'Alpha tetap tinggi',
            'issued_at' => now(),
        ]);

        $this->assertSame(3, $this->service->determineSpLevel($student->fresh(), $semester));
    }

    public function test_issue_and_revoke_warning_letter(): void
    {
        [$student] = $this->studentWithSemester(0);
        $issuer = User::factory()->create();
        $bkUser = User::factory()->create();
        $bkUser->assignRole('guru-bk');

        $letter = $this->service->issueWarningLetter($student, 1, 'Alpha mencapai batas.', $issuer);

        $this->assertSame('SP1', $letter->type);
        $this->assertDatabaseHas('warning_letters', ['id' => $letter->id, 'type' => 'SP1']);
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $bkUser->id,
            'type' => 'sp_issued',
        ]);

        $this->assertTrue($this->service->revokeWarningLetter($letter, 'Siswa sudah dibina.'));
        $this->assertDatabaseHas('warning_letters', [
            'id' => $letter->id,
            'revoke_reason' => 'Siswa sudah dibina.',
        ]);
        $this->assertFalse($this->service->revokeWarningLetter($letter->fresh(), 'Duplikat pencabutan.'));
    }

    public function test_issue_sp2_fails_without_active_sp1(): void
    {
        [$student] = $this->studentWithSemester(0);
        $issuer = User::factory()->create();

        $this->expectException(WarningLetterException::class);
        $this->service->issueWarningLetter($student, 2, 'Melewati urutan.', $issuer);
    }

    private function studentWithSemester(int $alphaCount): array
    {
        $year = AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'active' => true,
        ]);
        $semester = Semester::create([
            'academic_year_id' => $year->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
            'active' => true,
        ]);
        $student = Student::create([
            'user_id' => User::factory()->create()->id,
            'student_number' => 'S-' . $alphaCount . '-' . uniqid(),
            'grade_level' => '7',
        ]);

        for ($index = 0; $index < $alphaCount; $index++) {
            Attendance::create([
                'student_id' => $student->id,
                'semester_id' => $semester->id,
                'status' => 'alpha',
                'latitude' => -0.05,
                'longitude' => 109.3,
                'distance' => 10,
                'attendance_time' => now(),
            ]);
        }

        return [$student, $semester];
    }
}
