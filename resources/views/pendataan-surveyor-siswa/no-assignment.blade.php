@extends('layoutss.template')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <h2 class="mb-4">Anda Belum Mendapatkan Tugas</h2>
                    <p class="lead text-muted mb-4">
                        Saat ini, belum ada penugasan yang diberikan kepada Anda sebagai surveyor.
                    </p>

                    <!-- Script untuk Lottie -->
                    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>

                    <!-- Lottie GIF ditengah dan ukuran bisa diatur -->
                    <div class="d-flex justify-content-center my-4">
                        <dotlottie-player
                            src="https://lottie.host/f19ee638-25b4-42a4-955c-1a8ce473ca58/lL4SlLCZOE.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 300px; height: 300px;"
                            loop autoplay>
                        </dotlottie-player>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Silakan hubungi administrator untuk informasi lebih lanjut.
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
