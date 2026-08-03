<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\SchoolReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SchoolReportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_summary_returns_expected_keys_and_zero_counts_when_database_is_empty(): void
    {
        $service = new SchoolReportService();

        $summary = $service->summary();

        $expectedKeys = [
            'totalUsers',
            'adminCount',
            'teacherCount',
            'studentCount',
            'totalRoles',
            'classCount',
            'subjectCount',
            'academicYearCount',
            'semesterCount',
            'scheduleCount',
            'announcementCount',
            'gradeCount',
            'attendanceCount',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $summary);
            $this->assertSame(0, $summary[$key]);
        }
    }

    public function test_summary_counts_users_by_role(): void
    {
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('teacher', 'web');
        Role::findOrCreate('student', 'web');

        $admin = User::factory()->create();
        $teacher = User::factory()->create();

        $admin->assignRole('admin');
        $teacher->assignRole('teacher');

        $service = new SchoolReportService();

        $summary = $service->summary();

        $this->assertSame(2, $summary['totalUsers']);
        $this->assertSame(1, $summary['adminCount']);
        $this->assertSame(1, $summary['teacherCount']);
        $this->assertSame(0, $summary['studentCount']);
    }
}
