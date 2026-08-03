<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rapor - {{ $student->user?->name }}</title>
  <style>
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
    .navy { color: #1A2B6D; }
    .bg-navy { background-color: #1A2B6D; color: white; }
    .gold { color: #F5A623; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th { background-color: #1A2B6D; color: white; padding: 8px 10px; text-align: left; font-size: 10px; }
    td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; }
    tr:nth-child(even) td { background-color: #f8fafc; }
    .lulus { color: #16a34a; font-weight: bold; }
    .tidak-lulus { color: #dc2626; font-weight: bold; }
    .remedial { color: #d97706; font-weight: bold; }
    .kop { border-bottom: 3px double #1A2B6D; padding-bottom: 12px; margin-bottom: 16px; }
    .info-table { width: 100%; border: none; margin-bottom: 16px; }
    .info-table td { border: none; padding: 2px 10px; background-color: transparent !important; }
    .info-label { font-size: 10px; color: #64748b; margin-bottom: 4px; }
    .info-value { font-weight: bold; }
    .semester-header { background-color: #eef0f9; color: #1A2B6D; padding: 6px 10px; font-weight: bold; margin-top: 16px; }
    .score-high { color: #16a34a; font-weight: bold; }
    .score-mid { color: #d97706; font-weight: bold; }
    .score-low { color: #dc2626; font-weight: bold; }
    .score-low { color: #dc2626; font-weight: bold; }
    .footer { margin-top: 40px; width: 100%; }
    .footer-table { width: 100%; border: none; }
    .footer-table td { border: none; background-color: transparent !important; }
    .ttd-box { text-align: center; width: 200px; }
    .ttd-line { border-bottom: 1px solid #1e293b; margin: 40px 0 6px; }
  </style>
</head>
<body>

<div class="kop">
  <table style="width:100%; border:none;">
    <tr>
      <td style="width:80px; border:none; padding:0; background-color:transparent !important; text-align:left; vertical-align:middle;">
        <div style="width:60px;height:60px;border-radius:50%;background:#1A2B6D;color:#F5A623;font-size:22px;font-weight:900;text-align:center;line-height:60px;display:inline-block;">13</div>
      </td>
      <td style="border:none; padding:0; background-color:transparent !important; vertical-align:middle;">
        <div style="font-size:18px;font-weight:900;color:#1A2B6D;">SMP NEGERI 13</div>
        <div style="font-size:11px;color:#64748b;">Sistem Informasi Akademik</div>
      </td>
    </tr>
  </table>
</div>

<div style="text-align:center; font-size:16px; font-weight:900; color:#1A2B6D; text-transform:uppercase; margin-bottom:16px; letter-spacing:2px;">
  RAPOR SISWA
</div>

<table class="info-table">
  <tr>
    <td style="width:15%;"><div class="info-label">Nama Siswa</div></td>
    <td style="width:35%;"><div class="info-value">{{ $student->user?->name ?? '-' }}</div></td>
    <td style="width:15%;"><div class="info-label">Jenis Kelamin</div></td>
    <td style="width:35%;"><div class="info-value">{{ $student->user?->gender ?? '-' }}</div></td>
  </tr>
  <tr>
    <td><div class="info-label">NIS</div></td>
    <td><div class="info-value">{{ $student->student_number ?? '-' }}</div></td>
    <td><div class="info-label">Wali Kelas</div></td>
    <td><div class="info-value">{{ $student->academicClass?->teacher?->user?->name ?? '-' }}</div></td>
  </tr>
  <tr>
    <td><div class="info-label">Kelas</div></td>
    <td><div class="info-value">{{ $student->academicClass?->name ?? '-' }}</div></td>
    <td><div class="info-label">Tahun Ajaran</div></td>
    <td><div class="info-value">{{ $student->grades->first()?->semester?->academicYear?->name ?? '-' }}</div></td>
  </tr>
  <tr>
    <td><div class="info-label">Tingkat</div></td>
    <td><div class="info-value">{{ $student->academicClass?->grade_level ?? '-' }}</div></td>
    <td></td>
    <td></td>
  </tr>
</table>

@php
    $gradesBySemester = $student->grades->groupBy(fn($g) => $g->semester?->name ?? 'Tanpa Semester');
@endphp

@foreach($gradesBySemester as $semName => $grades)
  <div class="semester-header">{{ $semName }}</div>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mata Pelajaran</th>
        <th>Nilai</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
    @foreach($grades as $i => $grade)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $grade->subject?->name ?? '-' }}</td>
        <td class="{{ $grade->score >= 75 ? 'score-high' : ($grade->score >= 60 ? 'score-mid' : 'score-low') }}">
          {{ $grade->score }}
        </td>
        <td class="{{ $grade->status === 'pass' ? 'lulus' : ($grade->status === 'fail' ? 'tidak-lulus' : 'remedial') }}">
          {{ $grade->status === 'pass' ? 'Lulus' : ($grade->status === 'fail' ? 'Tidak Lulus' : 'Remedial') }}
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endforeach

<table style="width:100%; border:none; margin-top:16px;">
  <tr>
    <td style="padding:10px; background:#eef0f9; border-radius:6px; font-weight:bold; border:none; text-align:left;">
      Rata-rata Nilai Keseluruhan
    </td>
    <td style="padding:10px; background:#eef0f9; border-radius:6px; font-size:18px; font-weight:900; color:#1A2B6D; border:none; text-align:right;">
      {{ number_format($student->grades->avg('score'), 1) }}
    </td>
  </tr>
</table>

<div class="footer">
  <table class="footer-table">
    <tr>
      <td style="width:60%;"></td>
      <td style="width:40%; text-align:center;">
        <div>Mengetahui,</div>
        <div style="font-weight:bold;">Kepala Sekolah</div>
        <div class="ttd-line"></div>
        <div style="font-weight:bold;">( __________________ )</div>
      </td>
    </tr>
  </table>
</div>

</body>
</html>
