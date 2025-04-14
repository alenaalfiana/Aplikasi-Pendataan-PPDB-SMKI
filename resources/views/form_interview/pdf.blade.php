<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Interview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            font-size: 11px;
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
            border: 1px dashed #000;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 12px;
            background-color: #f0f0f0;
            padding: 5px;
        }

        .form-row {
            margin-bottom: 5px;
        }

        .form-row label {
            display: inline-block;
            width: 200px;
        }

        .form-value {
            display: inline-block;
            border-bottom: 1px dotted #000;
            min-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1px 0;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
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
            margin-bottom: 10px;
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

        .no-interview {
            text-align: right;
            font-size: 12px;
            padding-right: 20px;
        }

        .checkbox-container {
            margin-top: 5px;
        }

        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            position: relative;
        }

        .checkbox.checked:after {
            content: "✓";
            position: absolute;
            top: -3px;
            left: 1px;
        }

        .checkbox-label {
            display: inline-block;
            margin-right: 15px;
        }

        .page-break {
            page-break-before: always;
        }

        .col-6 {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .col-4 {
            width: 32%;
            display: inline-block;
            vertical-align: top;
        }

        .col-3 {
            width: 24%;
            display: inline-block;
            vertical-align: top;
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
                <h1>FORMULIR INTERVIEW</h1>
                <h1>CALON SISWA SMK INFORMATIKA UTAMA</h1>
                <h2>Tahun Pelajaran {{ isset($interview->formPendaftaran->registrasiPengambilan->periode->tahun_periode) ? $interview->formPendaftaran->registrasiPengambilan->periode->tahun_periode : 'Data tidak tersedia' }}</h2>
            </td>
            <td width="20%" style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logo_ybm_path)) }}" alt="YBM PLN Logo" class="right-logo">
            </td>
        </tr>
    </table>

    <hr>
    <br>

    <!-- Data Pribadi -->
    <div class="section">
        <div class="section-title">A. DATA PRIBADI</div>
        <div class="form-row">
            <label>1. Nama Lengkap - Calon Siswa</label>:
            @if(isset($interview->forminterview->registrasiPengambilan))
                <span class="form-value">{{ $interview->forminterview->registrasiPengambilan->nama }}</span>
            @endif
        </div>
        <div class="form-row">
            <label>2. Nama Panggilan</label>:
            <span class="form-value">{{ $interview->nama_panggilan ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>3. Pewawancara</label>:
            <span class="form-value">{{ $interview->users->name ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>4. Jumlah Saudara Kandung</label>:
            <span class="form-value">{{ $interview->jumlah_saudara_kandung ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>5. Jumlah Saudara Tiri</label>:
            <span class="form-value">{{ $interview->jumlah_saudara_tiri ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>6. Jumlah Saudara Angkat</label>:
            <span class="form-value">{{ $interview->jumlah_saudara_angkat ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>7. Cita-cita</label>:
            <span class="form-value">{{ $interview->cita_cita ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>8. Alasan Cita-cita</label>:
            <span class="form-value">{{ $interview->alasan_cita_cita ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>9. Usaha yang Dilakukan</label>:
            <span class="form-value">{{ $interview->usaha_yang_dilakukan ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>10. Motto / Semboyan</label>:
            <span class="form-value">{{ $interview->motto ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>11. Kekurangan</label>:
            <span class="form-value">{{ $interview->kekurangan ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>12. Kelebihan</label>:
            <span class="form-value">{{ $interview->kelebihan ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>13. Organisasi Sekolah</label>:
            <span class="form-value">{{ $interview->organisasi_sekolah ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>14. Organisasi Masyarakat</label>:
            <span class="form-value">{{ $interview->organisasi_masyarakat ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>15. Hobi</label>:
            <span class="form-value">{{ $interview->hobi ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>16. Nilai Komunikasi</label>:
            <span class="form-value">{{ $interview->nilai_komunikasi ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>17. Nilai Kepercayaan Diri</label>:
            <span class="form-value">{{ $interview->nilai_kepercayaan_diri ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>18. Uang Saku</label>:
            <span class="form-value">Rp {{ $interview->uang_saku }}</span>
        </div>
        <div class="form-row">
            <label>19. Kemampuan Bermotor</label>:
            <span class="form-value">{{ $interview->kemampuan_bermotor ?? '' }}</span>
        </div>
    </div>

    <!-- Data Sekolah Asal -->
    <div class="section">
        <div class="section-title">B. DATA SEKOLAH ASAL</div>
        <div class="form-row">
            <label>1. Prestasi yang Dicapai</label>:
        </div>
        @if(isset($interview->prestasi_yang_dicapai))
            @php $prestasi = json_decode($interview->prestasi_yang_dicapai, true); @endphp
            @if(is_array($prestasi))
                @foreach($prestasi as $index => $item)
                    <div class="form-row">
                        <label>&nbsp;&nbsp;&nbsp;{{ chr(97+$index) }}. Prestasi {{ $index+1 }}</label>:
                        <span class="form-value">{{ $item }}</span>
                    </div>
                @endforeach
            @endif
        @endif

        <div class="form-row">
            <label>2. Mata Pelajaran yang Disukai</label>:
            <span class="form-value">{{ $interview->mata_pelajaran ?? '' }}</span>
        </div>

        <div class="form-row">
            <label>3. Rencana Pilihan Sekolah & Alasan</label>:
        </div>
        <table>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Rencana Pilihan Sekolah</th>
                <th width="50%">Alasan Pilihan Sekolah</th>
            </tr>
            @if(isset($interview->rencana_pilihan_sekolah) && isset($interview->alasan_pilihan_sekolah))
                @php
                    $rencana = json_decode($interview->rencana_pilihan_sekolah, true);
                    $alasan = json_decode($interview->alasan_pilihan_sekolah, true);
                    $count = max(count($rencana ?? []), count($alasan ?? []));
                @endphp
                @for($i = 0; $i < $count; $i++)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $rencana[$i] ?? '' }}</td>
                        <td>{{ $alasan[$i] ?? '' }}</td>
                    </tr>
                @endfor
            @endif
        </table>

        <br>

        <div class="form-row">
            <label>4. Teman/Famili/Tetangga yang baru mendaftar/diterima di SMKI Utama</label>:
            <span class="form-value">{{ $interview->kenalan_yang_diterima_di_smki ?? '' }}</span>
        </div>

        <div class="form-row">
            <label>5. Histori Akademik</label>:
        </div>
        <div class="form-row">
            <label>&nbsp;&nbsp;&nbsp;a. Sakit</label>:
            <span class="form-value">{{ $interview->historis_sakit ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>&nbsp;&nbsp;&nbsp;b. Ijin</label>:
            <span class="form-value">{{ $interview->historis_ijin ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>&nbsp;&nbsp;&nbsp;c. Alfa</label>:
            <span class="form-value">{{ $interview->historis_alfa ?? '' }}</span>
        </div>

        <div class="form-row">
            <label>6. Catatan Kasus Pelanggaran</label>:
            <span class="form-value">{{ $interview->catatan_kasus_pelanggaran ?? '' }}</span>
        </div>

        <div class="form-row">
            <label>7. Bacaan Huruf Qur'an (BHQ)</label>:
            <span class="form-value">{{ $interview->bhq ?? '' }}</span>
        </div>

        <div class="form-row">
            <label>8. Hafalan Juz</label>:
            <span class="form-value">{{ $interview->hafalan_juz ?? '' }}</span>
        </div>
    </div>

    <!-- Data Kesehatan Jiwa Raga -->
    <div class="section">
        <div class="section-title">C. DATA KESEHATAN JIWA RAGA</div>
        <div class="form-row">
            <label>1. Merokok / Narkoba</label>:
            <span class="form-value">{{ $interview->merokok_narkoba ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>2. Jenis, Merek, dan Harga</label>:
            <span class="form-value">{{ $interview->jenis_merek_harga ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>3. Anggota Keluarga yang Merokok</label>:
            <span class="form-value">{{ $interview->anggota_keluarga_yg_merokok ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>4. Riwayat Kesehatan</label>:
            <span class="form-value">{{ $interview->riwayat_kesehatan ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>5. Ketertarikan dengan Lawan Jenis</label>:
            <span class="form-value">{{ $interview->ketertarikan_dengan_lawan_jenis ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>6. Terpapar Pornografi</label>:
            <span class="form-value">{{ $interview->terpapar_pornografi ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>7. Media Sosial yang Digunakan</label>:
        </div>
        <div class="checkbox-container">
            @if(isset($interview->media_sosial))
                @php $mediaSosial = json_decode($interview->media_sosial, true); @endphp
                @if(is_array($mediaSosial))
                    @foreach(['Facebook', 'Instagram', 'Twitter', 'TikTok', 'YouTube', 'WhatsApp', 'Telegram'] as $media)
                        <label class="checkbox-label">
                            <input type="checkbox" disabled {{ in_array($media, $mediaSosial) ? 'checked' : '' }}>
                            {{ $media }}
                        </label>
                    @endforeach

                    <!-- Untuk media sosial lainnya -->
                    <div class="form-row">
                        <label>Lainnya:</label>
                        <span class="form-value">
                            @foreach($mediaSosial as $media)
                                @if(!in_array($media, ['Facebook', 'Instagram', 'Twitter', 'TikTok', 'YouTube', 'WhatsApp', 'Telegram']))
                                    {{ $media }}{{ !$loop->last ? ', ' : '' }}
                                @endif
                            @endforeach
                        </span>
                    </div>
                @endif
            @endif
        </div>

    </div>

    <!-- Data Tanggungan Keluarga -->
    <div class="section">
        <div class="section-title">D. DATA TANGGUNGAN KELUARGA</div>
        <table>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Lengkap</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="5%">Usia</th>
                <th width="15%">Pendidikan</th>
                <th width="10%">Kelas</th>
                <th width="15%">Pekerjaan</th>
                <th width="10%">Hubungan</th>
            </tr>
            @if(isset($interview->nama_lengkap_keluarga) && isset($interview->jenis_kelamin) && isset($interview->usia) && isset($interview->pendidikan) && isset($interview->kelas) && isset($interview->pekerjaan) && isset($interview->hubungan))
                @php
                    $nama = json_decode($interview->nama_lengkap_keluarga, true) ?: [];
                    $jenisKelamin = json_decode($interview->jenis_kelamin, true) ?: [];
                    $usia = json_decode($interview->usia, true) ?: [];
                    $pendidikan = json_decode($interview->pendidikan, true) ?: [];
                    $kelas = json_decode($interview->kelas, true) ?: [];
                    $pekerjaan = json_decode($interview->pekerjaan, true) ?: [];
                    $hubungan = json_decode($interview->hubungan, true) ?: [];
                    $count = max(count($nama), count($jenisKelamin), count($usia), count($pendidikan), count($kelas), count($pekerjaan), count($hubungan));
                @endphp
                @for($i = 0; $i < $count; $i++)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $nama[$i] ?? '' }}</td>
                        <td>{{ $jenisKelamin[$i] ?? '' }}</td>
                        <td>{{ $usia[$i] ?? '' }}</td>
                        <td>{{ $pendidikan[$i] ?? '' }}</td>
                        <td>{{ $kelas[$i] ?? '' }}</td>
                        <td>{{ $pekerjaan[$i] ?? '' }}</td>
                        <td>{{ $hubungan[$i] ?? '' }}</td>
                    </tr>
                @endfor
            @endif
        </table>
    </div>

    <!-- Data Situasi Keluarga -->
    <div class="section">
        <div class="section-title">E. DATA SITUASI KELUARGA SISWA</div>
        <div class="form-row">
            <label>1. Siswa Tinggal Bersama</label>:
            <span class="form-value">{{ $interview->siswa_tinggal_bersama ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>2. Status Pernikahan Orang Tua</label>:
            <span class="form-value">
                {{ $interview->status_pernikahan_ortu ?? '' }}
                @if(($interview->status_pernikahan_ortu ?? '') == 'Lain-lain')
                    ({{ $interview->status_pernikahan_ortu_lainnya ?? '' }})
                @endif
            </span>
        </div>
        <div class="form-row">
            <label>3. Status Rumah</label>:
            <span class="form-value">{{ $interview->status_rumah ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>4. Harga Kontrak (Rp)</label>:
            <span class="form-value">
                @if(($interview->status_rumah ?? '') == 'Kontrak')
                    Rp {{ $interview->harga_kontrak }}
                @else
                    -
                @endif
            </span>
        </div>
        <div class="form-row">
            <label>5. Daya Listrik (Watt)</label>:
            <span class="form-value">{{ $interview->daya_listrik ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>6. Biaya Listrik per Bulan (Rp)</label>:
            <span class="form-value">Rp {{ $interview->biaya_listrik }}</span>
        </div>
        <div class="form-row">
            <label>7. Transportasi yang Dimiliki</label>:
        </div>
        <div class="checkbox-container">
            @if(isset($interview->transportasi_yg_dimiliki))
                @php $transportasi = json_decode($interview->transportasi_yg_dimiliki, true); @endphp
                @if(is_array($transportasi))
                    <label class="checkbox-label">
                        <input type="checkbox" disabled {{ in_array('Sepeda', $transportasi) ? 'checked' : '' }}>
                        Sepeda
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" disabled {{ in_array('Motor', $transportasi) ? 'checked' : '' }}>
                        Motor
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" disabled {{ in_array('Mobil', $transportasi) ? 'checked' : '' }}>
                        Mobil
                    </label>
                @endif
            @endif
        </div>
        <div class="form-row">
            <label>8. Harta Milik Keluarga</label>:
        </div>
        <div class="checkbox-container">
            @if(isset($interview->harta_milik_keluarga))
                @php $harta = json_decode($interview->harta_milik_keluarga, true); @endphp
                @if(is_array($harta))
                    @foreach(['Televisi', 'Radio/tape', 'PlayStation', 'Kulkas', 'Magic Jar', 'HP', 'DVD', 'AC/Kipas Angin', 'PC/Laptop'] as $item)
                        <label class="checkbox-label">
                            <input type="checkbox" disabled {{ in_array($item, $harta) ? 'checked' : '' }}>
                            {{ $item }}
                        </label>
                    @endforeach
                @endif
            @endif
        </div>

        <div class="form-row">
            <label>9. Berat Perhiasan</label>:
        </div>
        <div class="col-6">
            <div class="form-row">
                <label>&nbsp;&nbsp;&nbsp;a. Kalung (gr)</label>:
                <span class="form-value">{{ $interview->berat_kalung_gr ?? '' }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-row">
                <label>&nbsp;&nbsp;&nbsp;b. Cincin (gr)</label>:
                <span class="form-value">{{ $interview->berat_cincin_gr ?? '' }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-row">
                <label>&nbsp;&nbsp;&nbsp;c. Gelang (gr)</label>:
                <span class="form-value">{{ $interview->berat_gelang_gr ?? '' }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-row">
                <label>&nbsp;&nbsp;&nbsp;d. Anting (gr)</label>:
                <span class="form-value">{{ $interview->berat_anting_gr ?? '' }}</span>
            </div>
        </div>
        <div class="form-row">
            <label>10. Tanggungan Kredit</label>:
            <span class="form-value">Rp {{ $interview->tanggungan_kredit }}</span>
        </div>
        <div class="form-row">
            <label>11. Pendapat tentang perhatian orang tua terhadap kebutuhan</label>:
            <span class="form-value">{{ $interview->pendapat ?? '' }}</span>
        </div>
    </div>

    <!-- Kontak Darurat -->
    <div class="section">
        <div class="section-title">F. KONTAK DARURAT</div>
        <div class="form-row">
            <label>1. Nama</label>:
            <span class="form-value">{{ $interview->nama ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>2. Hubungan dengan Siswa</label>:
            <span class="form-value">{{ $interview->hubungan_dgn_siswa ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>3. Alamat</label>:
            <span class="form-value">{{ $interview->alamat_kontak_darurat ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>4. No. Telepon</label>:
            <span class="form-value">{{ $interview->no_telepon ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>5. No. HP</label>:
            <span class="form-value">{{ $interview->no_hp ?? '' }}</span>
        </div>
    </div>

    <!-- Kesimpulan dan Saran -->
    <div class="section">
        <div class="section-title">G. KESIMPULAN DAN SARAN</div>
        <div class="form-row">
            <label>Kesimpulan</label>:
            <span class="form-value">{{ $interview->kesimpulan ?? '' }}</span>
        </div>
    </div>

    <!-- Detail Tambahan -->
    <div class="section">
        <div class="section-title">H. DETAIL TAMBAHAN</div>
        <div class="form-row">
            <label>1. Nama Lengkap</label>:
            <span class="form-value">{{ $interview->nama_lengkap ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>2. Nama Panggilan di Lingkungan</label>:
            <span class="form-value">{{ $interview->nama_panggilan_di_lingkungan ?? '' }}</span>
        </div>
        <div class="form-row">
            <label>3. Tanggal Pengisian</label>:
            <span class="form-value">{{ date('d-m-Y', strtotime($interview->tanggal_pengisian ?? now())) }}</span>
        </div>
        <div class="form-row">
            <label>4. Ciri-ciri Rumah</label>:
        </div>
        @if(isset($interview->ciri_ciri_rumah))
            @php $ciriRumah = json_decode($interview->ciri_ciri_rumah, true); @endphp
            @if(is_array($ciriRumah))
                @foreach($ciriRumah as $index => $ciri)
                    <div class="form-row">
                        <label>&nbsp;&nbsp;&nbsp;{{ chr(97+$index) }}. Ciri {{ $index+1 }}</label>:
                        <span class="form-value">{{ $ciri }}</span>
                    </div>
                @endforeach
            @endif
        @endif
        <div class="form-row">
            <label>5. Status Interview</label>:
            <span class="form-value">{{ ucfirst($interview->status_interview ?? '') }}</span>
        </div>
    </div>

    <!-- Denah Lokasi -->
    <div class="section">
        <div class="section-title">I. DENAH LOKASI</div>
        <div style="border: 1px solid #000; padding: 10px; min-height: 200px; text-align: center;">
            @if($interview->denah_lokasi)
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $interview->denah_lokasi))) }}"
                     alt="Denah Lokasi" style="max-width: 100%; max-height: 300px;">
            @else
                [Denah Lokasi Tidak Tersedia]
            @endif
        </div>
    </div>

    <div class="clearfix">
        <div class="requirements">
            <strong>Catatan Pewawancara:</strong>
            <p style="min-height: 100px; border-bottom: 1px dotted #000;">
                {{ $interview->kesimpulan ?? '' }}
            </p>
        </div>

        <div class="signature text-center">
            <p>Depok, {{ $interview->tanggal_pengisian }}</p>
            <p>Pewawancara</p>

            @if(!empty($tandaTanganBase64))
            <img src="{{ $tandaTanganBase64 }}"
                 alt="Tanda Tangan"
                 style="max-width: 400px; max-height: 300px; object-fit: contain;">
        @endif



            <p>({{ $interview->pendataanSurveyor->user->name ?? '' }})</p>
        </div>
    </div>
</body>
</html>
