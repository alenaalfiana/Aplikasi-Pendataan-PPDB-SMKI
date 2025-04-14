<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Home - SMK Informatika Utama</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="asset/img/favicon.png" rel="icon">
    <link href="asset/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="asset/vendor/aos/aos.css" rel="stylesheet">
    <link href="asset/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="asset/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="asset/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: eNno
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="asset/img/smki-utama.png" alt="" style="width: 80px; height: 80px; margin: 5px 0;">
                <h1 class="sitename">SMKI UTAMA</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    @if (Route::has('login'))
                    @auth
                        @if (Auth::check())
                            @if (Auth::user()->role_as == 1)
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            @elseif(Auth::user()->role_as == 2)
                                <a href="{{ route('teacher.dashboard') }}">Dashboard</a>
                            @else
                                <a href="{{ route('user.dashboard') }}">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ url('/') }}">Home</a>
                        @endif
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Registrasi</a></li>
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
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="fade-up">
                        <h1>Aplikasi Pendataan
                            <br>PPDB Sekolah Gratis
                            <br>SMK Informatika Utama</h1>
                        <p>Sekolah Teknologi Informasi (TI) yang berbeasiswa full.</p>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <img src="asset/img/hero-img.png" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->
        <div class="testimonial-item" "="">



                                                                                                              </main>

                                                                                                              <footer id="
            footer" class="footer">

            <div class="container copyright text-center mt-4">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">Alena Alfiana</strong> <span>All Rights
                        Reserved</span></p>
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
