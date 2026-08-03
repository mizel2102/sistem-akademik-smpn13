<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SP #{{ $letter->id }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #111; }
        .header { text-align: center; margin-bottom: 20px; }
        .meta { margin-bottom: 12px; }
        .section { margin-top: 16px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width:100%; border:none; margin-bottom:8px;">
            <tr>
                <td style="width:30%; text-align:right; border:none; vertical-align:middle; padding-right:16px;">
                    @if(function_exists('gd_info'))
                        <img src="{{ public_path('images/logo_putih_besar.png') }}" alt="logo" style="height:60px;object-fit:contain;" />
                    @endif
                </td>
                <td style="text-align:left; border:none; vertical-align:middle;">
                    <div style="font-weight:700;font-size:18px;">SMP Negeri 13</div>
                    <div style="font-size:12px;color:#444;">Jl. Contoh No.1 — Kota — Provinsi</div>
                </td>
            </tr>
        </table>
        <hr style="border:none;border-bottom:2px solid #222;margin:12px 0 18px;" />
        <h2 style="margin:0;font-size:16px;">Surat Peringatan (SP)</h2>
    </div>

    <div class="meta">
        <p><span class="label">SP #:</span> {{ $letter->id }}</p>
        <p><span class="label">Siswa:</span> {{ $letter->student->user->name ?? 'N/A' }} ({{ $letter->student->student_number ?? '' }})</p>
        <p><span class="label">Jenis SP:</span> {{ $letter->type }}</p>
        <p><span class="label">Tanggal Dikeluarkan:</span> {{ $letter->issued_at ?? '' }}</p>
        <p><span class="label">Dikeluarkan Oleh:</span> {{ $letter->issuer->name ?? '' }}</p>
    </div>

    <div class="section">
        <p class="label">Alasan:</p>
        <p>{{ $letter->reason ?? '-' }}</p>
    </div>

    <div class="section" style="margin-top:40px;">
        <p>Mengetahui,</p>
        <p style="margin-top:60px;">__________________________</p>
    </div>
</body>
</html>
