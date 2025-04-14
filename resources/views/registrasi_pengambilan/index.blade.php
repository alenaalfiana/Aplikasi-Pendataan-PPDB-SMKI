@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div id="app">
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Data Pengambilan Formulir Pendaftaran</b>
                    </h2>
                </div>
                <div class="card mb-1">
                    <div class="container">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('registrasi_pengambilan.create') }}">
                                <button type="button" class="btn rounded-pill btn-primary mt-3 align-content-center">
                                    <i class="menu-icon tf-icons bx bxs-plus-circle"></i>Tambah
                                </button>
                            </a>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {!! session('success') !!}
                            </div>
                        @endif

                        <form method="GET" action="{{ route('registrasi_pengambilan.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="periode_id" class="form-control" onchange="this.form.submit()">
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
                                        placeholder="Cari berdasarkan nama siswa atau orang tua ....">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="{{ route('registrasi_pengambilan.index') }}"
                                        class="btn btn-secondary ms-2">X</a>
                                </div>
                            </div>
                        </form>


                        @if ($pengambilans->count() > 0)
                            <div class="table-responsive text-nowrap">
                                <br>
                                <table class="table table-hover align-content-center table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 5%;">No.</th>
                                            <th style="width: 15%;">No. Pendaftaran</th>
                                            <th style="width: 20%;">Nama Siswa</th>
                                            <th style="width: 10%;">Jenis Kelamin</th>
                                            <th style="width: 20%;">Asal Sekolah</th>
                                            <th style="width: 15%;">Tanggal Mendaftar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-1 align-content-center">
                                        @foreach ($pengambilans as $pengambilan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-truncate">
                                                    {{ $pengambilan->no_pendaftar }}
                                                </td>
                                                <td class="text-truncate">
                                                    <a href="#"
                                                        onclick="showDetail({{ $pengambilan->id_registrasi_pengambilan }})">
                                                        {{ $pengambilan->nama }}
                                                    </a>
                                                </td>
                                                <td class="text-truncate">
                                                    {{ strtoupper($pengambilan->jenis_kelamin) == 'PEREMPUAN' ? 'PEREMPUAN' : 'LAKI-LAKI' }}
                                                </td>
                                                <td class="text-truncate">
                                                    {{ $pengambilan->asal_sekolah }}
                                                </td>
                                                <td class="text-truncate">
                                                    {{ $pengambilan->tanggal_pengambilan }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center my-4 pagination-wrapper">
                                    {{ $pengambilans->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Tidak ada data pengambilan ditemukan.
                                </div>
                        @endif
                    </div>
                </div>
            </main>
            <div>
                <h5><b>Rekapitulasi Jumlah Siswa</b></h5>
                <p>Total Siswa Laki-laki: <b>{{ $totalLakiLaki }}</b></p>
                <p>Total Siswa Perempuan: <b>{{ $totalPerempuan }}</b></p>
                <p>Total Keseluruhan: <b>{{ $totalLakiLaki + $totalPerempuan }}</b></p>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title mb-3" id="detailModalLabel" style="color: #dee2e6">Detail Registrasi - No.
                    Pendaftar ( <span id="detail_no_pendaftar" class="text-uppercase"></span> )</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="fw-bold">Nama Pengambil :</label>
                            <p id="detail_nama_pengambil" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Nama Ayah :</label>
                            <p id="detail_nama_ayah" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Nama Ibu :</label>
                            <p id="detail_nama_ibu" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Nama Wali :</label>
                            <p id="detail_nama_wali" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Alamat Lengkap :</label>
                            <p id="detail_alamat_lengkap" class="text-uppercase"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="fw-bold">Nama Calon Siswa :</label>
                            <p id="detail_nama_siswa" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Jenis Kelamin :</label>
                            <p id="detail_jenis_kelamin" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Asal Sekolah :</label>
                            <p id="detail_asal_sekolah" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Keterangan :</label>
                            <p id="detail_keterangan" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">No. Telepon :</label>
                            <p id="detail_no_telepon" class="text-uppercase"></p>
                        </div>
                        <div class="detail-item">
                            <label class="fw-bold">Tanggal Pengambilan :</label>
                            <p id="detail_tanggal_pengambilan" class="text-uppercase"></p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h6 class="mb-3 fw-bold">Bukti Pengisian:</h6>
                    <img id="detail_foto" src="/placeholder.svg" alt="Bukti Pengisian"
                        class="img-fluid rounded shadow-sm">
                </div>
            </div>

            <div class="modal-footer">
                <a id="downloadButton" href="#" class="btn btn-success btn-sm" style="width: 8%"><i
                        class="menu-icon tf-icons bx bxs-printer"></i></a>
                <a id="editButton" href="#" class="btn btn-warning btn-sm" style="width: 8%"><i
                        class="menu-icon tf-icons bx bx-edit"></i></a>
                <form id="deleteForm" action="#" method="POST" style="display:inline;" style="width: 8%"
                    onsubmit="return confirm('Yakin ingin menghapus?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i
                            class="menu-icon tf-icons bx bx-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetail(id) {
        $.ajax({
            url: '/registrasi_pengambilan/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#detail_no_pendaftar').text(response?.no_pendaftar || '-');
                $('#detail_nama_pengambil').text(response?.nama_pengambil || '-');
                $('#detail_nama_ayah').text(response?.nama_ayah || '-');
                $('#detail_nama_ibu').text(response?.nama_ibu || '-');
                $('#detail_nama_wali').text(response?.nama_wali || '-');

                let alamatLengkap = `${response?.alamat_lengkap || '-'}, ` +
                    `${response?.village?.name || '-'}, ` +
                    `${response?.district?.name || '-'}, ` +
                    `${response?.regency?.name || '-'}, ` +
                    `${response?.province?.name || '-'}`;
                $('#detail_alamat_lengkap').text(alamatLengkap);

                $('#detail_no_telepon').text(response?.no_telepon || '-');
                $('#detail_nama_siswa').text(response?.nama || '-');
                $('#detail_jenis_kelamin').text(response?.jenis_kelamin || '-');
                $('#detail_asal_sekolah').text(response?.asal_sekolah || '-');
                $('#detail_keterangan').text(response?.keterangan || '-');
                $('#detail_tanggal_pengambilan').text(response?.tanggal_pengambilan || '-');

                let fotoBukti = response?.foto_bukti_pengisian ? response.foto_bukti_pengisian :
                    '/path/to/default-image.jpg';
                $('#detail_foto').attr('src', fotoBukti);

                // Set up action buttons with correct URLs and ID
                // Download button
                $('#downloadButton').attr('href', '/registrasi_pengambilan/download/' + id);

                // Edit button
                $('#editButton').attr('href', '/registrasi_pengambilan/' + id + '/edit');

                // Delete form
                $('#deleteForm').attr('action', '/registrasi_pengambilan/' + id);

                // Show the modal
                $('#detailModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data. Silakan coba lagi.');
                console.error('Error:', status, error);
            }
        });
    }
</script>

<style>
    .modal-dialog {
        max-width: 90%;
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .table th {
        width: 40%;
        font-weight: 600;
    }

    .table td {
        word-break: break-word;
    }

    #detail_foto {
        max-height: 300px;
        object-fit: contain;
    }

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
