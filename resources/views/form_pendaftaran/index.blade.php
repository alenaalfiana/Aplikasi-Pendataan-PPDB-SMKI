@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div id="app">
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Data Pengembalian Formulir dan Dokumen</b>
                    </h2>
                </div>
                <div class="card mb-1">
                    <div class="container">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('form_pendaftaran.create') }}">
                                <button type="button" class="btn rounded-pill btn-primary mt-3 align-content-center">
                                    <i class="menu-icon tf-icons bx bxs-plus-circle"></i>Tambah
                                </button>
                            </a>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="GET" action="{{ route('form_pendaftaran.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="id_periode" class="form-control" onchange="this.form.submit()">
                                        <option value="">-- Pilih Periode --</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id_periode }}"
                                                {{ request('periode_id') == $periode->id_periode ? 'selected' : '' }}>
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
                                    <a href="{{ route('form_pendaftaran.index') }}" class="btn btn-secondary ms-2">X</a>
                                </div>
                            </div>
                        </form>


                        @if ($pendaftarans->count() > 0)
                            <div class="table-responsive text-nowrap">
                                <br>
                                <table class="table table-hover align-content-center table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Asal Sekolah</th>
                                            <th>Status Dokumem</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-1 align-content-center">
                                        @foreach ($pendaftarans as $pendaftaran)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-truncate" style="max-width: auto;">
                                                    <a
                                                        href="{{ route('form_pendaftaran.show', $pendaftaran->id_form_pendaftaran) }}">
                                                        {{ $pendaftaran->registrasiPengambilan->nama }}
                                                    </a>

                                                </td>
                                                <td class="text-truncate" style="max-width: auto;">
                                                    {{ $pendaftaran->asal_sekolah }}
                                                </td>
                                                <td class="text-truncate" style="max-width: auto;">
                                                    @if ($pendaftaran->status == 'lengkap')
                                                        <span class="badge bg-success">Lengkap</span>
                                                    @elseif ($pendaftaran->status == 'tidak_lengkap')
                                                        <span class="badge bg-warning">Tidak Lengkap</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($pendaftaran->status) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center my-4 pagination-wrapper">
                                    {{ $pendaftarans->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Tidak ada data pendaftaran ditemukan.
                                </div>
                        @endif
                    </div>
                </div>
            </main>
            <div>
                <h5><b>Rekapitulasi Jumlah Siswa</b></h5>
                <p>Total Siswa Laki-laki: <b>{{ $totalLakiLaki }}</b></p>
                <p>Total Siswa Perempuan: <b>{{ $totalPerempuan }}</b></p>
                <p>Total Keseluruhan Pengembalian: <b>{{ $totalLakiLaki + $totalPerempuan }}</b></p>
            </div>
        </div>
    </div>
@endsection

<style>
    .table th,
    .table td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

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
