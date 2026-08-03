<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\TeachersImport;
use App\Imports\StudentsImport;
use App\Exports\UsersExport;
use App\Exports\TeachersExport;
use App\Exports\StudentsExport;

class DataImportExportController extends Controller
{
    public function importUsers(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new UsersImport, $request->file('file'));
        return back()->with('success', 'Data Users berhasil diimpor.');
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function importTeachers(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new TeachersImport, $request->file('file'));
        return back()->with('success', 'Data Guru berhasil diimpor.');
    }

    public function exportTeachers()
    {
        return Excel::download(new TeachersExport, 'teachers.xlsx');
    }

    public function importStudents(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new StudentsImport, $request->file('file'));
        return back()->with('success', 'Data Siswa berhasil diimpor.');
    }

    public function exportStudents()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
