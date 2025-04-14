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

                            <form action="{{ route('form_interview.store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <h2><b> [ Formulir Interview / Wawancara - Calon Siswa ] </b></h2>
                                <br>
                                <hr>
                                <div id="section-data-pribadi">
                                    <h4>Data Pribadi</h4>

                                    <div class="row mb-4 align-items-end">

                                        <div class="col-md-4">
                                            <label for="id_pendataan_surveyor_siswa" class="form-label">Surveyor</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $pendataan->user->name ?? 'User Tidak Ditemukan' }}" disabled>
                                            <input type="hidden" name="id_pendataan_surveyor_siswa"
                                                    value="{{ $pendataan->id_pendataan_surveyor_siswa ?? '' }}">

                                        </div>

                                        <!-- Nama Siswa -->
                                        <div class="col-md-4">
                                            <label for="id_form_pendaftaran" class="form-label">Nama Lengkap - Calon Siswa</label>
                                            <input type="text" class="form-control" value="{{ $formPendaftaran->registrasiPengambilan->nama ?? 'Nama Tidak Ditemukan' }}" readonly>
                                            <input type="hidden" name="id_form_pendaftaran" value="{{ $formPendaftaran->id_form_pendaftaran }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                            <input type="text" class="form-control" id="nama_panggilan"
                                                name="nama_panggilan" value="{{ old('nama_panggilan') }}" maxlength="25"
                                                required>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Jumlah Saudara</label>
                                        <div class="col-md-4">
                                            <label for="jumlah_saudara_kandung" class="form-label">Kandung</label>
                                            <input type="number" class="form-control" id="jumlah_saudara_kandung"
                                                name="jumlah_saudara_kandung" max="99">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jumlah_saudara_tiri" class="form-label">Tiri</label>
                                            <input type="number" class="form-control" id="jumlah_saudara_tiri"
                                                name="jumlah_saudara_tiri" max="99">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jumlah_saudara_angkat" class="form-label">Angkat</label>
                                            <input type="number" class="form-control" id="jumlah_saudara_angkat"
                                                name="jumlah_saudara_angkat" max="99">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="cita_cita" class="form-label">Cita-cita</label>
                                            <input type="text" class="form-control" id="cita_cita" name="cita_cita"
                                                maxlength="100">
                                        </div>
                                        <div class="col-md-8">
                                            <label for="alasan_cita_cita" class="form-label">a. Alasan</label>
                                            <input type="text" class="form-control" id="alasan_cita_cita"
                                                name="alasan_cita_cita">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-8">
                                            <label for="usaha_yang_dilakukan" class="form-label">b. Usaha/Proses yang
                                                telah dilakukan</label>
                                            <input class="form-control" id="usaha_yang_dilakukan"
                                                name="usaha_yang_dilakukan">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="motto" class="form-label">Motto / Semboyan</label>
                                        <input type="text" class="form-control" id="motto" name="motto"
                                            maxlength="150">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="kekurangan" class="form-label">Kekurangan</label>
                                            <input class="form-control" id="kekurangan" name="kekurangan">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kelebihan" class="form-label">Kelebihan</label>
                                            <input class="form-control" id="kelebihan" name="kelebihan">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label for="tempat_tanggal_lahir" class="form-label">Organisasi</label>
                                            <input type="text" class="form-control" hidden>
                                        </div>
                                        <div class="col-md-10">
                                            <label for="organisasi_sekolah" class="form-label">a. Sekolah</label>
                                            <input type="text" class="form-control" id="organisasi_sekolah"
                                                name="organisasi_sekolah" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-10">
                                            <label for="organisasi_masyarakat" class="form-label">b.
                                                Masyarakat</label>
                                            <input type="text" class="form-control" id="organisasi_masyarakat"
                                                name="organisasi_masyarakat" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="mb-3">
                                            <label for="hobi" class="form-label">Hobi</label>
                                            <input class="form-control" id="hobi" name="hobi">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label for="kesimpulan" class="form-label">Kesimpulan</label>
                                            <input type="text" id="kesimpulan" name="kesimpulan" class="form-control" hidden>
                                        </div>
                                        <div class="col-md-10">
                                            <label for="nilai_komunikasi" class="form-label">a. Komunikasi</label>
                                            <select class="form-control" id="nilai_komunikasi" name="nilai_komunikasi">
                                                <option value="">Pilih...</option>
                                                <option value="baik">Baik</option>
                                                <option value="cukup">Cukup</option>
                                                <option value="kurang">Kurang</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-10">
                                            <label for="nilai_kepercayaan_diri" class="form-label">b. Percaya
                                                Diri</label>
                                            <select class="form-control" id="nilai_kepercayaan_diri"
                                                name="nilai_kepercayaan_diri">
                                                <option value="">Pilih...</option>
                                                <option value="baik">Baik</option>
                                                <option value="cukup">Cukup</option>
                                                <option value="kurang">Kurang</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="uang_saku" class="form-label">Uang Saku</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="uang_saku" name="uang_saku" class="form-control"
                                                oninput="formatRupiah(this)" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kemampuan_bermotor" class="form-label">Kemampuan Bermotor</label>
                                        <select class="form-control" id="kemampuan_bermotor" name="kemampuan_bermotor">
                                            <option value="">Pilih...</option>
                                            <option value="bisa">Bisa</option>
                                            <option value="tidak_bisa">Tidak Bisa</option>
                                        </select>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <div id="section-data-sekolah">
                                    <h4>Data Sekolah Asal</h4>
                                    <div class="mb-3">
                                        <label for="prestasi_yang_dicapai" class="form-label">Prestasi yang
                                            Dicapai</label>
                                        <div id="prestasi-container">
                                            @if (isset($formInterview->prestasi_yang_dicapai))
                                                @php
                                                    $prestasi = json_decode(
                                                        $formInterview->prestasi_yang_dicapai,
                                                        true,
                                                    );
                                                @endphp
                                                @if (is_array($prestasi) && count($prestasi) > 0)
                                                    @foreach ($prestasi as $index => $item)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="prestasi_yang_dicapai[]"
                                                                class="form-control" value="{{ $item }}" required>
                                                            <button type="button"
                                                                class="btn btn-danger remove-prestasi">Hapus</button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="prestasi_yang_dicapai[]"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-prestasi">Hapus</button>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="input-group mb-2">
                                                    <input type="text" name="prestasi_yang_dicapai[]"
                                                        class="form-control" required>
                                                    <button type="button"
                                                        class="btn btn-danger remove-prestasi">Hapus</button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                            id="add-prestasi">Tambah
                                            Prestasi</button>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Tambah prestasi baru
                                            document.getElementById('add-prestasi').addEventListener('click', function() {
                                                const container = document.getElementById('prestasi-container');
                                                const newRow = document.createElement('div');
                                                newRow.className = 'input-group mb-2';

                                                newRow.innerHTML = `
                                                                <input type="text" name="prestasi_yang_dicapai[]" class="form-control" required>
                                                                <button type="button" class="btn btn-danger remove-prestasi">Hapus</button>
                                                            `;

                                                container.appendChild(newRow);

                                                // Tambahkan event listener ke tombol hapus
                                                newRow.querySelector('.remove-prestasi').addEventListener('click', function() {
                                                    container.removeChild(newRow);
                                                });
                                            });

                                            // Hapus prestasi (untuk elemen yang sudah ada)
                                            document.querySelectorAll('.remove-prestasi').forEach(button => {
                                                button.addEventListener('click', function() {
                                                    const row = this.parentNode;
                                                    if (document.querySelectorAll('#prestasi-container .input-group').length > 1) {
                                                        row.parentNode.removeChild(row);
                                                    } else {
                                                        // Jika hanya ada satu input, kosongkan nilainya saja
                                                        row.querySelector('input').value = '';
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <div class="mb-3">
                                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran yang
                                            Disukai</label>
                                        <select name="mata_pelajaran" id="mata_pelajaran" class="form-control" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            <option value="Matematika">Matematika</option>
                                            <option value="Bahasa_Indonesia">Bahasa Indonesia</option>
                                            <option value="Bahasa_Inggris">Bahasa Inggris</option>
                                            <option value="IPA">IPA</option>
                                            <option value="IPS">IPS</option>
                                            <option value="PKN">PKN</option>
                                            <option value="Seni_Budaya">Seni Budaya</option>
                                            <option value="Olahraga">Olahraga</option>
                                            <option value="Agama">Agama</option>
                                            <option value="Tidak_ada">Tidak Ada</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row mb-1">
                                            <div class="col-md-5">
                                                <label class="form-label">Rencana Pilihan Sekolah</label>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Alasan Pilihan Sekolah</label>
                                            </div>
                                        </div>
                                        <div id="sekolah-container">
                                            @if (isset($formInterview->rencana_pilihan_sekolah) && isset($formInterview->alasan_pilihan_sekolah))
                                                @php
                                                    $rencana = json_decode(
                                                        $formInterview->rencana_pilihan_sekolah,
                                                        true,
                                                    );
                                                    $alasan = json_decode($formInterview->alasan_pilihan_sekolah, true);
                                                    $count = max(count($rencana), count($alasan));
                                                @endphp
                                                @if (is_array($rencana) && is_array($alasan) && $count > 0)
                                                    @for ($i = 0; $i < $count; $i++)
                                                        <div class="row mb-2 sekolah-row">
                                                            <div class="col-md-5">
                                                                <input type="text" name="rencana_pilihan_sekolah[]"
                                                                    class="form-control" value="{{ $rencana[$i] ?? '' }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="alasan_pilihan_sekolah[]"
                                                                    class="form-control" value="{{ $alasan[$i] ?? '' }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-sekolah">Hapus</button>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                @else
                                                    <div class="row mb-2 sekolah-row">
                                                        <div class="col-md-5">
                                                            <input type="text" name="rencana_pilihan_sekolah[]"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" name="alasan_pilihan_sekolah[]"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button"
                                                                class="btn btn-danger remove-sekolah">Hapus</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="row mb-2 sekolah-row">
                                                    <div class="col-md-5">
                                                        <input type="text" name="rencana_pilihan_sekolah[]"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="alasan_pilihan_sekolah[]"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button"
                                                            class="btn btn-danger remove-sekolah">Hapus</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                            id="add-sekolah">Tambah
                                            Pilihan Sekolah</button>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Tambah pilihan sekolah baru
                                            document.getElementById('add-sekolah').addEventListener('click', function() {
                                                const container = document.getElementById('sekolah-container');
                                                const newRow = document.createElement('div');
                                                newRow.className = 'row mb-2 sekolah-row';

                                                newRow.innerHTML = `
                                                                <div class="col-md-5">
                                                                    <input type="text" name="rencana_pilihan_sekolah[]" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text" name="alasan_pilihan_sekolah[]" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button" class="btn btn-danger remove-sekolah">Hapus</button>
                                                                </div>
                                                            `;

                                                container.appendChild(newRow);

                                                // Tambahkan event listener ke tombol hapus
                                                newRow.querySelector('.remove-sekolah').addEventListener('click', function() {
                                                    container.removeChild(newRow);
                                                });
                                            });

                                            // Hapus pilihan sekolah (untuk elemen yang sudah ada)
                                            document.querySelectorAll('.remove-sekolah').forEach(button => {
                                                button.addEventListener('click', function() {
                                                    const row = this.closest('.sekolah-row');
                                                    if (document.querySelectorAll('#sekolah-container .sekolah-row').length > 1) {
                                                        row.parentNode.removeChild(row);
                                                    } else {
                                                        // Jika hanya ada satu input, kosongkan nilainya saja
                                                        row.querySelectorAll('input').forEach(input => {
                                                            input.value = '';
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <div class="mb-4">
                                        <label for="kenalan_yang_diterima_di_smki"
                                            class="form-label">Teman / Famili / Tetangga
                                            yang baru mendaftar / diterima di
                                            SMKI Utama</label>
                                        <input type="text" name="kenalan_yang_diterima_di_smki"
                                            id="kenalan_yang_diterima_di_smki" class="form-control" maxlength="100"
                                            required>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="form-label">Histori Akademik</label>
                                        <div class="col-md-4">
                                            <label for="historis_sakit" class="form-label">Sakit</label>
                                            <input type="text" name="historis_sakit" id="historis_sakit"
                                                class="form-control" maxlength="2" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="historis_ijin" class="form-label">Ijin</label>
                                            <input type="text" name="historis_ijin" id="historis_ijin"
                                                class="form-control" maxlength="2" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="historis_alfa" class="form-label">Alfa</label>
                                            <input type="text" name="historis_alfa" id="historis_alfa"
                                                class="form-control" maxlength="2" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan_kasus_pelanggaran" class="form-label">Catatan Kasus
                                            Pelanggaran</label>
                                        <input type="text" name="catatan_kasus_pelanggaran"
                                            id="catatan_kasus_pelanggaran" class="form-control" maxlength="100" required>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="bhq" class="form-label">Bacaan Huruf Qur'an (BHQ)</label>
                                            <select name="bhq" id="bhq" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                <option value="lancar">Lancar</option>
                                                <option value="terbata_bata">Terbata-bata</option>
                                                <option value="tidak_bisa">Tidak Bisa</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hafalan_juz" class="form-label">Hafalan Juz</label>
                                            <input type="text" name="hafalan_juz" id="hafalan_juz"
                                                class="form-control" maxlength="50">
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <div id="section-data-kesehatan">
                                    <h4>Data Kesehatan Jiwa Raga</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Merokok / Narkoba</label>
                                            <input type="text" name="merokok_narkoba" class="form-control"
                                                maxlength="50" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis, Merek, dan Harga</label>
                                            <input type="text" name="jenis_merek_harga" class="form-control"
                                                maxlength="100" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Anggota Keluarga yang Merokok</label>
                                            <input type="text" name="anggota_keluarga_yg_merokok" class="form-control"
                                                maxlength="100" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Riwayat Kesehatan</label>
                                            <input type="text" name="riwayat_kesehatan" class="form-control"
                                                maxlength="100" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Ketertarikan dengan Lawan Jenis</label>
                                            <select name="ketertarikan_dengan_lawan_jenis" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                <option value="tidak_pacaran">Tidak Pacaran</option>
                                                <option value="pacaran">Pacaran</option>
                                                <option value="pernah_pacaran">Pernah Pacaran</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Terpapar Pornografi</label>
                                            <select class="form-select" name="terpapar_pornografi">
                                                <option value="">Pilih...</option>
                                                <option value="melihat_gambar">Melihat Gambar</option>
                                                <option value="menonton_video">Menonton Video</option>
                                                <option value="menyebarluaskan">Menyebarluaskan</option>
                                                <option value="tidak_terpapar">Tidak Terpapar</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Media Sosial yang Digunakan</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="Facebook" id="facebook">
                                                <label class="form-check-label" for="facebook">Facebook</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="Instagram" id="instagram">
                                                <label class="form-check-label" for="instagram">Instagram</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="Twitter" id="twitter">
                                                <label class="form-check-label" for="twitter">Twitter</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="TikTok" id="tiktok">
                                                <label class="form-check-label" for="tiktok">TikTok</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="YouTube" id="youtube">
                                                <label class="form-check-label" for="youtube">YouTube</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="WhatsApp" id="whatsapp">
                                                <label class="form-check-label" for="whatsapp">WhatsApp</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                    value="Telegram" id="telegram">
                                                <label class="form-check-label" for="telegram">Telegram</label>
                                            </div>

                                            <!-- Opsi lainnya -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lainnya-checkbox"
                                                    onchange="toggleLainnya()">
                                                <label class="form-check-label" for="lainnya-checkbox">Lainnya</label>
                                            </div>

                                            <!-- Input untuk opsi lainnya -->
                                            <input type="text" name="media_sosial[]" id="lainnya-input"
                                                class="form-control mt-2" placeholder="Masukkan media sosial lain..."
                                                style="display: none;">
                                        </div>

                                        <script>
                                            function toggleLainnya() {
                                                let lainnyaCheckbox = document.getElementById('lainnya-checkbox');
                                                let lainnyaInput = document.getElementById('lainnya-input');

                                                if (lainnyaCheckbox.checked) {
                                                    lainnyaInput.style.display = 'block';
                                                    lainnyaInput.focus();
                                                } else {
                                                    lainnyaInput.style.display = 'none';
                                                    lainnyaInput.value = '';
                                                }
                                            }
                                        </script>

                                    </div>
                                </div>

                                <br>
                                <hr>
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
                                                                        class="form-control"
                                                                        value="{{ $nama[$i] ?? '' }}" required>
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
                                                                        class="form-control"
                                                                        value="{{ $usia[$i] ?? '' }}" required></td>
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
                                                                    <select name="hubungan[]" class="form-control"
                                                                        required>
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
                                                                    <option value="Laki-laki">Laki-laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
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

                                <br>
                                <hr>
                                <div id="section-situasi-keluarga">
                                    <h4>Data Situasi Keluarga Siswa</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Siswa Tinggal Bersama</label>
                                            <select name="siswa_tinggal_bersama" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                <option value="Ayah Kandung & Ibu Kandung">Ayah Kandung & Ibu Kandung
                                                </option>
                                                <option value="Ayah Kandung & Ibu Tiri">Ayah Kandung & Ibu Tiri
                                                </option>
                                                <option value="Ayah Kandung saja">Ayah Kandung saja</option>
                                                <option value="Ibu Kandung saja">Ibu Kandung saja</option>
                                                <option value="Nenek / Kakek dari Ayah">Nenek / Kakek dari Ayah
                                                </option>
                                                <option value="Nenek / Kakek dari Ibu">Nenek / Kakek dari Ibu</option>
                                                <option value="Keluarga lain">Keluarga lain</option>
                                                <option value="Asrama">Asrama</option>
                                                <option value="Panti Asuhan">Panti Asuhan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status Pernikahan Orang Tua</label>
                                            <select name="status_pernikahan_ortu" id="status_pernikahan_ortu"
                                                class="form-control" required onchange="toggleLainnyaInput()">
                                                <option value="">Pilih...</option>
                                                <option value="Utuh">Utuh</option>
                                                <option value="Cerai">Cerai</option>
                                                <option value="Berpisah">Berpisah</option>
                                                <option value="Lain-lain">Lain-lain</option>
                                            </select>
                                            <input type="text" name="status_pernikahan_ortu_lainnya"
                                                id="status_pernikahan_ortu_lainnya" class="form-control mt-2"
                                                placeholder="Masukkan status lainnya..." style="display: none;">
                                        </div>

                                        <script>
                                            function toggleLainnyaInput() {
                                                var selectBox = document.getElementById("status_pernikahan_ortu");
                                                var inputBox = document.getElementById("status_pernikahan_ortu_lainnya");
                                                if (selectBox.value === "Lain-lain") {
                                                    inputBox.style.display = "block";
                                                    inputBox.setAttribute("required", "required");
                                                } else {
                                                    inputBox.style.display = "none";
                                                    inputBox.removeAttribute("required");
                                                }
                                            }
                                        </script>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Status Rumah</label>
                                            <select name="status_rumah" id="status_rumah" class="form-control" required
                                                onchange="toggleHargaKontrak()">
                                                <option value="">Pilih...</option>
                                                <option value="Milik Sendiri">Milik Sendiri</option>
                                                <option value="Kontrak">Kontrak</option>
                                                <option value="Menumpang">Menumpang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6" id="harga_kontrak_group" style="display: none;">
                                            <label class="form-label">Harga Kontrak (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="harga_kontrak" id="harga_kontrak"
                                                    class="form-control" oninput="formatRupiah(this)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Daya Listrik (Watt)</label>
                                            <input type="number" name="daya_listrik" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Biaya Listrik per Bulan (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="biaya_listrik" id="biaya_listrik"
                                                    class="form-control" oninput="formatRupiah(this)" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Transportasi yang Dimiliki</label>

                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="transportasi_yg_dimiliki[]" value="Sepeda" id="sepeda">
                                                <label class="form-check-label" for="sepeda">Sepeda</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="transportasi_yg_dimiliki[]" value="Motor" id="motor">
                                                <label class="form-check-label" for="motor">Motor</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="transportasi_yg_dimiliki[]" value="Mobil" id="mobil">
                                                <label class="form-check-label" for="mobil">Mobil</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label class="form-label">Harta Milik Keluarga</label>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="Televisi" id="televisi">
                                                <label class="form-check-label" for="televisi">Televisi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="Radio/tape" id="radio">
                                                <label class="form-check-label" for="radio">Radio/tape</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="PlayStation" id="playstation">
                                                <label class="form-check-label" for="playstation">PlayStation</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="Kulkas" id="kulkas">
                                                <label class="form-check-label" for="kulkas">Kulkas</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="Magic Jar" id="magic_jar">
                                                <label class="form-check-label" for="magic_jar">Magic Jar</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="HP" id="hp">
                                                <label class="form-check-label" for="hp">HP</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="DVD" id="dvd">
                                                <label class="form-check-label" for="dvd">DVD</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="AC/Kipas Angin" id="ac_kipas">
                                                <label class="form-check-label" for="ac_kipas">AC/Kipas Angin</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="harta_milik_keluarga[]" value="PC/Laptop" id="pc_laptop">
                                                <label class="form-check-label" for="pc_laptop">PC/Laptop</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Kalung (gr)</label>
                                            <input type="number" name="berat_kalung_gr" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Cincin (gr)</label>
                                            <input type="number" name="berat_cincin_gr" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Gelang (gr)</label>
                                            <input type="number" name="berat_gelang_gr" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Anting (gr)</label>
                                            <input type="number" name="berat_anting_gr" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Tanggungan Kredit</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="tanggungan_kredit" id="tanggungan_kredit"
                                                    class="form-control" oninput="formatRupiah(this)" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Menurut anda, apakah orang tua anda cukup
                                                memperhatikan kebutuhan anda? Misalnya kebutuhan sekolah, pakaian, atau
                                                lainnya?</label>
                                            <textarea name="pendapat" class="form-control" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function toggleHargaKontrak() {
                                        let statusRumah = document.getElementById("status_rumah").value;
                                        let hargaKontrakGroup = document.getElementById("harga_kontrak_group");
                                        let hargaKontrakInput = document.getElementById("harga_kontrak");

                                        if (statusRumah === "Kontrak") {
                                            hargaKontrakGroup.style.display = "block";
                                            hargaKontrakInput.required = true;
                                        } else {
                                            hargaKontrakGroup.style.display = "none";
                                            hargaKontrakInput.required = false;
                                            hargaKontrakInput.value = "";
                                        }
                                    }
                                </script>

                                <br>
                                <hr>
                                <div id="section-kontak-darurat">
                                    <h4>Kontak Darurat</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hubungan dengan Siswa</label>
                                            <input type="text" name="hubungan_dgn_siswa" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-md-12 mb-3 mt-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea name="alamat_kontak_darurat" class="form-control" rows="3" required></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No. HP (Opsional)</label>
                                            <input type="text" name="no_hp" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <div id="section-kesimpulan">
                                    <h4>Kesimpulan dan Saran</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Kesimpulan Keseluruhan</label>
                                            <textarea name="kesimpulan" class="form-control" rows="4" name="kesimpulan" id="kesimpulan" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <div id="section-detail-tambahan">
                                    <h4>Detail Tambahan</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Denah Lokasi</label>
                                            <input type="file" name="denah_lokasi" class="form-control" accept="image/*" capture="camera">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap (yang dikenal di lingkungan)</label>
                                            <input type="text" name="nama_lengkap" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-label">Nama Panggilan di Lingkungan</label>
                                            <input type="text" name="nama_panggilan_di_lingkungan"
                                                class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-label">Tanggal Pengisian</label>
                                            <input type="date" name="tanggal_pengisian" class="form-control"
                                                id="tanggal_pengisian" required>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                let today = new Date().toISOString().split('T')[0];
                                                document.getElementById('tanggal_pengisian').value = today;
                                            });
                                        </script>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Ciri-ciri Rumah</label>
                                            <div id="ciri-ciri-container">
                                                @if (isset($ciri_ciri_rumah) && count($ciri_ciri_rumah) > 0)
                                                    @foreach ($ciri_ciri_rumah as $ciri)
                                                        <div class="input-group mb-2 ciri-item">
                                                            <input type="text" name="ciri_ciri_rumah[]"
                                                                class="form-control" value="{{ $ciri }}"
                                                                required>
                                                            <button type="button" class="btn btn-danger hapus-ciri">
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2 ciri-item">
                                                        <input type="text" name="ciri_ciri_rumah[]"
                                                            class="form-control" required>
                                                        <button type="button" class="btn btn-danger hapus-ciri">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" id="tambah-ciri" class="btn btn-primary btn-sm mt-2">
                                                Tambah Ciri-ciri
                                            </button>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status_interview" class="form-label">Status Interview</label>
                                            <select name="status_interview" id="status_interview" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="sudah">Sudah</option>
                                                <option value="belum">Belum</option>
                                            </select>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Fungsi untuk menambah field ciri-ciri baru
                                                document.getElementById('tambah-ciri').addEventListener('click', function() {
                                                    const container = document.getElementById('ciri-ciri-container');
                                                    const newRow = document.createElement('div');
                                                    newRow.className = 'input-group mb-2 ciri-item';
                                                    newRow.innerHTML = `
                        <input type="text" name="ciri_ciri_rumah[]" class="form-control" required>
                        <button type="button" class="btn btn-danger hapus-ciri">
                            Hapus </button>
                    `;
                                                    container.appendChild(newRow);

                                                    // Tambahkan event listener untuk tombol hapus yang baru ditambahkan
                                                    newRow.querySelector('.hapus-ciri').addEventListener('click', hapusCiri);
                                                });

                                                // Fungsi untuk menghapus field ciri-ciri
                                                function hapusCiri() {
                                                    // Pastikan minimal ada satu field yang tersisa
                                                    const items = document.querySelectorAll('.ciri-item');
                                                    if (items.length > 1) {
                                                        this.closest('.ciri-item').remove();
                                                    } else {
                                                        alert('Minimal harus ada satu ciri-ciri rumah!');
                                                    }
                                                }

                                                // Tambahkan event listener untuk tombol-tombol hapus yang sudah ada
                                                document.querySelectorAll('.hapus-ciri').forEach(function(button) {
                                                    button.addEventListener('click', hapusCiri);
                                                });
                                            });
                                        </script>

                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('form_interview.index') }}" class="btn btn-secondary">Kembali</a>
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
