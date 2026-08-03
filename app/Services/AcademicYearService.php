<?php

namespace App\Services;

use App\Models\AcademicYear;

class AcademicYearService
{
    public function all()
    {
        return AcademicYear::orderByDesc('start_date')->get();
    }

    public function create(array $data): AcademicYear
    {
        return AcademicYear::create($data);
    }

    public function update(AcademicYear $academicYear, array $data): AcademicYear
    {
        $academicYear->update($data);

        return $academicYear;
    }
}
