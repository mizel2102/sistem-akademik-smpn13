<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use App\Models\AcademicClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nis']) || !isset($row['nama'])) {
            return null;
        }

        // Cari atau buat User
        $user = User::firstOrCreate(
            ['email' => $row['email'] ?? $row['nis'] . '@siswa.com'],
            [
                'name' => $row['nama'],
                'password' => Hash::make($row['password'] ?? 'password123'),
            ]
        );
        $user->syncRoles(['student']);

        // Cari Class berdasarkan nama (opsional)
        $classId = null;
        if (!empty($row['kelas'])) {
            $aclass = AcademicClass::where('name', $row['kelas'])->first();
            $classId = $aclass ? $aclass->id : null;
        }

        // Update atau buat Student
        return Student::updateOrCreate(
            ['nis' => $row['nis']],
            [
                'user_id' => $user->id,
                'student_number' => $row['nisn'] ?? null,
                'grade_level' => $row['tingkat'] ?? null,
                'academic_class_id' => $classId,
                'gender' => $row['jenis_kelamin'] ?? 'L',
                'birthplace' => $row['tempat_lahir'] ?? null,
                'birthdate' => $row['tanggal_lahir'] ?? null,
                'address' => $row['alamat'] ?? null,
                'monitoring_status' => 'active',
            ]
        );
    }
}
