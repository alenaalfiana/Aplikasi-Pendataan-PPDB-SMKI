@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    @php
        $backUrl = route('form_pendaftaran.index'); // Default kembali ke index

        if (request()->query('from') === 'data_kelengkapan_create') {
            $backUrl = route('data_kelengkapan.create');
        } elseif (request()->query('from') === 'data_kelengkapan_edit' && request()->query('id_data_kelengkapan')) {
            $backUrl = route('data_kelengkapan.edit', ['id' => request()->query('id_data_kelengkapan')]);
        } elseif (request()->query('from') === 'form_interview_create') {
            $backUrl = route('form_interview.create'); // Kembali ke form_interview.create
        }
    @endphp

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0" style="color: #fff">Detail Pendaftaran - {{ $pendaftaran->registrasiPengambilan->nama }} ( {{ $pendaftaran->registrasiPengambilan->no_pendaftar }} )
                </h3>
                <a href="{{ $backUrl }}" class="btn btn-outline-light">Kembali</a>
            </div>

            <!-- Data Pribadi Section -->
            <div class="card-body mt-5">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="section-title"><strong>A. Data Pribadi</strong></h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th width="30%">No Pendaftaran</th>
                                    <td>{{ $pendaftaran->registrasiPengambilan->no_pendaftar }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $pendaftaran->registrasiPengambilan->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NISN</th>
                                    <td>{{ $pendaftaran->nisn }}</td>
                                </tr>
                                <tr>
                                    <th>Ukuran Baju</th>
                                    <td><span class="badge bg-info">{{ $pendaftaran->ukuran_baju }}</span></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        <span
                                            class="badge
                                        @if ($pendaftaran->jenis_kelamin == 'laki-laki') bg-primary
                                        @elseif($pendaftaran->jenis_kelamin == 'perempuan')
                                            bg-pink @endif">
                                            {{ $pendaftaran->jenis_kelamin }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td>{{ $pendaftaran->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Rumah</th>
                                    <td>
                                        {{ $pendaftaran->alamat_lengkap }}<br>
                                        {{ $pendaftaran->village->name }}, {{ $pendaftaran->district->name }}<br>
                                        {{ $pendaftaran->regency->name }}, {{ $pendaftaran->province->name }}
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="photo-container">
                            <img src="{{ asset('storage/' . $pendaftaran->pas_foto) }}" alt="Pas Foto"
                                class="img-thumbnail mb-2">
                            <p class="text-muted small">Pas Foto</p>
                        </div>
                    </div>
                </div>

                <br>
                <!-- Data Orang Tua Section -->
                <div class="mt-4">
                    <h4 class="section-title"><strong>B. Data Orang Tua dan Wali</strong></h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    Data Ayah
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $pendaftaran->nama_ayah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usia</th>
                                            <td>{{ $pendaftaran->usia_ayah }} Tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Pendidikan</th>
                                            <td>{{ $pendaftaran->pendidikan_ayah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $pendaftaran->pekerjaan_ayah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penghasilan</th>
                                            <td>Rp {{ $pendaftaran->penghasilan_ayah }} /bulan</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $pendaftaran->alamat_lengkap_ayah }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon/HP</th>
                                            <td>{{ $pendaftaran->no_telepon_ayah }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    Data Ibu
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $pendaftaran->nama_ibu }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usia</th>
                                            <td>{{ $pendaftaran->usia_ibu }} Tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Pendidikan</th>
                                            <td>{{ $pendaftaran->pendidikan_ibu }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $pendaftaran->pekerjaan_ibu }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penghasilan</th>
                                            <td>Rp {{ $pendaftaran->penghasilan_ibu }} /bulan</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $pendaftaran->alamat_lengkap_ibu }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon/HP</th>
                                            <td>{{ $pendaftaran->no_telepon_ibu }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-secondary text-white">
                                    Data Wali
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $pendaftaran->nama_wali }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usia</th>
                                            <td>{{ $pendaftaran->usia_wali }} Tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Pendidikan</th>
                                            <td>{{ $pendaftaran->pendidikan_wali }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $pendaftaran->pekerjaan_wali }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penghasilan</th>
                                            <td>Rp {{ $pendaftaran->penghasilan_wali }} /bulan</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $pendaftaran->alamat_lengkap_wali }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon/HP</th>
                                            <td>{{ $pendaftaran->no_telepon_wali }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Sekolah Asal Section -->
                <div class="mt-4">
                    <h4 class="section-title"><strong>C. Data Sekolah Asal</strong></h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th width="30%">Asal Sekolah</th>
                                <td>{{ $pendaftaran->asal_sekolah }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Sekolah</th>
                                <td>{{ $pendaftaran->alamat_lengkap_sekolah }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Lulus</th>
                                <td>{{ $pendaftaran->tahun_lulus }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <br>
                <div class="mt-4">
                    <h4 class="section-title"><strong>D. Persyaratan Dokumen</strong></h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center">
                            <thead>
                                <tr>
                                    <th>Dokumen</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="align-middle text-start">Akta Lahir</th>
                                    <td class="align-middle">{!! $pendaftaran->akta_lahir === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->akta_lahir !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">Kartu Keluarga</th>
                                    <td class="align-middle">{!! $pendaftaran->kartu_keluarga === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->kartu_keluarga !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">Pas Foto 3x4</th>
                                    <td class="align-middle">{!! $pendaftaran->pas_foto_3x4 === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->pas_foto_3x4 !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">SKTM Kelurahan</th>
                                    <td class="align-middle">{!! $pendaftaran->sktm_kelurahan === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->sktm_kelurahan !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">Kartu KIP</th>
                                    <td class="align-middle">{!! $pendaftaran->kartu_kip === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->kartu_kip !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">Raport SMP</th>
                                    <td class="align-middle">{!! $pendaftaran->raport_smp === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->raport_smp !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">Ijazah Legalisir</th>
                                    <td class="align-middle">{!! $pendaftaran->ijazah_legalisir === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->ijazah_legalisir !!}</td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start">KTP Orang Tua / Wali</th>
                                    <td class="align-middle">{!! $pendaftaran->ktp_ortu_wali === 'ada' ? '<i class="text-success bx bx-check-circle fs-4"></i>' : $pendaftaran->ktp_ortu_wali !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th class="align-middle text-start">Status Dokumen</th>
                                <td class="align-middle">{{ $pendaftaran->status }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tanda Tangan Section -->
                <div class="mt-4 text-end">
                    <h6>
                        <p class="mb-1">Tanggal Pengembalian:
                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mendaftar)->format('d-m-Y') }}</p>
                    </h6>
                    <img src="{{ asset('storage/' . $pendaftaran->tanda_tangan_siswa) }}" alt="Tanda Tangan" width="500"
                        height="100" class="mt-2">
                    <p class="text-muted small">Tanda Tangan Siswa</p>
                </div>

                <br>

                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('form_pendaftaran.index') }}" class="btn btn-secondary">
                        <i class="menu-icon tf-icons bx bx-arrow-back"></i> Kembali
                    </a>

                    <div>
                        <a href="{{ route('form_pendaftaran.download', $pendaftaran->id_form_pendaftaran) }}" class="btn btn-success">
                            <i class="menu-icon tf-icons bx bxs-printer"></i>
                        </a>

                        <a href="{{ route('form_pendaftaran.edit', $pendaftaran->id_form_pendaftaran) }}" class="btn btn-warning">
                            <i class="menu-icon tf-icons bx bx-edit"></i>
                        </a>

                        <form action="{{ route('form_pendaftaran.destroy', $pendaftaran->id_form_pendaftaran) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="menu-icon tf-icons bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .bg-pink {
            background-color: #f78fb3;
            /* Warna pink */
            color: white;
            /* Agar teks di dalam badge tetap terlihat jelas */
        }


        .section-title {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #3498db;
            color: white;
            padding: 1rem 1.5rem;
        }

        .photo-container {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .photo-container img {
            max-width: 245px;
            height: 295px;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 1em;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .card-header .btn {
                margin-top: 1rem;
            }

            .photo-container {
                margin-top: 2rem;
            }
        }
    </style>
@endsection
