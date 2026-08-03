<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id','issued_by','type','reason','issued_at','resolved_at','revoke_reason'])]
class WarningLetter extends Model
{
    use HasFactory;

    protected $casts = [
        'issued_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeByLevel($query, int $level)
    {
        return $query->where('type', "SP{$level}");
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
