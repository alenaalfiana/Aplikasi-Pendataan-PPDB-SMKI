@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div class="container">
        <h1>Detail Laporan Penerimaan</h1>

        <div class="card mb-3">
            <div class="card-header">
                <h3>Informasi Pendaftaran</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nama Lengkap:</strong> {{ $reportData['pendaftaran']->nama_lengkap }}<br>
                        <strong>NISN:</strong> {{ $reportData['pendaftaran']->nisn }}<br>
                        <strong>Jenis Kelamin:</strong> {{ $reportData['pendaftaran']->jenis_kelamin }}<br>
                        <strong>Tempat, Tanggal Lahir:</strong>
                        {{ $reportData['pendaftaran']->tempat_lahir }},
                        {{ $reportData['pendaftaran']->tanggal_lahir }}
                    </div>
                    <div class="col-md-6">
                        <strong>Periode:</strong> {{ $reportData['pendaftaran']->registrasiPengambilan->periode->tahun_periode }} <br>
                        <strong>Hasil Akhir:</strong>
                        <span class="badge {{ $laporanPenerimaan->hasil_akhir == 'diterima' ? 'bg-success' : 'bg-danger' }}">
                            {{ $laporanPenerimaan->hasil_akhir == 'diterima' ? 'Diterima' : 'Tidak Diterima' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3>Informasi Wawancara</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nama Panggilan:</strong> {{ $reportData['interview']->nama_panggilan ?? 'Tidak ada' }}<br>
                        <strong>Cita-cita:</strong> {{ $reportData['interview']->cita_cita ?? 'Tidak ada' }}<br>
                        <strong>Motto:</strong> {{ $reportData['interview']->motto ?? 'Tidak ada' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Organisasi Sekolah:</strong>
                        {{ $reportData['interview']->organisasi_sekolah ?? 'Tidak ada' }}<br>
                        <strong>Hobi:</strong> {{ $reportData['interview']->hobi ?? 'Tidak ada' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Informasi Survey</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Status Rumah:</strong> {{ $reportData['survey']->status_rumah ?? 'Tidak ada' }}<br>
                        <strong>Biaya Hidup per Bulan:</strong>
                        {{ $reportData['survey']->biaya_hidup_perbulan ?? 'Tidak ada' }}<br>
                        <strong>Alasan Pendukung:</strong>
                        @if (!empty($reportData['survey']->alasan_pendukung))
                            <ul class="list-disc pl-5">
                                @foreach ($reportData['survey']->alasan_pendukung as $alasan)
                                    <li>{{ $alasan }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Tidak ada</p>
                        @endif

                        <strong>Alasan Memberatkan:</strong>
                        @if (!empty($reportData['survey']->alasan_memberatkan))
                            <ul class="list-disc pl-5">
                                @foreach ($reportData['survey']->alasan_memberatkan as $alasan)
                                    <li>{{ $alasan }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Tidak ada</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Saran Rekomendasi:</strong> {{ $reportData['survey']->saran_rekomendasi ?? 'Tidak ada' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('laporan-penerimaan.index') }}" class="btn btn-secondary">Kembali</a>
            @if ($laporanPenerimaan->file_powerpoint)
                <a href="{{ route('laporan-penerimaan.download-ppt', $laporanPenerimaan->id_penerimaan) }}"
                    class="btn btn-primary">
                    Unduh PowerPoint
                </a>
            @endif
        </div>
    </div>
@endsection
