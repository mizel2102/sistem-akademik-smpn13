<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $bkRole = Role::firstOrCreate(['name' => 'guru-bk', 'guard_name' => 'web']);

        $permissions = [
            'view dashboard',
            'manage users',
            'manage roles',
            'manage academic records',
            'manage counseling',
            'manage warning letters',
            'view_counseling',
            'create_counseling',
            'edit_counseling',
            'view_warning_letter',
            'create_warning_letter',
            'view_alpha_report',
            'send_notification',
            'view_student_attendance',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole->syncPermissions(Permission::all());
        $bkRole->syncPermissions(Permission::whereIn('name', [
            'manage counseling',
            'manage warning letters',
            'view dashboard',
            'view_counseling',
            'create_counseling',
            'edit_counseling',
            'view_warning_letter',
            'create_warning_letter',
            'view_alpha_report',
            'send_notification',
            'view_student_attendance',
        ])->get());

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
            ]
        );
        $adminUser->assignRole($adminRole);

        $teacherUser = User::firstOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Mata Pelajaran',
                'password' => bcrypt('password'),
            ]
        );
        $teacherUser->assignRole($teacherRole);

        $bkUser = User::firstOrCreate(
            ['email' => 'guru.bk@example.com'],
            [
                'name' => 'Guru Bimbingan Konseling',
                'password' => bcrypt('password'),
            ]
        );
        $bkUser->assignRole($bkRole);

        $studentUser = User::firstOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa Contoh',
                'password' => bcrypt('password'),
            ]
        );
        $studentUser->assignRole($studentRole);
    }
}
