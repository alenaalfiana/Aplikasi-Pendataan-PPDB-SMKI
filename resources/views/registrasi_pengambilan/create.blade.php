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

                            <form action="{{ route('registrasi_pengambilan.store') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="no_pendaftar" class="form-label">Nomor Pendaftaran</label>
                                            <input type="text" class="form-control" id="no_pendaftar" name="no_pendaftar"
                                                value="{{ old('no_pendaftar', $nextNumber) }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="id_periode" class="form-label">Periode Pendaftaran</label>
                                            <select class="form-control select2" id="id_periode" name="id_periode" required>
                                                <option value="">Pilih Tahun</option>
                                                @foreach ($periodes as $periode)
                                                    <option value="{{ $periode->id_periode }}"
                                                        {{ old('id_periode') == $periode->id_periode ? 'selected' : '' }}>
                                                        {{ $periode->tahun_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="nama_pengambil" class="form-label">Nama Pengambil Formulir</label>
                                            <input type="text" class="form-control" id="nama_pengambil"
                                                name="nama_pengambil" value="{{ old('nama_pengambil') }}" maxlength="75"
                                                placeholder="Nama yang mengambil formulir ..."
                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                        </div>
                                    </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="nama" class="form-label">Nama Calon Siswa</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ old('nama') }}" maxlength="75"
                                                    placeholder="Nama lengkap calon siswa..."
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin"
                                                    required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="laki-laki"
                                                        {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki
                                                    </option>
                                                    <option value="perempuan"
                                                        {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>
                                                        Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="no_telepon" class="form-label">No Telepon</label>
                                                <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                                    value="{{ old('no_telepon') }}" maxlength="15"
                                                    placeholder="no. telp/hp..."
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,15)">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah"
                                                    value="{{ old('nama_ayah') }}" maxlength="75"
                                                    placeholder="Nama lengkap ayah..."
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu"
                                                    value="{{ old('nama_ibu') }}" maxlength="75"
                                                    placeholder="Nama lengkap ibu..."
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="nama_wali" class="form-label">Nama Wali</label>
                                                <input type="text" class="form-control" id="nama_wali"
                                                    name="nama_wali" value="{{ old('nama_wali') }}" maxlength="75"
                                                    placeholder="Nama lengkap wali..."
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="provinsi" class="form-label">Provinsi</label>
                                                <select id="provinsi" name="province_id" class="form-select select2"
                                                    required>
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                <select id="kabupaten" name="regency_id" class="form-select select2"
                                                    required disabled>
                                                    <option value="">Pilih Kabupaten/Kota</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                                <select id="kecamatan" name="district_id" class="form-select select2"
                                                    required disabled>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="desa" class="form-label">Desa/Kelurahan</label>
                                                <select id="desa" name="village_id" class="form-select select2"
                                                    required disabled>
                                                    <option value="">Pilih Desa/Kelurahan</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3" required>{{ old('alamat_lengkap') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                            <input type="text" name="asal_sekolah" id="asal_sekolah"
                                                class="form-control" value="{{ old('asal_sekolah') }}" maxlength="55"
                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase()">
                                        </div>

                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required>{{ old('keterangan') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_pengambilan" class="form-label" hidden>Tanggal
                                                Pengambilan</label>
                                            <input type="hidden" name="tanggal_pengambilan" id="tanggal_pengambilan"
                                                value="{{ now()->toDateString() }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="foto_bukti_pengisian" class="form-label" hidden>Foto Bukti
                                                Pengisian:</label>
                                            <video id="video" width="320" height="240" autoplay hidden></video>
                                            <canvas id="canvas" style="display: none;" hidden></canvas>
                                            <input type="file" name="foto_bukti_pengisian" id="foto_bukti_pengisian"
                                                hidden accept="image/*">
                                            <div id="preview" style="display: none;" hidden></div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('registrasi_pengambilan.index') }}"
                                            class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#provinsi').change(function() {
                    var provinceId = $(this).val();
                    $('#kabupaten').prop('disabled', true);
                    $('#kecamatan').prop('disabled', true);
                    $('#desa').prop('disabled', true);

                    if (provinceId) {
                        $.ajax({
                            url: '/regencies/' + provinceId,
                            type: 'GET',
                            success: function(data) {
                                $('#kabupaten').prop('disabled', false)
                                    .html('<option value="">Pilih Kabupaten/Kota</option>');
                                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
                                $('#desa').html('<option value="">Pilih Desa/Kelurahan</option>');

                                $.each(data, function(key, value) {
                                    $('#kabupaten').append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                            }
                        });
                    }
                });

                $('#kabupaten').change(function() {
                    var regencyId = $(this).val();
                    $('#kecamatan').prop('disabled', true);
                    $('#desa').prop('disabled', true);

                    if (regencyId) {
                        $.ajax({
                            url: '/districts/' + regencyId,
                            type: 'GET',
                            success: function(data) {
                                $('#kecamatan').prop('disabled', false)
                                    .html('<option value="">Pilih Kecamatan</option>');
                                $('#desa').html('<option value="">Pilih Desa/Kelurahan</option>');

                                $.each(data, function(key, value) {
                                    $('#kecamatan').append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                            }
                        });
                    }
                });

                $('#kecamatan').change(function() {
                    var districtId = $(this).val();
                    $('#desa').prop('disabled', true);

                    if (districtId) {
                        $.ajax({
                            url: '/villages/' + districtId,
                            type: 'GET',
                            success: function(data) {
                                $('#desa').prop('disabled', false)
                                    .html('<option value="">Pilih Desa/Kelurahan</option>');

                                $.each(data, function(key, value) {
                                    $('#desa').append('<option value="' + value.id + '">' +
                                        value.name + '</option>');
                                });
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let video = document.getElementById('video');
                let canvas = document.getElementById('canvas');
                let fileInput = document.getElementById('foto_bukti_pengisian');
                let preview = document.getElementById('preview');
                let stream = null;

                // Aktifkan kamera
                navigator.mediaDevices.getUserMedia({
                        video: {
                            width: {
                                ideal: 640
                            },
                            height: {
                                ideal: 480
                            }
                        }
                    })
                    .then(function(mediaStream) {
                        stream = mediaStream;
                        video.srcObject = stream;
                    })
                    .catch(function(err) {
                        console.error("Gagal mengakses kamera:", err);
                        alert("Tidak dapat mengakses kamera. Pastikan kamera tersedia dan izin diberikan.");
                    });

                // Auto capture setelah 5 detik
                setTimeout(() => {
                    if (stream) {
                        let context = canvas.getContext('2d');
                        canvas.width = 640;
                        canvas.height = 480;
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);

                        // Konversi canvas ke blob
                        canvas.toBlob((blob) => {
                            // Buat file dari blob
                            const imageFile = new File([blob], 'foto_bukti.jpg', {
                                type: 'image/jpeg'
                            });

                            // Buat object DataTransfer untuk mensimulasikan file upload
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(imageFile);

                            // Set file ke input
                            fileInput.files = dataTransfer.files;

                            // Tampilkan preview (opsional)
                            preview.innerHTML = '';
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(blob);
                            img.style.maxWidth = '200px';
                            preview.appendChild(img);
                            preview.style.display = 'block';

                            // Hentikan stream kamera
                            stream.getTracks().forEach(track => track.stop());

                            alert("Foto berhasil diambil!");
                        }, 'image/jpeg', 0.8);
                    }
                }, 5000);
            });
        </script>
    </body>

    </html>
@endsection
