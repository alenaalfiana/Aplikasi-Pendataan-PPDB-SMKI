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

                            <form action="{{ route('form_interview.update', $interview->id_form_interview) }}"
                                method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put" />

                                <div id="section-data-pribadi">
                                    <h4>Data Pribadi</h4>

                                    <div class="row mb-4 align-items-end">
                                        <!-- Surveyor -->
                                        <div class="col-md-4">
                                            <label for="id_pendataan_surveyor_siswa" class="form-label">Surveyor</label>
                                            <input type="text" class="form-control"
                                                value="{{ optional($interview->pendataanSurveyor->user)->name ?? 'User Tidak Ditemukan' }}"
                                                disabled>
                                            <input type="hidden" name="id_pendataan_surveyor_siswa"
                                                value="{{ old('id_pendataan_surveyor_siswa', $interview->id_pendataan_surveyor_siswa ?? '') }}">
                                        </div>

                                        <!-- Nama Siswa -->
                                        <div class="col-md-4">
                                            <label for="id_form_pendaftaran" class="form-label">Nama Lengkap - Calon
                                                Siswa</label>
                                            <input type="text" class="form-control"
                                                value="{{ optional($interview->formPendaftaran->registrasiPengambilan)->nama ?? 'Nama Tidak Ditemukan' }}"
                                                readonly>
                                            <input type="hidden" name="id_form_pendaftaran"
                                                value="{{ old('id_form_pendaftaran', $interview->id_form_pendaftaran) }}">
                                        </div>

                                        <!-- Nama Panggilan -->
                                        <div class="col-md-4">
                                            <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                            <input type="text" class="form-control" id="nama_panggilan"
                                                name="nama_panggilan"
                                                value="{{ old('nama_panggilan', $interview->nama_panggilan) }}"
                                                maxlength="25" required>
                                        </div>


                                    </div>


                                    <div class="row mb-3">
                                        <label class="form-label">Jumlah Saudara</label>
                                        <div class="col-md-4">
                                            <label for="jumlah_saudara_kandung" class="form-label">Kandung</label>
                                            <input type="number" class="form-control" id="jumlah_saudara_kandung"
                                                name="jumlah_saudara_kandung" max="99"
                                                value="{{ old('jumlah_saudara_kandung', $interview->jumlah_saudara_kandung) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jumlah_saudara_tiri" class="form-label">Tiri</label>
                                            <input type="number" class="form-control" id="jumlah_saudara_tiri"
                                                name="jumlah_saudara_tiri" max="99"
                                                value="{{ old('jumlah_saudara_tiri', $interview->jumlah_saudara_tiri) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jumlah_saudara_angkat" class="form-label">Angkat</label>
                                            <input type="number" class="form-control" id="jumlah_saudara_angkat"
                                                name="jumlah_saudara_angkat" max="99"
                                                value="{{ old('jumlah_saudara_angkat', $interview->jumlah_saudara_angkat) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="cita_cita" class="form-label">Cita-cita</label>
                                            <input type="text" class="form-control" id="cita_cita" name="cita_cita"
                                                value="{{ old('cita_cita', $interview->cita_cita) }}" maxlength="100">
                                        </div>
                                        <div class="col-md-8">
                                            <label for="alasan_cita_cita" class="form-label">a. Alasan</label>
                                            <input type="text" class="form-control" id="alasan_cita_cita"
                                                name="alasan_cita_cita"
                                                value="{{ old('alasan_cita_cita', $interview->alasan_cita_cita) }}"
                                                maxlength="25">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-8 offset-md-4">
                                            <label for="usaha_yang_dilakukan" class="form-label">b. Usaha/Proses yang telah
                                                dilakukan</label>
                                            <input class="form-control" id="usaha_yang_dilakukan"
                                                name="usaha_yang_dilakukan"
                                                value="{{ old('usaha_yang_dilakukan', $interview->usaha_yang_dilakukan) }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="motto" class="form-label">Motto / Semboyan</label>
                                        <input type="text" class="form-control" id="motto" name="motto"
                                            value="{{ old('motto', $interview->motto) }}" maxlength="150">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="kekurangan" class="form-label">Kekurangan</label>
                                            <input class="form-control" id="kekurangan" name="kekurangan"
                                                value="{{ old('kekurangan', $interview->kekurangan) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kelebihan" class="form-label">Kelebihan</label>
                                            <input class="form-control" id="kelebihan" name="kelebihan"
                                                value="{{ old('kelebihan', $interview->kelebihan) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-10 offset-md-2">
                                            <label for="organisasi_sekolah" class="form-label">a. Sekolah</label>
                                            <input type="text" class="form-control" id="organisasi_sekolah"
                                                name="organisasi_sekolah"
                                                value="{{ old('organisasi_sekolah', $interview->organisasi_sekolah) }}"
                                                maxlength="50">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-10 offset-md-2">
                                            <label for="organisasi_masyarakat" class="form-label">b. Masyarakat</label>
                                            <input type="text" class="form-control" id="organisasi_masyarakat"
                                                name="organisasi_masyarakat"
                                                value="{{ old('organisasi_masyarakat', $interview->organisasi_masyarakat) }}"
                                                maxlength="50">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="hobi" class="form-label">Hobi</label>
                                        <input class="form-control" id="hobi" name="hobi"
                                            value="{{ old('hobi', $interview->hobi) }}">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-10 offset-md-2">
                                            <label for="nilai_komunikasi" class="form-label">a. Komunikasi</label>
                                            <select class="form-control" id="nilai_komunikasi" name="nilai_komunikasi">
                                                <option value="">Pilih</option>
                                                <option value="baik"
                                                    {{ old('nilai_komunikasi', $interview->nilai_komunikasi) == 'baik' ? 'selected' : '' }}>
                                                    Baik</option>
                                                <option value="cukup"
                                                    {{ old('nilai_komunikasi', $interview->nilai_komunikasi) == 'cukup' ? 'selected' : '' }}>
                                                    Cukup</option>
                                                <option value="kurang"
                                                    {{ old('nilai_komunikasi', $interview->nilai_komunikasi) == 'kurang' ? 'selected' : '' }}>
                                                    Kurang</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-10 offset-md-2">
                                            <label for="nilai_kepercayaan_diri" class="form-label">b. Percaya Diri</label>
                                            <select class="form-control" id="nilai_kepercayaan_diri"
                                                name="nilai_kepercayaan_diri">
                                                <option value="">Pilih</option>
                                                <option value="baik"
                                                    {{ old('nilai_kepercayaan_diri', $interview->nilai_kepercayaan_diri) == 'baik' ? 'selected' : '' }}>
                                                    Baik</option>
                                                <option value="cukup"
                                                    {{ old('nilai_kepercayaan_diri', $interview->nilai_kepercayaan_diri) == 'cukup' ? 'selected' : '' }}>
                                                    Cukup</option>
                                                <option value="kurang"
                                                    {{ old('nilai_kepercayaan_diri', $interview->nilai_kepercayaan_diri) == 'kurang' ? 'selected' : '' }}>
                                                    Kurang</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="uang_saku" class="form-label">Uang Saku</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="uang_saku" name="uang_saku" class="form-control"
                                                value="{{ old('uang_saku', $interview->uang_saku) }}"
                                                oninput="formatRupiah(this)" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kemampuan_bermotor" class="form-label">Kemampuan Bermotor</label>
                                        <select class="form-control" id="kemampuan_bermotor" name="kemampuan_bermotor">
                                            <option value="">Pilih</option>
                                            <option value="bisa"
                                                {{ old('kemampuan_bermotor', $interview->kemampuan_bermotor) == 'bisa' ? 'selected' : '' }}>
                                                Bisa</option>
                                            <option value="tidak_bisa"
                                                {{ old('kemampuan_bermotor', $interview->kemampuan_bermotor) == 'tidak_bisa' ? 'selected' : '' }}>
                                                Tidak Bisa</option>
                                        </select>
                                    </div>

                                </div>

                                <script>
                                    $(document).ready(function() {
                                        let selectedId = $('#id_form_pendaftaran').val();
                                        $('#lihatProfilBtn').prop('disabled', !selectedId);

                                        $('#id_form_pendaftaran').on('change', function() {
                                            let selectedOption = this.options[this.selectedIndex];
                                            let idKelengkapan = selectedOption.getAttribute('data-id-kelengkapan') || "";
                                            let status = selectedOption.getAttribute('data-status') || "Belum Ada Data";

                                            $('#id_data_kelengkapan_text').val(status);
                                            $('#id_data_kelengkapan_hidden').val(idKelengkapan);
                                            $('#lihatProfilBtn').prop('disabled', !this.value);
                                        });

                                        $('#lihatProfilBtn').on('click', function() {
                                            if (selectedId) {
                                                $.ajax({
                                                    url: `/form-pendaftaran/${selectedId}`,
                                                    type: "GET",
                                                    dataType: "json",
                                                    success: function(data) {
                                                        $('#modal_nama').text(data.nama);
                                                        $('#modal_nisn').text(data.nisn);
                                                        $('#modal_jenis_kelamin').text(data.jenis_kelamin);
                                                        $('#modal_ttl').text(data.tempat_lahir + ', ' + data.tanggal_lahir);
                                                        $('#modal_alamat').text(data.alamat_lengkap);
                                                        $('#dataModal').modal('show');
                                                    },
                                                    error: function() {
                                                        alert('Data tidak ditemukan!');
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>

                                <br>
                                <hr>
                                <div id="section-data-sekolah">
                                    <h4>Data Sekolah Asal</h4>
                                    <div class="mb-3">
                                        <label for="prestasi_yang_dicapai" class="form-label">Prestasi yang
                                            Dicapai</label>
                                        <div id="prestasi-container">
                                            @php
                                                $prestasi = isset($interview->prestasi_yang_dicapai)
                                                    ? json_decode($interview->prestasi_yang_dicapai, true)
                                                    : [];
                                            @endphp
                                            @foreach ($prestasi as $index => $item)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="prestasi_yang_dicapai[]"
                                                        class="form-control" value="{{ $item }}" required>
                                                    <button type="button"
                                                        class="btn btn-danger remove-prestasi">Hapus</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                            id="add-prestasi">Tambah
                                            Prestasi</button>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran yang Disukai</label>
                                        <select name="mata_pelajaran" id="mata_pelajaran" class="form-control" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @php
                                                $mapel = [
                                                    'Matematika',
                                                    'Bahasa_Indonesia',
                                                    'Bahasa_Inggris',
                                                    'IPA',
                                                    'IPS',
                                                    'PKN',
                                                    'Seni_Budaya',
                                                    'Olahraga',
                                                    'Agama',
                                                    'Tidak_ada',
                                                ];
                                            @endphp
                                            @foreach ($mapel as $pelajaran)
                                                <option value="{{ $pelajaran }}"
                                                    {{ isset($interview->mata_pelajaran) && $interview->mata_pelajaran == $pelajaran ? 'selected' : '' }}>
                                                    {{ str_replace('_', ' ', $pelajaran) }}
                                                </option>
                                            @endforeach
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
                                            @php
                                                $rencana = isset($interview->rencana_pilihan_sekolah)
                                                    ? json_decode($interview->rencana_pilihan_sekolah, true)
                                                    : [];
                                                $alasan = isset($interview->alasan_pilihan_sekolah)
                                                    ? json_decode($interview->alasan_pilihan_sekolah, true)
                                                    : [];
                                                $count = max(count($rencana), count($alasan));
                                            @endphp
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
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                            id="add-sekolah">Tambah Pilihan Sekolah</button>
                                    </div>

                                    <div class="mb-4">
                                        <label for="kenalan_yang_diterima_di_smki"
                                            class="form-label">Teman/Famili/Tetangga yang baru mendaftar / diterima di SMKI
                                            Utama</label>
                                        <input type="text" name="kenalan_yang_diterima_di_smki"
                                            id="kenalan_yang_diterima_di_smki" class="form-control" maxlength="100"
                                            value="{{ $interview->kenalan_yang_diterima_di_smki ?? '' }}" required>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="form-label">Histori Akademik</label>
                                        <div class="col-md-4">
                                            <label for="historis_sakit" class="form-label">Sakit</label>
                                            <input type="text" name="historis_sakit" id="historis_sakit"
                                                class="form-control" maxlength="2"
                                                value="{{ $interview->historis_sakit }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="historis_ijin" class="form-label">Ijin</label>
                                            <input type="text" name="historis_ijin" id="historis_ijin"
                                                class="form-control" maxlength="2"
                                                value="{{ $interview->historis_ijin }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="historis_alfa" class="form-label">Alfa</label>
                                            <input type="text" name="historis_alfa" id="historis_alfa"
                                                class="form-control" maxlength="2"
                                                value="{{ $interview->historis_alfa }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan_kasus_pelanggaran" class="form-label">Catatan Kasus
                                            Pelanggaran</label>
                                        <input type="text" name="catatan_kasus_pelanggaran"
                                            id="catatan_kasus_pelanggaran" class="form-control" maxlength="100"
                                            value="{{ $interview->catatan_kasus_pelanggaran }}" required>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="bhq" class="form-label">Bacaan Huruf Qur'an (BHQ)</label>
                                            <select name="bhq" id="bhq" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="lancar"
                                                    {{ $interview->bhq == 'lancar' ? 'selected' : '' }}>Lancar</option>
                                                <option value="terbata_bata"
                                                    {{ $interview->bhq == 'terbata_bata' ? 'selected' : '' }}>Terbata-bata
                                                </option>
                                                <option value="tidak_bisa"
                                                    {{ $interview->bhq == 'tidak_bisa' ? 'selected' : '' }}>Tidak Bisa
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hafalan_juz" class="form-label">Hafalan Juz</label>
                                            <input type="text" name="hafalan_juz" id="hafalan_juz"
                                                class="form-control" maxlength="50"
                                                value="{{ $interview->hafalan_juz }}">
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
                                                maxlength="50"
                                                value="{{ old('merokok_narkoba', $interview->merokok_narkoba ?? '') }}"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis, Merek, dan Harga</label>
                                            <input type="text" name="jenis_merek_harga" class="form-control"
                                                maxlength="100"
                                                value="{{ old('jenis_merek_harga', $interview->jenis_merek_harga ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Anggota Keluarga yang Merokok</label>
                                            <input type="text" name="anggota_keluarga_yg_merokok" class="form-control"
                                                value="{{ old('anggota_keluarga_yg_merokok', $interview->anggota_keluarga_yg_merokok ?? '') }}"
                                                maxlength="100" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Riwayat Kesehatan</label>
                                            <input type="text" name="riwayat_kesehatan" class="form-control"
                                                maxlength="100"
                                                value="{{ old('riwayat_kesehatan', $interview->riwayat_kesehatan ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Ketertarikan dengan Lawan Jenis</label>
                                            <select name="ketertarikan_dengan_lawan_jenis" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                @php
                                                    $opsi_ketertarikan = [
                                                        'tidak_pacaran' => 'Tidak Pacaran',
                                                        'pacaran' => 'Pacaran',
                                                        'pernah_pacaran' => 'Pernah Pacaran',
                                                    ];
                                                @endphp
                                                @foreach ($opsi_ketertarikan as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('ketertarikan_dengan_lawan_jenis', $interview->ketertarikan_dengan_lawan_jenis ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Terpapar Pornografi</label>
                                            <select class="form-select" name="terpapar_pornografi">
                                                @php
                                                    $opsi_terpapar = [
                                                        'melihat_gambar' => 'Melihat Gambar',
                                                        'menonton_video' => 'Menonton Video',
                                                        'menyebarluaskan' => 'Menyebarluaskan',
                                                        'tidak_terpapar' => 'Tidak Terpapar',
                                                    ];
                                                @endphp
                                                @foreach ($opsi_terpapar as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('terpapar_pornografi', $interview->terpapar_pornografi ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Media Sosial yang Digunakan</label>
                                            @php
                                                $media_sosial_options = [
                                                    'Facebook',
                                                    'Instagram',
                                                    'Twitter',
                                                    'TikTok',
                                                    'YouTube',
                                                    'WhatsApp',
                                                    'Telegram',
                                                ];
                                                $media_terpilih = old(
                                                    'media_sosial',
                                                    json_decode($interview->media_sosial ?? '[]', true) ?? [],
                                                );
                                            @endphp

                                            @foreach ($media_sosial_options as $media)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="media_sosial[]"
                                                        value="{{ $media }}" id="{{ strtolower($media) }}"
                                                        {{ in_array($media, $media_terpilih) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ strtolower($media) }}">{{ $media }}</label>
                                                </div>
                                            @endforeach

                                            <!-- Opsi lainnya -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lainnya-checkbox"
                                                    onchange="toggleLainnya()">
                                                <label class="form-check-label" for="lainnya-checkbox">Lainnya</label>
                                            </div>

                                            <!-- Input untuk opsi lainnya -->
                                            <input type="text" name="media_sosial[]" id="lainnya-input"
                                                class="form-control mt-2" placeholder="Masukkan media sosial lain..."
                                                style="display: none;"
                                                value="{{ in_array($interview->media_sosial, $media_sosial_options) ? '' : $interview->media_sosial ?? '' }}">

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
                                                @if (
                                                    $interview->nama_lengkap_keluarga !== null &&
                                                        $interview->jenis_kelamin !== null &&
                                                        $interview->usia !== null &&
                                                        $interview->pendidikan !== null &&
                                                        $interview->kelas !== null &&
                                                        $interview->pekerjaan !== null &&
                                                        $interview->hubungan !== null)
                                                    @php
                                                        $nama =
                                                            json_decode($interview->nama_lengkap_keluarga, true) ?: [];
                                                        $jenisKelamin =
                                                            json_decode($interview->jenis_kelamin, true) ?: [];
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
                                                            count($hubungan),
                                                        );
                                                    @endphp

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
                                                                        Laki-laki</option>
                                                                    <option value="Perempuan"
                                                                        {{ isset($jenisKelamin[$i]) && $jenisKelamin[$i] == 'Perempuan' ? 'selected' : '' }}>
                                                                        Perempuan</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="usia[]" class="form-control"
                                                                    value="{{ $usia[$i] ?? '' }}" required></td>
                                                            <td>
                                                                <select name="pendidikan[]" class="form-control" required>
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
                                                            <td><input type="text" name="kelas[]" class="form-control"
                                                                    value="{{ $kelas[$i] ?? '' }}"></td>
                                                            <td>
                                                                <select name="pekerjaan[]" class="form-control" required>
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
                                                            <select name="jenis_kelamin[]" class="form-control" required>
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
                                    <button type="button" class="btn btn-primary mt-2 mb-3"
                                        id="add-tanggungan">Tambah</button>
                                </div>

                                <br>
                                <hr>
                                <div id="section-situasi-keluarga">
                                    <h4>Data Situasi Keluarga Siswa</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Siswa Tinggal Bersama</label>
                                            <select name="siswa_tinggal_bersama" class="form-control" required>
                                                <option value="">Pilih...</option>
                                                <option value="Ayah Kandung & Ibu Kandung"
                                                    {{ $interview->siswa_tinggal_bersama == 'Ayah Kandung & Ibu Kandung' ? 'selected' : '' }}>
                                                    Ayah Kandung & Ibu Kandung</option>
                                                <option value="Ayah Kandung & Ibu Tiri"
                                                    {{ $interview->siswa_tinggal_bersama == 'Ayah Kandung & Ibu Tiri' ? 'selected' : '' }}>
                                                    Ayah Kandung & Ibu Tiri</option>
                                                <option value="Ayah Kandung saja"
                                                    {{ $interview->siswa_tinggal_bersama == 'Ayah Kandung saja' ? 'selected' : '' }}>
                                                    Ayah Kandung saja</option>
                                                <option value="Ibu Kandung saja"
                                                    {{ $interview->siswa_tinggal_bersama == 'Ibu Kandung saja' ? 'selected' : '' }}>
                                                    Ibu Kandung saja</option>
                                                <option value="Nenek / Kakek dari Ayah"
                                                    {{ $interview->siswa_tinggal_bersama == 'Nenek / Kakek dari Ayah' ? 'selected' : '' }}>
                                                    Nenek / Kakek dari Ayah</option>
                                                <option value="Nenek / Kakek dari Ibu"
                                                    {{ $interview->siswa_tinggal_bersama == 'Nenek / Kakek dari Ibu' ? 'selected' : '' }}>
                                                    Nenek / Kakek dari Ibu</option>
                                                <option value="Keluarga lain"
                                                    {{ $interview->siswa_tinggal_bersama == 'Keluarga lain' ? 'selected' : '' }}>
                                                    Keluarga lain</option>
                                                <option value="Asrama"
                                                    {{ $interview->siswa_tinggal_bersama == 'Asrama' ? 'selected' : '' }}>
                                                    Asrama</option>
                                                <option value="Panti Asuhan"
                                                    {{ $interview->siswa_tinggal_bersama == 'Panti Asuhan' ? 'selected' : '' }}>
                                                    Panti Asuhan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status Pernikahan Orang Tua</label>
                                            <select name="status_pernikahan_ortu" id="status_pernikahan_ortu"
                                                class="form-control" required onchange="toggleLainnyaInput()">
                                                <option value="">Pilih...</option>
                                                <option value="Utuh"
                                                    {{ $interview->status_pernikahan_ortu == 'Utuh' ? 'selected' : '' }}>
                                                    Utuh</option>
                                                <option value="Cerai"
                                                    {{ $interview->status_pernikahan_ortu == 'Cerai' ? 'selected' : '' }}>
                                                    Cerai</option>
                                                <option value="Berpisah"
                                                    {{ $interview->status_pernikahan_ortu == 'Berpisah' ? 'selected' : '' }}>
                                                    Berpisah</option>
                                                <option value="Lain-lain"
                                                    {{ $interview->status_pernikahan_ortu == 'Lain-lain' ? 'selected' : '' }}>
                                                    Lain-lain</option>
                                            </select>
                                            <input type="text" name="status_pernikahan_ortu_lainnya"
                                                id="status_pernikahan_ortu_lainnya" class="form-control mt-2"
                                                placeholder="Masukkan status lainnya..."
                                                value="{{ $interview->status_pernikahan_ortu_lainnya }}"
                                                style="display: {{ $interview->status_pernikahan_ortu == 'Lain-lain' ? 'block' : 'none' }};">
                                        </div>
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

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Status Rumah</label>
                                            @php
                                                $status_rumah_terpilih = old(
                                                    'status_rumah',
                                                    $interview->status_rumah ?? '',
                                                );
                                                $harga_kontrak_terisi = old(
                                                    'harga_kontrak',
                                                    $interview->harga_kontrak ?? '',
                                                );
                                            @endphp
                                            <select name="status_rumah" id="status_rumah" class="form-control" required
                                                onchange="toggleHargaKontrak()">
                                                <option value="">Pilih...</option>
                                                <option value="Milik Sendiri"
                                                    {{ $status_rumah_terpilih == 'Milik Sendiri' ? 'selected' : '' }}>
                                                    Milik
                                                    Sendiri</option>
                                                <option value="Kontrak"
                                                    {{ $status_rumah_terpilih == 'Kontrak' ? 'selected' : '' }}>Kontrak
                                                </option>
                                                <option value="Menumpang"
                                                    {{ $status_rumah_terpilih == 'Menumpang' ? 'selected' : '' }}>
                                                    Menumpang
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6" id="harga_kontrak_group"
                                            style="{{ $status_rumah_terpilih == 'Kontrak' ? 'display: block;' : 'display: none;' }}">
                                            <label class="form-label">Harga Kontrak (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="harga_kontrak" id="harga_kontrak"
                                                    class="form-control" oninput="formatRupiah(this)"
                                                    value="{{ $harga_kontrak_terisi }}">
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function toggleHargaKontrak() {
                                            var statusRumah = document.getElementById("status_rumah").value;
                                            var hargaKontrakGroup = document.getElementById("harga_kontrak_group");
                                            if (statusRumah === "Kontrak") {
                                                hargaKontrakGroup.style.display = "block";
                                            } else {
                                                hargaKontrakGroup.style.display = "none";
                                                document.getElementById("harga_kontrak").value = ""; // Kosongkan jika bukan Kontrak
                                            }
                                        }
                                    </script>


                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Daya Listrik (Watt)</label>
                                            <input type="number" name="daya_listrik" class="form-control" required
                                                value="{{ old('daya_listrik', $interview->daya_listrik) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Biaya Listrik per Bulan (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="biaya_listrik" id="biaya_listrik"
                                                    class="form-control" oninput="formatRupiah(this)" required
                                                    value="{{ old('biaya_listrik', $interview->biaya_listrik) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Transportasi yang Dimiliki</label>
                                        @php
                                            $transportasi_options = ['Sepeda', 'Motor', 'Mobil'];
                                            $transportasi_terpilih = old(
                                                'transportasi_yg_dimiliki',
                                                json_decode($interview->transportasi_yg_dimiliki ?? '[]', true) ?? [],
                                            );
                                        @endphp

                                        @foreach ($transportasi_options as $transport)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="transportasi_yg_dimiliki[]" value="{{ $transport }}"
                                                        id="{{ strtolower($transport) }}"
                                                        {{ in_array($transport, $transportasi_terpilih) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ strtolower($transport) }}">{{ $transport }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="row mb-3">
                                        <label class="form-label">Harta Milik Keluarga</label>
                                        @php
                                            $harta_options = [
                                                'Televisi',
                                                'Radio/tape',
                                                'PlayStation',
                                                'Kulkas',
                                                'Magic Jar',
                                                'HP',
                                                'DVD',
                                                'AC/Kipas Angin',
                                                'PC/Laptop',
                                            ];
                                            $harta_terpilih = old(
                                                'harta_milik_keluarga',
                                                json_decode($interview->harta_milik_keluarga ?? '[]', true) ?? [],
                                            );
                                        @endphp

                                        <div class="col-md-4">
                                            @foreach (array_slice($harta_options, 0, 3) as $harta)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="harta_milik_keluarga[]" value="{{ $harta }}"
                                                        id="{{ strtolower(str_replace(' ', '_', $harta)) }}"
                                                        {{ in_array($harta, $harta_terpilih) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ strtolower(str_replace(' ', '_', $harta)) }}">{{ $harta }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-4">
                                            @foreach (array_slice($harta_options, 3, 3) as $harta)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="harta_milik_keluarga[]" value="{{ $harta }}"
                                                        id="{{ strtolower(str_replace(' ', '_', $harta)) }}"
                                                        {{ in_array($harta, $harta_terpilih) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ strtolower(str_replace(' ', '_', $harta)) }}">{{ $harta }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-4">
                                            @foreach (array_slice($harta_options, 6) as $harta)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="harta_milik_keluarga[]" value="{{ $harta }}"
                                                        id="{{ strtolower(str_replace(' ', '_', $harta)) }}"
                                                        {{ in_array($harta, $harta_terpilih) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ strtolower(str_replace(' ', '_', $harta)) }}">{{ $harta }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Opsi lainnya -->
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lainnya-checkbox"
                                                    onchange="toggleLainnya()">
                                                <label class="form-check-label" for="lainnya-checkbox">Lainnya</label>
                                            </div>

                                            <!-- Input untuk opsi lainnya -->
                                            <input type="text" name="harta_milik_keluarga[]" id="lainnya-input"
                                                class="form-control mt-2" placeholder="Masukkan harta lainnya..."
                                                style="display: none;"
                                                value="{{ in_array($interview->harta_milik_keluarga, $harta_options) ? '' : $interview->harta_milik_keluarga ?? '' }}">
                                        </div>
                                    </div>

                                    <script>
                                        function toggleLainnya() {
                                            var inputLainnya = document.getElementById('lainnya-input');
                                            inputLainnya.style.display = inputLainnya.style.display === 'none' ? 'block' : 'none';
                                        }
                                    </script>


                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Kalung (gr)</label>
                                            <input type="number" name="berat_kalung_gr" class="form-control"
                                                value="{{ old('berat_kalung_gr', $interview->berat_kalung_gr) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Cincin (gr)</label>
                                            <input type="number" name="berat_cincin_gr" class="form-control"
                                                value="{{ old('berat_cincin_gr', $interview->berat_cincin_gr) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Gelang (gr)</label>
                                            <input type="number" name="berat_gelang_gr" class="form-control"
                                                value="{{ old('berat_gelang_gr', $interview->berat_gelang_gr) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Berat Anting (gr)</label>
                                            <input type="number" name="berat_anting_gr" class="form-control"
                                                value="{{ old('berat_anting_gr', $interview->berat_anting_gr) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Tanggungan Kredit</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" name="tanggungan_kredit" id="tanggungan_kredit"
                                                    class="form-control" oninput="formatRupiah(this)" required
                                                    value="{{ old('tanggungan_kredit', $interview->tanggungan_kredit) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Menurut anda, apakah orang tua anda cukup
                                                memperhatikan kebutuhan anda? Misalnya kebutuhan sekolah, pakaian, atau
                                                lainnya?</label>
                                            <textarea name="pendapat" class="form-control" rows="4" required>{{ old('pendapat', $interview->pendapat) }}</textarea>
                                        </div>
                                    </div>

                                </div>

                                <br>
                                <hr>
                                <div id="section-kontak-darurat">
                                    <h4>Kontak Darurat</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" required
                                                value="{{ old('nama', $interview->nama ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hubungan dengan Siswa</label>
                                            <input type="text" name="hubungan_dgn_siswa" class="form-control" required
                                                value="{{ old('hubungan_dgn_siswa', $interview->hubungan_dgn_siswa ?? '') }}">
                                        </div>
                                        <div class="col-md-12 mb-3 mt-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea name="alamat_kontak_darurat" class="form-control" rows="3" required>{{ old('alamat_kontak_darurat', $interview->alamat_kontak_darurat ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="form-control" required
                                                value="{{ old('no_telepon', $interview->no_telepon ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No. HP</label>
                                            <input type="text" name="no_hp" class="form-control" required
                                                value="{{ old('no_hp', $interview->no_hp ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <div id="section-kesimpulan">
                                    <h4>Kesimpulan dan Saran</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Kesimpulan</label>
                                            <textarea name="kesimpulan" class="form-control" rows="4" required>{{ old('kesimpulan', $interview->kesimpulan ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <br>
                                <hr>
                                <div id="section-detail-tambahan">
                                    <h4>Detail Tambahan</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Denah Lokasi</label>
                                            <input type="file" name="denah_lokasi" class="form-control"
                                                accept="image/*">
                                            @if (isset($interview->denah_lokasi))
                                                <p class="mt-2">File saat ini: <a
                                                        href="{{ asset('storage/' . $interview->denah_lokasi) }}"
                                                        target="_blank">Lihat Denah</a></p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control" required
                                                value="{{ old('nama_lengkap', $interview->nama_lengkap ?? '') }}">
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-label">Nama Panggilan di Lingkungan</label>
                                            <input type="text" name="nama_panggilan_di_lingkungan"
                                                class="form-control" required
                                                value="{{ old('nama_panggilan_di_lingkungan', $interview->nama_panggilan_di_lingkungan ?? '') }}">
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-label">Tanggal Pengisian</label>
                                            <input type="date" name="tanggal_pengisian" class="form-control"
                                                id="tanggal_pengisian" required
                                                value="{{ old('tanggal_pengisian', $interview->tanggal_pengisian ?? date('Y-m-d')) }}">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Ciri-ciri Rumah</label>
                                            <div id="ciri-ciri-container">
                                                @if (isset($interview->ciri_ciri_rumah) && count(json_decode($interview->ciri_ciri_rumah, true)) > 0)
                                                    @foreach (json_decode($interview->ciri_ciri_rumah, true) as $ciri)
                                                        <div class="input-group mb-2 ciri-item">
                                                            <input type="text" name="ciri_ciri_rumah[]"
                                                                class="form-control" value="{{ $ciri }}"
                                                                required>
                                                            <button type="button"
                                                                class="btn btn-danger hapus-ciri">Hapus</button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2 ciri-item">
                                                        <input type="text" name="ciri_ciri_rumah[]"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-danger hapus-ciri">Hapus</button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" id="tambah-ciri"
                                                class="btn btn-primary mt-2 mb-3">Tambah Ciri-ciri</button>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status_interview" class="form-label">Status Interview</label>
                                            <select name="status_interview" id="status_interview" class="form-control"
                                                required>
                                                <option value="">Pilih</option>
                                                <option value="sudah"
                                                    {{ old('status_interview', $interview->status_interview) == 'sudah' ? 'selected' : '' }}>
                                                    Sudah</option>
                                                <option value="belum"
                                                    {{ old('status_interview', $interview->status_interview) == 'belum' ? 'selected' : '' }}>
                                                    Belum</option>
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
                                                        <button type="button" class="btn btn-danger hapus-ciri">Hapus</button>
                                                    `;
                                                    container.appendChild(newRow);

                                                    // Tambahkan event listener untuk tombol hapus yang baru ditambahkan
                                                    newRow.querySelector('.hapus-ciri').addEventListener('click', hapusCiri);
                                                });

                                                // Fungsi untuk menghapus field ciri-ciri
                                                function hapusCiri() {
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

                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                <a href="{{ route('form_interview.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
