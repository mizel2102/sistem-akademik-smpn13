<?php
// Boot Laravel and call SchoolController::reportsPdf() to generate PDF and save it to storage/app/public
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the framework
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Build data similar to controller
    $users = App\Models\User::with('roles')->get();
    $totalUsers = $users->count();
    $adminCount = $users->filter(fn ($user) => $user->hasRole('admin'))->count();
    $teacherCount = $users->filter(fn ($user) => $user->hasRole('teacher'))->count();
    $studentCount = $users->filter(fn ($user) => $user->hasRole('student'))->count();
    $totalRoles = Spatie\Permission\Models\Role::all()->count();

    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports-pdf', compact('totalUsers', 'adminCount', 'teacherCount', 'studentCount', 'totalRoles'));
    $output = $pdf->output();

    $destDir = __DIR__ . '/../storage/app/public';
    if (! is_dir($destDir)) {
        mkdir($destDir, 0775, true);
    }
    $dest = $destDir . '/school-report-summary.pdf';
    file_put_contents($dest, $output);
    echo "Saved: $dest\n";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
