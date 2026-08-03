<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\SchoolReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function index(): View
    {
        $teachers = Teacher::with(['user', 'subject'])
            ->orderBy('id')
            ->take(6)
            ->get();

        $berita = Announcement::query()
            ->where(function ($query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (Announcement $announcement): array => [
                'title' => $announcement->title,
                'date' => $announcement->published_at?->format('Y-m-d') ?? $announcement->created_at?->format('Y-m-d'),
                'category' => $announcement->audience ?: 'Pengumuman',
                'excerpt' => Str::limit(strip_tags($announcement->content), 180),
            ]);

        $statistics = [
            'teachers' => Teacher::query()->get()->count(),
            'students' => Student::query()->get()->count(),
            'classes' => AcademicClass::query()->get()->count(),
        ];

        return view('welcome', compact('teachers', 'berita', 'statistics'));
    }

    public function reports(SchoolReportService $service): View
    {
        $data = $service->summary();

        return view('admin.reports', $data);
    }

    public function reportsPdf(SchoolReportService $service)
    {
        $data = $service->summary();

        $pdf = Pdf::loadView('admin.reports-pdf', $data);

        return $pdf->download('school-report-summary.pdf');
    }
}
