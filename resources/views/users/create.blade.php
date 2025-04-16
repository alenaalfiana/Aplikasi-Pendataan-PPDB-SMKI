@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Data User</title>
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

                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="mb-3">
                                    <!-- Nama -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Pengguna</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name') }}" required pattern="[A-Za-z\s]+"
                                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <!-- Hidden field dulu -->
                                            <input type="hidden" name="verify_email" value="0">

                                            <!-- Lalu checkbox -->
                                            <input class="form-check-input" type="checkbox" id="verify_email" name="verify_email" value="1">
                                            <label class="form-check-label" for="verify_email">
                                                <b>Verifikasi email pengguna secara otomatis (tanpa perlu konfirmasi)</b>
                                            </label>
                                        </div>
                                    </div>


                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="************" required>
                                            <span class="input-group-text cursor-pointer"
                                                onclick="togglePassword('password', this)">
                                                <i class="bx bx-hide"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi
                                            Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" placeholder="************" required>
                                            <span class="input-group-text cursor-pointer"
                                                onclick="togglePassword('password_confirmation', this)">
                                                <i class="bx bx-hide"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Script Toggle Password -->
                                    <script>
                                        function togglePassword(id, el) {
                                            const input = document.getElementById(id);
                                            const icon = el.querySelector('i');

                                            if (input.type === "password") {
                                                input.type = "text";
                                                icon.classList.remove('bx-hide');
                                                icon.classList.add('bx-show');
                                            } else {
                                                input.type = "password";
                                                icon.classList.remove('bx-show');
                                                icon.classList.add('bx-hide');
                                            }
                                        }
                                    </script>


                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="provinsi" class="form-label">Provinsi</label>
                                            <select id="provinsi" name="province_id" class="form-select select2">
                                                <option value="">-- Pilih Provinsi --</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                            <select id="kabupaten" name="regency_id" class="form-select select2" disabled>
                                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <select id="kecamatan" name="district_id" class="form-select select2" disabled>
                                                <option value="">-- Pilih Kecamatan --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="desa" class="form-label">Desa/Kelurahan</label>
                                            <select id="desa" name="village_id" class="form-select select2" disabled>
                                                <option value="">-- Pilih Desa/Kelurahan --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="role_as" class="form-label">Role</label>
                                        <select name="role_as" id="role_as" class="form-control" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Surveyor</option>
                                        </select>
                                        @error('role_as')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><b>Tanda Tangan</b></label>
                                        <div class="border p-2 rounded">
                                            <!-- Canvas untuk menggambar tanda tangan -->
                                            <canvas id="signature-pad" class="border w-100" height="60"></canvas>

                                            <!-- Input hidden untuk menyimpan tanda tangan sebagai Base64 -->
                                            <input type="hidden" name="tanda_tangan" id="tanda_tangan">

                                            <div class="mt-2 d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    id="clear-signature">Hapus</button>
                                                <div class="input-group">
                                                    <input type="file" class="form-control form-control-sm"
                                                        id="upload-signature" accept="image/png,image/jpeg">
                                                </div>
                                            </div>
                                            <small class="text-muted">Anda bisa menggambar tanda tangan atau mengunggah
                                                gambar (format PNG/JPEG).</small>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const canvas = document.getElementById("signature-pad");
            const ctx = canvas.getContext("2d");
            const inputSignature = document.getElementById("tanda_tangan");
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            // Set canvas size berdasarkan ukuran tampilan
            function resizeCanvas() {
                const rect = canvas.getBoundingClientRect();
                canvas.width = rect.width;
                canvas.height = rect.height;
                ctx.lineWidth = 2;
                ctx.lineCap = "round";
                ctx.strokeStyle = "black";
            }

            // Inisialisasi ukuran canvas
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Fungsi untuk mendapatkan posisi kursor/touch yang tepat
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

            // Fungsi untuk menggambar
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

            function stopDrawing(event) {
                if (isDrawing) {
                    isDrawing = false;
                    saveSignature();
                }
            }

            // Event listeners untuk mouse
            canvas.addEventListener("mousedown", startDrawing);
            canvas.addEventListener("mousemove", draw);
            canvas.addEventListener("mouseup", stopDrawing);
            canvas.addEventListener("mouseout", stopDrawing);

            // Event listeners untuk touch devices
            canvas.addEventListener("touchstart", startDrawing);
            canvas.addEventListener("touchmove", draw);
            canvas.addEventListener("touchend", stopDrawing);

            // Fungsi untuk menyimpan tanda tangan
            function saveSignature() {
                try {
                    const dataURL = canvas.toDataURL("image/png");
                    inputSignature.value = dataURL;
                } catch (error) {
                    console.error("Error saving signature:", error);
                }
            }

            // Fungsi untuk menghapus tanda tangan
            document.getElementById("clear-signature").addEventListener("click", function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                inputSignature.value = "";
            });

            // Fungsi untuk mengupload gambar
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

                        // Hitung aspek rasio untuk mempertahankan proporsi gambar
                        const ratio = Math.min(
                            canvas.width / img.width,
                            canvas.height / img.height
                        );
                        const centerX = (canvas.width - img.width * ratio) / 2;
                        const centerY = (canvas.height - img.height * ratio) / 2;

                        ctx.drawImage(
                            img,
                            centerX,
                            centerY,
                            img.width * ratio,
                            img.height * ratio
                        );
                        saveSignature();
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        });

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
@endsection
