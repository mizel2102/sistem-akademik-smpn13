<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Student;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkDailyAlpha extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:generate-alpha {date? : The date to generate alpha for (Y-m-d), defaults to today}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark students who have no attendance record for the day as alpha';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dateInput = $this->argument('date') ?: today()->toDateString();
        $date = Carbon::parse($dateInput);

        // Skip Sundays as it is not a school day
        if ($date->isSunday()) {
            $this->info("Skipping Sunday ({$dateInput}). No attendance required.");
            return 0;
        }

        $semester = Semester::active();
        if (! $semester) {
            $this->error('No active semester found. Cannot process daily alpha.');
            return 1;
        }

        $students = Student::all();
        $attendanceService = app(AttendanceService::class);
        $count = 0;

        foreach ($students as $student) {
            // Check if student already has an attendance record for this date
            $hasRecord = Attendance::where('student_id', $student->id)
                ->whereDate('attendance_time', $date)
                ->exists();

            if (! $hasRecord) {
                // Create an alpha record
                $attendance = Attendance::create([
                    'student_id' => $student->id,
                    'academic_class_id' => $student->academic_class_id,
                    'semester_id' => $semester->id,
                    'latitude' => 0.0,
                    'longitude' => 0.0,
                    'distance' => 0,
                    'status' => 'alpha',
                    'device' => 'System Auto-Alpha',
                    'browser' => 'System',
                    'ip_address' => '127.0.0.1',
                    'selfie_path' => null,
                    'attendance_time' => $date->copy()->setTime(17, 0, 0), // End of school day
                ]);

                $count++;

                // Check alpha threshold to trigger SP warning letters
                $attendanceService->checkAlphaThreshold($student, $semester);
            }
        }

        $this->info("Successfully generated {$count} alpha attendance records for {$dateInput}.");
        return 0;
    }
}
