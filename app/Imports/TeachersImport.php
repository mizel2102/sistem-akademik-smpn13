<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class TeachersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nip']) || !isset($row['nama'])) {
            return null;
        }

        // Cari atau buat User
        $user = User::firstOrCreate(
            ['email' => $row['email'] ?? $row['nip'] . '@guru.com'],
            [
                'name' => $row['nama'],
                'password' => Hash::make($row['password'] ?? 'password123'),
            ]
        );
        $user->syncRoles(['teacher']);

        // Cari Subject berdasarkan nama (opsional)
        $subjectId = null;
        if (!empty($row['mata_pelajaran'])) {
            $subject = Subject::where('name', $row['mata_pelajaran'])->first();
            $subjectId = $subject ? $subject->id : null;
        }

        // Update atau buat Teacher
        return Teacher::updateOrCreate(
            ['nip' => $row['nip']],
            [
                'user_id' => $user->id,
                'subject_id' => $subjectId,
                'phone' => $row['no_hp'] ?? null,
                'address' => $row['alamat'] ?? null,
            ]
        );
    }
}
