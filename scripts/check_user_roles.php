<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::with('roles')->get();
foreach ($users as $user) {
    echo $user->id . ' ' . $user->email . ' [' . implode(',', $user->getRoleNames()->toArray()) . ']\n';
}
