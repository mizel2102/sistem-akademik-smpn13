<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin \Spatie\Permission\Traits\HasRoles
 */
#[Fillable(['name', 'email', 'password', 'avatar_path'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar_path) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->avatar_path);
        }

        return null;
    }

    /**
     * Get the teacher profile relation.
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isGuru(): bool
    {
        return $this->hasRole('teacher');
    }

    public function isGuruBK(): bool
    {
        return $this->hasAnyRole(['guru-bk', 'guru_bk']);
    }

    public function isSiswa(): bool
    {
        return $this->hasRole('student');
    }

    public function hasAccessTo(string $permission): bool
    {
        return $this->can($permission);
    }

    public function primaryRoleLabel(): string
    {
        $role = $this->getRoleNames()->first();

        return match ($role) {
            'admin' => 'Super Admin',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            'guru-bk', 'guru_bk' => 'Guru BK',
            default => ucfirst((string) $role),
        };
    }

    public static function roleLabel(string $role): string
    {
        return match ($role) {
            'admin' => 'Super Admin',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            'guru-bk', 'guru_bk' => 'Guru BK',
            default => ucfirst($role),
        };
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
