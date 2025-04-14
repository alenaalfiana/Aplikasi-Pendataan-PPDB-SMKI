@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
<div class="container">
    <h1>Edit Laporan Penerimaan</h1>

    <form action="{{ route('laporan-penerimaan.update', $laporanPenerimaan->id_penerimaan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" class="form-control" value="{{ $laporanPenerimaan->formPendaftaran->registrasiPengambilan->nama }}" readonly>
        </div>

        <div class="form-group">
            <label>Periode</label>
            <input type="text" class="form-control" value="{{ $laporanPenerimaan->formPendaftaran->registrasiPengambilan->periode->tahun_periode }}" readonly>
        </div>

        <div class="form-group">
            <label for="hasil_akhir">Hasil Akhir</label>
            <select name="hasil_akhir" id="hasil_akhir" class="form-control" required>
                <option value="diterima" {{ $laporanPenerimaan->hasil_akhir == 'diterima' ? 'selected' : '' }}>
                    Diterima
                </option>
                <option value="tidak_diterima" {{ $laporanPenerimaan->hasil_akhir == 'tidak_diterima' ? 'selected' : '' }}>
                    Tidak Diterima
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
