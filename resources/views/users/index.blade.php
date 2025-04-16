@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
        <div class="container-xxl flex-grow-1 container-p-y">
            <main class="py-4">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="fw-bold py-3 mb-1">
                        <b>Data Pengguna - Admin & Guru</b>
                    </h2>
                </div>
                <div class="card mb-4">
                    <div class="container">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('users.create') }}">
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

                        <form action="{{ route('users.index') }}" method="GET" class="mb-3">
                            <div class="form-group d-flex">
                                <input type="text" name="search" value="{{ request()->input('search') }}"
                                    class="form-control" placeholder="Cari berdasarkan nama ...">
                                <button type="submit" class="btn btn-primary ms-2">Cari</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">X</a>
                            </div>
                        </form>

                        <div class="mb-3">
                            <a href="{{ route('users.index', ['role_as' => null]) }}" class="btn btn-secondary {{ request('role_as') === null ? 'active' : '' }}">Semua</a>
                            <a href="{{ route('users.index', ['role_as' => 1]) }}" class="btn btn-success {{ request('role_as') == 1 ? 'active' : '' }}">Admin</a>
                            <a href="{{ route('users.index', ['role_as' => 2]) }}" class="btn btn-warning {{ request('role_as') == 2 ? 'active' : '' }}">Guru</a>
                        </div>

                        @if ($users->count() > 0)
                            <div class="table-responsive text-nowrap">
                                <br>
                                <table class="table table-hover align-content-center table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-1 align-content-center">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-truncate" style="max-width: auto;">
                                                    <a href="#" class="user-detail" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}" data-role="{{ $user->role_as }}">
                                                        {{ $user->name }}
                                                    </a>
                                                </td>
                                                <td class="text-truncate" style="max-width: auto;">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="text-truncate" style="max-width: auto;">
                                                    <strong>
                                                        @if ($user->role_as == '1')
                                                            <button
                                                                class="btn btn-success btn-sm disabled">&nbsp;&nbsp;&nbsp;&nbsp;Admin&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                                        @elseif ($user->role_as == '2')
                                                            <button
                                                                class="btn btn-warning btn-sm disabled">Guru</button>
                                                        @elseif ($user->role_as == '0')
                                                            <button
                                                                class="btn btn-primary btn-sm disabled">&nbsp;&nbsp;&nbsp;User&nbsp;&nbsp;&nbsp;</button>
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.edit', ['user' => $user->id, 'source' => 'users.index']) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="menu-icon tf-icons bx bx-edit"></i>
                                                    </a>

                                                    <form
                                                        action="{{ route('users.destroy', $user->id) }}"
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
                                {{ $users->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data user ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
@endsection

<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> <span id="modalUserName"></span></p>
                        <p><strong>Email:</strong> <span id="modalUserEmail"></span></p>
                        <p><strong>Role:</strong> <span id="modalUserRole"></span></p>
                        <p><strong>Provinsi:</strong> <span id="modalUserProvince"></span></p>
                        <p><strong>Kabupaten/Kota:</strong> <span id="modalUserRegency"></span></p>
                        <p><strong>Kecamatan:</strong> <span id="modalUserDistrict"></span></p>
                        <p><strong>Kelurahan/Desa:</strong> <span id="modalUserVillage"></span></p>
                        <p><strong>Alamat:</strong> <span id="modalUserAddress"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanda Tangan:</strong></p>
                        <div id="modalUserSignatureContainer" class="text-center p-2 border rounded">
                            <img id="modalUserSignatureImg" src="" alt="Tanda Tangan" class="img-fluid" style="max-height: 300px; max-width: 100%; display: none;">
                            <p id="modalUserNoSignature" class="text-muted" style="display: none;">Tidak ada tanda tangan</p>
                            <p id="modalUserSignatureDebug" class="text-muted small" style="display: none;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".user-detail").forEach(function (element) {
        element.addEventListener("click", function () {
            let userId = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let email = this.getAttribute("data-email");
            let role = this.getAttribute("data-role");

            // Menampilkan data dasar
            document.getElementById("modalUserName").textContent = name;
            document.getElementById("modalUserEmail").textContent = email;
            document.getElementById("modalUserRole").textContent = role == '1' ? 'Admin' : (role == '2' ? 'Operator' : 'User');

            // Reset tampilan tanda tangan
            document.getElementById("modalUserSignatureImg").style.display = "none";
            document.getElementById("modalUserNoSignature").style.display = "none";
            document.getElementById("modalUserSignatureDebug").style.display = "none";

            // Mengambil data lengkap user dari server
            fetch(`/users/${userId}/detail`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Data user:", data); // Debugging

                    // Menampilkan data lokasi
                    document.getElementById("modalUserProvince").textContent = data.province || '-';
                    document.getElementById("modalUserRegency").textContent = data.regency || '-';
                    document.getElementById("modalUserDistrict").textContent = data.district || '-';
                    document.getElementById("modalUserVillage").textContent = data.village || '-';
                    document.getElementById("modalUserAddress").textContent = data.alamat || '-';

                    // Menampilkan tanda tangan - prioritaskan URL
                    if (data.signature_url) {
                        document.getElementById("modalUserSignatureImg").src = data.signature_url;
                        document.getElementById("modalUserSignatureImg").style.display = "block";
                        document.getElementById("modalUserNoSignature").style.display = "none";

                        // Tambahkan event listener untuk menangani jika gambar gagal dimuat
                        document.getElementById("modalUserSignatureImg").onerror = function() {
                            document.getElementById("modalUserSignatureImg").style.display = "none";
                            document.getElementById("modalUserNoSignature").style.display = "block";
                            document.getElementById("modalUserSignatureDebug").textContent =
                                "Gagal memuat gambar. Path: " + data.path;
                            document.getElementById("modalUserSignatureDebug").style.display = "block";
                        };
                    }
                    // Jika tidak ada URL tapi ada base64, gunakan base64
                    else if (data.signature_base64) {
                        document.getElementById("modalUserSignatureImg").src = data.signature_base64;
                        document.getElementById("modalUserSignatureImg").style.display = "block";
                        document.getElementById("modalUserNoSignature").style.display = "none";
                    }
                    // Jika tidak ada tanda tangan sama sekali
                    else {
                        document.getElementById("modalUserSignatureImg").style.display = "none";
                        document.getElementById("modalUserNoSignature").style.display = "block";
                    }

                    // Tambahkan debug info jika diperlukan
                    if (data.has_path) {
                        document.getElementById("modalUserSignatureDebug").textContent =
                            "Path: " + data.path + " | File exists: " + (data.file_exists ? "Ya" : "Tidak");
                        document.getElementById("modalUserSignatureDebug").style.display = "block";
                    }
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                    document.getElementById("modalUserSignatureDebug").textContent = "Error: " + error.message;
                    document.getElementById("modalUserSignatureDebug").style.display = "block";
                });

            $("#userDetailModal").modal("show");
        });
    });

    document.querySelectorAll(".close, [data-dismiss='modal']").forEach(function (btn) {
        btn.addEventListener("click", function () {
            $("#userDetailModal").modal("hide");
        });
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
