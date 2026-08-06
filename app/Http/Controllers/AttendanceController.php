<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request, AttendanceService $attendanceService): View
    {
        $user = $request->user();
        $student = $user?->student;

        $classes = collect();
        if ($student) {
            $classes = $student->classes()->orderBy('name', 'asc')->get();
            if ($student->academicClass && ! $classes->contains(fn ($item) => $item->id == $student->academic_class_id)) {
                $classes->push($student->academicClass);
            }
            if ($classes->isEmpty()) {
                $classes = \App\Models\AcademicClass::query()->orderBy('name', 'asc')->get();
            }
        }

        return view('student.attendance', compact('classes'));
    }

    public function history(Request $request): View
    {
        $student = $request->user()?->student;

        $query = Attendance::with('academicClass');

        if ($student) {
            $query->where('student_id', '=', $student->id, 'and');

            if ($request->filled('start_date')) {
                $query->whereDate('attendance_time', '>=', $request->start_date, 'and');
            }

            if ($request->filled('end_date')) {
                $query->whereDate('attendance_time', '<=', $request->end_date, 'and');
            }

            $attendances = $query->orderByDesc('attendance_time')->paginate(15)->withQueryString();
        } else {
            $attendances = Attendance::whereRaw('1=0', [], 'and')->paginate(15);
        }

        $totalAttendance = 0;
        $presentCount = 0;
        $absentCount = 0;

        if ($student) {
            $statsQuery = Attendance::where('student_id', '=', $student->id, 'and');
            if ($request->filled('start_date')) {
                $statsQuery->whereDate('attendance_time', '>=', $request->start_date, 'and');
            }
            if ($request->filled('end_date')) {
                $statsQuery->whereDate('attendance_time', '<=', $request->end_date, 'and');
            }
            $totalAttendance = (clone $statsQuery)->count('*');
            $presentCount = (clone $statsQuery)->whereIn('status', ['present', 'late'], 'and', false)->count('*');
            $absentCount = (clone $statsQuery)->where('status', '=', 'absent', 'and')->count('*');
        }

        return view('student.attendance-history', compact('attendances', 'totalAttendance', 'presentCount', 'absentCount'));
    }

    public function store(StoreAttendanceRequest $request, AttendanceService $attendanceService): RedirectResponse
    {
        $this->authorize('create', Attendance::class);

        $student = $request->user()->student;

        if (! $student) {
            return redirect()->back()->withErrors(['student' => 'Profil siswa tidak ditemukan.']);
        }

        $class = null;
        if ($student->academic_class_id == $request->academic_class_id) {
            $class = $student->academicClass;
        } else {
            $class = $student->classes()->where('academic_classes.id', $request->academic_class_id)->first();
        }

        if (! $class) {
            $class = \App\Models\AcademicClass::find($request->academic_class_id, ['*']);
        }

        if (! $class) {
            return redirect()->back()->withErrors(['academic_class_id' => 'Kelas tidak ditemukan atau tidak terdaftar untuk siswa.']);
        }

        $data = $request->validated();
        $status = $data['status'] ?? 'present';
        $isSickOrPermission = in_array($status, ['sick', 'permission']);

        if ($isSickOrPermission) {
            $calculatedDistance = 0;
            $data['latitude'] = $request->latitude ?? 0.0;
            $data['longitude'] = $request->longitude ?? 0.0;
        } else {
            // Validate Distance from backend
            $schoolLat = config('app.school_latitude');
            $schoolLng = config('app.school_longitude');
            $calculatedDistance = $this->calculateDistance(
                (float) $request->latitude,
                (float) $request->longitude,
                (float) $schoolLat,
                (float) $schoolLng
            );

            $maxDistance = (int) config('app.school_max_distance_meters', 100);
            if ($calculatedDistance > $maxDistance) {
                return redirect()->back()->withErrors(['distance' => 'Jarak Anda (' . round($calculatedDistance) . 'm) melebihi batas maksimal ' . $maxDistance . ' meter dari sekolah.'])->withInput();
            }
        }

        $data['student_id'] = $student->id;
        $data['distance'] = round($calculatedDistance);
        $data['ip_address'] = $request->ip();
        $data['browser'] = $request->header('User-Agent');
        $data['device'] = $request->header('User-Agent');

        // Check attendance time against school entry time + late tolerance (e.g., 06:45 + 15m = 07:00 WIB)
        $attendanceTime = \Carbon\Carbon::parse($data['attendance_time'] ?? now());
        $entryTimeStr = config('app.school_entry_time', '06:45');
        $toleranceMinutes = (int) config('app.school_late_tolerance_minutes', 15);

        $schoolStartTime = $attendanceTime->copy()->setTimeFromTimeString($entryTimeStr);
        $lateCutoffTime = $schoolStartTime->copy()->addMinutes($toleranceMinutes);

        if (in_array($status, ['present', 'late', 'hadir', 'terlambat'])) {
            if ($attendanceTime->greaterThan($lateCutoffTime)) {
                $data['status'] = 'late';
            } else {
                $data['status'] = 'present';
            }
        }

        if ($isSickOrPermission) {
            if ($request->hasFile('evidence')) {
                $data['evidence_path'] = $request->file('evidence')->store('evidences', 'public');
            }
            $data['reason'] = $request->input('reason');
        } else {
            if ($request->hasFile('selfie')) {
                $data['selfie_path'] = $request->file('selfie')->store('attendances', 'public');
            } elseif ($request->filled('selfie_base64')) {
                $imageData = $request->input('selfie_base64');
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);
                $fileName = 'attendances/' . \Illuminate\Support\Str::random(40) . '.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, base64_decode($imageData));
                $data['selfie_path'] = $fileName;
            }
        }

        $attendanceService->createAttendance($data);

        $statusLabel = match ($data['status']) {
            'sick' => 'Sakit',
            'permission' => 'Izin',
            'late' => 'Terlambat (melewati batas waktu ' . $lateCutoffTime->format('H:i') . ' WIB)',
            default => 'Hadir Tepat Waktu',
        };

        return redirect()->route('student.attendance.history')->with('success', "Absensi berhasil disimpan. Status: {$statusLabel}.");
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
