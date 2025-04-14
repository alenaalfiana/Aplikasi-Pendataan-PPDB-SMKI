<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="admin-dashboard" class="app-brand-link">
            <span class="app-brand-logo demo">
                <div class="sidebar-header">
                    <img src="{{ asset('assets/img/illustrations/logo-asn.png') }}" alt="logo-smk" class="logo-image">
                </div>
            </span>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Master</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('users.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-face"></i>
                <div data-i18n="Boxicons">Data Admin & Guru</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('periode.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-time"></i>
                <div data-i18n="Boxicons">Data Periode Pendaftaran</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('pendataan_tpa_bhq.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-file"></i>
                <div data-i18n="Boxicons">Data Penilaian</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Surveyor</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('pendataan-surveyor-siswa.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-group"></i>
                <div data-i18n="Boxicons">Data Pembagian <br>Surveyor Siswa</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Proses Pendaftaran</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('registrasi_pengambilan.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Boxicons">Pengambilan <br>Formulir</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('form_pendaftaran.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Boxicons">Pengembalian Formulir dan Dokumen</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('form_interview.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Boxicons">Pendataan <br>Hasil Interview</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('form_survey.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Boxicons">Pendataan <br>Hasil Survey</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Hasil Akhir</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('laporan-penerimaan.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Boxicons">Laporan Penerimaan</div>
            </a>
        </li>
    </ul>


</aside>

<style>
    .app-brand {
        text-align: center;
        margin-bottom: 20px;
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-image {
        max-width: 100%;
        /* Ensure it doesn't overflow the container */
        width: 80%;
        /* Adjust this value as needed */
        height: auto;
        /* Maintain the aspect ratio */
    }
</style>
