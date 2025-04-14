@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div id="app">
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                {{-- Judul --}}
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Laporan Penerimaan - Siswa Baru</b>
                    </h2>
                </div>

                {{-- Card utama --}}
                <div class="card mb-4">
                    <div class="container">

                        {{-- Tombol Tambah dan Cetak --}}
                        <div class="d-flex justify-content-between mb-3 mt-3">
                            <a href="{{ route('laporan-penerimaan.create') }}">
                                <button type="button" class="btn rounded-pill btn-primary">
                                    <i class="menu-icon tf-icons bx bxs-plus-circle"></i> Tambah
                                </button>
                            </a>
                            <a href="{{ route('laporan-penerimaan.download', ['id_periode' => request('id_periode')]) }}" target="_blank" class="btn btn-danger mb-3">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        </div>

                        {{-- Notifikasi sukses --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('laporan-penerimaan.index') }}" method="GET" class="mb-3">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <select name="id_periode" class="form-control" onchange="this.form.submit()">
                                        <option value="">-- Pilih Periode --</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id_periode }}"
                                                {{ request('id_periode') == $periode->id_periode ? 'selected' : '' }}>
                                                {{ $periode->tahun_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        value="{{ request('search') }}"
                                        placeholder="Cari berdasarkan nama siswa atau nisn ....">
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="{{ route('laporan-penerimaan.index') }}" class="btn btn-secondary ms-2">X</a>
                                </div>
                            </div>
                        </form>

                        {{-- Tabel Laporan --}}
                        @if ($laporanPenerimaan->count())
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-content-center table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Hasil Akhir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporanPenerimaan as $index => $laporan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $laporan->formPendaftaran->registrasiPengambilan->nama ?? '-' }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $laporan->hasil_akhir == 'diterima' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($laporan->hasil_akhir) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Lihat Detail --}}
                                                    <a href="{{ route('laporan-penerimaan.show', $laporan->id_penerimaan) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="menu-icon tf-icons bx bxs-detail"></i>
                                                    </a>

                                                    {{-- Edit --}}
                                                    <a href="{{ route('laporan-penerimaan.edit', $laporan->id_penerimaan) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="menu-icon tf-icons bx bx-edit"></i>
                                                    </a>

                                                    {{-- Hapus --}}
                                                    <form
                                                        action="{{ route('laporan-penerimaan.destroy', $laporan->id_penerimaan) }}"
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('Yakin ingin menghapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="menu-icon tf-icons bx bx-trash"></i>
                                                        </button>
                                                    </form>

                                                    {{-- Unduh PPT (jika ada) --}}
                                                    @if ($laporan->file_powerpoint)
                                                        <a href="{{ route('laporan-penerimaan.download-ppt', $laporan->id_penerimaan) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-file-powerpoint"></i> Unduh PPT
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center my-4 pagination-wrapper">
                                {{ $laporanPenerimaan->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data periode ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

<style>
    .pagination-wrapper .pagination {
        display: flex;
        justify-content: center;
        padding: 1rem 0;
    }

    .pagination-wrapper .pagination li {
        margin: 0 0.25rem;
    }

    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        color: #007bff;
        padding: 0.5rem 0.75rem;
        text-decoration: none;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }

    .pagination-wrapper .pagination li a:hover,
    .pagination-wrapper .pagination li span:hover {
        background-color: #e9ecef;
    }

    .pagination-wrapper .pagination li.active span {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination-wrapper .pagination li.disabled span {
        color: #6c757d;
    }
</style>
