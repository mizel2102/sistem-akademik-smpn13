<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MigrateLegacyData extends Command
{
    protected $signature = 'migrate:legacy-data';
    protected $description = 'Migrate data from raw guru and siswa tables to Laravel native schema';

    public function handle()
    {
        $this->info('Starting migration of legacy data...');

        // Migrate Guru
        $gurus = DB::table('guru')->get();
        $this->info("Found {$gurus->count()} records in guru table.");
        $teacherCount = 0;

        foreach ($gurus as $guru) {
            if (!$guru->nama_lengkap) continue;

            $nip = $guru->nip ?: Str::random(10);
            $email = str_replace(' ', '', strtolower($nip)) . '@smpn13.sch.id';
            
            // Check if user already exists
            $user = User::query()->where('email', $email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $guru->nama_lengkap,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                ]);
                
                $user->assignRole('teacher');

                Teacher::create([
                    'user_id' => $user->id,
                    'nip' => $guru->nip ?: 'NIP-' . Str::random(5),
                    'phone' => null,
                    'address' => null,
                ]);
                $teacherCount++;
            }
        }
        $this->info("Successfully migrated {$teacherCount} teachers.");

        // Migrate Siswa
        $siswas = DB::table('siswa')->get();
        $this->info("Found {$siswas->count()} records in siswa table.");
        $studentCount = 0;

        foreach ($siswas as $siswa) {
            if (!$siswa->nama_siswa) continue;

            $baseNis = $siswa->nis ?: Str::random(8);
            $finalNis = Student::query()->where('nis', $baseNis)->exists() ? $baseNis . '-' . Str::random(3) : $baseNis;
            $email = str_replace(' ', '', strtolower($finalNis)) . '@siswa.smpn13.sch.id';

            // Check if user already exists
            $user = User::query()->where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $siswa->nama_siswa,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                ]);
                
                $user->assignRole('student');

                $baseNisn = $siswa->nisn ?: 'NISN-' . Str::random(5);
                $finalNisn = Student::query()->where('student_number', $baseNisn)->exists() ? $baseNisn . '-' . Str::random(3) : $baseNisn;

                Student::create([
                    'user_id' => $user->id,
                    'nis' => $finalNis,
                    'student_number' => $finalNisn,
                    'grade_level' => $siswa->kelas ?: 'VII',
                    'gender' => $siswa->jenis_kelamin,
                    'birthplace' => $siswa->tempat_lahir,
                    'birthdate' => $siswa->tanggal_lahir,
                    'address' => $siswa->alamat,
                ]);
                $studentCount++;
            }
        }
        $this->info("Successfully migrated {$studentCount} students.");

        $this->info('Legacy data migration completed successfully!');
    }
}
