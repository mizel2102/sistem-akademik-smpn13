<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::with('roles')->get();
foreach ($users as $u) {
    $roles = $u->getRoleNames()->toArray();
    echo "User: {$u->email} | id: {$u->id} | roles: " . (count($roles)?implode(',',$roles):'(none)') . "\n";
}
