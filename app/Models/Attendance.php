<?php

namespace App\Models;

use Database\Factories\AttendanceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id', 'academic_class_id', 'semester_id', 'latitude', 'longitude', 'distance', 'status', 'device', 'browser', 'ip_address', 'selfie_path', 'attendance_time', 'reason', 'evidence_path'])]
class Attendance extends Model
{
    use HasFactory;

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'distance' => 'integer',
        'attendance_time' => 'datetime',
    ];

    /**
     * Scope a query to only include alpha (absent without reason) attendances.
     */
    public function scopeAlpha(Builder $query): Builder
    {
        return $query->where('status', 'alpha');
    }

    /**
     * Scope a query to only include attendances for a specific student.
     */
    public function scopeByStudent(Builder $query, int $studentId): Builder
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope a query to only include attendances for a specific semester.
     */
    public function scopeBySemester(Builder $query, int $semesterId): Builder
    {
        return $query->where('semester_id', $semesterId);
    }

    /**
     * Count total alpha attendances for a given student and optional semester.
     */
    public static function countAlpha(?int $studentId = null, ?int $semesterId = null): int
    {
        $query = static::alpha();

        if ($studentId !== null) {
            $query->byStudent($studentId);
        }

        if ($semesterId !== null) {
            $query->bySemester($semesterId);
        }

        return $query->count();
    }

    /**
     * Check if this student's alpha count exceeds the given limit for the current semester.
     */
    public function isExceedingAlphaLimit(int $limit = 3): bool
    {
        $semesterId = Semester::active()?->id;

        if ($semesterId === null) {
            return false;
        }

        $alphaCount = static::alpha()
            ->byStudent($this->student_id)
            ->bySemester($semesterId)
            ->count();

        return $alphaCount >= $limit;
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicClass(): BelongsTo
    {
        return $this->belongsTo(AcademicClass::class);
    }
}
