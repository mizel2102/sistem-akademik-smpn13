<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

$email = 'andre.ramadiansyah12@gmail.com';
$user = User::query()->where('email', $email)->first();
if (! $user) {
    echo "User with email {$email} not found\n";
    exit(1);
}
$studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
if (! $user->hasRole('student')) {
    $user->assignRole($studentRole);
    echo "Assigned student role to {$user->email}\n";
} else {
    echo "User {$user->email} already has student role\n";
}
