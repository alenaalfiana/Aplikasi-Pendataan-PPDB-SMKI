<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Home - SMK Informatika Utama</title>
    <meta name="description" content="Sekolah Teknologi Informasi (TI) yang berbeasiswa full">
    <meta name="keywords" content="SMK, Informatika, Beasiswa, Pendidikan, TI">

    <!-- Favicons -->
    <link href="asset/img/favicon.png" rel="icon">
    <link href="asset/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="asset/vendor/aos/aos.css" rel="stylesheet">
    <link href="asset/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="asset/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="asset/css/main.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --accent-color: #f6c23e;
            --text-color: #333;
            --light-color: #f8f9fc;
            --dark-color: #2c3e50;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: #f8f9fc;
        }

        .header {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .header .sitename {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-left: 10px;
        }

        .navmenu ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navmenu a {
            display: block;
            position: relative;
            color: var(--dark-color);
            padding: 10px 20px;
            font-weight: 500;
            font-size: 16px;
            transition: 0.3s;
            text-decoration: none;
            border-radius: 50px;
        }

        .navmenu a:hover,
        .navmenu a:focus {
            color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.1);
        }

        .hero {
            padding: 80px 0;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fc 0%, #e8eeff 100%);
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--dark-color);
            background: linear-gradient(to right, var(--dark-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
        }

        .hero-btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
            margin-top: 20px;
        }

        .hero-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
            color: white;
        }

        .hero-img {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-animation {
            max-width: 100%;
            height: auto;
        }

        .footer {
            background-color: #fff;
            padding: 30px 0;
            font-size: 14px;
            border-top: 1px solid #eee;
        }

        .footer .copyright {
            color: #555;
        }

        .footer .sitename {
            color: var(--primary-color);
        }

        .scroll-top {
            position: fixed;
            visibility: hidden;
            opacity: 0;
            right: 15px;
            bottom: 15px;
            z-index: 99999;
            background: var(--primary-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.4s;
            color: #fff;
        }

        .scroll-top:hover {
            background: var(--secondary-color);
        }

        .scroll-top.active {
            visibility: visible;
            opacity: 1;
        }

        /* Features Section */
        .features {
            padding: 60px 0;
            background-color: #fff;
        }

        .features .feature-box {
            padding: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
            border-radius: 15px;
            background: #fff;
            height: 100%;
            transition: all 0.3s ease;
        }

        .features .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .features .feature-icon {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .features .feature-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .features .feature-text {
            color: #555;
            font-size: 15px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .hero-animation {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <img src="asset/img/smki-utama.png" alt="SMK Informatika Utama Logo" style="width: 60px; height: 60px; margin-right: 10px;">
                <h1 class="sitename">SMKI UTAMA</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    @if (Route::has('login'))
                    @auth
                        @if (Auth::check())
                            @if (Auth::user()->role_as == 1)
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            @elseif(Auth::user()->role_as == 2)
                                <li><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            @endif
                        @else
                            <li><a href="{{ url('/') }}">Home</a></li>
                        @endif
                    @else
                    <li><a href="{{ route('login') }}" style="all: unset; cursor: pointer; color: #1d316d;"><b>Masuk</b></a></li>
                    {{-- <li><a href="{{ route('register') }}">Registrasi</a></li> --}}
                    @endif
                    @endif
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container">
                <div class="row gy-4 align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
                        <h1>Aplikasi Pendataan<br>PPDB Sekolah Gratis<br>SMK Informatika Utama</h1>
                        <p>Aplikasi Pendataan PPDB Sekolah ini memudahkan proses pendaftaran peserta didik baru dengan sistem yang cepat, efisien, dan terintegrasi.</p>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <!-- Lottie Animation -->
                        <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
                        <dotlottie-player
                            src="https://lottie.host/8007f3e3-8cb3-465c-afec-dbde295ff459/rABV0QnZM1.lottie"
                            background="transparent"
                            speed="1"
                            class="hero-animation"
                            style="width: 500px; height: 500px"
                            loop
                            autoplay>
                        </dotlottie-player>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- Features Section -->
        <section id="features" class="features section">
            <div class="container" data-aos="fade-up">
                <div class="section-header text-center mb-5">
                    <h2 class="mb-3" style="font-weight: 700; color: var(--dark-color);">Keunggulan Kami</h2>
                    <p style="color: #555; max-width: 700px; margin: 0 auto;">Kami menyediakan pendidikan berkualitas di bidang teknologi informasi dengan berbagai keunggulan</p>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h3 class="feature-title">Beasiswa Penuh</h3>
                            <p class="feature-text">Dapatkan pendidikan berkualitas tanpa biaya dengan program beasiswa penuh untuk seluruh siswa.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <h3 class="feature-title">Kurikulum Industri</h3>
                            <p class="feature-text">Kurikulum yang dirancang sesuai kebutuhan industri IT terkini untuk mempersiapkan siswa siap kerja.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <h3 class="feature-title">Kerjasama Industri</h3>
                            <p class="feature-text">Bekerjasama dengan berbagai perusahaan teknologi untuk program magang dan penempatan kerja.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Features Section -->

    </main>

    <footer id="footer" class="footer">
        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Alena Alfiana</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/php-email-form/validate.js"></script>
    <script src="asset/vendor/aos/aos.js"></script>
    <script src="asset/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="asset/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="asset/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="asset/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="asset/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="asset/js/main.js"></script>

</body>

</html>
