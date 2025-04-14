@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div id="app">
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Data Pendataan Nilai BHQ & TPA - Calon Siswa</b>
                    </h2>
                </div>
                <div class="card mb-4">
                    <div class="container">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('pendataan_tpa_bhq.create') }}">
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

                        <form action="{{ route('pendataan_tpa_bhq.index') }}" method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="id_periode" class="form-control mb-3" onchange="this.form.submit()">
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
                                    <input type="text" name="search" class="form-control mb-3"
                                        value="{{ request('search') }}"
                                        placeholder="Cari berdasarkan nama siswa atau nisn ....">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary mb-3">Cari</button>
                                    <a href="{{ route('pendataan_tpa_bhq.index') }}" class="btn btn-secondary ms-2 mb-3">X</a>
                                </div>
                            </div>
                        </form>

                        @if ($nilais->count() > 0)
                            <div class="table-responsive text-nowrap">
                                <br>
                                <table class="table table-hover align-content-center table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th>Nama</th>
                                            <th>Rata-Rata TPA</th>
                                            <th>Rata-Rata BHQ</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-1 align-content-center">
                                        @forelse ($nilais as $index => $nilai)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="#" class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal"
                                                        data-id="{{ $nilai->id_pendataan_tpa_bhq }}"
                                                        data-nama="{{ $nilai->formPendaftaran->registrasiPengambilan->nama }}"
                                                        data-tpa="{{ $nilai->rata2_tpa }}"
                                                        data-rata2-max-tpa="{{ $nilai->max_tpa }}"
                                                        data-rata2-min-tpa="{{ $nilai->min_tpa }}"
                                                        data-bhq="{{ $nilai->rata2_tes_alquran }}"
                                                        data-rata2-max-bhq="{{ $nilai->max_alquran }}"
                                                        data-rata2-min-bhq="{{ $nilai->min_alquran }}">
                                                        {{ $nilai->formPendaftaran->registrasiPengambilan->nama }}
                                                    </a>
                                                </td>
                                                <td>{{ $nilai->rata2_tpa }}</td>
                                                <td>{{ $nilai->rata2_tes_alquran }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center my-4 pagination-wrapper">
                                {{ $nilais->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data nilai ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Nilai Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Nama</th><td><strong id="data-nama"></strong></td></tr>
                    <tr><th>Rata-Rata TPA</th><td id="data-tpa"></td></tr>
                    <tr><th>Nilai Maksimum TPA</th><td id="rata2-max-tpa"></td></tr>
                    <tr><th>Nilai Minimum TPA</th><td id="rata2-min-tpa"></td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><th>Rata-Rata BHQ</th><td id="data-bhq"></td></tr>
                    <tr><th>Nilai Maksimum BHQ</th><td id="rata2-max-bhq"></td></tr>
                    <tr><th>Nilai Minimum BHQ</th><td id="rata2-min-bhq"></td></tr>
                </table>
                <div class="text-end">
                    <a id="edit-btn" class="btn btn-warning btn-sm"><i class="bx bx-edit"></i> Edit</a>
                    <form id="delete-form" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var detailModal = document.getElementById("detailModal");
        detailModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            document.getElementById("data-nama").textContent = button.getAttribute("data-nama");
            document.getElementById("data-tpa").textContent = button.getAttribute("data-tpa");
            document.getElementById("rata2-max-tpa").textContent = button.getAttribute("data-rata2-max-tpa");
            document.getElementById("rata2-min-tpa").textContent = button.getAttribute("data-rata2-min-tpa");
            document.getElementById("data-bhq").textContent = button.getAttribute("data-bhq");
            document.getElementById("rata2-max-bhq").textContent = button.getAttribute("data-rata2-max-bhq");
            document.getElementById("rata2-min-bhq").textContent = button.getAttribute("data-rata2-min-bhq");

            var id = button.getAttribute("data-id");
            document.getElementById("edit-btn").setAttribute("href", `/pendataan_tpa_bhq/${id}/edit`);
            document.getElementById("delete-form").setAttribute("action", `/pendataan_tpa_bhq/${id}`);
        });
    });
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
