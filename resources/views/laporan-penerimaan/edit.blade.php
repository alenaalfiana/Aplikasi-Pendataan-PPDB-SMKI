@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="text-center font-weight-light my-2">
                        <i class="fas fa-edit mr-2"></i>Edit Laporan Penerimaan Siswa
                    </h3>
                </div>
                <div class="card-body">

                    <form action="{{ route('laporan-penerimaan.update', $laporanPenerimaan->id_penerimaan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-graduate mr-2"></i>Nama Siswa
                                    </label>
                                    <input type="text" class="form-control" value="{{ $laporanPenerimaan->formPendaftaran->registrasiPengambilan->nama }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt mr-2"></i>Periode
                                    </label>
                                    <input type="text" class="form-control" value="{{ $laporanPenerimaan->formPendaftaran->registrasiPengambilan->periode->tahun_periode }}" readonly>
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
                                        <option value="diterima" {{ $laporanPenerimaan->hasil_akhir == 'diterima' ? 'selected' : '' }}>
                                            Diterima
                                        </option>
                                        <option value="tidak_diterima" {{ $laporanPenerimaan->hasil_akhir == 'tidak_diterima' ? 'selected' : '' }}>
                                            Tidak Diterima
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-save mr-2"></i>Perbarui Laporan
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