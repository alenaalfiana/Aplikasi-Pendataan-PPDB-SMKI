<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            font-size: 11px; /* Set default font size to 12px for all body text */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }

        .form-number {
            text-align: right;
            margin-bottom: 10px;
        }

        .photo-area {
            width: 90px;
            height: 120px;
            float: right;
            margin-top: 10px;
            text-align: center;
            padding-top: 5px;
            font-size: 12px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 12px; /* Headers get a slightly larger font size */
        }

        .form-row {
            margin-bottom: 5px;
        }

        .form-row label {
            display: inline-block;
            width: 150px;
        }

        .form-row input[type="text"] {
            border-bottom: 1px dotted #000;
            border-top: none;
            border-left: none;
            border-right: none;
            width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 2px;
            text-align: left;
        }

        .requirements {
            border: 1px solid black;
            padding: 10px;
            width: 60%;
            float: left;
        }

        .signature {
            float: right;
            width: 35%;
            text-align: center;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }

        .header-table td {
            padding: 5px;
            vertical-align: middle;
            border: none;
        }

        .logo {
            width: 100px;
            height: 100px;
        }

        .center-text {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .center-text h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }

        .center-text h2 {
            font-size: 14px;
            margin: 5px 0;
        }

        .right-logo {
            width: 100px;
            height: auto;
        }

        .no-pendaftaran {
            text-align: right;
            font-size: 12px;
            padding-right: 20px;
        }
    </style>
</head>
<body>
<!-- Bagian head dan style tetap sama seperti sebelumnya -->

<div class="form-number">No. Pendaftaran: {{ $pendaftaran->registrasiPengambilan->no_pendaftar }}</div>

<table class="header-table">
    <tr>
        <td width="20%" style="text-align: center;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logo_path)) }}" alt="School Logo" class="logo">
        </td>
        <td width="60%" class="center-text">
            <h1>FORMULIR PENDAFTARAN</h1>
            <h1>PENERIMAAN PESERTA DIDIK BARU (PPDB)</h1>
            <h1>SISWA SMK INFORMATIKA UTAMA</h1>
            <h2>Tahun Pelajaran 2024/2025</h2>
        </td>
        <td width="20%" style="text-align: center;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logo_ybm_path)) }}" alt="YBM PLN Logo" class="right-logo">
        </td>
    </tr>
</table>

<hr>
<br>
<div class="photo-area">
    @if($pendaftaran->pas_foto)
        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $pendaftaran->pas_foto))) }}"
             alt="Pas Foto" style="max-width: 90px; max-height: 120px;">
    @else
        Pas Foto 3x4
    @endif
</div>

<div class="section">
    <div class="section-title">A. BIODATA PRIBADI</div>
    <div class="form-row">
        <label>1. NISN SMP/MTs</label>: {{ $pendaftaran->nisn }}
    </div>
    <div class="form-row">
        <label>2. Nama</label>: {{ $pendaftaran->registrasiPengambilan->nama }}
    </div>
    <div class="form-row">
        <label>3. Ukuran Baju</label>: {{ $pendaftaran->ukuran_baju }}
    </div>
    <div class="form-row">
        <label>4. Jenis Kelamin</label>: {{ ucfirst($pendaftaran->jenis_kelamin) }}
    </div>
    <div class="form-row">
        <label>5. Tempat Lahir</label>: {{ $pendaftaran->tempat_lahir }}
    </div>
    <div class="form-row">
        <label>6. Tanggal Lahir</label>: {{ Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>
    <div class="form-row">
        <label>7. Agama</label>: {{ $pendaftaran->agama }}
    </div>
    <div class="form-row">
        <label>8. Anak ke</label>: {{ $pendaftaran->anak_ke }} dari {{ $pendaftaran->dari }} saudara kandung
    </div>
    <div class="form-row">
        <label>9. Status Siswa</label>: {{ $pendaftaran->status_siswa_formatted }}
    </div>
    <div class="form-row">
        <label>10. Bahasa sehari-hari</label>: {{ $pendaftaran->bahasa_keseharian }}
    </div>
    <div class="form-row">
        <label>11. Alamat Lengkap</label>:
        {{ ucwords(strtolower($pendaftaran->alamat_lengkap)) }}
        {{ $pendaftaran->village ? ucwords(strtolower($pendaftaran->village->name)) : '' }},
        {{ $pendaftaran->district ? ucwords(strtolower($pendaftaran->district->name)) : '' }},
        {{ $pendaftaran->regency ? ucwords(strtolower($pendaftaran->regency->name)) : '' }},
        {{ $pendaftaran->province ? ucwords(strtolower($pendaftaran->province->name)) : '' }},
    </div>
</div>

<!-- Bagian Data Orang Tua/Wali -->
<div class="section">
    <div class="section-title">B. DATA ORANG TUA / WALI</div>
    <table>
        <tr>
            <th></th>
            <th style="text-align: center; vertical-align: middle;">Ayah</th>
            <th style="text-align: center; vertical-align: middle;">Ibu</th>
            <th style="text-align: center; vertical-align: middle;">Wali</th>

        </tr>
        <tr>
            <td>Nama</td>
            <td>{{ $pendaftaran->nama_ayah }}</td>
            <td>{{ $pendaftaran->nama_ibu }}</td>
            <td>{{ $pendaftaran->nama_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td>Usia</td>
            <td>{{ $pendaftaran->usia_ayah }}</td>
            <td>{{ $pendaftaran->usia_ibu }}</td>
            <td>{{ $pendaftaran->usia_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td>{{ $pendaftaran->ayah_pendidikan_formatted }}</td>
            <td>{{ $pendaftaran->ibu_pendidikan_formatted }}</td>
            <td>{{ $pendaftaran->wali_pendidikan_formatted ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>{{ $pendaftaran->pekerjaan_ayah }}</td>
            <td>{{ $pendaftaran->pekerjaan_ibu }}</td>
            <td>{{ $pendaftaran->pekerjaan_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td>Penghasilan</td>
            <td>{{ $pendaftaran->penghasilan_ayah }}</td>
            <td>{{ $pendaftaran->penghasilan_ibu }}</td>
            <td>{{ $pendaftaran->penghasilan_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $pendaftaran->alamat_lengkap_ayah ?? '-'  }}</td>
            <td>{{ $pendaftaran->alamat_lengkap_ibu ?? '-' }}</td>
            <td>{{ $pendaftaran->alamat_lengkap_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td>Telepon / HP</td>
            <td>{{ $pendaftaran->no_telepon_ayah }}</td>
            <td>{{ $pendaftaran->no_telepon_ibu }}</td>
            <td>{{ $pendaftaran->no_telepon_wali ?? '-' }}</td>
        </tr>
    </table>
</div>

<!-- Bagian Data Sekolah Asal -->
<div class="section">
    <div class="section-title">C. DATA SEKOLAH ASAL</div>
    <div class="form-row">
        <label>1. Asal Sekolah</label>: {{ $pendaftaran->asal_sekolah }}
    </div>
    <div class="form-row">
        <label>2. Alamat Lengkap</label>: {{ $pendaftaran->alamat_lengkap_sekolah }}
    </div>
    <div class="form-row">
        <label>3. Tahun Lulus</label>: {{ $pendaftaran->tahun_lulus }}
    </div>
</div>

<div class="clearfix">
    <div class="requirements">
        <strong>Syarat Administrasi:</strong>
        <ol>
            <li>Photo copy Akta Lahir / Kenal Lahir</li>
            <li>Photo copy Kartu Keluarga</li>
            <li>Pas Foto 3 x 4 (3 lembar) terbaru</li>
            <li>Surat Keterangan Tidak Mampu dari Kelurahan</li>
            <li>Photo copy Kartu KIP (jika ada)</li>
            <li>Photo copy Rapor SMP Kelas 7 – 9 ( 5 Semester )</li>
            <li>Photo copy KTP kedua orang tua ( 2 lembar )</li>
            <li>Photo copy KTP kedua orang tua/wali (2 lembar)</li>
            <li>Seluruh berkas dimasukan dalam Map</li>
        </ol>
    </div>

    <div class="signature">
        <p>Depok, {{ $pendaftaran->tanggal_mendaftar }} 2024</p>
        <p>Siswa yang Bersangkutan</p>
        <br>
        @if($pendaftaran->tanda_tangan_siswa)
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $pendaftaran->tanda_tangan_siswa))) }}"
                 alt="Tanda Tangan Siswa" width="300" height="50">
        @endif
        <p>({{ $pendaftaran->registrasiPengambilan->nama }})</p>
        <p>Tanda tangan & Nama</p>
    </div>
</div>
</body>

</html>
