<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Survey (Validasi Data)</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm;
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            font-size: 11px;
            color: #000;
        }

        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }

        .header-table td {
            padding: 5px;
            vertical-align: middle;
            border: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .logo {
            width: 100px;
            height: 100px;
        }

        .right-logo {
            width: 100px;
            height: auto;
        }

        .title {
            text-align: center;
            flex-grow: 1;
            padding: 0 10px;
        }

        .title h1 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title p {
            margin: 3px 0;
            font-size: 12px;
        }

        .divider {
            height: 2px;
            background-color: #4a86e8;
            margin: 5px 0 15px 0;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            background-color: #f0f0f0;
            padding: 3px 5px;
            font-size: 11px;
        }

        .form-row {
            display: flex;
            margin-bottom: 5px;
        }

        .form-label {
            width: 120px;
            font-weight: normal;
        }

        .form-value {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 10px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 3px 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .small-text {
            font-size: 9px;
            font-style: italic;
            margin-top: 2px;
        }

        .conclusion-table th {
            text-align: center;
        }

        .conclusion-cell {
            height: 80px;
            vertical-align: top;
            padding: 5px;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 150px;
            display: inline-block;
        }

        .text-center {
            text-align: center;
        }

        .status-box {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            width: 100px;
            margin-left: auto;
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
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td width="20%" style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logo_path)) }}" alt="School Logo" class="logo">
            </td>
            <td width="60%" class="center-text">
                <h1>FORM SURVEY (VALIDASI DATA)</h1>
                <h1>CALON SISWA SMK INFORMATIKA UTAMA, KRUKUT - DEPOK</h1>
                <h2>Tahun Pelajaran {{ isset($survey->formPendaftaran->registrasiPengambilan->periode->tahun_periode) ? $survey->formPendaftaran->registrasiPengambilan->periode->tahun_periode : 'Data tidak tersedia' }}</h2>
            </td>
            <td width="20%" style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logo_ybm_path)) }}" alt="YBM PLN Logo" class="right-logo">
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Data Calon Siswa -->
    <div class="section">
        <div class="section-title">A. DATA CALON SISWA</div>
        <div class="form-row">
            <div class="form-label">NISN</div>
            <div class="form-value">: {{ $survey->formInterview->formPendaftaran->nisn ?? '' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label">Nama</div>
            <div class="form-value">: {{ $survey->formPendaftaran->registrasiPengambilan->nama ?? '' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label">TTL</div>
            <div class="form-value">
                : {{ optional($survey->formPendaftaran)->tempat_lahir ?? '' }},
                {{ optional($survey->formInterview)->formPendaftaran ?
                   date('d-m-Y', strtotime(optional($survey->formInterview->formPendaftaran)->tanggal_lahir)) : '' }}
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">Anak ke</div>
            <div class="form-value">: {{ $survey->formInterview->anak_ke ?? '' }} dari {{ $survey->formInterview->jumlah_saudara_kandung ?? '' }} saudara</div>
        </div>
        <div class="form-row">
            <div class="form-label">Status</div>
            <div class="form-value">: {{ $survey->formInterview->status_interview ?? '' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label">Alamat</div>
            <div class="form-value">: {{ $survey->formInterview->formPendaftaran->alamat_lengkap ?? '' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label">Cita-cita</div>
            <div class="form-value">: {{ $survey->formInterview->cita_cita ?? '' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label">Rata2 TPA</div>
            <div class="form-value">: {{ $survey->rata2_tpa ?? '' }} ( max = {{ $survey->max_tpa ?? '' }}; min = {{ $survey->min_tpa ?? '' }} )</div>
        </div>
        <div class="form-row">
            <div class="form-label">Tes Al-Qur'an</div>
            <div class="form-value">: {{ $survey->rata2_tes_alquran ?? '' }} ( max = {{ $survey->max_alquran ?? '' }}; min = {{ $survey->min_alquran ?? '' }} )</div>
        </div>
        <div class="form-row">
            <div class="form-label">Asal Sekolah</div>
            <div class="form-value">: {{ $survey->formPendaftaran->asal_sekolah ?? '' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label"></div>
            <div class="form-value">
                S = {{ optional($survey->formInterview)->historis_sakit ?? 'N/A' }}
                I = {{ optional($survey->formInterview)->historis_ijin ?? 'N/A' }}
                A = {{ optional($survey->formInterview)->historis_alfa ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Data Profil Orang Tua -->
    <div class="section">
        <div class="section-title">B. DATA PROFIL ORANG TUA / WALI</div>
        <table>
            <tr>
                <th width="25%">Biodata</th>
                <th width="37.5%">Ayah</th>
                <th width="37.5%">Ibu</th>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $survey->formInterview->formPendaftaran->nama_ayah ?? '' }}</td>
                <td>{{ $survey->formInterview->formPendaftaran->nama_ibu ?? '' }}</td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>{{ $survey->formInterview->usia_ayah ?? '' }}</td>
                <td>{{ $survey->formInterview->usia_ibu ?? '' }}</td>
            </tr>
            <tr>
                <td>Pendidikan</td>
                <td>{{ $survey->formInterview->pendidikan_ayah ?? '' }}</td>
                <td>{{ $survey->formInterview->pendidikan_ibu ?? '' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>{{ $survey->formInterview->pekerjaan_ayah ?? '' }}</td>
                <td>{{ $survey->formInterview->pekerjaan_ibu ?? '' }}</td>
            </tr>
            <tr>
                <td rowspan="3">Income</td>
                <td>Form: {{ $survey->income_form_ayah }}</td>
                <td>Form: {{ $survey->income_form_ibu }}</td>
            </tr>
            <tr>
                <td>Interview: {{ $survey->income_interview_ayah }}</td>
                <td>Interview: {{ $survey->income_interview_ibu }}</td>
            </tr>
            <tr>
                <td>Survey: {{ $survey->income_survey_ayah }}</td>
                <td>Survey: {{ $survey->income_survey_ibu }}</td>
            </tr>

            <tr>
                <td>Telepon</td>
                <td>{{ $survey->formInterview->formPendaftaran->no_hp_ayah ?? '' }}</td>
                <td>{{ $survey->formInterview->formPendaftaran->no_hp_ibu ?? '' }}</td>
            </tr>
        </table>
    </div>

    <!-- Data Tanggungan -->
    <div class="section">
        <div class="section-title">C. DATA TANGGUNGAN ORANG TUA*</div>
        <table>
            <tr>
                <th width="5%">No.</th>
                <th width="25%">Nama</th>
                <th width="8%">L/P</th>
                <th width="8%">Usia</th>
                <th width="15%">Pendidikan</th>
                <th width="8%">Kls</th>
                <th width="15%">Pekerjaan</th>
                <th width="16%">Hubungan</th>
            </tr>
            @if(isset($survey->nama_lengkap_keluarga))
                @php
                    $nama = json_decode($survey->nama_lengkap_keluarga, true) ?: [];
                    $jenisKelamin = json_decode($survey->jenis_kelamin, true) ?: [];
                    $usia = json_decode($survey->usia, true) ?: [];
                    $pendidikan = json_decode($survey->pendidikan, true) ?: [];
                    $kelas = json_decode($survey->kelas, true) ?: [];
                    $pekerjaan = json_decode($survey->pekerjaan, true) ?: [];
                    $hubungan = json_decode($survey->hubungan, true) ?: [];
                    $count = max(count($nama), 7); // Ensure at least 7 rows
                @endphp

                @for($i = 0; $i < $count; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $nama[$i] ?? '' }}</td>
                        <td>{{ isset($jenisKelamin[$i]) ? (substr($jenisKelamin[$i], 0, 1) == 'L' ? 'L' : 'P') : '' }}</td>
                        <td>{{ $usia[$i] ?? '' }}</td>
                        <td>{{ $pendidikan[$i] ?? '' }}</td>
                        <td>{{ $kelas[$i] ?? '' }}</td>
                        <td>{{ $pekerjaan[$i] ?? '' }}</td>
                        <td>{{ $hubungan[$i] ?? '' }}</td>
                    </tr>
                @endfor
            @else
                @for($i = 0; $i < 7; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        </table>
        <div class="small-text">* Ibu / Isteri termasuk dalam tanggungan orang tua</div>
    </div>

    <!-- Validasi Tambahan -->
    <div class="section">
        <div class="section-title">D. VALIDASI TAMBAHAN</div>
        <div class="form-row">
            <div class="form-label">Status Rumah</div>
            <div class="form-value">: {{ $survey->status_rumah ?? 'Sendiri / Kontrak / Menumpang (Nenek)' }}</div>
        </div>
        <div class="form-row">
            <div class="form-label">Biaya / Bln</div>
            <div class="form-value">: Rp {{ number_format($survey->biaya_hidup_perbulan, 0, ',', '.') }} / Bln</div>
        </div>
        <div class="form-row">
            <div class="form-label">Luas</div>
            <div class="form-value">: B : ± {{ $survey->luas_bangunan ?? '' }} m² / T : ± {{ $survey->luas_tanah ?? '' }} m²</div>
        </div>
        <div class="form-row">
            <div class="form-label">Fasilitas</div>
            <div class="form-value">: {{ $survey->fasilitas_ruang_tamu ?? '0' }} RT + {{ $survey->fasilitas_ruang_keluarga ?? '0' }} RK + {{ $survey->fasilitas_kamar_tidur ?? '0' }} KT + Dapur + WC</div>
        </div>
        <div class="form-row">
            <div class="form-label">Listrik</div>
            <div class="form-value">: {{ $survey->besar_listrik ?? '' }} KWh (Rp {{ number_format($survey->biaya_listrik, 0, ',', '.') }} / Bln)</div>
        </div>
        <div class="form-row">
            <div class="form-label">Harta Milik Keluarga</div>
            <div class="form-value">
                @if(isset($survey->harta_milik_keluarga))
                    @php $harta = json_decode($survey->harta_milik_keluarga, true); @endphp
                    @if(is_array($harta))
                        @foreach($harta as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @endif
                @else
                    1. <br>
                    2. <br>
                    3. <br>
                    4. <br>
                    5. <br>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">Tanggungan Hutang</div>
            <div class="form-value">
                @if(isset($survey->tanggungan_hutang))
                    @php $hutang = json_decode($survey->tanggungan_hutang, true); @endphp
                    @if(is_array($hutang))
                        @foreach($hutang as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @endif
                @else
                    1. <br>
                    2. <br>
                    3. <br>
                    4. <br>
                    5. <br>
                @endif
            </div>
        </div>
    </div>

    <!-- Kesimpulan -->
    <div class="section">
        <div class="section-title">E. KESIMPULAN</div>
        <table class="conclusion-table">
            <tr>
                <th width="33%">Alasan Pendukung</th>
                <th width="33%">Alasan Memberatkan</th>
                <th width="34%">Saran Rekomendasi</th>
            </tr>
            <tr>
                <td class="conclusion-cell">
                    @if(isset($survey->alasan_pendukung))
                        @php $pendukung = json_decode($survey->alasan_pendukung, true); @endphp
                        @if(is_array($pendukung))
                            @foreach($pendukung as $index => $item)
                                {{ $index + 1 }}. {{ $item }}<br>
                            @endforeach
                        @endif
                    @else
                        1. <br>
                        2. <br>
                        3. <br>
                        4. <br>
                        5. <br>
                        6. <br>
                        7. <br>
                        8. <br>
                    @endif
                </td>
                <td class="conclusion-cell">
                    @if(isset($survey->alasan_memberatkan))
                        @php $memberatkan = json_decode($survey->alasan_memberatkan, true); @endphp
                        @if(is_array($memberatkan))
                            @foreach($memberatkan as $index => $item)
                                {{ $index + 1 }}. {{ $item }}<br>
                            @endforeach
                        @endif
                    @else
                        1. <br>
                        2. <br>
                        3. <br>
                        4. <br>
                        5. <br>
                        6. <br>
                        7. <br>
                        8. <br>
                    @endif
                </td>
                <td class="conclusion-cell text-center">
                    <div style="margin-top: 30px;">
                        <strong>{{ $survey->saran_rekomendasi ?? 'Diterima / Ditolak / Abu-abu' }}</strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
