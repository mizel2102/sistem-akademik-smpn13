<?php

namespace App\Models;

use Database\Factories\AcademicClassFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Str;

#[Fillable(['teacher_id', 'name', 'room', 'schedule', 'capacity', 'status', 'access_token'])]
class AcademicClass extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (AcademicClass $class) {
            if (empty($class->access_token)) {
                $class->access_token = static::generateUniqueToken();
            }
        });
    }

    public static function generateUniqueToken(): string
    {
        do {
            $token = Str::upper(Str::random(6));
        } while (static::where('access_token', $token)->exists());

        return $token;
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'academic_class_student');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
