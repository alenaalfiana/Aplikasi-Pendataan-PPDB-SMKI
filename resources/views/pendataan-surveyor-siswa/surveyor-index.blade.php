@extends('layoutss.template')

@section('content')
    <div class="container py-4">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Detail Pendataan Surveyor</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Surveyor</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Nama Surveyor</th>
                                <td>{{ $firstRecord->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $firstRecord->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $firstRecord->user->alamat ?? 'Tidak ada' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Wilayah</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Provinsi</th>
                                <td>{{ $firstRecord->user->province->name ?? 'Tidak ada' }}</td>
                            </tr>
                            <tr>
                                <th>Kabupaten/Kota</th>
                                <td>{{ $firstRecord->user->regency->name ?? 'Tidak ada' }}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td>{{ $firstRecord->user->district->name ?? 'Tidak ada' }}</td>
                            </tr>
                            <tr>
                                <th>Kelurahan/Desa</th>
                                <td>{{ $firstRecord->user->village->name ?? 'Tidak ada' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Daftar Siswa untuk Surveyor</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($students as $student)
                        <div class="col-md-6 mb-4">
                            <div
                                class="card h-100 border {{ $student->computed_status == 'Selesai' ? 'border-success' : 'border-warning' }}">
                                <div
                                    class="card-header {{ $student->computed_status == 'Selesai' ? 'bg-success text-white' : 'bg-warning' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-white">
                                            {{ $student->formPendaftaran->registrasiPengambilan->nama ?? 'Nama tidak tersedia' }}
                                        </h5>
                                        <span
                                            class="badge {{ $student->computed_status == 'Selesai' ? 'bg-light text-dark' : 'bg-light text-dark' }}">
                                            {{ $student->computed_status == 'Selesai' ? 'Selesai' : 'Belum Selesai' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p class="mb-1 mt-3"><strong>NISN:</strong>
                                            {{ $student->formPendaftaran->nisn ?? 'Tidak tersedia' }}</p>
                                        <p class="mb-1"><strong>Sekolah:</strong>
                                            {{ $student->formPendaftaran->asal_sekolah ?? 'Tidak tersedia' }}</p>
                                        <p class="mb-0"><strong>Alamat:</strong>
                                            {{ $student->formPendaftaran->alamat_lengkap ?? 'Tidak tersedia' }}</p>
                                        <p>
                                            {{ $student->formPendaftaran->village->name }},
                                            {{ $student->formPendaftaran->district->name }},
                                            {{ $student->formPendaftaran->regency->name }},
                                            {{ $student->formPendaftaran->province->name }}
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <!-- Tombol Mulai Interview -->
                                        @if ($student->formInterview)
                                            <button class="btn btn-success w-100" disabled>Sudah Interview</button>
                                        @else
                                            <a href="{{ route('form_interview.create', ['id_pendataan_surveyor_siswa' => $student->id_pendataan_surveyor_siswa]) }}"
                                                class="btn btn-primary">
                                                Mulai Interview
                                            </a>
                                        @endif

                                        <!-- Tombol Mulai Survey -->
                                        @if ($student->formSurvey)
                                            <button class="btn btn-success w-100" disabled>Sudah Survey</button>
                                        @else
                                            <a href="{{ route('form_survey.create', ['id_pendataan_surveyor_siswa' => $student->id_pendataan_surveyor_siswa]) }}"
                                                class="btn btn-primary">
                                                Mulai Survey
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                Belum ada siswa yang ditugaskan kepada surveyor ini.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
