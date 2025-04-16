<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

    <head>
        <head>
            <meta charset="utf-8" />
            <meta
              name="viewport"
              content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
            />

            <title>PPDB SMKIU | Verifikasi Email </title>

            <meta name="description" content="" />

            <!-- Favicon -->
            <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon/favicon.png') }}?v=1" />

            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link
              href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
              rel="stylesheet"
            />

            <!-- Icons. Uncomment required icon fonts -->
            <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

            <!-- Core CSS -->
            <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="../assets/css/demo.css" />

            <!-- Vendors CSS -->
            <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

            <!-- Page CSS -->
            <!-- Page -->
            <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
            <!-- Helpers -->
            <script src="../assets/vendor/js/helpers.js"></script>

            <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
            <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
            <script src="../assets/js/config.js"></script>

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f3f4f6;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }

            .container {
                background-color: #fff;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                max-width: 400px;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .logo {
                width: 100px;
                height: 100px;
            }

            .center {
                align-items: center;
            }

            h1 {
                font-size: 1.5rem;
                color: #333;
                margin-bottom: 0.5rem;
            }

            p {
                font-size: 1rem;
                color: #666;
                margin-bottom: 1.5rem;
            }

            .btn-primary {
                background-color: #4f46e5;
                color: #fff;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 4px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                margin-bottom: 1rem;
            }

            .btn-primary:hover {
                background-color: #4338ca;
            }

            .btn-link {
                color: #4f46e5;
                font-size: 0.875rem;
                text-decoration: underline;
                cursor: pointer;
            }

            .alert {
                color: #16a34a;
                font-size: 0.875rem;
                margin-bottom: 1rem;
            }
        </style>
    </head>

    <body>
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Register -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2"><b>Verifikasi Alamat Email-mu!</b></h4>
                            <br>
                            <p class="mb-4">Terimakasih sudah mendaftar! Untuk melengkapi pendaftaran, tolong
                                verifikasi alamat email-mu dengan mengklik link yang telah kami kirim!
                                <br>
                                <br>Tidak menerima link-nya? <br>Kami bisa kirimkan ulang.
                            </p>

                            @if (session('status') == 'verification-link-sent')
                                <div class="alert">
                                    Link verifikasi yang baru telah dikirimkan ulang ke alamat email yang didaftarkan oleh Admin
                                </div>
                            @endif

                            <div class="mb-3">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button class="btn btn-primary d-grid w-100" type="submit">Kirimkan Ulang Email
                                        Verifikasi</button>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <p><button type="submit" class="btn-link">Keluar</button></p>
                            </form>
                        </div>
    </body>

</html>
