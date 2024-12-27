<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    {{-- navbar section --}}
    <nav class="navbar navbar-expand-lg bg-body fixed-top shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/landingPage/medipet 2.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-5" href="#footer">Kontak</a>
                    </li>
                    <a href="{{ url('/login') }}" class="btn btn-outline-violet shadow-sm d-sm d-block">Login</a>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content">
        {{-- Hero Section --}}
        <section class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Bagian Teks -->
                    <div class="col-md-6 col-12 mb-4 mb-md-0 text-md-start text-center">
                        <div class="text">
                            <h1 class="fw-bold mb-3">
                                Ciptakan Momen Indah Bersama Hewan Kesayangan Anda.
                            </h1>
                            <p class="lead">
                                <strong>Medipet </strong> hadir untuk memastikan hewan peliharaan Anda mendapatkan
                                perawatan terbaik.
                                💖 Perawatan Terbaik Dimulai di Sini. Ayo, daftarkan sekarang dan wujudkan kebahagiaan
                                bersama teman berbulu Anda! 🐾
                            </p>
                            <a href="{{ route('register') }}" class="btn btn-primary mt-3 shadow-lg">Daftar Sekarang</a>
                        </div>
                    </div>
                    <!-- Bagian Gambar -->
                    <div class="col-md-6 col-12 text-center">
                        <div class="img mx-auto">
                            <img src="{{ asset('img/landingPage/gambar.png') }}" alt="Hero" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- setup section --}}
    <div class="content">
        <section id="layanan" class="layanan">
            <div class="container">
                <div class="text-header text-center">
                    <h3>Layanan</h3>
                    <p>Medipet menyediakan berbagai layanan untuk mendukung kebutuhan kesehatan dan perawatan hewan
                        peliharaan Anda.
                        Kami menawarkan layanan konsultasi medis, pemeriksaan kesehatan, vaksinasi, perawatan rutin,
                        hingga perawatan darurat
                        yang didukung oleh profesional medis berpengalaman. Dengan tujuan memberikan pelayanan terbaik
                        bagi hewan peliharaan Anda,
                        Medipet siap membantu dengan solusi yang terjangkau dan terpercaya.</p><br><br>
                </div>
                <div class="items text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="icons">
                                <img src="{{ asset('img/landingPage/pet-carrier_1614375.png') }}" alt="">
                            </div>
                            <div class="desc">
                                <h5>Pet Hotel</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem at corporis eligendi
                                    consectetur, sunt optio,
                                    ipsa aliquid natus est minus quo dicta numquam earum repellat pariatur deleniti
                                    doloribus magni ut.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem at corporis eligendi
                                    consectetur.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icons">
                                <img src="{{ asset('img/landingPage/pet-friendly_12141108.png') }}" alt="">
                            </div>
                            <div class="desc">
                                <h5>Grooming</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem at corporis eligendi
                                    consectetur, sunt optio,
                                    ipsa aliquid natus est minus quo dicta numquam earum repellat pariatur deleniti
                                    doloribus magni ut.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem at corporis eligendi
                                    consectetur.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icons">
                                <img src="{{ asset('img/landingPage/veterinary_16862640.png') }}" alt="">
                            </div>
                            <div class="desc">
                                <h5>Vaksin</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem at corporis eligendi
                                    consectetur, sunt optio,
                                    ipsa aliquid natus est minus quo dicta numquam earum repellat pariatur deleniti
                                    doloribus magni ut.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem at corporis eligendi
                                    consectetur.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- produk section --}}
    <section id="produk" class="produk">
        <div class="container">
            <!-- Judul Produk -->
            <div class="text-center">
                <h3>Produk</h3>
                {{-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure similique iusto eaque nisi, excepturi vel quasi omnis provident perspiciatis,
                    id optio doloremque cumque, aut accusamus numquam asperiores necessitatibus quidem. Nostrum?
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim error optio ab facilis aut?
                Iste harum veritatis aperiam porro ab fugit at repellendus dolor similique itaque! Eligendi vel quo debitis!</p> <br><br> --}}
            </div>
            <div class="row info-1">
                {{-- gambar --}}
                <div class="col-md-6 order-md-2">
                    <img src="{{ asset('img/landingPage/produk1.jpg') }}" alt="">
                </div>
                {{-- text --}}
                <div class="col-md-6 order-md-1">
                    <div class="text-produk">
                        <h5>Wiskhas</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi commodi porro consectetur
                            voluptas, nostrum minima ratione.
                            Nulla eveniet dolorum quibusdam pariatur architecto, at nostrum incidunt, enim iure dolorem,
                            corporis laboriosam.</p>
                    </div>
                </div>
            </div>
            <div class="row info-2">
                {{-- gambar --}}
                <div class="col-md-6 order-md-1">
                    <img src="{{ asset('img/landingPage/produk4.png') }}" alt="">
                </div>
                {{-- text --}}
                <div class="col-md-6 order-md-2">
                    <div class="text-produk">
                        <h5>Happy Cat</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi commodi porro consectetur
                            voluptas, nostrum minima ratione.
                            Nulla eveniet dolorum quibusdam pariatur architecto, at nostrum incidunt, enim iure dolorem,
                            corporis laboriosam.</p>
                    </div>
                </div>
            </div>
            <div class="row info-3">
                {{-- gambar --}}
                <div class="col-md-6 order-md-2">
                    <img src="{{ asset('img/landingPage/produk3.webp') }}" alt="">
                </div>
                {{-- text --}}
                <div class="col-md-6 order-md-1">
                    <div class="text-produk">
                        <h5>Royal Canin</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi commodi porro consectetur
                            voluptas, nostrum minima ratione.
                            Nulla eveniet dolorum quibusdam pariatur architecto, at nostrum incidunt, enim iure dolorem,
                            corporis laboriosam.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- footer section --}}
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row">
                <!-- Kolom pertama: Informasi Perusahaan -->
                <div class="col-md-4">
                    <h5>Medipet</h5>
                    <p>Memberikan solusi terbaik untuk kesehatan hewan peliharaan Anda dengan layanan berkualitas.</p>
                </div>

                <!-- Kolom kedua: Navigasi -->
                <div class="col-md-4">
                    <h5>Navigasi</h5>
                    <ul>
                        <li>Home</li>
                        <li>Layanan</li>
                        <li>Produk</li>
                        <li>Kontak</li>
                    </ul>
                </div>

                <!-- Kolom ketiga: Kontak -->
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <p>Email: info@medipet.com</p>
                    <p>Telp: (021) 12345678</p>
                    <p>Alamat: Jl. Contoh No. 123, Jakarta</p>
                </div>
            </div>

            <!-- Copyright -->
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; 2024 Medipet. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
