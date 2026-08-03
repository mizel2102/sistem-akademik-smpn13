<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use Spatie\Permission\Models\Role;

$studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
$assigned = 0;
foreach (Student::with('user')->get() as $s) {
    $u = $s->user;
    if ($u && ! $u->hasRole('student')) {
        $u->assignRole($studentRole);
        echo "Assigned student role to user {$u->email}\n";
        $assigned++;
    }
}

echo "Done. Total assigned: {$assigned}\n";
