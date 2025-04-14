@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Data Survey</title>
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

            .badge-diterima {
                background-color: #d1e7dd;
                color: #0f5132;
                border: 1px solid #badbcc;
            }

            .badge-ditolak {
                background-color: #f8d7da;
                color: #842029;
                border: 1px solid #f5c2c7;
            }

            .badge-abu-abu {
                background-color: #e2e3e5;
                color: #41464b;
                border: 1px solid #d3d6d8;
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
            }
        </style>
    </head>

    <body>
        <div class="main-container">

            <!-- Informasi Surveyor -->
            <div class="section-header">
                <i class="fas fa-user-check me-2"></i> Informasi Surveyor
            </div>
            <div class="info-card">
                <div class="info-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Nama Surveyor</div>
                                <div class="info-value">{{ $formSurvey->pendataanSurveyor->user->name ?? 'Tidak ada data' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Tanggal Survey</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($formSurvey->tanggal_survey)->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Calon Siswa -->
            <div class="section-header">
                <i class="fas fa-user-graduate me-2"></i> Data Calon Siswa
            </div>
            <div class="info-card">
                <div class="info-card-body">
                    <div class="info-row">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">
                            {{ $formSurvey->formInterview->formPendaftaran->registrasiPengambilan->nama ?? 'Tidak ada data' }}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">Rata-rata TPA</div>
                                <div class="info-card-body">
                                    <div class="info-row">
                                        <div class="info-label">Rata-rata</div>
                                        <div class="info-value">{{ $formSurvey->rata2_tpa ?? '-' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Max</div>
                                        <div class="info-value">{{ $formSurvey->max_tpa ?? '-' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Min</div>
                                        <div class="info-value">{{ $formSurvey->min_tpa ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">Rata-rata Tes Al-Qur'an</div>
                                <div class="info-card-body">
                                    <div class="info-row">
                                        <div class="info-label">Rata-rata</div>
                                        <div class="info-value">{{ $formSurvey->rata2_tes_alquran ?? '-' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Max</div>
                                        <div class="info-value">{{ $formSurvey->max_alquran ?? '-' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Min</div>
                                        <div class="info-value">{{ $formSurvey->min_alquran ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Tanggungan Orang Tua -->
            <div class="section-header">
                <i class="fas fa-users me-2"></i> Data Tanggungan Orang Tua
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
                                @if (isset($formSurvey->nama_lengkap_keluarga) &&
                                        isset($formSurvey->jenis_kelamin) &&
                                        isset($formSurvey->usia) &&
                                        isset($formSurvey->pendidikan) &&
                                        isset($formSurvey->kelas) &&
                                        isset($formSurvey->pekerjaan) &&
                                        isset($formSurvey->hubungan))
                                    @php
                                        $nama = json_decode($formSurvey->nama_lengkap_keluarga, true) ?: [];
                                        $jenisKelamin = json_decode($formSurvey->jenis_kelamin, true) ?: [];
                                        $usia = json_decode($formSurvey->usia, true) ?: [];
                                        $pendidikan = json_decode($formSurvey->pendidikan, true) ?: [];
                                        $kelas = json_decode($formSurvey->kelas, true) ?: [];
                                        $pekerjaan = json_decode($formSurvey->pekerjaan, true) ?: [];
                                        $hubungan = json_decode($formSurvey->hubungan, true) ?: [];

                                        $count = max(
                                            count($nama),
                                            count($jenisKelamin),
                                            count($usia),
                                            count($pendidikan),
                                            count($kelas),
                                            count($pekerjaan),
                                            count($hubungan),
                                        );
                                    @endphp

                                    @if ($count > 0)
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
                                            <td colspan="7" class="text-center">Tidak ada data tanggungan</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data tanggungan</td>
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

            <!-- Data Orang Tua -->
            <div class="section-header">
                <i class="fas fa-user-friends me-2"></i> Data Orang Tua
            </div>
            <div class="info-card">
                <div class="info-card-body">
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th width="30%">Jenis Income</th>
                                    <th width="35%">Ayah</th>
                                    <th width="35%">Ibu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Income Form</td>
                                    <td>{{ $formSurvey->income_form_ayah ?? '-' }}</td>
                                    <td>{{ $formSurvey->income_form_ibu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Income Interview</td>
                                    <td>{{ $formSurvey->income_interview_ayah ?? '-' }}</td>
                                    <td>{{ $formSurvey->income_interview_ibu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Income Survey</td>
                                    <td>{{ $formSurvey->income_survey_ayah ?? '-' }}</td>
                                    <td>{{ $formSurvey->income_survey_ibu ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Validasi Tambahan -->
            <div class="section-header">
                <i class="fas fa-clipboard-check me-2"></i> Validasi Tambahan
            </div>
            <div class="info-card">
                <div class="info-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">Informasi Rumah</div>
                                <div class="info-card-body">
                                    <div class="info-row">
                                        <div class="info-label">Status Rumah</div>
                                        <div class="info-value">{{ $formSurvey->status_rumah ?? '-' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Biaya Per-Bulan</div>
                                        <div class="info-value">Rp {{ number_format(str_replace('.', '', $formSurvey->biaya_hidup_perbulan ?? 0), 0, ',', '.') }} / Bln</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Luas Bangunan</div>
                                        <div class="info-value">± {{ $formSurvey->luas_bangunan ?? '-' }} m²</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Luas Tanah</div>
                                        <div class="info-value">± {{ $formSurvey->luas_tanah ?? '-' }} m²</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">Fasilitas & Listrik</div>
                                <div class="info-card-body">
                                    <div class="info-row">
                                        <div class="info-label">Fasilitas Ruang Tamu</div>
                                        <div class="info-value">{{ $formSurvey->fasilitas_ruang_tamu ?? '0' }} RT</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Fasilitas Ruang Keluarga</div>
                                        <div class="info-value">{{ $formSurvey->fasilitas_ruang_keluarga ?? '0' }} RK</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Fasilitas Kamar Tidur</div>
                                        <div class="info-value">{{ $formSurvey->fasilitas_kamar_tidur ?? '0' }} KT + Dapur + WC</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Besar Listrik</div>
                                        <div class="info-value">{{ $formSurvey->besar_listrik ?? '-' }} KWh</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Biaya Listrik</div>
                                        <div class="info-value">Rp {{ number_format($formSurvey->biaya_listrik ?? 0, 0, ',', '.') }} / Bln</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">Harta Milik Keluarga</div>
                                <div class="info-card-body">
                                    @if (isset($formSurvey->harta_milik_keluarga))
                                        @php
                                            $harta = json_decode($formSurvey->harta_milik_keluarga, true);
                                        @endphp
                                        @if (is_array($harta) && count($harta) > 0)
                                            <ul class="list-data">
                                                @foreach ($harta as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-center py-2">Tidak ada data harta milik keluarga</p>
                                        @endif
                                    @else
                                        <p class="text-center py-2">Tidak ada data harta milik keluarga</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">Tanggungan Hutang</div>
                                <div class="info-card-body">
                                    @if (isset($formSurvey->tanggungan_hutang))
                                        @php
                                            $hutang = json_decode($formSurvey->tanggungan_hutang, true);
                                        @endphp
                                        @if (is_array($hutang) && count($hutang) > 0)
                                            <ul class="list-data">
                                                @foreach ($hutang as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-center py-2">Tidak ada data tanggungan hutang</p>
                                        @endif
                                    @else
                                        <p class="text-center py-2">Tidak ada data tanggungan hutang</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kesimpulan -->
            <div class="section-header">
                <i class="fas fa-flag-checkered me-2"></i> Kesimpulan
            </div>
            <div class="info-card">
                <div class="info-card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-card">
                                <div class="info-card-header">Alasan Pendukung</div>
                                <div class="info-card-body">
                                    @if (isset($formSurvey->alasan_pendukung))
                                        @php
                                            $alasanPendukung = json_decode($formSurvey->alasan_pendukung, true);
                                        @endphp
                                        @if (is_array($alasanPendukung) && count($alasanPendukung) > 0)
                                            <ul class="list-data">
                                                @foreach ($alasanPendukung as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-center py-2">Tidak ada data alasan pendukung</p>
                                        @endif
                                    @else
                                        <p class="text-center py-2">Tidak ada data alasan pendukung</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <div class="info-card-header">Alasan Memberatkan</div>
                                <div class="info-card-body">
                                    @if (isset($formSurvey->alasan_memberatkan))
                                        @php
                                            $alasanMemberatkan = json_decode($formSurvey->alasan_memberatkan, true);
                                        @endphp
                                        @if (is_array($alasanMemberatkan) && count($alasanMemberatkan) > 0)
                                            <ul class="list-data">
                                                @foreach ($alasanMemberatkan as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-center py-2">Tidak ada data alasan memberatkan</p>
                                        @endif
                                    @else
                                        <p class="text-center py-2">Tidak ada data alasan memberatkan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <div class="info-card-header">Saran Rekomendasi</div>
                                <div class="info-card-body text-center py-4">
                                    @if (isset($formSurvey->saran_rekomendasi))
                                        <div class="mt-2 mb-2">
                                            <span class="badge-custom
                                                @if ($formSurvey->saran_rekomendasi == 'Diterima')
                                                    badge-diterima
                                                @elseif ($formSurvey->saran_rekomendasi == 'Ditolak')
                                                    badge-ditolak
                                                @else
                                                    badge-abu-abu
                                                @endif
                                            ">
                                                {{ $formSurvey->saran_rekomendasi }}
                                            </span>
                                        </div>
                                    @else
                                        <p>Tidak ada rekomendasi</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('form_survey.index') }}" class="btn btn-secondary btn-action">
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
