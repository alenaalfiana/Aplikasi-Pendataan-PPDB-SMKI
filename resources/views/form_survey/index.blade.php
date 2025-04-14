@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div id="app">
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Data Formulir Survey / Peninjauan</b>
                    </h2>
                </div>
                <div class="card mb-4">
                    <div class="container mt-3">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('form_survey.index') }}" method="GET" class="mb-3">
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
                                    <a href="{{ route('form_survey.index') }}" class="btn btn-secondary ms-2">X</a>
                                </div>
                            </div>
                        </form>

                        @if ($surveys->count() > 0)
                            <div class="table-responsive text-nowrap">
                                <br>
                                <table class="table table-hover align-content-center table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="max-width: 10%;">No</th>
                                            <th style="max-width: auto;">Nama Calon Siswa</th>
                                            <th style="max-width: auto;">Surveyor</th>
                                            <th style="max-width: auto;">Tanggal Survey</th>
                                            <th style="max-width: auto;">Status Survey</th>
                                            <th style="max-width: auto;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-1 align-content-center">
                                        @foreach ($surveys as $survey)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-truncate">
                                                    {{ $survey->formPendaftaran->registrasiPengambilan->nama }}
                                                </td>
                                                <td class="text-truncate">
                                                    @if ($survey->pendataanSurveyor && $survey->pendataanSurveyor->user)
                                                        {{ $survey->pendataanSurveyor->user->name }}
                                                    @else
                                                        <span class="text-muted">Tidak ada data</span>
                                                    @endif
                                                </td>
                                                <td class="text-truncate">
                                                    {{ $survey->tanggal_survey }}
                                                </td>
                                                <td class="text-truncate">
                                                    @if($survey->saran_rekomendasi === 'Diterima')
                                                        <span class="badge bg-success">{{ $survey->saran_rekomendasi }}</span>
                                                    @elseif($survey->saran_rekomendasi === 'Ditolak')
                                                        <span class="badge bg-danger">{{ $survey->saran_rekomendasi }}</span>
                                                    @elseif($survey->saran_rekomendasi === 'Abu-abu')
                                                        <span class="badge bg-warning text-dark">{{ $survey->saran_rekomendasi }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $survey->saran_rekomendasi }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('form_survey.show', $survey->id_form_survey) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="menu-icon tf-icons bx bxs-detail"></i>
                                                    </a>

                                                    <a href="{{ route('form_survey.download', $survey->id_form_survey) }}"
                                                        class="btn btn-success btn-sm"><i
                                                            class="menu-icon tf-icons bx bxs-file-blank"></i>
                                                    </a>
                                                    <a href="{{ route('form_survey.edit', $survey->id_form_survey) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="menu-icon tf-icons bx bx-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('form_survey.destroy', $survey->id_form_survey) }}"
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('Yakin ingin menghapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="menu-icon tf-icons bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center my-4 pagination-wrapper">
                                {{ $surveys->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data survey ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mt-3">
                    <h5><b>Rekapitulasi Hasil Survey</b></h5>
                    <p>Diterima: <b>{{ $totalLulus }}</b></p>
                    <p>Ditolak: <b>{{ $totalTidakLulus }}</b></p>
                    <p>Abu-abu: <b>{{ $totalAbuAbu }}</b></p>
                </div>
            </main>
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
