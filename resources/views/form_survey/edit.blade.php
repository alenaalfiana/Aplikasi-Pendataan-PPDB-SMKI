@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Data Survey</title>
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

                            <form action="{{ route('form_survey.update', $formSurvey->id_form_survey) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put" />

                                <div id="section-data-calon-siswa">

                                    <div class="mb-5">
                                        <label for="id" class="form-label">Surveyor</label>
                                        <select class="form-control" id="id" name="id">
                                            <option value="">Pilih Nama Surveyor</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $formSurvey->id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <h4>Data Calon Siswa</h4>

                                    <div class="mb-3">
                                        <label for="id_form_interview" class="form-label">Nama Lengkap - Calon Siswa</label>
                                        <select class="form-control" id="id_form_interview" name="id_form_interview">
                                            <option value="">Pilih Nama Siswa</option>
                                            @foreach ($formInterview as $interview)
                                                <option value="{{ $interview->id_form_interview }}"
                                                    {{ $formSurvey->id_form_interview == $interview->id_form_interview ? 'selected' : '' }}>
                                                    {{ $interview->formPendaftaran->registrasiPengambilan->nama ?? 'Nama Tidak Ditemukan' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="rata2_tpa" class="form-label">Rata-rata TPA</label>
                                            <input type="string" class="form-control" id="rata2_tpa" name="rata2_tpa"
                                                value="{{ $formSurvey->rata2_tpa }}" max="5">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="max_tpa" class="form-label">Max. </label>
                                            <input type="string" class="form-control" id="max_tpa" name="max_tpa"
                                                value="{{ $formSurvey->max_tpa }}" max="5">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="min_tpa" class="form-label">Min. </label>
                                            <input type="string" class="form-control" id="min_tpa" name="min_tpa"
                                                value="{{ $formSurvey->min_tpa }}" max="5">
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-4">
                                            <label for="rata2_tes_alquran" class="form-label">Rata-rata Tes
                                                Al-Qur'an</label>
                                            <input type="string" class="form-control" id="rata2_tes_alquran"
                                                name="rata2_tes_alquran" value="{{ $formSurvey->rata2_tes_alquran }}"
                                                max="5">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="max_alquran" class="form-label">Max. </label>
                                            <input type="string" class="form-control" id="max_alquran" name="max_alquran"
                                                value="{{ $formSurvey->max_alquran }}" max="5">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="min_alquran" class="form-label">Min. </label>
                                            <input type="string" class="form-control" id="min_alquran" name="min_alquran"
                                                value="{{ $formSurvey->min_alquran }}" max="5">
                                        </div>
                                    </div>

                                </div>

                                <div id="section-tanggungan-keluarga">
                                    <h4>Edit Data Tanggungan Orang Tua</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-3">
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
                                                @if (isset($formSurvey->nama_lengkap_keluarga) &&
                                                        isset($formSurvey->jenis_kelamin) &&
                                                        isset($formSurvey->usia) &&
                                                        isset($formSurvey->pendidikan) &&
                                                        isset($formSurvey->kelas) &&
                                                        isset($formSurvey->pekerjaan) &&
                                                        isset($formSurvey->hubungan))
                                                    @php
                                                        $nama =
                                                            json_decode($formSurvey->nama_lengkap_keluarga, true) ?: [];
                                                        $jenisKelamin =
                                                            json_decode($formSurvey->jenis_kelamin, true) ?: [];
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
                                                            <tr class="tanggungan-row">
                                                                <td>
                                                                    <input type="text" name="nama_lengkap_keluarga[]"
                                                                        class="form-control" value="{{ $nama[$i] ?? '' }}"
                                                                        required>
                                                                </td>
                                                                <td>
                                                                    <select name="jenis_kelamin[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="Laki-laki"
                                                                            {{ isset($jenisKelamin[$i]) && $jenisKelamin[$i] == 'Laki-laki' ? 'selected' : '' }}>
                                                                            Laki-laki
                                                                        </option>
                                                                        <option value="Perempuan"
                                                                            {{ isset($jenisKelamin[$i]) && $jenisKelamin[$i] == 'Perempuan' ? 'selected' : '' }}>
                                                                            Perempuan
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="usia[]"
                                                                        class="form-control"
                                                                        value="{{ $usia[$i] ?? '' }}" required>
                                                                </td>
                                                                <td>
                                                                    <select name="pendidikan[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="SD/MI"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SD/MI' ? 'selected' : '' }}>
                                                                            SD/MI
                                                                        </option>
                                                                        <option value="SMP/MTs"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SMP/MTs' ? 'selected' : '' }}>
                                                                            SMP/MTs
                                                                        </option>
                                                                        <option value="SMA/MA"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SMA/MA' ? 'selected' : '' }}>
                                                                            SMA/MA
                                                                        </option>
                                                                        <option value="SMK"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'SMK' ? 'selected' : '' }}>
                                                                            SMK
                                                                        </option>
                                                                        <option value="S1"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'S1' ? 'selected' : '' }}>
                                                                            S1
                                                                        </option>
                                                                        <option value="S2"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'S2' ? 'selected' : '' }}>
                                                                            S2
                                                                        </option>
                                                                        <option value="S3"
                                                                            {{ isset($pendidikan[$i]) && $pendidikan[$i] == 'S3' ? 'selected' : '' }}>
                                                                            S3
                                                                        </option>
                                                                        <option value="Lainnya"
                                                                            {{ isset($pendidikan[$i]) && !in_array($pendidikan[$i], ['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3']) ? 'selected' : '' }}>
                                                                            Lainnya
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="kelas[]"
                                                                        class="form-control"
                                                                        value="{{ $kelas[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <select name="pekerjaan[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="PNS"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'PNS' ? 'selected' : '' }}>
                                                                            PNS
                                                                        </option>
                                                                        <option value="TNI/Polri"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'TNI/Polri' ? 'selected' : '' }}>
                                                                            TNI/Polri
                                                                        </option>
                                                                        <option value="Pegawai Swasta"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pegawai Swasta' ? 'selected' : '' }}>
                                                                            Pegawai Swasta
                                                                        </option>
                                                                        <option value="Wiraswasta"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Wiraswasta' ? 'selected' : '' }}>
                                                                            Wiraswasta
                                                                        </option>
                                                                        <option value="Petani"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Petani' ? 'selected' : '' }}>
                                                                            Petani
                                                                        </option>
                                                                        <option value="Nelayan"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Nelayan' ? 'selected' : '' }}>
                                                                            Nelayan
                                                                        </option>
                                                                        <option value="Buruh"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Buruh' ? 'selected' : '' }}>
                                                                            Buruh
                                                                        </option>
                                                                        <option value="Guru/Dosen"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Guru/Dosen' ? 'selected' : '' }}>
                                                                            Guru/Dosen
                                                                        </option>
                                                                        <option value="Dokter"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Dokter' ? 'selected' : '' }}>
                                                                            Dokter
                                                                        </option>
                                                                        <option value="Pengemudi"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pengemudi' ? 'selected' : '' }}>
                                                                            Pengemudi
                                                                        </option>
                                                                        <option value="Pedagang"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pedagang' ? 'selected' : '' }}>
                                                                            Pedagang
                                                                        </option>
                                                                        <option value="Pensiunan"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Pensiunan' ? 'selected' : '' }}>
                                                                            Pensiunan
                                                                        </option>
                                                                        <option value="Tidak Bekerja"
                                                                            {{ isset($pekerjaan[$i]) && $pekerjaan[$i] == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                                            Tidak Bekerja
                                                                        </option>
                                                                        <option value="Lainnya"
                                                                            {{ isset($pekerjaan[$i]) && !in_array($pekerjaan[$i], ['PNS', 'TNI/Polri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter', 'Pengemudi', 'Pedagang', 'Pensiunan', 'Tidak Bekerja']) ? 'selected' : '' }}>
                                                                            Lainnya
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="hubungan[]" class="form-control"
                                                                        required>
                                                                        <option value="">Pilih</option>
                                                                        <option value="Ayah"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Ayah' ? 'selected' : '' }}>
                                                                            Ayah
                                                                        </option>
                                                                        <option value="Ibu"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Ibu' ? 'selected' : '' }}>
                                                                            Ibu
                                                                        </option>
                                                                        <option value="Saudara"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Saudara' ? 'selected' : '' }}>
                                                                            Saudara
                                                                        </option>
                                                                        <option value="Kakek"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Kakek' ? 'selected' : '' }}>
                                                                            Kakek
                                                                        </option>
                                                                        <option value="Nenek"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Nenek' ? 'selected' : '' }}>
                                                                            Nenek
                                                                        </option>
                                                                        <option value="Paman"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Paman' ? 'selected' : '' }}>
                                                                            Paman
                                                                        </option>
                                                                        <option value="Bibi"
                                                                            {{ isset($hubungan[$i]) && $hubungan[$i] == 'Bibi' ? 'selected' : '' }}>
                                                                            Bibi
                                                                        </option>
                                                                        <option value="Lainnya"
                                                                            {{ isset($hubungan[$i]) && !in_array($hubungan[$i], ['Ayah', 'Ibu', 'Saudara', 'Kakek', 'Nenek', 'Paman', 'Bibi']) ? 'selected' : '' }}>
                                                                            Lainnya
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <button type="button"
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
                                                                    <option value="Laki-laki">Laki-laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="usia[]" class="form-control"
                                                                    required></td>
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
                                                                <option value="Laki-laki">Laki-laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" name="usia[]" class="form-control"
                                                                required></td>
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
                                    </div>
                                    <span>Ibu / Isteri termasuk dalam tanggungan orang tua</span>
                                    <br>
                                    <button type="button" class="btn btn-primary mt-2 mb-5"
                                        id="add-tanggungan">Tambah</button>
                                    <button type="submit" class="btn btn-success mt-2 mb-5">Simpan Perubahan</button>
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
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
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
                                                    <td>
                                                        <input type="text" class="form-control" id="income_form_ayah"
                                                            name="income_form_ayah"
                                                            value="{{ old('income_form_ayah', $formSurvey->income_form_ayah) }}"
                                                            maxlength="10" placeholder="income form ayah..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="income_form_ibu"
                                                            name="income_form_ibu"
                                                            value="{{ old('income_form_ibu', $formSurvey->income_form_ibu) }}"
                                                            maxlength="10" placeholder="income form ibu..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Income Interview</td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            id="income_interview_ayah" name="income_interview_ayah"
                                                            value="{{ old('income_interview_ayah', $formSurvey->income_interview_ayah) }}"
                                                            maxlength="10" placeholder="income interview ayah..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            id="income_interview_ibu" name="income_interview_ibu"
                                                            value="{{ old('income_interview_ibu', $formSurvey->income_interview_ibu) }}"
                                                            maxlength="10" placeholder="income interview ibu..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Income Survey</td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            id="income_survey_ayah" name="income_survey_ayah"
                                                            value="{{ old('income_survey_ayah', $formSurvey->income_survey_ayah) }}"
                                                            maxlength="10" placeholder="income survey ayah..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="income_survey_ibu"
                                                            name="income_survey_ibu"
                                                            value="{{ old('income_survey_ibu', $formSurvey->income_survey_ibu) }}"
                                                            maxlength="10" placeholder="income survey ibu..."
                                                            oninput="this.value = this.value.slice(0,10)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div id="section-data-validasi-tambahan">
                                    <h4>Validasi Tambahan</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="status_rumah" class="form-label">Status Rumah</label>
                                            <select name="status_rumah" id="status_rumah" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                <option value="Sendiri"
                                                    {{ $formSurvey->status_rumah == 'Sendiri' ? 'selected' : '' }}>Milik
                                                    Sendiri</option>
                                                <option value="Kontrak"
                                                    {{ $formSurvey->status_rumah == 'Kontrak' ? 'selected' : '' }}>Kontrak
                                                </option>
                                                <option value="Menumpang"
                                                    {{ $formSurvey->status_rumah == 'Menumpang' ? 'selected' : '' }}>
                                                    Menumpang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="biaya_hidup_perbulan" class="form-label">Biaya Per-Bulan
                                                (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="biaya_hidup_perbulan"
                                                    id="biaya_hidup_perbulan" class="form-control"
                                                    value="{{ $formSurvey->biaya_hidup_perbulan }}"
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
                                                    class="form-control" value="{{ $formSurvey->luas_bangunan }}">
                                                <span class="input-group-text">m²</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">T : ±</span>
                                                <input type="text" name="luas_tanah" id="luas_tanah"
                                                    class="form-control" value="{{ $formSurvey->luas_tanah }}">
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
                                                    value="{{ $formSurvey->fasilitas_ruang_tamu }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">RT +</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="fasilitas_ruang_keluarga"
                                                    id="fasilitas_ruang_keluarga" class="form-control" maxlength="2"
                                                    value="{{ $formSurvey->fasilitas_ruang_keluarga }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">RK +</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="fasilitas_kamar_tidur"
                                                    id="fasilitas_kamar_tidur" class="form-control" maxlength="2"
                                                    value="{{ $formSurvey->fasilitas_kamar_tidur }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <span class="input-group-text">KT + Dapur + WC</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="section-data-kesimpulan">
                                    <h4>Kesimpulan</h4>

                                    <div class="row mb-5">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Alasan Pendukung</label>
                                            <div id="pendukung-container">
                                                @php
                                                    $alasanPendukung = isset($formSurvey->alasan_pendukung)
                                                        ? json_decode($formSurvey->alasan_pendukung, true)
                                                        : [];
                                                @endphp
                                                @foreach ($alasanPendukung as $item)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="alasan_pendukung[]"
                                                            class="form-control" value="{{ $item }}" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-field">Hapus</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm mt-2"
                                                id="add-pendukung">Tambah</button>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Alasan Memberatkan</label>
                                            <div id="memberatkan-container">
                                                @php
                                                    $alasanMemberatkan = isset($formSurvey->alasan_memberatkan)
                                                        ? json_decode($formSurvey->alasan_memberatkan, true)
                                                        : [];
                                                @endphp
                                                @foreach ($alasanMemberatkan as $item)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="alasan_memberatkan[]"
                                                            class="form-control" value="{{ $item }}" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-field">Hapus</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm mt-2"
                                                id="add-memberatkan">Tambah</button>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
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
                                                <option value="Diterima"
                                                    {{ isset($formSurvey->saran_rekomendasi) && $formSurvey->saran_rekomendasi == 'Diterima' ? 'selected' : '' }}>
                                                    Diterima</option>
                                                <option value="Ditolak"
                                                    {{ isset($formSurvey->saran_rekomendasi) && $formSurvey->saran_rekomendasi == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak</option>
                                                <option value="Abu-abu"
                                                    {{ isset($formSurvey->saran_rekomendasi) && $formSurvey->saran_rekomendasi == 'Abu-abu' ? 'selected' : '' }}>
                                                    Abu-abu</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Survey</label>
                                            <input type="date" name="tanggal_survey" class="form-control"
                                                id="tanggal_survey"
                                                value="{{ isset($formSurvey->tanggal_survey) ? $formSurvey->tanggal_survey : '' }}"
                                                required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('form_survey.index') }}" class="btn btn-secondary">Kembali</a>
                                    <div>

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
