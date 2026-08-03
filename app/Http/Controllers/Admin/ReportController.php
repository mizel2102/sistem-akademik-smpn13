<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function studentRapor(int $studentId)
    {
        $student = Student::with(['grades.subject','grades.semester','user','academicClass'])->findOrFail($studentId);
        return view('admin.reports.rapor', compact('student'));
    }

    public function studentRaporPdf(int $studentId)
    {
        $student = Student::with(['grades.subject','grades.semester','user','academicClass'])->findOrFail($studentId);

        $pdf = Pdf::loadView('admin.reports.rapor_pdf', compact('student'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('rapor_' . $student->id . '.pdf');
    }
}
