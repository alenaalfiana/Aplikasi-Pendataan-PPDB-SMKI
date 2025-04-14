@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Biodata Pribadi</title>
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

                            <form action="{{ route('form_pendaftaran.update', $pendaftaran->id_form_pendaftaran) }}"
                                method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put" />

                                <h4> Biodata Pribadi Siswa</h4>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="id_registrasi_pengambilan" class="form-label">Nomor Pendaftar</label>
                                        <select class="form-control select2" id="id_registrasi_pengambilan" name="id_registrasi_pengambilan">
                                            <option value="">Pilih Nomor Pendaftar</option>
                                            @foreach ($registrasiPengambilans as $registrasi)
                                                <option value="{{ $registrasi->id_registrasi_pengambilan }}"
                                                    data-nama="{{ $registrasi->nama }}"
                                                    {{ $pendaftaran->id_registrasi_pengambilan == $pendaftaran->id_registrasi_pengambilan ? 'selected' : '' }}>
                                                    {{ $registrasi->no_pendaftar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="nisn" class="form-label">NISN</label>
                                            <input type="text" class="form-control" id="nisn" name="nisn"
                                                value="{{ old('nisn', $pendaftaran->nisn) }}" maxlength="10"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nama" class="form-label">Nama Lengkap - Calon Siswa</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ old('nama', $pendaftaran->nama) }}" readonly>
                                        </div>
                                    </div>

                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(document).ready(function () {
                                            $('#id_registrasi_pengambilan').change(function () {
                                                var selectedOption = $(this).find(':selected');
                                                var namaCalonSiswa = selectedOption.data('nama'); // Ambil data dari option
                                                $('#nama').val(namaCalonSiswa); // Masukkan ke input Nama Calon Siswa
                                            });

                                            // Saat halaman dimuat, set nama calon siswa berdasarkan pilihan yang sudah ada
                                            var selectedOption = $('#id_registrasi_pengambilan').find(':selected');
                                            var namaCalonSiswa = selectedOption.data('nama');
                                            if (namaCalonSiswa) {
                                                $('#nama').val(namaCalonSiswa);
                                            }
                                        });
                                    </script>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="ukuran_baju" class="form-label">Ukuran Baju</label>
                                            <select class="form-select @error('ukuran_baju') is-invalid @enderror"
                                                id="ukuran_baju" name="ukuran_baju" required>
                                                <option value="">Pilih Ukuran Baju</option>
                                                @foreach (['M', 'L', 'XL', 'XXL'] as $size)
                                                    <option value="{{ $size }}"
                                                        {{ old('ukuran_baju', $pendaftaran->ukuran_baju) == $size ? 'selected' : '' }}>
                                                        {{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="laki-laki"
                                                    {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="perempuan"
                                                    {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                                maxlength="25" required
                                                value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir"
                                                name="tanggal_lahir" required
                                                value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="agama" class="form-label">Agama</label>
                                            <select class="form-select" id="agama" name="agama" required>
                                                <option value="">Pilih Agama</option>
                                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                                    <option value="{{ $agama }}"
                                                        {{ old('agama', $pendaftaran->agama) == $agama ? 'selected' : '' }}>
                                                        {{ $agama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="anak_ke" class="form-label">Anak ke-</label>
                                            <input type="text" class="form-control" id="anak_ke" name="anak_ke"
                                                maxlength="2" required
                                                value="{{ old('anak_ke', $pendaftaran->anak_ke) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dari" class="form-label">Dari</label>
                                            <input type="text" class="form-control" id="dari" name="dari"
                                                maxlength="2" required value="{{ old('dari', $pendaftaran->dari) }}">
                                            <small class="form-text text-muted">total saudara</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="status_siswa" class="form-label">Status Siswa</label>
                                            <select class="form-select" id="status_siswa" name="status_siswa" required>
                                                <option value="">Pilih Status Siswa</option>
                                                @foreach (['yatim-piatu', 'yatim', 'piatu', 'orang-tua-lengkap'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ old('status_siswa', $pendaftaran->status_siswa) == $status ? 'selected' : '' }}>
                                                        {{ ucwords(str_replace('-', ' ', $status)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="bahasa_keseharian" class="form-label">Bahasa Keseharian</label>
                                            <input type="text" class="form-control" id="bahasa_keseharian"
                                                name="bahasa_keseharian" maxlength="20" required
                                                value="{{ old('bahasa_keseharian', $pendaftaran->bahasa_keseharian) }}">
                                            <small class="form-text text-muted">bahasa yang digunakan sehari-hari</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="provinsi" class="form-label">Provinsi</label>
                                            <select id="provinsi" name="province_id" class="form-select" required>
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}"
                                                        {{ old('province_id', $pendaftaran->province_id) == $province->id ? 'selected' : '' }}>
                                                        {{ $province->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                            <select id="kabupaten" name="regency_id" class="form-select" required
                                                {{ $pendaftaran->regency_id ? '' : 'disabled' }}>
                                                <option value="">Pilih Kabupaten/Kota</option>
                                                @if ($pendaftaran->regency)
                                                    <option value="{{ $pendaftaran->regency_id }}" selected>
                                                        {{ $pendaftaran->regency->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <select id="kecamatan" name="district_id" class="form-select" required
                                                {{ $pendaftaran->district_id ? '' : 'disabled' }}>
                                                <option value="">Pilih Kecamatan</option>
                                                @if ($pendaftaran->district)
                                                    <option value="{{ $pendaftaran->district_id }}" selected>
                                                        {{ $pendaftaran->district->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="desa" class="form-label">Desa/Kelurahan</label>
                                            <select id="desa" name="village_id" class="form-select" required
                                                {{ $pendaftaran->village_id ? '' : 'disabled' }}>
                                                <option value="">Pilih Desa/Kelurahan</option>
                                                @if ($pendaftaran->village)
                                                    <option value="{{ $pendaftaran->village_id }}" selected>
                                                        {{ $pendaftaran->village->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3" required>{{ old('alamat_lengkap', $pendaftaran->alamat_lengkap) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pas_foto" class="form-label">Pas Foto</label>
                                            <input type="file" class="form-control" id="pas_foto" name="pas_foto"
                                                accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this);">
                                            <div class="mt-2">
                                                <img id="preview"
                                                    src="{{ $pendaftaran->pas_foto ? asset('storage/' . $pendaftaran->pas_foto) : asset('placeholder.jpg') }}"
                                                    alt="Preview" class="img-thumbnail img-preview">
                                            </div>
                                            <small class="form-text text-muted">
                                                - Ukuran maksimum: 5MB. Format: JPEG, PNG, JPG.
                                                <br>- Foto berukuran 3x4
                                                <br>- Foto berformat formal
                                                <br>- Menggunakan seragam sekolah asal
                                            </small>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <h4> Biodata Orang Tua dan Wali</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start"> </th>
                                                    <th>Ayah</th>
                                                    <th>Ibu</th>
                                                    <th>Wali</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-start fw-bold">Nama</td>
                                                    <td><input type="text" class="form-control" id="nama_ayah"
                                                            name="nama_ayah"
                                                            value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}"
                                                            maxlength="75" placeholder="Nama lengkap ayah..."
                                                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="nama_ibu"
                                                            name="nama_ibu"
                                                            value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}"
                                                            maxlength="75" placeholder="Nama lengkap ibu..."
                                                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="nama_wali"
                                                            name="nama_wali"
                                                            value="{{ old('nama_wali', $pendaftaran->nama_wali) }}"
                                                            maxlength="75" placeholder="Nama lengkap wali..."
                                                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Usia</td>
                                                    <td><input type="text" class="form-control" id="usia_ayah"
                                                            name="usia_ayah" maxlength="2"
                                                            value="{{ old('usia_ayah', $pendaftaran->usia_ayah) }}"
                                                            placeholder="Usia ayah saat ini..."
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="usia_ibu"
                                                            name="usia_ibu" maxlength="2"
                                                            value="{{ old('usia_ibu', $pendaftaran->usia_ibu) }}"
                                                            placeholder="Usia ibu saat ini..."
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="usia_wali"
                                                            name="usia_wali" maxlength="2"
                                                            value="{{ old('usia_wali', $pendaftaran->usia_wali) }}"
                                                            placeholder="Usia wali saat ini..."
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Pendidikan</td>
                                                    <td><select class="form-select" id="pendidikan_ayah"
                                                            name="pendidikan_ayah">
                                                            <option value="">Pilih Pendidikan Ayah</option>
                                                            @foreach (['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3'] as $education)
                                                                <option value="{{ $education }}"
                                                                    {{ old('pendidikan_ayah', $pendaftaran->pendidikan_ayah) == $education ? 'selected' : '' }}>
                                                                    {{ $education }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                    <td><select class="form-select" id="pendidikan_ibu"
                                                            name="pendidikan_ibu">
                                                            <option value="">Pilih Pendidikan Ibu</option>
                                                            @foreach (['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3'] as $education)
                                                                <option value="{{ $education }}"
                                                                    {{ old('pendidikan_ibu', $pendaftaran->pendidikan_ibu) == $education ? 'selected' : '' }}>
                                                                    {{ $education }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                    <td><select class="form-select" id="pendidikan_wali"
                                                            name="pendidikan_wali">
                                                            <option value="">Pilih Pendidikan Wali</option>
                                                            @foreach (['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3'] as $education)
                                                                <option value="{{ $education }}"
                                                                    {{ old('pendidikan_wali', $pendaftaran->pendidikan_wali) == $education ? 'selected' : '' }}>
                                                                    {{ $education }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Pekerjaan</td>
                                                    <td><select class="form-select" id="pekerjaan_ayah"
                                                            name="pekerjaan_ayah">
                                                            <option value="">Pilih Pekerjaan Ayah</option>
                                                            @foreach (['PNS', 'TNI/Polri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter', 'Pengemudi', 'Pedagang', 'Pensiunan', 'Tidak Bekerja'] as $job)
                                                                <option value="{{ $job }}"
                                                                    {{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) == $job ? 'selected' : '' }}>
                                                                    {{ $job }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                    <td><select class="form-select" id="pekerjaan_ibu"
                                                            name="pekerjaan_ibu">
                                                            <option value="">Pilih Pekerjaan Ibu</option>
                                                            @foreach (['PNS', 'TNI/Polri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter', 'Pengemudi', 'Pedagang', 'Pensiunan', 'Tidak Bekerja'] as $job)
                                                                <option value="{{ $job }}"
                                                                    {{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) == $job ? 'selected' : '' }}>
                                                                    {{ $job }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                    <td><select class="form-select" id="pekerjaan_wali"
                                                            name="pekerjaan_wali">
                                                            <option value="">Pilih Pekerjaan Wali</option>
                                                            @foreach (['PNS', 'TNI/Polri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter', 'Pengemudi', 'Pedagang', 'Pensiunan', 'Tidak Bekerja'] as $job)
                                                                <option value="{{ $job }}"
                                                                    {{ old('pekerjaan_wali', $pendaftaran->pekerjaan_wali) == $job ? 'selected' : '' }}>
                                                                    {{ $job }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Penghasilan</td>
                                                    <td><input type="text" class="form-control" id="penghasilan_ayah"
                                                            name="penghasilan_ayah"
                                                            value="{{ old('penghasilan_ayah', $pendaftaran->penghasilan_ayah) }}"
                                                            placeholder="Penghasilan bulanan ayah.."
                                                            oninput="formatRupiah(this)"></td>
                                                    <td><input type="text" class="form-control" id="penghasilan_ibu"
                                                            name="penghasilan_ibu"
                                                            value="{{ old('penghasilan_ibu', $pendaftaran->penghasilan_ibu) }}"
                                                            placeholder="Penghasilan bulanan ibu.."
                                                            oninput="formatRupiah(this)"></td>
                                                    <td><input type="text" class="form-control" id="penghasilan_wali"
                                                            name="penghasilan_wali"
                                                            value="{{ old('penghasilan_wali', $pendaftaran->penghasilan_wali) }}"
                                                            placeholder="Penghasilan bulanan wali.."
                                                            oninput="formatRupiah(this)"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Alamat</td>
                                                    <td>
                                                        <textarea class="form-control" id="alamat_lengkap_ayah" name="alamat_lengkap_ayah"
                                                            placeholder="Alamat lengkap ayah.." rows="3">{{ old('alamat_lengkap_ayah', $pendaftaran->alamat_lengkap_ayah) }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" id="alamat_lengkap_ibu" name="alamat_lengkap_ibu" placeholder="Alamat lengkap ibu.."
                                                            rows="3">{{ old('alamat_lengkap_ibu', $pendaftaran->alamat_lengkap_ibu) }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" id="alamat_lengkap_wali" name="alamat_lengkap_wali"
                                                            placeholder="Alamat lengkap wali.." rows="3">{{ old('alamat_lengkap_wali', $pendaftaran->alamat_lengkap_wali) }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-bold">Telepon / HP</td>
                                                    <td><input type="text" class="form-control" id="no_telepon_ayah"
                                                            name="no_telepon_ayah"
                                                            value="{{ old('no_telepon_ayah', $pendaftaran->no_telepon_ayah) }}"
                                                            maxlength="15" placeholder="no. telp/hp..."
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,15)">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="no_telepon_ibu"
                                                            name="no_telepon_ibu"
                                                            value="{{ old('no_telepon_ibu', $pendaftaran->no_telepon_ibu) }}"
                                                            maxlength="15" placeholder="no. telp/hp..."
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,15)">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="no_telepon_wali"
                                                            name="no_telepon_wali"
                                                            value="{{ old('no_telepon_wali', $pendaftaran->no_telepon_wali) }}"
                                                            maxlength="15" placeholder="no. telp/hp..."
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,15)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>
                                    <hr>
                                    <h4>Data Sekolah Asal</h4>
                                    <div class="mb-3">
                                        <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control"
                                            value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" maxlength="55"
                                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat_lengkap" class="form-label">Alamat Lengkap Sekolah Asal</label>
                                        <textarea name="alamat_lengkap_sekolah" id="alamat_lengkap_sekolah" class="form-control" required>{{ old('alamat_lengkap', $pendaftaran->alamat_lengkap) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                        <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control"
                                            value="{{ old('tahun_lulus', $pendaftaran->tahun_lulus) }}" min="2000"
                                            max="{{ date('Y') }}" required>
                                    </div>

                                    <br>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="tanggal_mendaftar" class="form-label" hidden>Tanggal Mendaftar</label>
                                        <input type="hidden" name="tanggal_mendaftar" id="tanggal_mendaftar"
                                            value="{{ now()->toDateString() }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Tanda Tangan Siswa</b></label>
                                        <div class="border p-2 rounded">
                                            <!-- Canvas untuk menggambar tanda tangan -->
                                            <canvas id="signature-pad" class="border w-100" height="150"></canvas>

                                            <!-- Input hidden untuk menyimpan tanda tangan sebagai Base64 -->
                                            <input type="hidden" name="tanda_tangan_siswa" id="tanda_tangan_siswa"
                                                value="{{ $pendaftaran->tanda_tangan_siswa }}">

                                            <div class="mt-2 d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    id="clear-signature">Hapus</button>
                                                <input type="file" class="form-control form-control-sm"
                                                    id="upload-signature" accept="image/png,image/jpeg">
                                            </div>
                                            <small class="text-muted">Anda bisa menggambar tanda tangan atau mengunggah
                                                gambar (format PNG/JPEG).</small>

                                            @if ($pendaftaran->tanda_tangan_siswa)
                                                <div class="mt-2">
                                                    <small class="text-muted">Tanda tangan saat ini:</small>
                                                    <img id="existing-signature"
                                                        src="{{ asset('storage/' . $pendaftaran->tanda_tangan_siswa) }}"
                                                        alt="Tanda tangan saat ini" class="img-fluid"
                                                        style="max-height: 60px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <br>
<hr>
<h4>Data Persyaratan Dokumen</h4>

<table class="table table-bordered table-hover text-center mb-3">
    <thead>
        <tr>
            <th>
                <h6 class="mt-1 mb-1"><b>Dokumen</b></h6>
            </th>
            <th>
                <h6 class="mt-1 mb-1"><b>Status</b></h6>
            </th>
        </tr>
    </thead>
    <tbody>
        @php
            $fields = ['akta_lahir', 'kartu_keluarga', 'pas_foto_3x4', 'sktm_kelurahan', 'kartu_kip', 'raport_smp', 'ijazah_legalisir', 'ktp_ortu_wali'];
        @endphp
        @foreach ($fields as $field)
            <tr>
                <td>{{ strtoupper(str_replace('_', ' ', $field)) }}</td>
                <td>
                    <div class="btn-group text-center align-middle" role="group">
                        <input type="radio" class="btn-check" name="{{ $field }}"
                            id="{{ $field }}_ada" value="ada" {{ $pendaftaran->$field == 'ada' ? 'checked' : '' }} required>
                        <label class="btn btn-outline-success" for="{{ $field }}_ada">Ada</label>

                        <input type="radio" class="btn-check" name="{{ $field }}"
                            id="{{ $field }}_tidak_ada" value="tidak_ada" {{ $pendaftaran->$field == 'tidak_ada' ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="{{ $field }}_tidak_ada">Tidak Ada</label>

                        <input type="radio" class="btn-check" name="{{ $field }}"
                            id="{{ $field }}_menyusul" value="menyusul" {{ $pendaftaran->$field == 'menyusul' ? 'checked' : '' }}>
                        <label class="btn btn-outline-warning" for="{{ $field }}_menyusul">Menyusul</label>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mb-3 text-end">
    <button type="button" class="btn btn-primary" id="selectAllAda">
        <i class="menu-icon tf-icons bx bxs-checkbox" id="iconCheckbox"></i>
    </button>
</div>

<div class="mb-3">
    <label class="form-label" hidden>Status</label>
    <div>
        <input type="radio" name="status" id="lengkap" value="lengkap" {{ $pendaftaran->status == 'lengkap' ? 'checked' : '' }} hidden>
        <input type="radio" name="status" id="tidak_lengkap" value="tidak_lengkap" {{ $pendaftaran->status == 'tidak_lengkap' ? 'checked' : '' }} hidden>
    </div>
</div>

<div class="mb-3">
    <label for="tanggal_pengembalian" class="form-label" hidden>Tanggal Pengembalian Dokumen</label>
    <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
        class="form-control" value="{{ old('tanggal_pengembalian', $pendaftaran->tanggal_pengembalian) }}" hidden>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllButton = document.getElementById('selectAllAda');
        const iconCheckbox = document.getElementById('iconCheckbox');
        const fields = @json($fields);

        let isAllSelected = false;

        function checkAllFieldsAda() {
            return fields.every(field => document.getElementById(`${field}_ada`).checked);
        }

        function checkIfNotComplete() {
            return fields.some(field =>
                document.getElementById(`${field}_tidak_ada`).checked ||
                document.getElementById(`${field}_menyusul`).checked
            );
        }

        function updateStatus() {
            if (checkIfNotComplete()) {
                document.getElementById('tidak_lengkap').checked = true;
                document.getElementById('lengkap').checked = false;
            } else {
                document.getElementById('lengkap').checked = true;
                document.getElementById('tidak_lengkap').checked = false;
            }
        }

        fields.forEach(field => {
            document.querySelectorAll(`input[name="${field}"]`).forEach(radio => {
                radio.addEventListener('change', function () {
                    updateStatus();
                });
            });
        });

        selectAllButton.addEventListener('click', function () {
            isAllSelected = !isAllSelected;

            fields.forEach(field => {
                document.getElementById(`${field}_ada`).checked = isAllSelected;
            });

            updateStatus();

            iconCheckbox.classList.toggle("bxs-checkbox");
            iconCheckbox.classList.toggle("bxs-checkbox-checked");
        });
    });
</script>


                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                    <a href="{{ route('form_pendaftaran.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const canvas = document.getElementById("signature-pad");
                const ctx = canvas.getContext("2d");
                const inputSignature = document.getElementById("tanda_tangan_siswa");
                let isDrawing = false;
                let lastX = 0;
                let lastY = 0;

                // **Set canvas agar bisa digambar**
                function resizeCanvas() {
                    const rect = canvas.getBoundingClientRect();
                    canvas.width = rect.width;
                    canvas.height = 150; // Tinggi tetap agar tidak terlalu kecil
                    ctx.lineWidth = 2;
                    ctx.lineCap = "round";
                    ctx.strokeStyle = "black";
                    loadExistingSignature(); // Muat tanda tangan yang sudah ada
                }

                function loadExistingSignature() {
                    const existingSignature = inputSignature.value;
                    if (existingSignature.startsWith("data:image") || existingSignature.trim() !== "") {
                        const img = new Image();
                        img.onload = function() {
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        };
                        img.src = existingSignature;
                    }
                }

                // **Event untuk menggambar tanda tangan**
                function startDrawing(event) {
                    event.preventDefault();
                    isDrawing = true;
                    const pos = getPosition(event);
                    lastX = pos.x;
                    lastY = pos.y;
                }

                function draw(event) {
                    if (!isDrawing) return;
                    event.preventDefault();

                    const pos = getPosition(event);
                    ctx.beginPath();
                    ctx.moveTo(lastX, lastY);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                    lastX = pos.x;
                    lastY = pos.y;
                }

                function stopDrawing() {
                    isDrawing = false;
                    saveSignature();
                }

                // **Mendapatkan posisi kursor di canvas**
                function getPosition(event) {
                    const rect = canvas.getBoundingClientRect();
                    const scaleX = canvas.width / rect.width;
                    const scaleY = canvas.height / rect.height;

                    if (event.touches && event.touches[0]) {
                        return {
                            x: (event.touches[0].clientX - rect.left) * scaleX,
                            y: (event.touches[0].clientY - rect.top) * scaleY
                        };
                    }

                    return {
                        x: (event.clientX - rect.left) * scaleX,
                        y: (event.clientY - rect.top) * scaleY
                    };
                }

                // **Cek apakah canvas kosong**
                function isCanvasBlank() {
                    const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
                    return !pixelData.some(channel => channel !== 0);
                }

                // **Simpan tanda tangan hanya jika tidak kosong**
                function saveSignature() {
                    if (!isCanvasBlank()) {
                        const dataURL = canvas.toDataURL("image/png");
                        inputSignature.value = dataURL;
                    }
                }

                // **Hapus tanda tangan**
                document.getElementById("clear-signature").addEventListener("click", function() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    inputSignature.value = "";
                });

                // **Upload tanda tangan dari file**
                document.getElementById("upload-signature").addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    if (!file.type.match('image/png') && !file.type.match('image/jpeg')) {
                        alert('Hanya file PNG dan JPEG yang diperbolehkan!');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            ctx.clearRect(0, 0, canvas.width, canvas.height);

                            // **Menyesuaikan ukuran gambar agar proporsional**
                            const ratio = Math.min(canvas.width / img.width, canvas.height / img
                            .height);
                            const centerX = (canvas.width - img.width * ratio) / 2;
                            const centerY = (canvas.height - img.height * ratio) / 2;

                            ctx.drawImage(img, centerX, centerY, img.width * ratio, img.height * ratio);
                            saveSignature();
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });

                // **Tambahkan event listener untuk mouse & touchscreen**
                canvas.addEventListener("mousedown", startDrawing);
                canvas.addEventListener("mousemove", draw);
                canvas.addEventListener("mouseup", stopDrawing);
                canvas.addEventListener("mouseout", stopDrawing);

                canvas.addEventListener("touchstart", startDrawing);
                canvas.addEventListener("touchmove", draw);
                canvas.addEventListener("touchend", stopDrawing);

                // **Inisialisasi canvas setelah halaman dimuat**
                resizeCanvas();
                window.addEventListener("resize", resizeCanvas);
            });
        </script>
        <script>
            function previewImage(input) {
                var preview = document.getElementById('preview');

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                function loadDropdown(url, target, selectedId) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
                            $(target).prop('disabled', false).html('<option value="">Pilih</option>');
                            $.each(data, function(key, value) {
                                let isSelected = selectedId == value.id ? 'selected' : '';
                                $(target).append('<option value="' + value.id + '" ' + isSelected +
                                    '>' + value.name + '</option>');
                            });
                        }
                    });
                }

                // Load Kabupaten jika ada Province terpilih
                let provinceId = $('#provinsi').val();
                let selectedRegency = "{{ $pendaftaran->regency_id }}";
                if (provinceId) {
                    loadDropdown('/regencies/' + provinceId, '#kabupaten', selectedRegency);
                }

                // Load Kecamatan jika ada Kabupaten terpilih
                let regencyId = $('#kabupaten').val();
                let selectedDistrict = "{{ $pendaftaran->district_id }}";
                if (regencyId) {
                    loadDropdown('/districts/' + regencyId, '#kecamatan', selectedDistrict);
                }

                // Load Desa jika ada Kecamatan terpilih
                let districtId = $('#kecamatan').val();
                let selectedVillage = "{{ $pendaftaran->village_id }}";
                if (districtId) {
                    loadDropdown('/villages/' + districtId, '#desa', selectedVillage);
                }

                // Event listener untuk setiap perubahan
                $('#provinsi').change(function() {
                    let provinceId = $(this).val();
                    $('#kabupaten').prop('disabled', true).html(
                        '<option value="">Pilih Kabupaten/Kota</option>');
                    $('#kecamatan, #desa').prop('disabled', true).html('<option value="">Pilih</option>');
                    if (provinceId) {
                        loadDropdown('/regencies/' + provinceId, '#kabupaten', null);
                    }
                });

                $('#kabupaten').change(function() {
                    let regencyId = $(this).val();
                    $('#kecamatan').prop('disabled', true).html('<option value="">Pilih Kecamatan</option>');
                    $('#desa').prop('disabled', true).html('<option value="">Pilih Desa/Kelurahan</option>');
                    if (regencyId) {
                        loadDropdown('/districts/' + regencyId, '#kecamatan', null);
                    }
                });

                $('#kecamatan').change(function() {
                    let districtId = $(this).val();
                    $('#desa').prop('disabled', true).html('<option value="">Pilih Desa/Kelurahan</option>');
                    if (districtId) {
                        loadDropdown('/villages/' + districtId, '#desa', null);
                    }
                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function formatRupiah(input) {
                let value = input.value.replace(/\D/g, '');
                input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
        </script>
    </body>

    </html>
@endsection
