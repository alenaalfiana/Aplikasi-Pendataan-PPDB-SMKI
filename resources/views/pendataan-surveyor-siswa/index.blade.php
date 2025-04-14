@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <div id="app">
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Pendataan Surveyor Siswa</b>
                    </h2>
                </div>
                <div class="card mb-4">
                    <div class="container">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('pendataan-surveyor-siswa.create') }}">
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

                        <form action="{{ route('pendataan-surveyor-siswa.index') }}" method="GET">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select name="id_periode" class="form-control mb-3" onchange="this.form.submit()">
                                        <option value="">-- Pilih Periode --</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id_periode }}"
                                                {{ request('id_periode') == $periode->id_periode ? 'selected' : '' }}>
                                                {{ $periode->tahun_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari nama siswa..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="{{ route('pendataan-surveyor-siswa.index') }}" class="btn btn-secondary">X</a>
                                </div>
                            </div>
                        </form>

                        @if ($pendataanSurveyorSiswa->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Surveyor</th>
                                            <th>Jumlah Siswa</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Group by surveyor (user_id)
                                            $groupedData = $pendataanSurveyorSiswa->groupBy('id_user');
                                        @endphp
                                        
                                        @foreach ($groupedData as $userId => $items)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $items->first()->user->name }}</td>
                                                <td>{{ $items->count() }}</td>
                                                <td>
                                                    @php
                                                        $status = $items->first()->status;
                                                    @endphp
                                                
                                                    @if($status == 'selesai')
                                                        <span class="badge bg-success text-white">Selesai</span>
                                                    @elseif($status == 'belum_selesai')
                                                        <span class="badge bg-warning text-dark text-white">Belum Selesai</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    <a href="{{ route('pendataan-surveyor-siswa.show', $userId) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="menu-icon tf-icons bx bxs-detail"></i>
                                                    </a>
                                                    <a href="{{ route('pendataan-surveyor-siswa.edit', $userId) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="menu-icon tf-icons bx bxs-edit"></i>
                                                    </a>
                                                    <form action="{{ route('pendataan-surveyor-siswa.destroy', $userId) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            <i class="menu-icon tf-icons bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center my-4">
                                    {{ $pendataanSurveyorSiswa->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">Tidak ada data ditemukan.</div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection