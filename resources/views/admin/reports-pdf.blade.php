<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>School Report Summary</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; }
        .header { text-align: center; margin-bottom: 20px; }
        .grid { text-align: center; }
        .card { display: inline-block; vertical-align: top; text-align: left; border: 1px solid #e5e7eb; padding: 12px 16px; margin: 10px; border-radius: 8px; width: 180px; }
        .title { font-size: 12px; color: #374151; }
        .value { font-size: 28px; font-weight: 700; color: #111827; }
    </style>
</head>
<body>
    <div class="header">
        <h1>School Report Summary</h1>
        <p>Sistem Akademik SMPN 13 Sungai Raya</p>
    </div>

    <div class="grid">
        <div class="card">
            <div class="title">Total users</div>
            <div class="value">{{ $totalUsers }}</div>
        </div>
        <div class="card">
            <div class="title">Students</div>
            <div class="value">{{ $studentCount }}</div>
        </div>
        <div class="card">
            <div class="title">Teachers</div>
            <div class="value">{{ $teacherCount }}</div>
        </div>
        <div class="card">
            <div class="title">Administrators</div>
            <div class="value">{{ $adminCount }}</div>
        </div>
        <div class="card">
            <div class="title">Defined roles</div>
            <div class="value">{{ $totalRoles }}</div>
        </div>
        <div class="card">
            <div class="title">Academic classes</div>
            <div class="value">{{ $classCount }}</div>
        </div>
        <div class="card">
            <div class="title">Subjects</div>
            <div class="value">{{ $subjectCount }}</div>
        </div>
        <div class="card">
            <div class="title">Academic years</div>
            <div class="value">{{ $academicYearCount }}</div>
        </div>
        <div class="card">
            <div class="title">Semesters</div>
            <div class="value">{{ $semesterCount }}</div>
        </div>
        <div class="card">
            <div class="title">Schedules</div>
            <div class="value">{{ $scheduleCount }}</div>
        </div>
        <div class="card">
            <div class="title">Announcements</div>
            <div class="value">{{ $announcementCount }}</div>
        </div>
        <div class="card">
            <div class="title">Grades recorded</div>
            <div class="value">{{ $gradeCount }}</div>
        </div>
        <div class="card">
            <div class="title">Attendance records</div>
            <div class="value">{{ $attendanceCount }}</div>
        </div>
    </div>

</body>
</html>
