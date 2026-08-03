<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Teacher::with(['user', 'subject'])->get();
    }

    public function headings(): array
    {
        return ['ID Guru', 'NIP', 'Nama', 'Email', 'Mata Pelajaran', 'No HP', 'Alamat'];
    }

    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->nip,
            $teacher->user->name ?? '',
            $teacher->user->email ?? '',
            $teacher->subject->name ?? '',
            $teacher->phone,
            $teacher->address,
        ];
    }
}
