<?php

namespace App\Services;

use App\Models\Semester;

class SemesterService
{
    public function all()
    {
        return Semester::with('academicYear')->orderBy('name')->get();
    }

    public function create(array $data): Semester
    {
        return Semester::create($data);
    }

    public function update(Semester $semester, array $data): Semester
    {
        $semester->update($data);

        return $semester;
    }
}
