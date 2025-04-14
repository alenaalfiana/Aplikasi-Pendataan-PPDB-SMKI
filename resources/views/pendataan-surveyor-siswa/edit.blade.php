@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h4>Edit Pendataan Surveyor Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pendataan-surveyor-siswa.update', $pendataan->first()->id_periode) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Surveyor Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Data Surveyor</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_periode" class="form-label">Periode Pembagian</label>
                                <select class="form-control select2" id="id_periode" name="id_periode" required>
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id_periode }}"
                                            {{ $firstRecord->id_periode == $periode->id_periode ? 'selected' : '' }}>
                                            {{ $periode->tahun_periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_user" class="form-label">Pilih Surveyor</label>
                                <select name="id_user" id="id_user" class="form-select select2" required>
                                    <option value="">Pilih Surveyor</option>
                                    @foreach($surveyors as $surveyor)
                                        <option value="{{ $surveyor->id }}" 
                                            {{ $firstRecord->id_user == $surveyor->id ? 'selected' : '' }}>
                                            {{ $surveyor->name }} ({{ $surveyor->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="surveyor-details" class="mt-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Detail Surveyor</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Nama:</strong> <span id="surveyor-name">{{ $firstRecord->user->name }}</span></p>
                                            <p><strong>Email:</strong> <span id="surveyor-email">{{ $firstRecord->user->email }}</span></p>
                                            <p><strong>Alamat:</strong> <span id="surveyor-alamat">{{ $firstRecord->user->alamat ?? 'Tidak ada' }}</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Provinsi:</strong> <span id="surveyor-province">{{ $firstRecord->user->province->name ?? 'Tidak ada' }}</span></p>
                                            <p><strong>Kabupaten/Kota:</strong> <span id="surveyor-regency">{{ $firstRecord->user->regency->name ?? 'Tidak ada' }}</span></p>
                                            <p><strong>Kecamatan:</strong> <span id="surveyor-district">{{ $firstRecord->user->district->name ?? 'Tidak ada' }}</span></p>
                                            <p><strong>Kelurahan/Desa:</strong> <span id="surveyor-village">{{ $firstRecord->user->village->name ?? 'Tidak ada' }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Selection -->
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Siswa</h5>
                        <button type="button" class="btn btn-sm btn-success" id="addStudentBtn">
                            <i class="bi bi-plus-circle"></i> Tambah Siswa
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="studentsContainer">
                            <!-- Existing students will be loaded here -->
                            @foreach($pendataanRecords as $record)
                                <div class="row mb-3 student-item" id="student-row-{{ $record->id_form_pendaftaran }}">
                                    <div class="col-md-10">
                                        <select name="id_form_pendaftaran[]" class="form-select student-select" required>
                                            <option value="{{ $record->id_form_pendaftaran }}" selected>
                                                {{ $record->formPendaftaran->registrasiPengambilan->nama ?? 'Tidak ada nama' }} 
                                                ({{ $record->formPendaftaran->nisn ?? 'Tidak ada NISN' }}) - 
                                                {{ $record->formPendaftaran->asal_sekolah ?? 'Tidak ada sekolah' }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-student" data-row="student-row-{{ $record->id_form_pendaftaran }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="card mb-4"> 
                    <div class="card-header bg-light"> 
                        <h5 class="mb-0">Status Pendataan</h5> 
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    @php
                                        // Count occurrences of each status
                                        $statusCounts = $pendataanRecords->groupBy('status')->map->count();
                                        // Get the most common status
                                        $commonStatus = $statusCounts->sortDesc()->keys()->first();
                                    @endphp
                                    <option value="belum_selesai" {{ $commonStatus == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                                    <option value="selesai" {{ $commonStatus == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-end">
                    <a href="{{ route('pendataan-surveyor-siswa.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    // Store selected students
    window.selectedStudents = [];
    
    // Initialize with selected students
    @foreach($pendataanRecords as $record)
        window.selectedStudents.push("{{ $record->id_form_pendaftaran }}");
    @endforeach
    
    console.log("Initially selected students:", window.selectedStudents);
    
    // Initialize Select2
    if ($.fn.select2) {
        $('.select2').select2({ theme: 'bootstrap-5' });
    }
    
    // Surveyor selection event
    $('#id_user').change(function() {
        const surveyorId = $(this).val();
        
        if (surveyorId) {
            // Load surveyor details
            $.ajax({
                url: '/get-surveyor-details/' + surveyorId,
                type: 'GET',
                success: function(data) {
                    $('#surveyor-name').text(data.name);
                    $('#surveyor-email').text(data.email);
                    $('#surveyor-alamat').text(data.alamat || 'Tidak ada');
                    $('#surveyor-province').text(data.province_name || 'Tidak ada');
                    $('#surveyor-regency').text(data.regency_name || 'Tidak ada');
                    $('#surveyor-district').text(data.district_name || 'Tidak ada');
                    $('#surveyor-village').text(data.village_name || 'Tidak ada');
                    $('#surveyor-details').show();
                },
                error: function() {
                    alert('Gagal memuat data surveyor');
                }
            });
        }
    });
    
    // Add Student button event - Add new field directly
    $('#addStudentBtn').click(function() {
        const newRowId = 'student-row-new-' + Date.now();
        const newStudentRow = `
            <div class="row mb-3 student-item" id="${newRowId}">
                <div class="col-md-10">
                    <select name="id_form_pendaftaran[]" class="form-select student-select" required>
                        <option value="">Pilih Siswa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-student" data-row="${newRowId}">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>
        `;
        
        $('#studentsContainer').append(newStudentRow);
        
        // Load all available students to the new select field
        const newSelect = $('#' + newRowId + ' .student-select');
        
        $.ajax({
    url: '/get-available-students',
    type: 'GET',
    success: function(data) {
        // Pastikan data adalah array dari objek siswa
        // Misalnya: [{ id: 1, nama: 'Budi', nisn: '12345', sekolah: 'SDN 1' }, ...]
        
        newSelect.empty().append('<option value="">Pilih Siswa</option>');
        
        data.forEach(function(siswa) {
            if (!window.selectedStudents.includes(String(siswa.id))) {
                newSelect.append(
                    `<option value="${siswa.id}">${siswa.nama} (${siswa.nisn ?? 'Tidak ada NISN'}) - ${siswa.asal_sekolah ?? 'Tidak ada sekolah'}</option>`
                );
            }
        });
        
        // Re-init select2
        if ($.fn.select2) {
            newSelect.select2({ theme: 'bootstrap-5' });
        }
    },
    error: function() {
        alert('Gagal memuat data siswa');
        $('#' + newRowId).remove();
    }
});

    });
    
    // Remove student button click event (using event delegation)
    $(document).on('click', '.remove-student', function() {
        const rowId = $(this).data('row');
        const studentId = rowId.replace('student-row-', '');
        
        // Remove selection from tracking array if it's an existing student
        if (!rowId.includes('new-')) {
            const index = window.selectedStudents.indexOf(String(studentId));
            if (index > -1) {
                window.selectedStudents.splice(index, 1);
                console.log("Updated selected students after removal:", window.selectedStudents);
            }
        }
        
        // Remove the row
        $('#' + rowId).remove();
    });
});
</script>