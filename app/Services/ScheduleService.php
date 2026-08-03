<?php

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScheduleService
{
    public function all(): Collection
    {
        return Schedule::with(['subject', 'teacher', 'academicClass', 'academicYear', 'semester'])->orderBy('day')->get();
    }

    public function create(array $data): Schedule
    {
        return DB::transaction(function () use ($data) {
            $this->ensureNoConflict($data);

            return Schedule::create($data);
        });
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        return DB::transaction(function () use ($schedule, $data) {
            $payload = array_merge($schedule->only([
                'academic_class_id',
                'academic_year_id',
                'semester_id',
                'subject_id',
                'teacher_id',
                'day',
                'start_time',
                'end_time',
            ]), $data);

            $this->ensureNoConflict($payload, $schedule->id);

            $schedule->update($data);

            return $schedule;
        });
    }

    public function delete(Schedule $schedule): bool
    {
        Schedule::destroy($schedule->id);
        return true;
    }

    private function ensureNoConflict(array $data, ?int $ignoreScheduleId = null): void
    {
        $conflict = Schedule::query()
            ->when($ignoreScheduleId, fn ($query) => $query->whereKeyNot($ignoreScheduleId))
            ->where('academic_year_id', $data['academic_year_id'])
            ->where('semester_id', $data['semester_id'])
            ->where('day', $data['day'])
            ->where(function ($query) use ($data) {
                $query
                    ->where('academic_class_id', $data['academic_class_id'])
                    ->orWhere('teacher_id', $data['teacher_id']);
            })
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->first();

        if (! $conflict) {
            return;
        }

        $message = $conflict->academic_class_id === (int) $data['academic_class_id']
            ? 'Kelas sudah memiliki jadwal pada rentang waktu tersebut.'
            : 'Guru sudah memiliki jadwal pada rentang waktu tersebut.';

        throw ValidationException::withMessages([
            'start_time' => $message,
        ]);
    }
}
