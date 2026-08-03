<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $service = app(App\Services\SchoolReportService::class);
    $data = $service->summary();
    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports-pdf', $data);
    $pdf->output(); // try to render it
    echo "School reports PDF generated successfully!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
