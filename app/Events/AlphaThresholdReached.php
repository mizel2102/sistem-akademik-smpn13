<?php

namespace App\Events;

use App\Models\Semester;
use App\Models\Student;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlphaThresholdReached
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Student $student,
        public int $alphaCount,
        public ?Semester $semester = null,
    ) {
    }
}
