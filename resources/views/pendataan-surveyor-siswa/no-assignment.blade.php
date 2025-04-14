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
