@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wawancara Calon Siswa</title>
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 0.5rem;
        }

        .section-header {
            background-color: #0d6efd;
            color: white;
            padding: 0.75rem 1rem;
            font-weight: 600;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .info-card {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .info-card-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        .info-card-body {
            padding: 1rem;
        }

        .info-row {
            display: flex;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 0.75rem;
        }

        .info-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            width: 40%;
            padding-right: 1rem;
        }

        .info-value {
            color: #212529;
            width: 60%;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            text-align: left;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }

        .table-custom td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .table-custom tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .badge-custom {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 4px;
            text-align: center;
        }

        .badge-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffe69c;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .list-data {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-data li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .list-data li:last-child {
            border-bottom: none;
        }

        .action-buttons {
            margin-top: 1.5rem;
            text-align: center;
        }

        .btn-action {
            margin: 0 0.25rem;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag {
            background-color: #f1f3f5;
            color: #495057;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .info-row {
                flex-direction: column;
            }

            .info-label, .info-value {
                width: 100%;
                padding-right: 0;
            }

            .info-label {
                margin-bottom: 0.25rem;
            }

            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background-color: #fff;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .action-buttons {
                display: none !important;
            }
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .text-muted {
            color: #6c757d;
        }

        .fst-italic {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <div class="section-header">
            <i class="fas fa-user-check me-2"></i> Informasi Utama
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Nama Siswa</div>
                            <div class="info-value">{{ $interview->formPendaftaran->registrasiPengambilan->nama ?? 'Data tidak tersedia' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Nama Panggilan</div>
                            <div class="info-value">{{ $interview->nama_panggilan ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Pewawancara</div>
                            <div class="info-value">{{ $interview->pendataanSurveyor->user->name ?? 'Data tidak tersedia' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status Interview</div>
                            <div class="info-value">
                                <span class="badge-custom {{ $interview->status_interview == 'sudah' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $interview->status_interview == 'sudah' ? 'Sudah Interview' : 'Belum Interview' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tanggal Pengisian</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($interview->tanggal_pengisian)->locale('id')->translatedFormat('d F Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pribadi -->
        <div class="section-header">
            <i class="fas fa-user me-2"></i> Data Pribadi
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="info-card">
                    <div class="info-card-header">Informasi Jumlah Saudara</div>
                    <div class="info-card-body">
                        <div class="grid-3">
                            <div class="info-row">
                                <div class="info-label">Kandung</div>
                                <div class="info-value">{{ $interview->jumlah_saudara_kandung ?? '0' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Tiri</div>
                                <div class="info-value">{{ $interview->jumlah_saudara_tiri ?? '0' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Angkat</div>
                                <div class="info-value">{{ $interview->jumlah_saudara_angkat ?? '0' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Cita-cita</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Cita-cita</div>
                            <div class="info-value">{{ $interview->cita_cita ?? 'Data tidak tersedia' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Alasan</div>
                            <div class="info-value">{{ $interview->alasan_cita_cita ?? 'Data tidak tersedia' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Usaha yang dilakukan</div>
                            <div class="info-value">{{ $interview->usaha_yang_dilakukan ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Profil Diri</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Motto / Semboyan</div>
                            <div class="info-value">{{ $interview->motto ?? 'Data tidak tersedia' }}</div>
                        </div>
                        <div class="grid-2 mt-3">
                            <div class="info-card">
                                <div class="info-card-header">Kelebihan</div>
                                <div class="info-card-body">
                                    <div class="info-value">{{ $interview->kelebihan ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                            <div class="info-card">
                                <div class="info-card-header">Kekurangan</div>
                                <div class="info-card-body">
                                    <div class="info-value">{{ $interview->kekurangan ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Organisasi</div>
                    <div class="info-card-body">
                        <div class="grid-2">
                            <div class="info-row">
                                <div class="info-label">Sekolah</div>
                                <div class="info-value">{{ $interview->organisasi_sekolah ?? 'Data tidak tersedia' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Masyarakat</div>
                                <div class="info-value">{{ $interview->organisasi_masyarakat ?? 'Data tidak tersedia' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Informasi Lainnya</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Hobi</div>
                            <div class="info-value">{{ $interview->hobi ?? 'Data tidak tersedia' }}</div>
                        </div>
                        <div class="grid-3 mt-3">
                            <div class="info-row">
                                <div class="info-label">Uang Saku</div>
                                <div class="info-value">Rp {{ number_format(str_replace('.', '', $interview->uang_saku), 0, ',', '.') }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Kemampuan Bermotor</div>
                                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $interview->kemampuan_bermotor)) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Kesimpulan</div>
                    <div class="info-card-body">
                        <div class="grid-2">
                            <div class="info-row">
                                <div class="info-label">Komunikasi</div>
                                <div class="info-value">
                                    <span class="badge-custom {{ $interview->nilai_komunikasi == 'baik' ? 'badge-success' : ($interview->nilai_komunikasi == 'cukup' ? 'badge-warning' : 'badge-danger') }}">
                                        {{ ucfirst($interview->nilai_komunikasi) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Percaya Diri</div>
                                <div class="info-value">
                                    <span class="badge-custom {{ $interview->nilai_kepercayaan_diri == 'baik' ? 'badge-success' : ($interview->nilai_kepercayaan_diri == 'cukup' ? 'badge-warning' : 'badge-danger') }}">
                                        {{ ucfirst($interview->nilai_kepercayaan_diri) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Sekolah Asal -->
        <div class="section-header">
            <i class="fas fa-school me-2"></i> Data Sekolah Asal
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="info-card">
                    <div class="info-card-header">Prestasi yang Dicapai</div>
                    <div class="info-card-body">
                        @if(isset($interview->prestasi_yang_dicapai))
                            @php $prestasi = json_decode($interview->prestasi_yang_dicapai, true); @endphp
                            @if(is_array($prestasi) && count($prestasi) > 0)
                                <ul class="list-data">
                                    @foreach($prestasi as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="info-value">Data tidak tersedia</div>
                            @endif
                        @else
                            <div class="info-value">Data tidak tersedia</div>
                        @endif
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Mata Pelajaran yang Disukai</div>
                    <div class="info-card-body">
                        <div class="info-value">{{ str_replace('_', ' ', $interview->mata_pelajaran) }}</div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Rencana Pilihan Sekolah</div>
                    <div class="info-card-body">
                        @if(isset($interview->rencana_pilihan_sekolah) && isset($interview->alasan_pilihan_sekolah))
                            @php
                                $rencana = json_decode($interview->rencana_pilihan_sekolah, true);
                                $alasan = json_decode($interview->alasan_pilihan_sekolah, true);
                                $count = max(count($rencana), count($alasan));
                            @endphp
                            @if(is_array($rencana) && is_array($alasan) && $count > 0)
                                <div class="table-responsive">
                                    <table class="table-custom">
                                        <thead>
                                            <tr>
                                                <th width="40%">Sekolah</th>
                                                <th width="60%">Alasan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($i = 0; $i < $count; $i++)
                                                <tr>
                                                    <td>{{ $rencana[$i] ?? '-' }}</td>
                                                    <td>{{ $alasan[$i] ?? '-' }}</td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="info-value">Data tidak tersedia</div>
                            @endif
                        @else
                            <div class="info-value">Data tidak tersedia</div>
                        @endif
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Informasi Akademik</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Kenalan yang Diterima di SMKI Utama</div>
                            <div class="info-value">{{ $interview->kenalan_yang_diterima_di_smki ?? 'Data tidak tersedia' }}</div>
                        </div>

                        <div class="grid-3 mt-3">
                            <div class="info-row">
                                <div class="info-label">Sakit</div>
                                <div class="info-value">{{ $interview->historis_sakit ?? '0' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Ijin</div>
                                <div class="info-value">{{ $interview->historis_ijin ?? '0' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Alfa</div>
                                <div class="info-value">{{ $interview->historis_alfa ?? '0' }}</div>
                            </div>
                        </div>

                        <div class="info-row mt-3">
                            <div class="info-label">Catatan Kasus Pelanggaran</div>
                            <div class="info-value">{{ $interview->catatan_kasus_pelanggaran ?? 'Data tidak tersedia' }}</div>
                        </div>

                        <div class="grid-2 mt-3">
                            <div class="info-row">
                                <div class="info-label">BHQ</div>
                                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $interview->bhq)) }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Hafalan Juz</div>
                                <div class="info-value">{{ $interview->hafalan_juz ?? 'Data tidak tersedia' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Kesehatan Jiwa Raga -->
        <div class="section-header">
            <i class="fas fa-heartbeat me-2"></i> Data Kesehatan Jiwa Raga
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="grid-2">
                    <div class="info-card">
                        <div class="info-card-header">Merokok / Narkoba</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->merokok_narkoba ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Jenis, Merek, dan Harga</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->jenis_merek_harga ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Anggota Keluarga yang Merokok</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->anggota_keluarga_yg_merokok ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Riwayat Kesehatan</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->riwayat_kesehatan ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid-2 mt-3">
                    <div class="info-card">
                        <div class="info-card-header">Ketertarikan dengan Lawan Jenis</div>
                        <div class="info-card-body">
                            <div class="info-value">
                                @if($interview->ketertarikan_dengan_lawan_jenis == 'tidak_pacaran')
                                    Tidak Pacaran
                                @elseif($interview->ketertarikan_dengan_lawan_jenis == 'pacaran')
                                    Pacaran
                                @elseif($interview->ketertarikan_dengan_lawan_jenis == 'pernah_pacaran')
                                    Pernah Pacaran
                                @else
                                    Data tidak tersedia
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Terpapar Pornografi</div>
                        <div class="info-card-body">
                            <div class="info-value">
                                @if($interview->terpapar_pornografi == 'melihat_gambar')
                                    Melihat Gambar
                                @elseif($interview->terpapar_pornografi == 'menonton_video')
                                    Menonton Video
                                @elseif($interview->terpapar_pornografi == 'menyebarluaskan')
                                    Menyebarluaskan
                                @elseif($interview->terpapar_pornografi == 'tidak_terpapar')
                                    Tidak Terpapar
                                @else
                                    Data tidak tersedia
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Media Sosial yang Digunakan</div>
                    <div class="info-card-body">
                        @if(isset($interview->media_sosial))
                            @php $mediaSosial = json_decode($interview->media_sosial, true); @endphp
                            @if(is_array($mediaSosial) && count($mediaSosial) > 0)
                                <div class="tag-list">
                                    @foreach($mediaSosial as $media)
                                        <span class="tag">{{ $media }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div class="info-value">Data tidak tersedia</div>
                            @endif
                        @else
                            <div class="info-value">Data tidak tersedia</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tanggungan Keluarga -->
        <div class="section-header">
            <i class="fas fa-users me-2"></i> Data Tanggungan Keluarga
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Pendidikan</th>
                                <th>Kelas</th>
                                <th>Pekerjaan</th>
                                <th>Hubungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($interview->nama_lengkap_keluarga) &&
                                  isset($interview->jenis_kelamin) &&
                                  isset($interview->usia) &&
                                  isset($interview->pendidikan) &&
                                  isset($interview->kelas) &&
                                  isset($interview->pekerjaan) &&
                                  isset($interview->hubungan))
                                @php
                                    $nama = json_decode($interview->nama_lengkap_keluarga, true) ?: [];
                                    $jenisKelamin = json_decode($interview->jenis_kelamin, true) ?: [];
                                    $usia = json_decode($interview->usia, true) ?: [];
                                    $pendidikan = json_decode($interview->pendidikan, true) ?: [];
                                    $kelas = json_decode($interview->kelas, true) ?: [];
                                    $pekerjaan = json_decode($interview->pekerjaan, true) ?: [];
                                    $hubungan = json_decode($interview->hubungan, true) ?: [];

                                    $count = max(
                                        count($nama),
                                        count($jenisKelamin),
                                        count($usia),
                                        count($pendidikan),
                                        count($kelas),
                                        count($pekerjaan),
                                        count($hubungan)
                                    );
                                @endphp

                                @if($count > 0)
                                    @for ($i = 0; $i < $count; $i++)
                                        <tr>
                                            <td>{{ $nama[$i] ?? '-' }}</td>
                                            <td>{{ $jenisKelamin[$i] ?? '-' }}</td>
                                            <td>{{ $usia[$i] ?? '-' }}</td>
                                            <td>{{ $pendidikan[$i] ?? '-' }}</td>
                                            <td>{{ $kelas[$i] ?? '-' }}</td>
                                            <td>{{ $pekerjaan[$i] ?? '-' }}</td>
                                            <td>{{ $hubungan[$i] ?? '-' }}</td>
                                        </tr>
                                    @endfor
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak tersedia</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 text-muted fst-italic">
                    <small>* Ibu / Isteri termasuk dalam tanggungan orang tua</small>
                </div>
            </div>
        </div>

        <!-- Data Situasi Keluarga -->
        <div class="section-header">
            <i class="fas fa-home me-2"></i> Data Situasi Keluarga Siswa
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="grid-2">
                    <div class="info-card">
                        <div class="info-card-header">Siswa Tinggal Bersama</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->siswa_tinggal_bersama ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Status Pernikahan Orang Tua</div>
                        <div class="info-card-body">
                            <div class="info-value">
                                @if($interview->status_pernikahan_ortu == 'Lain-lain')
                                    {{ $interview->status_pernikahan_ortu_lainnya ?? 'Lain-lain' }}
                                @else
                                    {{ $interview->status_pernikahan_ortu ?? 'Data tidak tersedia' }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Status Rumah</div>
                        <div class="info-card-body">
                            <div class="info-value">
                                {{ $interview->status_rumah ?? 'Data tidak tersedia' }}
                                @if($interview->status_rumah == 'Kontrak')
                                    <div><small class="text-muted">Harga Kontrak:</small> Rp {{ number_format(str_replace('.', '', $interview->harga_kontrak), 0, ',', '.') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Daya & Biaya Listrik</div>
                        <div class="info-card-body">
                            <div class="info-value">
                                <div><small class="text-muted">Daya:</small> {{ $interview->daya_listrik ?? '0' }} Watt</div>
                                <div><small class="text-muted">Biaya per Bulan:</small> Rp {{ number_format(str_replace('.', '', $interview->biaya_listrik), 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Transportasi yang Dimiliki</div>
                    <div class="info-card-body">
                        @if(isset($interview->transportasi_yg_dimiliki))
                            @php $transportasi = json_decode($interview->transportasi_yg_dimiliki, true); @endphp
                            @if(is_array($transportasi) && count($transportasi) > 0)
                                <div class="tag-list">
                                    @foreach($transportasi as $transport)
                                        <span class="tag">{{ $transport }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div class="info-value">Data tidak tersedia</div>
                            @endif
                        @else
                            <div class="info-value">Data tidak tersedia</div>
                        @endif
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Harta Milik Keluarga</div>
                    <div class="info-card-body">
                        @if(isset($interview->harta_milik_keluarga))
                            @php $harta = json_decode($interview->harta_milik_keluarga, true); @endphp
                            @if(is_array($harta) && count($harta) > 0)
                                <div class="tag-list">
                                    @foreach($harta as $item)
                                        <span class="tag">{{ $item }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div class="info-value">Data tidak tersedia</div>
                            @endif
                        @else
                            <div class="info-value">Data tidak tersedia</div>
                        @endif
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Perhiasan</div>
                    <div class="info-card-body">
                        <div class="grid-4">
                            <div class="info-row">
                                <div class="info-label">Kalung</div>
                                <div class="info-value">{{ $interview->berat_kalung_gr ?? '0' }} gr</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Cincin</div>
                                <div class="info-value">{{ $interview->berat_cincin_gr ?? '0' }} gr</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Gelang</div>
                                <div class="info-value">{{ $interview->berat_gelang_gr ?? '0' }} gr</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Anting</div>
                                <div class="info-value">{{ $interview->berat_anting_gr ?? '0' }} gr</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Tanggungan Kredit</div>
                    <div class="info-card-body">
                        <div class="info-value">Rp {{ number_format(str_replace('.', '', $interview->tanggungan_kredit), 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Pendapat tentang Perhatian Orang Tua</div>
                    <div class="info-card-body">
                        <div class="info-value">{{ $interview->pendapat ?? 'Data tidak tersedia' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontak Darurat -->
        <div class="section-header">
            <i class="fas fa-phone-alt me-2"></i> Kontak Darurat
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="grid-2">
                    <div class="info-card">
                        <div class="info-card-header">Nama</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->nama ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Hubungan dengan Siswa</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->hubungan_dgn_siswa ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Nomor Telepon</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->no_telepon ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Nomor HP</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->no_hp ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Alamat</div>
                    <div class="info-card-body">
                        <div class="info-value">{{ $interview->alamat_kontak_darurat ?? 'Data tidak tersedia' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Tambahan -->
        <div class="section-header">
            <i class="fas fa-info-circle me-2"></i> Detail Tambahan
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="grid-2">
                    <div class="info-card">
                        <div class="info-card-header">Nama Lengkap</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->nama_lengkap ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">Nama Panggilan di Lingkungan</div>
                        <div class="info-card-body">
                            <div class="info-value">{{ $interview->nama_panggilan_di_lingkungan ?? 'Data tidak tersedia' }}</div>
                        </div>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header">Ciri-ciri Rumah</div>
                    <div class="info-card-body">
                        @if(isset($interview->ciri_ciri_rumah))
                            @php $ciriRumah = json_decode($interview->ciri_ciri_rumah, true); @endphp
                            @if(is_array($ciriRumah) && count($ciriRumah) > 0)
                                <ul class="list-data">
                                    @foreach($ciriRumah as $ciri)
                                        <li>{{ $ciri }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="info-value">Data tidak tersedia</div>
                            @endif
                        @else
                            <div class="info-value">Data tidak tersedia</div>
                        @endif
                    </div>
                </div>

                @if($interview->denah_lokasi)
                    <div class="info-card mt-3">
                        <div class="info-card-header">Denah Lokasi</div>
                        <div class="info-card-body text-center">
                            <img src="{{ asset('storage/'.$interview->denah_lokasi) }}"
                                 alt="Denah Lokasi"
                                 class="img-fluid rounded border"
                                 style="max-height: 300px;">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kesimpulan dan Saran -->
        <div class="section-header">
            <i class="fas fa-clipboard-check me-2"></i> Kesimpulan dan Saran
        </div>
        <div class="info-card">
            <div class="info-card-body">
                <div class="info-value">{{ $interview->kesimpulan ?? 'Data tidak tersedia' }}</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('form_interview.index') }}" class="btn btn-secondary btn-action">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
@endsection
