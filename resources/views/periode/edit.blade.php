@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
    <!DOCTYPE html>
    <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Data Periode</title>
            <style>
                body {
                    background-color: #f8f9fa;
                }

                .card {
                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                }

                .form-label::after {
                    content: " *";
                    color: red;
                }

                .img-preview {
                    max-width: 200px;
                    max-height: 200px;
                    object-fit: cover;
                }

                .card-header {
                    align-items: center;
                    display: flex;
                    height: 3.3rem;
                }
            </style>
        </head>

        <body>
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('periode.update', $periode->id_periode) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="tahun_periode" class="form-label">Tahun Periode</label>
                                        <input type="text" class="form-control" id="tahun_periode" name="tahun_periode"
                                            value="{{ old('tahun_periode', $periode->tahun_periode) }}" required pattern="^\d{4}\/\d{4}$"
                                            oninput="this.value = this.value.replace(/[^0-9\/]/g, '')">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="mulai_tanggal" class="form-label">Mulai Tanggal</label>
                                            <input type="date" class="form-control" id="mulai_tanggal"
                                                name="mulai_tanggal" value="{{ old('mulai_tanggal', $periode->mulai_tanggal) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sampai_tanggal" class="form-label">Sampai Tanggal</label>
                                            <input type="date" class="form-control" id="sampai_tanggal"
                                                name="sampai_tanggal" value="{{ old('sampai_tanggal', $periode->sampai_tanggal) }}">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('periode.index') }}" class="btn btn-secondary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>

    </html>
@endsection
