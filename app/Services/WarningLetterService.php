<?php

namespace App\Services;

use App\Exceptions\WarningLetterException;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use App\Models\WarningLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WarningLetterService
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function determineSpLevel(Student $student, Semester $semester): ?int
    {
        $alphaCount = $student->attendances()
            ->where('semester_id', $semester->id)
            ->where('status', 'alpha')
            ->count();

        $level = match (true) {
            $alphaCount >= 9 => 3,
            $alphaCount >= 6 => 2,
            $alphaCount >= 3 => 1,
            default => null,
        };

        if ($level === null || $this->hasActiveType($student, $level)) {
            return null;
        }

        if ($level > 1 && ! $this->hasActiveType($student, $level - 1)) {
            return null;
        }

        return $level;
    }

    public function issueWarningLetter(
        Student $student,
        int $level,
        string $reason,
        ?User $issuer = null
    ): WarningLetter {
        if (! in_array($level, [1, 2, 3], true)) {
            throw new WarningLetterException('Level SP harus berupa 1, 2, atau 3.');
        }

        if ($this->hasActiveType($student, $level)) {
            throw new WarningLetterException("SP{$level} masih aktif untuk siswa ini.");
        }

        if ($level > 1 && ! $this->hasActiveType($student, $level - 1)) {
            $previousLevel = $level - 1;
            throw new WarningLetterException("SP{$level} tidak dapat diterbitkan sebelum SP{$previousLevel} aktif.");
        }

        $issuer ??= Auth::user();

        if (! $issuer instanceof User) {
            throw new WarningLetterException('Penerbit surat tidak ditemukan.');
        }

        $letter = DB::transaction(function () use ($student, $level, $reason, $issuer): WarningLetter {
            return WarningLetter::create([
                'student_id' => $student->id,
                'issued_by' => $issuer->id,
                'type' => "SP{$level}",
                'reason' => $reason,
                'issued_at' => now(),
            ]);
        });

        $this->notificationService->sendToGuruBK('sp_issued', [
            'title' => "SP{$level} diterbitkan",
            'message' => "SP{$level} diterbitkan untuk siswa {$student->user?->name}.",
            'student_id' => $student->id,
            'warning_letter_id' => $letter->id,
        ]);

        if ($student->user) {
            $student->user->notifications()->create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'type' => 'student_sp_issued',
                'data' => [
                    'title' => "Surat Peringatan SP{$level} Diterbitkan",
                    'message' => "Anda menerima surat peringatan SP{$level} karena: {$reason}. Silakan hubungi Guru BK.",
                    'warning_letter_id' => $letter->id,
                ],
            ]);
        }

        return $letter;
    }

    public function revokeWarningLetter(WarningLetter $warningLetter, string $reason): bool
    {
        if ($warningLetter->resolved_at !== null) {
            return false;
        }

        return $warningLetter->update([
            'resolved_at' => now(),
            'revoke_reason' => $reason,
        ]);
    }

    public function getActiveSpForStudent(Student $student): ?WarningLetter
    {
        return $student->warningLetters()
            ->active()
            ->latest('issued_at')
            ->first();
    }

    public function canIssueNextSp(Student $student): bool
    {
        $activeTypes = $student->warningLetters()
            ->active()
            ->pluck('type')
            ->all();

        if (in_array('SP3', $activeTypes, true)) {
            return false;
        }

        if (in_array('SP2', $activeTypes, true)) {
            return true;
        }

        if (in_array('SP1', $activeTypes, true)) {
            return true;
        }

        return true;
    }

    public function generateSpPdf(WarningLetter $warningLetter): string
    {
        $warningLetter->loadMissing('student.user', 'issuer');
        $path = "warning-letters/{$warningLetter->id}.pdf";

        Storage::disk('local')->put(
            $path,
            Pdf::loadView('admin.warning-letters.pdf', ['letter' => $warningLetter])
                ->setPaper('a4', 'portrait')
                ->output()
        );

        return Storage::disk('local')->path($path);
    }

    private function hasActiveType(Student $student, int $level): bool
    {
        return $student->warningLetters()
            ->active()
            ->where('type', "SP{$level}")
            ->exists();
    }
}
