<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = $argv[1] ?? 'andre.ramadiansyah12@gmail.com';
$user = User::query()->where('email', $email)->first();
if (! $user) {
    echo "User {$email} not found\n";
    exit(1);
}
$roles = $user->getRoleNames()->toArray();
echo "User: {$user->email} | roles: " . implode(',', $roles) . "\n";
