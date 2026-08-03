<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::with(['user', 'academicClass'])->get();
    }

    public function headings(): array
    {
        return ['ID Siswa', 'NIS', 'NISN', 'Nama', 'Email', 'Kelas', 'Tingkat', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat'];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->nis,
            $student->student_number,
            $student->user->name ?? '',
            $student->user->email ?? '',
            $student->academicClass->name ?? '',
            $student->grade_level,
            $student->gender,
            $student->birthplace,
            $student->birthdate,
            $student->address,
        ];
    }
}
