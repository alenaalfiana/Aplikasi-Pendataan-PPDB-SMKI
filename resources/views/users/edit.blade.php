@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <div class="container py-4">
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

                        <form action="{{ route('users.update', ['user' => $user->id, 'source' => request('source')]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required
                                    oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s]/g, '')">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') ?: $user->email }}">
                                <small class="form-text text-muted">Email pengguna dengan ID: {{ $user->id }}</small>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <!-- Hidden field tetap diperlukan untuk memastikan nilai terkirim saat checkbox tidak dicentang -->
                                    <input type="hidden" name="verify_email" value="0">

                                    <!-- Checkbox akan tercentang jika email_verified_at tidak null -->
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="verify_email"
                                        name="verify_email"
                                        value="1"
                                        {{ old('verify_email', $user->email_verified_at ? 1 : 0) == 1 ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="verify_email">
                                        <span class="text-muted small d-block mb-1">
                                            *Jika sudah tercentang, akun sudah terverifikasi.
                                        </span>
                                        <strong>Verifikasi email pengguna secara otomatis (tanpa perlu konfirmasi)</strong>
                                    </label>

                                </div>
                            </div>


                            <!-- Password (Opsional) -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru (Kosongkan jika tidak ingin
                                    mengubah)</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                <small class="form-text text-muted">Password untuk pengguna: {{ $user->name }} (ID:
                                    {{ $user->id }})</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select id="provinsi" name="province_id" class="form-select select2" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ old('province_id', $user->province_id) == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                    <select id="kabupaten" name="regency_id" class="form-select select2" required
                                        {{ $user->regency_id ? '' : 'disabled' }}>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        @if ($user->regency)
                                            <option value="{{ $user->regency_id }}" selected>
                                                {{ $user->regency->name }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select id="kecamatan" name="district_id" class="form-select select2" required
                                        {{ $user->district_id ? '' : 'disabled' }}>
                                        <option value="">Pilih Kecamatan</option>
                                        @if ($user->district)
                                            <option value="{{ $user->district_id }}" selected>
                                                {{ $user->district->name }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="desa" class="form-label">Desa/Kelurahan</label>
                                    <select id="desa" name="village_id" class="form-select select2" required
                                        {{ $user->village_id ? '' : 'disabled' }}>
                                        <option value="">Pilih Desa/Kelurahan</option>
                                        @if ($user->village)
                                            <option value="{{ $user->village_id }}" selected>
                                                {{ $user->village->name }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label class="form-label" for="role_as">Role</label>
                                <select name="role_as" id="role_as"
                                    class="form-control @error('role_as') is-invalid @enderror">
                                    @if (Auth::user()->role_as == '1')
                                        <option value="1"
                                            {{ old('role_as', $user->role_as) == '1' ? 'selected' : '' }}>Admin</option>
                                        <option value="2"
                                            {{ old('role_as', $user->role_as) == '2' ? 'selected' : '' }}>Surveyor</option>
                                    @else
                                        @if ($user->role_as == '1')
                                            <option value="1" selected disabled>Admin</option>
                                        @elseif($user->role_as == '2')
                                            <option value="2" selected disabled>Surveyor</option>
                                        @endif
                                    @endif
                                </select>
                                @error('role_as')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><b>Tanda Tangan Siswa</b></label>
                                <div class="border p-2 rounded">
                                    <!-- Canvas untuk menggambar tanda tangan -->
                                    <canvas id="signature-pad" class="border w-100" height="150"></canvas>

                                    <!-- Input hidden untuk menyimpan tanda tangan sebagai Base64 -->
                                    <input type="hidden" name="tanda_tangan" id="tanda_tangan"
                                        value="{{ $user->tanda_tangan }}">

                                    <div class="mt-2 d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            id="clear-signature">Hapus</button>
                                        <input type="file" class="form-control form-control-sm" id="upload-signature"
                                            accept="image/png,image/jpeg">
                                    </div>
                                    <small class="text-muted">Anda bisa menggambar tanda tangan atau mengunggah
                                        gambar (format PNG/JPEG).</small>
                                </div>
                            </div>

                            <div class="d-flex mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route(request('source', 'users.index')) }}"
                                    class="btn btn-secondary">Kembali</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            const canvas = document.getElementById("signature-pad");
            const ctx = canvas.getContext("2d");
            const inputSignature = document.getElementById("tanda_tangan");
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

    <style>
        .form-label::after {
            content: " *";
            color: red;
        }

        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #f8f9fa;
            align-items: center;
            display: flex;
            height: 3.3rem;
        }
    </style>
@endsection
