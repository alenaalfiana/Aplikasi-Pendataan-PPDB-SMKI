@extends(Auth::user()->role_as == '1' ? 'layouts.template' : (Auth::user()->role_as == '2' ? 'layoutss.template' : 'layoutsss.template'))

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Pendataan Surveyor Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pendataan-surveyor-siswa.store') }}" method="POST">
                @csrf

                <!-- Surveyor Selection -->
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
                                            {{ old('id_periode') == $periode->id_periode ? 'selected' : '' }}>
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
                                        <option value="{{ $surveyor->id }}">{{ $surveyor->name }} ({{ $surveyor->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="surveyor-details" class="mt-3" style="display: none;">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Detail Surveyor</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Nama:</strong> <span id="surveyor-name"></span></p>
                                            <p><strong>Email:</strong> <span id="surveyor-email"></span></p>
                                            <p><strong>Alamat:</strong> <span id="surveyor-alamat"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Provinsi:</strong> <span id="surveyor-province"></span></p>
                                            <p><strong>Kabupaten/Kota:</strong> <span id="surveyor-regency"></span></p>
                                            <p><strong>Kecamatan:</strong> <span id="surveyor-district"></span></p>
                                            <p><strong>Kelurahan/Desa:</strong> <span id="surveyor-village"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Region Filter for Students -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Filter Siswa Berdasarkan Wilayah</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select id="province-select" class="form-control">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="regency-select" class="form-control" disabled>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="district-select" class="form-control" disabled>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="village-select" name="id_region" class="form-control" disabled>
                                    <option value="">-- Pilih Kelurahan --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Selection -->
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Siswa</h5>
                        <button type="button" class="btn btn-sm btn-success" id="addStudentBtn" disabled>
                            <i class="bi bi-plus-circle"></i> Tambah Siswa
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="studentsContainer">
                            <div class="alert alert-info">
                                Pilih wilayah terlebih dahulu untuk menampilkan daftar siswa yang tersedia.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="card mb-4" hidden>
                    <div class="card-header bg-light" hidden>
                        <h5 class="mb-0" hidden>Status Pendataan</h5>
                    </div>
                    <div class="card-body" hidden>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="belum_selesai">Belum selesai</option>
                                    <option value="selesai">selesai</option>
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
    // Store all available students
    window.allStudents = [];
    window.selectedStudents = [];

    // Debug flag
    const DEBUG = true;

    function debugLog(message, data) {
        if (DEBUG) {
            console.log(message, data);
        }
    }

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
                    $('#surveyor-details').hide();
                }
            });
        } else {
            $('#surveyor-details').hide();
        }
    });

    // Province change event
    $('#province-select').change(function () {
        let provinceId = $(this).val();
        resetDropdown('#regency-select', 'Pilih Kabupaten/Kota');
        resetDropdown('#district-select', 'Pilih Kecamatan');
        resetDropdown('#village-select', 'Pilih Kelurahan');
        resetStudentsContainer();

        if (provinceId) {
            fetchOptions('/regencies/' + provinceId, '#regency-select');
        }
    });

    // Regency change event
    $('#regency-select').change(function () {
        let regencyId = $(this).val();
        resetDropdown('#district-select', 'Pilih Kecamatan');
        resetDropdown('#village-select', 'Pilih Kelurahan');
        resetStudentsContainer();

        if (regencyId) {
            fetchOptions('/districts/' + regencyId, '#district-select');
        }
    });

    // District change event
    $('#district-select').change(function () {
        let districtId = $(this).val();
        resetDropdown('#village-select', 'Pilih Kelurahan');
        resetStudentsContainer();

        if (districtId) {
            fetchOptions('/villages/' + districtId, '#village-select');
        }
    });

    // Village change event - Load Students
    $('#village-select').change(function () {
        let villageId = $(this).val();
        resetStudentsContainer();

        if (villageId) {
            loadStudents();
        }
    });

    // Reset students container
    function resetStudentsContainer() {
        $('#studentsContainer').html('<div class="alert alert-info">Pilih wilayah terlebih dahulu untuk menampilkan daftar siswa yang tersedia.</div>');
        window.allStudents = [];
        window.selectedStudents = [];
        $('#addStudentBtn').prop('disabled', true);
    }

    // Fungsi untuk mengambil data dan mengisi dropdown
    function fetchOptions(url, targetSelect) {
        $(targetSelect).prop('disabled', true).html('<option value="">Loading...</option>');
        $.get(url, function (data) {
            $(targetSelect).prop('disabled', false).html('<option value="">-- Pilih --</option>');
            $.each(data, function (key, value) {
                $(targetSelect).append(`<option value="${value.id}">${value.name}</option>`);
            });
        });
    }

    // Fungsi untuk reset dropdown
    function resetDropdown(selector, placeholder) {
        $(selector).prop('disabled', true).html(`<option value="">-- ${placeholder} --</option>`);
    }

    // Fungsi untuk memuat daftar Siswa berdasarkan wilayah
    function loadStudents() {
        let params = {
            province_id: $('#province-select').val(),
            regency_id: $('#regency-select').val(),
            district_id: $('#district-select').val(),
            village_id: $('#village-select').val(),
        };

        $.ajax({
            url: '/students-by-region',
            type: 'GET',
            data: params,
            success: function (data) {
                debugLog("Received students data:", data);

                // Periksa struktur data untuk satu siswa (jika ada)
                if (data.length > 0) {
                    debugLog("First student data structure:", data[0]);
                }

                let studentsContainer = $('#studentsContainer');
                studentsContainer.empty();

                // Store available students
                window.allStudents = data;
                window.selectedStudents = [];

                if (data.length > 0) {
                    studentsContainer.html(`
                        <div class="alert alert-success mb-3">
                            ${data.length} siswa ditemukan di wilayah ini. Silakan klik tombol "Tambah Siswa" untuk menambahkan siswa.
                        </div>
                    `);

                    // Enable add student button
                    $('#addStudentBtn').prop('disabled', false);
                } else {
                    studentsContainer.html(`
                        <div class="alert alert-warning">
                            Tidak ada siswa ditemukan di wilayah ini.
                        </div>
                    `);

                    // Disable add student button
                    $('#addStudentBtn').prop('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading students:", error);
                $('#studentsContainer').html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat memuat data siswa. Silakan coba lagi.
                    </div>
                `);
                $('#addStudentBtn').prop('disabled', true);
            }
        });
    }

    // Get available students (excluding already selected ones)
    function getAvailableStudents() {
        // Pastikan bahwa selectedStudents dan allStudents adalah array
        if (!Array.isArray(window.selectedStudents) || !Array.isArray(window.allStudents)) {
            console.error("selectedStudents or allStudents is not an array");
            return [];
        }

        return window.allStudents.filter(student => {
            // Gunakan id_form_pendaftaran daripada id
            const studentId = student.id_form_pendaftaran;

            // Cek apakah studentId ada dan valid
            if (studentId === undefined || studentId === null) {
                debugLog("Student missing id_form_pendaftaran:", student);
                return false;
            }

            // Konversi ke string untuk perbandingan konsisten
            const studentIdStr = String(studentId);

            // Periksa apakah ID siswa ada di array selectedStudents
            const isAvailable = !window.selectedStudents.includes(studentIdStr);

            return isAvailable;
        });
    }

    // Add Student button event
    $('#addStudentBtn').click(function () {
        if (!window.allStudents || window.allStudents.length === 0) {
            alert('Pilih wilayah terlebih dahulu untuk menampilkan daftar siswa.');
            return;
        }

        const availableStudents = getAvailableStudents();
        debugLog("Available students:", availableStudents);

        if (availableStudents.length === 0) {
            alert('Semua siswa sudah dipilih.');
            return;
        }

        const studentRowId = 'student-row-' + Date.now();
        const studentRow = `
            <div class="row mb-3 student-item" id="${studentRowId}">
                <div class="col-md-10">
                    <select name="id_form_pendaftaran[]" class="form-select student-select" id="select-${studentRowId}" required>
                        <option value="">Pilih Siswa</option>
                        ${availableStudents.map(student => {
                            // Gunakan id_form_pendaftaran sebagai nilai
                            const studentId = student.id_form_pendaftaran;
                            // Gunakan nama dari join, atau nama dari form_pendaftaran
                            const studentName = student.nama || 'Nama tidak tersedia';
                            const studentNisn = student.nisn || 'NISN tidak tersedia';
                            const studentSchool = student.asal_sekolah || 'Sekolah tidak tersedia';

                            return `<option value="${studentId}">${studentName} (${studentNisn}) - ${studentSchool}</option>`;
                        }).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-student" data-row="${studentRowId}">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>
        `;

        $('#studentsContainer').append(studentRow);

        // Jika ini adalah siswa pertama yang ditambahkan, hapus alert
        if ($('.student-item').length === 1) {
            $('#studentsContainer .alert').remove();
        }

        // Initialize Select2 for the new student select
        if ($.fn.select2) {
            $(`#select-${studentRowId}`).select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Siswa'
            });
        }

        // Handle student selection change
        $(`#select-${studentRowId}`).change(function() {
            const selectedValue = $(this).val();
            const previousSelectId = $(this).data('previous-selection');

            // Remove any previous selection for this dropdown
            if (previousSelectId) {
                const index = window.selectedStudents.indexOf(previousSelectId);
                if (index > -1) {
                    window.selectedStudents.splice(index, 1);
                }
            }

            // Add new selection
            if (selectedValue) {
                window.selectedStudents.push(String(selectedValue));
                $(this).data('previous-selection', String(selectedValue));
                debugLog("Selected students after adding:", window.selectedStudents);
            }

            // Update all other dropdowns to remove this option
            updateAllStudentDropdowns();
        });
    });

    // Update all student dropdowns to reflect current selections
    function updateAllStudentDropdowns() {
        $('.student-select').each(function() {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();

            // Store current selection state
            const isSelect2 = currentSelect.data('select2') !== undefined;

            // Get available students plus current selection
            const availableStudents = window.allStudents.filter(student => {
                // Gunakan id_form_pendaftaran sebagai ID siswa
                const studentId = student.id_form_pendaftaran;

                if (studentId === undefined || studentId === null) {
                    return false;
                }

                const studentIdStr = String(studentId);
                return !window.selectedStudents.includes(studentIdStr) || studentIdStr === String(currentValue);
            });

            // Rebuild dropdown options
            let options = '<option value="">Pilih Siswa</option>';
            availableStudents.forEach(student => {
                const studentId = student.id_form_pendaftaran;

                if (studentId !== undefined && studentId !== null) {
                    const studentIdStr = String(studentId);
                    const selected = studentIdStr === String(currentValue) ? 'selected' : '';
                    const studentName = student.nama || 'Nama tidak tersedia';
                    const studentNisn = student.nisn || 'NISN tidak tersedia';
                    const studentSchool = student.asal_sekolah || 'Sekolah tidak tersedia';

                    options += `<option value="${studentIdStr}" ${selected}>${studentName} (${studentNisn}) - ${studentSchool}</option>`;
                }
            });

            // Update dropdown content
            if (isSelect2) {
                // Destroy select2 before updating options
                currentSelect.select2('destroy');
                currentSelect.html(options);
                // Reinitialize select2
                currentSelect.select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Pilih Siswa'
                });
            } else {
                currentSelect.html(options);
            }
        });
    }

    // Remove student button click event (using event delegation)
    $(document).on('click', '.remove-student', function () {
        const rowId = $(this).data('row');
        const selectElement = $(`#select-${rowId}`);
        const selectedValue = selectElement.val();

        // Remove selection from tracking array
        if (selectedValue) {
            const index = window.selectedStudents.indexOf(String(selectedValue));
            if (index > -1) {
                window.selectedStudents.splice(index, 1);
                debugLog("Selected students after removing:", window.selectedStudents);
            }
        }

        // Remove the row
        $(`#${rowId}`).remove();

        // Update remaining dropdowns
        updateAllStudentDropdowns();

        // If no student rows remain, show the info message
        if ($('.student-item').length === 0) {
            $('#studentsContainer').html(`
                <div class="alert alert-success">
                    ${window.allStudents.length} siswa ditemukan di wilayah ini. Silakan klik tombol "Tambah Siswa" untuk menambahkan siswa.
                </div>
            `);
        }
    });
});
</script>
