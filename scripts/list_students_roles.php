<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$students = App\Models\Student::with('user.roles')->get();
foreach ($students as $s) {
    $user = $s->user;
    $roles = $user ? $user->getRoleNames()->toArray() : [];
    echo 'Student ID: ' . $s->id . ' | user_id: ' . $s->user_id . ' | email: ' . ($user?->email ?? 'NULL') . ' | roles: ' . implode(',', $roles) . "\n";
}
