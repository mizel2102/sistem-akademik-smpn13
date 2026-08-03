<?php

namespace App\Services;

use App\Models\Subject;

class SubjectService
{
    public function all()
    {
        return Subject::with('teacher')->orderBy('name')->get();
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(Subject $subject, array $data): Subject
    {
        $subject->update($data);

        return $subject;
    }
}
