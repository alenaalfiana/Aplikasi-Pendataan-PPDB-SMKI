@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Data Sekolah Asal</title>
        <style>
            body {
                background-color: #f8f9fa;
            }

            .card {
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            .form-label::after {
                content: " *";
                color: red;
            }

            .img-preview {
                max-width: 200px;
                max-height: 200px;
                object-fit: cover;
            }

            .card-header {
                align-items: center;
                display: flex;
                height: 3.3rem;
            }
        </style>
    </head>

    <body>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('form_survey.store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div id="section-data-calon-siswa">

                                    <div class="mb-5">
                                        <label for="id_pendataan_surveyor_siswa" class="form-label">Surveyor</label>
                                        <input type="text" class="form-control"
                                            value="{{ $pendataan->user->name ?? 'User Tidak Ditemukan' }}" disabled>
                                        <input type="hidden" name="id_pendataan_surveyor_siswa"
                                            value="{{ $pendataan->id_pendataan_surveyor_siswa ?? '' }}">
                                    </div>

                                    <hr />
                                    <h4>Data Calon Siswa</h4>

                                    <div class="mb-3">
                                        <label for="id_form_pendaftaran" class="form-label">Nama Lengkap - Calon
                                            Siswa</label>
                                        <input type="text" class="form-control"
                                            value="{{ $formPendaftaran->registrasiPengambilan->nama ?? 'Nama Tidak Ditemukan' }}"
                                            readonly>
                                        <input type="hidden" name="id_form_pendaftaran"
                                            value="{{ $formPendaftaran->id_form_pendaftaran }}">
                                    </div>
                                    <br>
                                </div>

                                <!-- Tambahkan section tanggungan keluarga di bawah ini -->
                                <div id="section-tanggungan-keluarga">
                                    <h4>Data Tanggungan Keluarga</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Lengkap</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Usia</th>
                                                    <th>Pendidikan</th>
                                                    <th>Kelas</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Hubungan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tanggungan-body">
                                                @if (isset($formInterview->nama_lengkap_keluarga) &&
                                                        isset($formInterview->jenis_kelamin) &&
                                                        isset($formInterview->usia) &&
                                                        isset($formInterview->pendidikan) &&
                                                        isset($formInterview->kelas) &&
                                                        isset($formInterview->pekerjaan) &&
                                                        isset($formInterview->hubungan))
                                                    @php
                                                        $nama =
                                                            json_decode($formInterview->nama_lengkap_keluarga, true) ?:
                                                            [];
                                                        $jenisKelamin =
                                                            json_decode($formInterview->jenis_kelamin, true) ?: [];
                                                        $usia = json_decode($formInterview->usia, true) ?: [];
                                                        $pendidikan =
                                                            json_decode($formInterview->pendidikan, true) ?: [];
                                                        $kelas = json_decode($formInterview->kelas, true) ?: [];
                                                        $pekerjaan = json_decode($formInterview->pekerjaan, true) ?: [];
                                                        $hubungan = json_decode($formInterview->hubungan, true) ?: [];

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
                                                            <tr class="tanggungan-row">
                                                                <td><input type="text" name="nama_lengkap_keluarga[]"
                                                                        class="form-control" value="{{ $nama[$i] ?? '' }}"
                                                                        required>
                                                                </td>
                                                                <td>
                                                                    <select name="jenis_kelamin[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="Laki-laki"
                                                                            {{ isset($jenisKelamin[$i]) && $jenisKelamin[$i] == 'Laki-laki' ? 'selected' : '' }}>
                                                                            L</option>
                                                                        <option value="Perempuan"
                                                                            {{ isset($jenisKelamin[$i]) && $jenisKelamin[$i] == 'Perempuan' ? 'selected' : '' }}>
                                                                            P</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" name="usia[]"
                                                                        class="form-control" value="{{ $usia[$i] ?? '' }}"
                                                                        required></td>
                                                                <td>
                                                                    <select name="pendidikan[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="SD/MI"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SD/MI' ? 'selected' : '' }}>
                                                                            SD/MI</option>
                                                                        <option value="SMP/MTs"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SMP/MTs' ? 'selected' : '' }}>
                                                                            SMP/MTs</option>
                                                                        <option value="SMA/MA"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SMA/MA' ? 'selected' : '' }}>
                                                                            SMA/MA</option>
                                                                        <option value="SMK"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SMK' ? 'selected' : '' }}>
                                                                            SMK</option>
                                                                        <option value="S1"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'S1' ? 'selected' : '' }}>
                                                                            S1</option>
                                                                        <option value="S2"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'S2' ? 'selected' : '' }}>
                                                                            S2</option>
                                                                        <option value="S3"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'S3' ? 'selected' : '' }}>
                                                                            S3</option>
                                                                        <option value="Lainnya"
                                                                            {{ isset($pendidikan[$i]) && !in_array($pendidikan[$i], ['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3']) ? 'selected' : '' }}>
                                                                            Lainnya</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="kelas[]"
                                                                        class="form-control"
                                                                        value="{{ $kelas[$i] ?? '' }}"></td>
                                                                <td>
                                                                    <select name="pekerjaan[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="PNS"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'PNS' ? 'selected' : '' }}>
                                                                            PNS</option>
                                                                        <option value="TNI/Polri"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'TNI/Polri' ? 'selected' : '' }}>
                                                                            TNI/Polri</option>
                                                                        <option value="Pegawai Swasta"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pegawai Swasta' ? 'selected' : '' }}>
                                                                            Pegawai Swasta</option>
                                                                        <option value="Wiraswasta"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Wiraswasta' ? 'selected' : '' }}>
                                                                            Wiraswasta</option>
                                                                        <option value="Petani"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Petani' ? 'selected' : '' }}>
                                                                            Petani</option>
                                                                        <option value="Nelayan"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Nelayan' ? 'selected' : '' }}>
                                                                            Nelayan</option>
                                                                        <option value="Buruh"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Buruh' ? 'selected' : '' }}>
                                                                            Buruh</option>
                                                                        <option value="Guru/Dosen"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Guru/Dosen' ? 'selected' : '' }}>
                                                                            Guru/Dosen</option>
                                                                        <option value="Dokter"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Dokter' ? 'selected' : '' }}>
                                                                            Dokter</option>
                                                                        <option value="Pengemudi"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pengemudi' ? 'selected' : '' }}>
                                                                            Pengemudi</option>
                                                                        <option value="Pedagang"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pedagang' ? 'selected' : '' }}>
                                                                            Pedagang</option>
                                                                        <option value="Pensiunan"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pensiunan' ? 'selected' : '' }}>
                                                                            Pensiunan</option>
                                                                        <option value="Tidak Bekerja"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                                            Tidak Bekerja</option>
                                                                        <option value="Lainnya"
                                                                            {{ isset($pekerjaan[$i]) && !in_array($pekerjaan[$i], ['PNS', 'TNI/Polri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter', 'Pengemudi', 'Pedagang', 'Pensiunan', 'Tidak Bekerja']) ? 'selected' : '' }}>
                                                                            Lainnya</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="hubungan[]" class="form-control" required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="Ayah"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Ayah' ? 'selected' : '' }}>
                                                                            Ayah</option>
                                                                        <option value="Ibu"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Ibu' ? 'selected' : '' }}>
                                                                            Ibu</option>
                                                                        <option value="Saudara"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Saudara' ? 'selected' : '' }}>
                                                                            Saudara</option>
                                                                        <option value="Kakek"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Kakek' ? 'selected' : '' }}>
                                                                            Kakek</option>
                                                                        <option value="Nenek"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Nenek' ? 'selected' : '' }}>
                                                                            Nenek</option>
                                                                        <option value="Paman"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Paman' ? 'selected' : '' }}>
                                                                            Paman</option>
                                                                        <option value="Bibi"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Bibi' ? 'selected' : '' }}>
                                                                            Bibi</option>
                                                                        <option value="Lainnya"
                                                                            {{ isset($hubungan[$i]) && !in_array($hubungan[$i], ['Ayah', 'Ibu', 'Saudara', 'Kakek', 'Nenek', 'Paman', 'Bibi']) ? 'selected' : '' }}>
                                                                            Lainnya</option>
                                                                    </select>
                                                                </td>
                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-remove">Hapus</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        <tr class="tanggungan-row">
                                                            <td><input type="text" name="nama_lengkap_keluarga[]"
                                                                    class="form-control" required></td>
                                                            <td>
                                                                <select name="jenis_kelamin[]" class="form-control"
                                                                    required>
                                                                    <option value="">Pilih</option>
                                                                    <option value="Laki-laki">L</option>
                                                                    <option value="Perempuan">P</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="usia[]" class="form-control"
                                                                    required>
                                                            </td>
                                                            <td>
                                                                <select name="pendidikan[]" class="form-control" required>
                                                                    <option value="">Pilih</option>
                                                                    <option value="SD/MI">SD/MI</option>
                                                                    <option value="SMP/MTs">SMP/MTs</option>
                                                                    <option value="SMA/MA">SMA/MA</option>
                                                                    <option value="SMK">SMK</option>
                                                                    <option value="S1">S1</option>
                                                                    <option value="S2">S2</option>
                                                                    <option value="S3">S3</option>
                                                                    <option value="Lainnya">Lainnya</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="kelas[]"
                                                                    class="form-control"></td>
                                                            <td>
                                                                <select name="pekerjaan[]" class="form-control" required>
                                                                    <option value="">Pilih</option>
                                                                    <option value="PNS">PNS</option>
                                                                    <option value="TNI/Polri">TNI/Polri</option>
                                                                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                                                                    <option value="Wiraswasta">Wiraswasta</option>
                                                                    <option value="Petani">Petani</option>
                                                                    <option value="Nelayan">Nelayan</option>
                                                                    <option value="Buruh">Buruh</option>
                                                                    <option value="Guru/Dosen">Guru/Dosen</option>
                                                                    <option value="Dokter">Dokter</option>
                                                                    <option value="Pengemudi">Pengemudi</option>
                                                                    <option value="Pedagang">Pedagang</option>
                                                                    <option value="Pensiunan">Pensiunan</option>
                                                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                                                    <option value="Lainnya">Lainnya</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="hubungan[]" class="form-control" required>
                                                                    <option value="">Pilih</option>
                                                                    <option value="Ayah">Ayah</option>
                                                                    <option value="Ibu">Ibu</option>
                                                                    <option value="Saudara">Saudara</option>
                                                                    <option value="Kakek">Kakek</option>
                                                                    <option value="Nenek">Nenek</option>
                                                                    <option value="Paman">Paman</option>
                                                                    <option value="Bibi">Bibi</option>
                                                                    <option value="Lainnya">Lainnya</option>
                                                                </select>
                                                            </td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-remove">Hapus</button></td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    <tr class="tanggungan-row">
                                                        <td><input type="text" name="nama_lengkap_keluarga[]"
                                                                class="form-control" required></td>
                                                        <td>
                                                            <select name="jenis_kelamin[]" class="form-control" required>
                                                                <option value="">Pilih</option>
                                                                <option value="Laki-laki">L</option>
                                                                <option value="Perempuan">P</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" name="usia[]" class="form-control"
                                                                required>
                                                        </td>
                                                        <td>
                                                            <select name="pendidikan[]" class="form-control" required>
                                                                <option value="">Pilih</option>
                                                                <option value="SD/MI">SD/MI</option>
                                                                <option value="SMP/MTs">SMP/MTs</option>
                                                                <option value="SMA/MA">SMA/MA</option>
                                                                <option value="SMK">SMK</option>
                                                                <option value="S1">S1</option>
                                                                <option value="S2">S2</option>
                                                                <option value="S3">S3</option>
                                                                <option value="Lainnya">Lainnya</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="kelas[]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <select name="pekerjaan[]" class="form-control" required>
                                                                <option value="">Pilih</option>
                                                                <option value="PNS">PNS</option>
                                                                <option value="TNI/Polri">TNI/Polri</option>
                                                                <option value="Pegawai Swasta">Pegawai Swasta</option>
                                                                <option value="Wiraswasta">Wiraswasta</option>
                                                                <option value="Petani">Petani</option>
                                                                <option value="Nelayan">Nelayan</option>
                                                                <option value="Buruh">Buruh</option>
                                                                <option value="Guru/Dosen">Guru/Dosen</option>
                                                                <option value="Dokter">Dokter</option>
                                                                <option value="Pengemudi">Pengemudi</option>
                                                                <option value="Pedagang">Pedagang</option>
                                                                <option value="Pensiunan">Pensiunan</option>
                                                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                                                <option value="Lainnya">Lainnya</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="hubungan[]" class="form-control" required>
                                                                <option value="">Pilih</option>
                                                                <option value="Ayah">Ayah</option>
                                                                <option value="Ibu">Ibu</option>
                                                                <option value="Saudara">Saudara</option>
                                                                <option value="Kakek">Kakek</option>
                                                                <option value="Nenek">Nenek</option>
                                                                <option value="Paman">Paman</option>
                                                                <option value="Bibi">Bibi</option>
                                                                <option value="Lainnya">Lainnya</option>
                                                            </select>
                                                        </td>
                                                        <td><button type="button"
                                                                class="btn btn-danger btn-remove">Hapus</button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <span style="display: block; margin: 10px 0;">Ibu / Isteri termasuk dalam tanggungan orang tua</span>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2"
                                        id="add-tanggungan">Tambah</button>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Fungsi untuk menambah baris baru
                                        document.getElementById('add-tanggungan').addEventListener('click', function() {
                                            const container = document.getElementById('tanggungan-body');
                                            const newRow = document.createElement('tr');
                                            newRow.className = 'tanggungan-row';

                                            newRow.innerHTML = `
                            <td><input type="text" name="nama_lengkap_keluarga[]" class="form-control" required></td>
                            <td>
                                <select name="jenis_kelamin[]" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">L</option>
                                    <option value="Perempuan">P</option>
                                </select>
                            </td>
                            <td><input type="number" name="usia[]" class="form-control" required></td>
                            <td>
                                <select name="pendidikan[]" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="SD/MI">SD/MI</option>
                                    <option value="SMP/MTs">SMP/MTs</option>
                                    <option value="SMA/MA">SMA/MA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </td>
                            <td><input type="text" name="kelas[]" class="form-control"></td>
                            <td>
                                <select name="pekerjaan[]" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="PNS">PNS</option>
                                    <option value="TNI/Polri">TNI/Polri</option>
                                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Nelayan">Nelayan</option>
                                    <option value="Buruh">Buruh</option>
                                    <option value="Guru/Dosen">Guru/Dosen</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="Pengemudi">Pengemudi</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </td>
                            <td>
                                <select name="hubungan[]" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Kakek">Kakek</option>
                                    <option value="Nenek">Nenek</option>
                                    <option value="Paman">Paman</option>
                                    <option value="Bibi">Bibi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>
                        `;

                                            container.appendChild(newRow);

                                            // Tambahkan event listener ke tombol hapus
                                            newRow.querySelector('.btn-remove').addEventListener('click', function() {
                                                removeRow(newRow);
                                            });
                                        });

                                        // Setup event listener untuk tombol hapus yang sudah ada
                                        document.querySelectorAll('.btn-remove').forEach(button => {
                                            button.addEventListener('click', function() {
                                                removeRow(this.closest('.tanggungan-row'));
                                            });
                                        });

                                        // Fungsi untuk menghapus baris
                                        function removeRow(row) {
                                            const rows = document.querySelectorAll('.tanggungan-row');
                                            if (rows.length > 1) {
                                                row.parentNode.removeChild(row);
                                            } else {
                                                // Jika hanya ada satu baris, kosongkan field-nya saja
                                                const inputs = row.querySelectorAll('input, select');
                                                inputs.forEach(input => {
                                                    if (input.tagName === 'SELECT') {
                                                        input.selectedIndex = 0;
                                                    } else {
                                                        input.value = '';
                                                    }
                                                });
                                            }
                                        }
                                    });
                                </script>

                                <hr />
                                <div id="section-data-orang-tua">
                                    <h4>Data Orang Tua</h4>
                                    <div class="table-responsive mb-5">
                                        <table class="table table-bordered text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start"> </th>
                                                    <th>Ayah</th>
                                                    <th>Ibu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-start fw-bold">Income Form</td>
                                                    <td><input type="text" class="form-control" id="income_form_ayah"
                                                            name="income_form_ayah" value="{{ old('income_form_ayah') }}"
                                                            maxlength="10" placeholder="income form ayah..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="income_form_ibu"
                                                            name="income_form_ibu" value="{{ old('income_form_ibu') }}"
                                                            maxlength="10" placeholder="income form ibu..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Income Interview</td>
                                                    <td><input type="text" class="form-control"
                                                            id="income_interview_ayah" name="income_interview_ayah"
                                                            value="{{ old('income_interview_ayah') }}" maxlength="10"
                                                            placeholder="income interview ayah..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                    <td><input type="text" class="form-control"
                                                            id="income_interview_ibu" name="income_interview_ibu"
                                                            value="{{ old('income_interview_ibu') }}" maxlength="10"
                                                            placeholder="income interview ibu..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Income Survey</td>
                                                    <td><input type="text" class="form-control"
                                                            id="income_survey_ayah" name="income_survey_ayah"
                                                            value="{{ old('income_survey_ayah') }}" maxlength="10"
                                                            placeholder="income survey ayah..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="income_survey_ibu"
                                                            name="income_survey_ibu"
                                                            value="{{ old('income_survey_ibu') }}" maxlength="10"
                                                            placeholder="income survey ibu..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <hr />
                                <div id="section-data-validasi-tambahan">
                                    <h4>Validasi Tambahan</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="status_rumah" class="form-label">Status Rumah</label>
                                            <select name="status_rumah" id="status_rumah" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                <option value="Sendiri">Milik Sendiri</option>
                                                <option value="Kontrak">Kontrak</option>
                                                <option value="Menumpang">Menumpang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="biaya_hidup_perbulan" class="form-label">Biaya Per-Bulan
                                                (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="biaya_hidup_perbulan"
                                                    id="biaya_hidup_perbulan" class="form-control"
                                                    oninput="formatRupiah(this)">
                                                <span class="input-group-text">/ Bln</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="form-label">Luas</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">B : ±</span>
                                                <input type="text" name="luas_bangunan" id="luas_bangunan"
                                                    class="form-control">
                                                <span class="input-group-text">m²</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">T : ±</span>
                                                <input type="text" name="luas_tanah" id="luas_tanah"
                                                    class="form-control">
                                                <span class="input-group-text">m²</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="form-label">Fasilitas</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="fasilitas_ruang_tamu"
                                                    id="fasilitas_ruang_tamu" class="form-control" maxlength="2"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">RT +</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="fasilitas_ruang_keluarga"
                                                    id="fasilitas_ruang_keluarga" class="form-control" maxlength="2"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">RK +</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="fasilitas_kamar_tidur"
                                                    id="fasilitas_kamar_tidur" class="form-control" maxlength="2"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">KT + Dapur + WC</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="form-label">Listrik</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name="besar_listrik" id="besar_listrik"
                                                    class="form-control" maxlength="12"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">KWh</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="biaya_listrik" id="biaya_listrik"
                                                    class="form-control" maxlength="12" oninput="formatRupiah(this)">
                                                <span class="input-group-text">/ Bln</span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="harta_milik_keluarga" class="form-label">Harta Milik Keluarga</label>
                                        <div id="harta-container">
                                            @if (isset($formSurvey->harta_milik_keluarga))
                                                @php
                                                    $harta = json_decode($formSurvey->harta_milik_keluarga, true);
                                                @endphp
                                                @if (is_array($harta) && count($harta) > 0)
                                                    @foreach ($harta as $index => $item)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="harta_milik_keluarga[]"
                                                                class="form-control" value="{{ $item }}"
                                                                required>
                                                            <button type="button"
                                                                class="btn btn-danger remove-harta">Hapus</button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="harta_milik_keluarga[]"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-harta">Hapus</button>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="input-group mb-2">
                                                    <input type="text" name="harta_milik_keluarga[]"
                                                        class="form-control" required>
                                                    <button type="button"
                                                        class="btn btn-danger remove-harta">Hapus</button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" id="add-harta">Tambah
                                            harta</button>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Tambah harta baru
                                            document.getElementById('add-harta').addEventListener('click', function() {
                                                const container = document.getElementById('harta-container');
                                                const newRow = document.createElement('div');
                                                newRow.className = 'input-group mb-2';

                                                newRow.innerHTML = `
                                                                <input type="text" name="harta_milik_keluarga[]" class="form-control" required>
                                                                <button type="button" class="btn btn-danger remove-harta">Hapus</button>
                                                            `;

                                                container.appendChild(newRow);

                                                // Tambahkan event listener ke tombol hapus
                                                newRow.querySelector('.remove-harta').addEventListener('click', function() {
                                                    container.removeChild(newRow);
                                                });
                                            });

                                            // Hapus harta (untuk elemen yang sudah ada)
                                            document.querySelectorAll('.remove-harta').forEach(button => {
                                                button.addEventListener('click', function() {
                                                    const row = this.parentNode;
                                                    if (document.querySelectorAll('#harta-container .input-group').length > 1) {
                                                        row.parentNode.removeChild(row);
                                                    } else {
                                                        // Jika hanya ada satu input, kosongkan nilainya saja
                                                        row.querySelector('input').value = '';
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <div class="mb-5">
                                        <label for="tanggungan_hutang" class="form-label">Tanggungan Hutang</label>
                                        <div id="hutang-container">
                                            @if (isset($formSurvey->tanggungan_hutang))
                                                @php
                                                    $hutang = json_decode($formSurvey->tanggungan_hutang, true);
                                                @endphp
                                                @if (is_array($hutang) && count($hutang) > 0)
                                                    @foreach ($hutang as $index => $item)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="tanggungan_hutang[]"
                                                                class="form-control" value="{{ $item }}"
                                                                required>
                                                            <button type="button"
                                                                class="btn btn-danger remove-hutang">Hapus</button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="tanggungan_hutang[]"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-hutang">Hapus</button>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="input-group mb-2">
                                                    <input type="text" name="tanggungan_hutang[]" class="form-control"
                                                        required>
                                                    <button type="button"
                                                        class="btn btn-danger remove-hutang">Hapus</button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                            id="add-hutang">Tambah</button>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Tambah hutang baru
                                            document.getElementById('add-hutang').addEventListener('click', function() {
                                                const container = document.getElementById('hutang-container');
                                                const newRow = document.createElement('div');
                                                newRow.className = 'input-group mb-2';

                                                newRow.innerHTML = `
                            <input type="text" name="tanggungan_hutang[]" class="form-control" required>
                            <button type="button" class="btn btn-danger remove-hutang">Hapus</button>
                        `;

                                                container.appendChild(newRow);

                                                // Tambahkan event listener ke tombol hapus
                                                newRow.querySelector('.remove-hutang').addEventListener('click', function() {
                                                    container.removeChild(newRow);
                                                });
                                            });

                                            // Hapus hutang (untuk elemen yang sudah ada)
                                            document.querySelectorAll('.remove-hutang').forEach(button => {
                                                button.addEventListener('click', function() {
                                                    const row = this.parentNode;
                                                    if (document.querySelectorAll('#hutang-container .input-group').length > 1) {
                                                        row.parentNode.removeChild(row);
                                                    } else {
                                                        // Jika hanya ada satu input, kosongkan nilainya saja
                                                        row.querySelector('input').value = '';
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                </div>

                                <hr />
                                <div id="section-data-kesimpulan">
                                    <h4>Kesimpulan</h4>

                                    <div class="row mb-5">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Alasan Pendukung</label>
                                            <div id="pendukung-container">
                                                @if (isset($formSurvey->alasan_pendukung))
                                                    @php
                                                        $alasanPendukung = json_decode(
                                                            $formSurvey->alasan_pendukung,
                                                            true,
                                                        );
                                                    @endphp
                                                    @if (is_array($alasanPendukung) && count($alasanPendukung) > 0)
                                                        @foreach ($alasanPendukung as $index => $item)
                                                            <div class="input-group mb-2">
                                                                <input type="text" name="alasan_pendukung[]"
                                                                    class="form-control" value="{{ $item }}"
                                                                    required>
                                                                <button type="button"
                                                                    class="btn btn-danger remove-field">Hapus</button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="alasan_pendukung[]"
                                                                class="form-control" required>
                                                            <button type="button"
                                                                class="btn btn-danger remove-field">Hapus</button>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="alasan_pendukung[]"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-field">Hapus</button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm mt-2"
                                                id="add-pendukung">Tambah</button>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Alasan Memberatkan</label>
                                            <div id="memberatkan-container">
                                                @if (isset($formSurvey->alasan_memberatkan))
                                                    @php
                                                        $alasanMemberatkan = json_decode(
                                                            $formSurvey->alasan_memberatkan,
                                                            true,
                                                        );
                                                    @endphp
                                                    @if (is_array($alasanMemberatkan) && count($alasanMemberatkan) > 0)
                                                        @foreach ($alasanMemberatkan as $index => $item)
                                                            <div class="input-group mb-2">
                                                                <input type="text" name="alasan_memberatkan[]"
                                                                    class="form-control" value="{{ $item }}"
                                                                    required>
                                                                <button type="button"
                                                                    class="btn btn-danger remove-field">Hapus</button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="alasan_memberatkan[]"
                                                                class="form-control" required>
                                                            <button type="button"
                                                                class="btn btn-danger remove-field">Hapus</button>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="alasan_memberatkan[]"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-field">Hapus</button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm mt-2"
                                                id="add-memberatkan">Tambah</button>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                // Fungsi untuk menambah kolom input di alasan pendukung
                                                document.getElementById("add-pendukung").addEventListener("click", function() {
                                                    let container = document.getElementById("pendukung-container");
                                                    let newInput = document.createElement("div");
                                                    newInput.classList.add("input-group", "mb-2");
                                                    newInput.innerHTML = `
            <input type="text" name="alasan_pendukung[]" class="form-control" required>
            <button type="button" class="btn btn-danger remove-field">Hapus</button>
        `;
                                                    container.appendChild(newInput);
                                                });

                                                // Fungsi untuk menambah kolom input di alasan memberatkan
                                                document.getElementById("add-memberatkan").addEventListener("click", function() {
                                                    let container = document.getElementById("memberatkan-container");
                                                    let newInput = document.createElement("div");
                                                    newInput.classList.add("input-group", "mb-2");
                                                    newInput.innerHTML = `
            <input type="text" name="alasan_memberatkan[]" class="form-control" required>
            <button type="button" class="btn btn-danger remove-field">Hapus</button>
        `;
                                                    container.appendChild(newInput);
                                                });

                                                // Fungsi untuk menghapus kolom input
                                                document.addEventListener("click", function(e) {
                                                    if (e.target.classList.contains("remove-field")) {
                                                        e.target.parentElement.remove();
                                                    }
                                                });
                                            });
                                        </script>

                                        <div class="col-md-4">
                                            <label class="form-label">Saran Rekomendasi</label>
                                            <select name="saran_rekomendasi" id="saran_rekomendasi" class="form-control"
                                                required>
                                                <option value="">Pilih...</option>
                                                <option value="Diterima">Diterima</option>
                                                <option value="Ditolak">Ditolak</option>
                                                <option value="Abu-abu">Abu-abu</option>
                                            </select>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Survey</label>
                                        <input type="date" name="tanggal_survey" class="form-control"
                                            id="tanggal_survey" required>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            let today = new Date().toISOString().split('T')[0];
                                            document.getElementById('tanggal_survey').value = today;
                                        });
                                    </script>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('form_survey.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function formatRupiah(input) {
                let value = input.value.replace(/\D/g, '');
                input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
        </script>

        <script>
            function toggleLainnya() {
                let lainnyaCheckbox = document.getElementById("lainnya-checkbox");
                let lainnyaInput = document.getElementById("lainnya-input");
                if (lainnyaCheckbox.checked) {
                    lainnyaInput.style.display = "block";
                    lainnyaInput.required = true;
                } else {
                    lainnyaInput.style.display = "none";
                    lainnyaInput.required = false;
                }
            }
        </script>
    </body>

    </html>
@endsection
