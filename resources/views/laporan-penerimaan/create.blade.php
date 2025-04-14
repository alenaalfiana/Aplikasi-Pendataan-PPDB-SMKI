@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="text-center font-weight-light my-2">
                        <i class="fas fa-file-alt mr-2"></i>Tambah Laporan Penerimaan Siswa
                    </h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Kesalahan Validasi!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('laporan-penerimaan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="id_form_pendaftaran" class="form-label">
                                        <i class="fas fa-user-graduate mr-2"></i>Pilih Siswa
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="id_form_pendaftaran" id="id_form_pendaftaran"
                                    class="form-control" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($formPendaftarans as $pendaftaran)
                                    <option value="{{ $pendaftaran->id_form_pendaftaran }}">
                                        {{ optional($pendaftaran->registrasiPengambilan)->nama ?? 'Tanpa Nama' }} - {{ $pendaftaran->nisn }}
                                    </option>
                                @endforeach
                            </select>

                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="hasil_akhir" class="form-label">
                                        <i class="fas fa-check-circle mr-2"></i>Hasil Akhir
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="hasil_akhir" id="hasil_akhir" class="form-control" required>
                                        <option value="">-- Pilih Hasil --</option>
                                        <option value="diterima" class="text-success">Diterima</option>
                                        <option value="tidak_diterima" class="text-danger">Tidak Diterima</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-save mr-2"></i>Simpan Laporan
                            </button>
                            <a href="{{ route('laporan-penerimaan.index') }}" class="btn btn-secondary btn-lg ml-2 shadow-sm">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .form-label {
        font-weight: 600;
        color: #495057;
    }
</style>
