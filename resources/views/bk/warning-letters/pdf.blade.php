<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Peringatan {{ $letter->type }} — {{ $letter->student?->user?->name ?? 'Siswa' }}</title>
    <style>
        @page { margin: 2.5cm 2cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #1a1a1a;
        }
        .kop {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1E3A5F;
            padding-bottom: 15px;
        }
        .kop h1 {
            font-size: 16pt;
            font-weight: bold;
            color: #1E3A5F;
            margin: 0 0 5px;
        }
        .kop h2 {
            font-size: 13pt;
            font-weight: bold;
            color: #1E3A5F;
            margin: 0 0 3px;
        }
        .kop p {
            font-size: 11pt;
            margin: 2px 0;
            color: #333;
        }
        .kop .alamat {
            font-size: 10pt;
            color: #555;
        }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 25px 0 30px;
        }
        .content {
            text-align: justify;
        }
        .content p {
            margin: 10px 0;
        }
        .data-siswa {
            margin: 20px 0;
            padding-left: 20px;
        }
        .data-siswa td {
            padding: 3px 10px;
            vertical-align: top;
        }
        .data-siswa .label {
            width: 120px;
        }
        .isi-surat {
            margin: 25px 0;
            padding: 15px 0;
        }
        .tanda-tangan {
            margin-top: 50px;
            text-align: right;
        }
        .tanda-tangan .tanggal {
            margin-bottom: 80px;
        }
        .tanda-tangan .nama {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
            font-size: 9pt;
            text-align: center;
            color: #888;
        }
        .sp-level {
            font-weight: bold;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop">
        <h1>PEMERINTAH KABUPATEN KUBU RAYA</h1>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h2>SMP NEGERI 13 SUNGAI RAYA</h2>
        <p class="alamat">
            Jl. Raya Sungai Raya, Kec. Sungai Raya, Kab. Kubu Raya, Kalimantan Barat 78391
        </p>
        <p>Email: smpn13sraya@sch.id | Telp: (0561) 123456</p>
    </div>

    <!-- Title -->
    <div class="title">
        SURAT PERINGATAN {{ $letter->type }}
    </div>
    <p style="text-align: center;">
        Nomor: SP/{{ str_replace('SP', '', $letter->type) }}/SMPN13/{{ $letter->issued_at?->format('Y') ?? date('Y') }}/{{ str_pad($letter->id, 3, '0', STR_PAD_LEFT) }}
    </p>

    <!-- Content -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala SMP Negeri 13 Sungai Raya, menerangkan bahwa:</p>

        <table class="data-siswa">
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $letter->student?->user?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NIS / NISN</td>
                <td>: {{ $letter->student?->student_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>: {{ $letter->student?->academicClass?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>: {{ $letter->student?->address ?? '-' }}</td>
            </tr>
        </table>

        <p>Dengan ini diberikan <span class="sp-level">Surat Peringatan {{ $letter->type }}</span> kepada siswa tersebut di atas dengan alasan:</p>

        <div class="isi-surat">
            <p>{{ $letter->reason ?? 'Berdasarkan hasil monitoring dan evaluasi kehadiran, yang bersangkutan telah melampaui batas ketidakhadiran tanpa keterangan (alpha) yang telah ditentukan oleh sekolah.' }}</p>
        </div>

        @if ($letter->type === 'SP1')
        <p>Kami mengingatkan siswa ini untuk segera memperbaiki kehadiran dan kedisiplinannya. Jika dalam waktu yang akan datang masih ditemukan pelanggaran serupa, maka pihak sekolah akan memberikan sanksi yang lebih tegas.</p>
        @elseif ($letter->type === 'SP2')
        <p>Ini adalah peringatan kedua bagi siswa yang bersangkutan. Dengan ini, kami meminta kerja sama orang tua/wali untuk lebih mengawasi dan membimbing putra/putrinya agar tidak mengulangi pelanggaran yang sama.</p>
        @elseif ($letter->type === 'SP3')
        <p>Ini adalah peringatan <strong>TERAKHIR</strong> bagi siswa yang bersangkutan. Apabila masih ditemukan pelanggaran, maka pihak sekolah akan mempertimbangkan tindakan lebih lanjut sesuai dengan peraturan yang berlaku, termasuk kemungkinan dikembalikannya siswa kepada orang tua/wali.</p>
        @endif
    </div>

    <!-- Tanda Tangan -->
    <div class="tanda-tangan">
        <p class="tanggal">
            Sungai Raya, {{ $letter->issued_at?->format('d F Y') ?? date('d F Y') }}
        </p>

        <p>Kepala Sekolah,</p>
        <div style="height: 80px;"></div>
        <p class="nama">Drs. H. Ahmad Fikri, M.M.</p>
        <p>NIP. 19681231 199403 1 002</p>

        <div style="margin-top: 40px;">
            <p>Mengetahui,</p>
            <div style="height: 60px;"></div>
            <p class="nama">{{ $letter->issuer?->name ?? 'Guru BK' }}</p>
            <p>Guru Bimbingan Konseling</p>
        </div>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari Sistem Informasi Akademik SMPN 13 Sungai Raya<br>
        Dicetak pada: {{ now()->format('d F Y H:i:s') }}
    </div>
</body>
</html>
