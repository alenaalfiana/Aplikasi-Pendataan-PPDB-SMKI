@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))
@section('content')
    <!DOCTYPE html>
    <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tambah Data Nilai TPA & BHQ - Calon Siswa</title>
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

                                <form action="{{ route('pendataan_tpa_bhq.store') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="mb-3">
                                        <label for="id_form_pendaftaran" class="form-label">Nomor Pendaftar - Nama Calon Siswa</label>
                                        <select class="form-control select2" id="id_form_pendaftaran" name="id_form_pendaftaran">
                                            <option value="">Pilih Nama Siswa</option>
                                            @foreach ($formPendaftarans as $siswa)
                                                <option value="{{ $siswa->id_form_pendaftaran }}"
                                                    {{ old('id_form_pendaftaran') == $siswa->id_form_pendaftaran ? 'selected' : '' }}>
                                                    {{ $siswa->registrasiPengambilan->nama ?? 'Nama Tidak Ditemukan' }} {{ $siswa->registrasiPengambilan->no_pendaftar ?? 'Nama Tidak Ditemukan' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('#id_form_pendaftaran').select2({
                                                placeholder: "Pilih Nama Siswa",
                                                allowClear: true,
                                                width: '100%'
                                            });
                                        });
                                    </script>


                                    <h4> Penilaian - TPA </h4>

                                    <div class="mb-3">
                                        <label for="rata2_tpa" class="form-label">Rata - Rata TPA</label>
                                        <input type="text" class="form-control" id="rata2_tpa" name="rata2_tpa"
                                            value="{{ old('rata2_tpa') }}" maxlength="5"
                                            inputmode="numeric">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="max_tpa" class="form-label">Nilai Maksimal TPA</label>
                                            <input type="text" class="form-control" id="max_tpa" maxlength="5"
                                                name="max_tpa" value="{{ old('max_tpa') }}"
                                                inputmode="numeric">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="min_tpa" class="form-label">Nilai Minimum TPA</label>
                                            <input type="text" class="form-control" id="min_tpa" maxlength="5"
                                                name="min_tpa" value="{{ old('min_tpa') }}"
                                                inputmode="numeric">
                                        </div>
                                    </div>

                                    <h4> Penilaian - BHQ </h4>

                                    <div class="mb-3">
                                        <label for="rata2_tes_alquran" class="form-label">Rata - Rata TPA</label>
                                        <input type="text" class="form-control" id="rata2_tes_alquran" name="rata2_tes_alquran"
                                            value="{{ old('rata2_tes_alquran') }}" maxlength="5"
                                            inputmode="numeric">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="max_alquran" class="form-label">Nilai Maksimal BHQ</label>
                                            <input type="text" class="form-control" id="max_alquran" maxlength="5"
                                                name="max_alquran" value="{{ old('max_alquran') }}"
                                                inputmode="numeric">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="min_alquran" class="form-label">Nilai Minimum BHQ</label>
                                            <input type="text" class="form-control" id="min_alquran" maxlength="5"
                                                name="min_alquran" value="{{ old('min_alquran') }}"
                                                inputmode="numeric">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('pendataan_tpa_bhq.index') }}" class="btn btn-secondary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>

    </html>
@endsection
