@extends('layoutss.template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row d-flex align-items-stretch">
            <div class="col-lg-6 mb-4">
                <div class="card h-100" style="background: url('assets/img/illustrations/Header.png') center/cover no-repeat;">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h3 class="card-title text-primary" style="font-size: 24px"><b>Halo, Selamat Datang! &#128516; &#10024;</b></h3>
                                <p class="mb-4" style="font-size: 20px">
                                    Anda telah menjadi, <span class="fw-bold" style="color:midnightblue">Guru.</span>
                                    <br>sekarang anda bisa bertugas
                                    <br>untuk interview dan survey
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title mb-3 text-white">Profil Pengguna</h3>
                        <div class="row align-items-center">
                            <!-- Kolom untuk Nama dan Role -->
                            <div class="col-md-4 text-center">
                                <h4 class="mb-2">{{ Auth::user()->name }}</h4>
                                <span class="badge bg-info text-white px-3 py-2 mb-2">
                                    {{ Auth::user()->role_as == 1 ? 'Administrator' : 'Surveyor' }}
                                </span>
                                <p>
                                    <a href="{{ route('users.edit', ['user' => Auth::id(), 'source' => 'admin.dashboard']) }}"
                                        class="btn btn-outline-primary">Edit</a>
                                </p>
                            </div>
                            <!-- Kolom untuk Detail Profil -->
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                                    <li class="list-group-item"><strong>Alamat:</strong>
                                        {{ Auth::user()->alamat ?? 'Alamat tidak tersedia' }},
                                        {{ Auth::user()->village->name ?? 'Desa tidak tersedia' }},
                                        {{ Auth::user()->district->name ?? 'Kecamatan tidak tersedia' }},
                                        {{ Auth::user()->regency->name ?? 'Kabupaten tidak tersedia' }},
                                        {{ Auth::user()->province->name ?? 'Provinsi tidak tersedia' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Tanda Tangan:</strong>
                                        @if (Auth::user()->tanda_tangan)
                                            <div class="d-flex align-items-center mt-2">
                                                <img class="img-fluid" style="max-width: auto; height: auto;"
                                                    src="{{ Auth::user()->tanda_tangan }}" alt="Tanda Tangan">
                                            </div>
                                        @else
                                            <p class="text-muted">Tanda tangan tidak tersedia</p>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $countGuru = \App\Models\User::where('role_as', '2')->count();
                $countUser = \App\Models\FormPendaftaran::count(); // Diperbaiki di sini
            @endphp

<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title text-white"><b>Total Guru</b></h5>
                <p class="card-text">{{ $countGuru }}</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title text-white"><b>Total Calon Siswa</b></h5>
                <p class="card-text">{{ $countUser }}</p>
            </div>
        </div>
    </div>
</div>

        </div>


        <script>
            function updateClock() {
                var now = new Date();
                var hours = now.getHours().toString().padStart(2, '0');
                var minutes = now.getMinutes().toString().padStart(2, '0');
                var seconds = now.getSeconds().toString().padStart(2, '0');
                var timeString = hours + ':' + minutes + ':' + seconds;

                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                    'November', 'December'
                ];
                var day = days[now.getDay()];
                var month = months[now.getMonth()];
                var date = now.getDate().toString().padStart(2, '0');
                var fullDate = day + ', ' + date + ' ' + month + ' ' + now.getFullYear();

                document.getElementById('clock').textContent = timeString;
                document.getElementById('date').textContent = fullDate;
            }

            // Update clock every second
            setInterval(updateClock, 1000);
            updateClock(); // Run once immediately to display the time right away
        </script>


        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card"
                    style="background: url('assets/img/illustrations/content1.jpg') center/cover no-repeat;">
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="card"
                    style="background: url('assets/img/illustrations/content1.jpg') center/cover no-repeat;">
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="card"
                    style="background: url('assets/img/illustrations/content1.jpg') center/cover no-repeat;">
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="card"
                    style="background: url('assets/img/illustrations/content1.jpg') center/cover no-repeat;">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h2 class="mb-4">Grafik Total Pendaftar Per Periode</h2>
                <canvas id="pendaftaranChart"></canvas>
            </div>
            <div class="col-lg-6 mb-4">
                <h2 class="mb-4">Grafik Total Siswa Diterima Per Periode</h2>
                <canvas id="pendaftaranDiterimaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var periodeLabels = @json($periodeLabels);
        var periodeData = @json($periodeData);
        var periodeDataDiterima = @json($periodeDataDiterima);

        // First Chart - Total Pendaftar
        var ctx = document.getElementById('pendaftaranChart').getContext('2d');
        var pendaftaranChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: periodeLabels,
                datasets: [{
                    label: 'Jumlah Pendaftaran Berhasil',
                    data: periodeData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pendaftaran'
                        }
                    }
                }
            }
        });

        // Second Chart - Siswa Diterima
        var ctxDiterima = document.getElementById('pendaftaranDiterimaChart').getContext('2d');
        var pendaftaranDiterimaChart = new Chart(ctxDiterima, {
            type: 'bar',
            data: {
                labels: periodeLabels,
                datasets: [{
                    label: 'Jumlah Siswa Diterima',
                    data: periodeDataDiterima,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Siswa Diterima'
                        }
                    }
                }
            }
        });
    </script>
@endsection
