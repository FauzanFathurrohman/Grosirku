@extends('layouts.app')

@section('content')

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background: #f8f9fa; /* Warna latar belakang lebih terang */
    }
    .hero {
        background: linear-gradient(to right, #e0ffe0, #c6f0cd); /* Gradien lebih lembut */
        border-radius: 20px;
        position: relative; /* Untuk positioning elemen di dalamnya */
        overflow: hidden; /* Memastikan tidak ada luapan */
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(40, 167, 69, 0.1); /* Efek lingkaran transparan */
        border-radius: 50%;
        animation: heroBlob1 15s infinite alternate;
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: -70px;
        right: -70px;
        width: 250px;
        height: 250px;
        background: rgba(40, 167, 69, 0.08);
        border-radius: 50%;
        animation: heroBlob2 18s infinite alternate;
    }
    @keyframes heroBlob1 {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(100px, 50px) scale(1.2); }
    }
    @keyframes heroBlob2 {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(-80px, -40px) scale(1.1); }
    }

    .btn-primary {
        background-color: #28a745;
        border: none;
        transition: all 0.3s ease-in-out;
        padding: 12px 30px; /* Ukuran tombol lebih besar */
        border-radius: 30px; /* Sudut lebih melengkung */
        font-weight: bold;
    }
    .btn-primary:hover {
        background-color: #218838;
        transform: translateY(-3px); /* Efek angkat */
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3); /* Tambah bayangan */
    }
    .feature-box,
    .fitur-box,
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px; /* Sudut lebih melengkung */
        overflow: hidden; /* Memastikan gambar produk tidak keluar dari border-radius */
    }
    .feature-box:hover,
    .fitur-box:hover,
    .product-card:hover {
        transform: translateY(-8px); /* Angkatan sedikit lebih tinggi */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15); /* Bayangan lebih jelas */
    }
    .fitur-icon {
        font-size: 56px; /* Ikon lebih besar */
        transition: transform 0.4s ease, color 0.3s;
        color: #28a745; /* Warna ikon hijau */
    }
    .fitur-box:hover .fitur-icon {
        transform: scale(1.25) rotate(7deg); /* Efek rotasi dan skala lebih menonjol */
        color: #198754;
        text-shadow: 0 0 15px rgba(25, 135, 84, 0.6); /* Bayangan teks lebih kuat */
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .carousel-caption {
        background: rgba(0, 0, 0, 0.6); /* Latar belakang caption lebih solid */
        border-radius: 10px;
        padding: 15px;
    }
    .carousel-caption h5 {
        font-size: 1.8rem;
        font-weight: bold;
    }
    .carousel-caption p {
        font-size: 1.1rem;
    }
    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 40px;
    }
    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: #28a745;
        border-radius: 5px;
    }
    .product-card .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .video-section {
        position: relative;
        overflow: hidden;
        min-height: 450px; /* Tinggi minimum untuk video */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
    }
    .video-section video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: 1;
        transform: translate(-50%, -50%);
        background-size: cover;
    }
    .video-section .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Overlay lebih gelap */
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        border-radius: 20px;
        border: none;
    }
    .modal-header {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }
    .modal-body img {
        border-radius: 10px;
    }

    /* Responsif */
    @media (max-width: 767px) {
        h1 {
            font-size: 2rem;
        }
        h2 {
            font-size: 1.8rem;
        }
        h5 {
            font-size: 1.2rem;
        }
        .btn-lg {
            font-size: 0.9rem;
            padding: 0.7rem 1.5rem;
        }
        .fitur-icon {
            font-size: 48px;
        }
        .carousel-caption {
            font-size: 0.8rem;
            padding: 10px;
        }
        .carousel-caption h5 {
            font-size: 1.1rem;
        }
        .hero {
            padding: 3rem 1rem;
        }
        .video-section {
            min-height: 300px;
        }
    }
</style>

<div class="container py-4">

    <div id="promoCarousel" class="carousel slide mb-5 shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach([0, 1, 2, 3] as $i)
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach([
                ['img' => 'memberday.png', 'title' => 'Belanja Sembako Hemat!', 'text' => 'Harga grosir terbaik, kualitas premium. Jangan lewatkan promo spesial kami!', 'link' => route('katalog.index'), 'link_text' => 'Lihat Produk'],
                ['img' => 'promogajian.png', 'title' => 'Pengiriman Super Cepat!', 'text' => 'Pesanan Anda tiba dalam 1x24 jam. Praktis tanpa ribet.', 'link' => '#', 'link_text' => 'Pelajari Lebih Lanjut'],
                ['img' => 'promojsm.png', 'title' => 'Diskon Gajian Spesial!', 'text' => 'Nikmati diskon besar dan cashback menarik. Belanja sekarang, untung lebih banyak!', 'link' => route('katalog.index'), 'link_text' => 'Ambil Promonya'],
                ['img' => 'event.png', 'title' => 'Gabung Komunitas Kami!', 'text' => 'Dapatkan info terbaru, promo eksklusif, dan tips menarik seputar belanja hemat.', 'link' => '#', 'link_text' => 'Daftar Sekarang']
            ] as $i => $slide)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <img src="{{ asset('img/' . $slide['img']) }}" class="d-block w-100 object-fit-cover" style="height: 500px;" alt="{{ $slide['title'] }}">
                <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInUp">
                    <img src="{{ asset('img/logo.png') }}" alt="Grosirku" height="60" class="mb-3 animate__animated animate__zoomIn animate__delay-1s">
                    <h5 class="text-white animate__animated animate__fadeInDown animate__delay-1s">{{ $slide['title'] }}</h5>
                    <p class="text-light animate__animated animate__fadeInUp animate__delay-1s">{{ $slide['text'] }}</p>
                    <a href="{{ $slide['link'] }}" class="btn btn-success btn-lg mt-3 animate__animated animate__bounceIn animate__delay-2s">{{ $slide['link_text'] }} <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="text-center py-5 px-3 hero shadow-lg mb-5 rounded-4" data-aos="fade-up" data-aos-duration="1200">
        <h1 class="display-3 fw-bold text-success animate__animated animate__fadeInDown">Selamat Datang di Grosirku!</h1>
        <p class="lead text-muted mt-4 animate__animated animate__fadeInUp animate__delay-1s">
            Temukan <b>kemudahan</b> berbelanja kebutuhan pokok dan barang grosir lainnya <b>langsung dari rumah Anda</b>.
        </p>
        <p class="lead text-muted animate__animated animate__fadeInUp animate__delay-1-5s">
            <b>menjamin harga terbaik</b> pengiriman <b>cepat</b>, dan transaksi <b>aman</b>. Belanja cerdas, hidup hemat!
        </p>
        <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" class="img-fluid my-5 animate__animated animate__zoomIn animate__delay-2s" alt="Ilustrasi belanja" style="max-height: 250px;">
        <div class="mt-4 animate__animated animate__fadeInUp animate__delay-2-5s">
            <a href="{{ route('katalog.index') }}" class="btn btn-primary btn-lg me-3">Mulai Belanja <i class="fas fa-shopping-cart ms-2"></i></a>
            <a href="{{ route('about.us') }}" class="btn btn-outline-success btn-lg">Tentang Kami <i class="fas fa-info-circle ms-2"></i></a>
        </div>
    </div>

    <hr class="my-5">

    <section class="py-5">
        <h2 class="text-center fw-bold section-title" data-aos="fade-up">Kenapa Harus Grosirku?</h2>
        <div class="row mt-5">
            @foreach([
                ['icon' => 'fa-shield-alt', 'title' => 'Transaksi Aman & Terjamin', 'desc' => 'Sistem pembayaran terenkripsi dan jaminan barang sampai tujuan dengan selamat.'],
                ['icon' => 'fa-truck-fast', 'title' => 'Pengiriman Cepat & Tepat', 'desc' => 'Pesanan diproses dan dikirim dalam 1x24 jam. Tracking real-time tersedia.'],
                ['icon' => 'fa-tags', 'title' => 'Harga Grosir Terbaik', 'desc' => 'Dapatkan harga paling kompetitif langsung dari distributor terpercaya.'],
                ['icon' => 'fa-handshake', 'title' => 'Layanan Pelanggan Responsif', 'desc' => 'Tim kami siap membantu Anda kapan saja untuk pengalaman belanja terbaik.']
            ] as $i => $feature)
            <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">
                <div class="card h-100 text-center p-3 shadow-sm fitur-box">
                    <div class="card-body">
                        <i class="fas {{ $feature['icon'] }} fitur-icon mb-3"></i>
                        <h5 class="fw-bold">{{ $feature['title'] }}</h5>
                        <p class="text-muted">{{ $feature['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <hr class="my-5">

    <section class="py-5">
        <h2 class="text-center fw-bold section-title" data-aos="fade-up">✨ Produk Unggulan Kami ✨</h2>
        <div class="row justify-content-center mt-5">
            @foreach([
                ['title' => 'Beras Premium "Super Pulen"', 'desc' => 'Beras pilihan dengan kualitas terbaik, cocok untuk hidangan keluarga Anda.', 'price' => 'Rp 85.000 / 5kg', 'img' => 'beras.png'],
                ['title' => 'Minyak Goreng Sawit Murni', 'desc' => 'Minyak goreng berkualitas tinggi, sehat, dan jernih. Cocok untuk semua masakan.', 'price' => 'Rp 38.000 / 2L', 'img' => 'minyak.png'],
                ['title' => 'Mie Instan Rasa Kari Ayam', 'desc' => 'Mie instan favorit dengan rasa kari ayam yang kaya dan nikmat. Praktis dan lezat!', 'price' => 'Rp 3.000 / bungkus', 'img' => 'indomie.png']
            ] as $i => $p)
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 150 }}">
                <div class="card h-100 shadow-lg product-card">
                    <img src="{{ asset('img/' . $p['img']) }}" class="card-img-top object-fit-cover" alt="{{ $p['title'] }}" style="height: 250px;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-success">{{ $p['title'] }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ $p['desc'] }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="badge bg-success fs-5 p-2">{{ $p['price'] }}</span>
                            <a href="{{ route('katalog.index') }}" class="btn btn-outline-success btn-sm"><i class="fas fa-cart-plus me-1"></i> Beli</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4 py-2">
                Jelajahi Semua Produk <i class="fas fa-box-open ms-2"></i>
            </a>
        </div>
    </section>

    <hr class="my-5">

    <section class="video-section rounded-4 shadow-lg mb-5" data-aos="zoom-in">
        <video autoplay muted loop playsinline class="object-fit-cover">
            <source src="https://www.w3schools.com/howto/rain.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay animate__animated animate__fadeIn">
            <h2 class="display-4 fw-bold animate__animated animate__fadeInDown animate__delay-1s">Belanja Grosir, Lebih Mudah, Lebih Untung!</h2>
            <p class="lead text-white-50 mt-3 mb-4 animate__animated animate__fadeInUp animate__delay-1-5s">
                Nikmati kemudahan berbelanja tanpa batas, kapan pun, di mana pun.
            </p>
            <a href="{{ route('katalog.index') }}" class="btn btn-light btn-lg rounded-pill mt-3 animate__animated animate__bounceIn animate__delay-2s">
                Mulai Belanja Sekarang! <i class="fas fa-chevron-right ms-2"></i>
            </a>
        </div>
    </section>

    <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg animate__animated animate__zoomIn">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="promoModalLabel"><i class="fas fa-gift me-2"></i> Promo Spesial Hanya Untuk Anda!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4 d-flex flex-column flex-md-row align-items-center">
                    <img src="{{ asset('img/iklan.png') }}" alt="Promo Gajian" class="img-fluid rounded me-md-4 mb-3 mb-md-0" style="max-width: 250px;">
                    <div>
                        <h4 class="fw-bold text-success mb-2">Diskon Fantastis Hingga 50% Menanti!</h4>
                        <p class="text-muted mb-3">
                            Khusus untuk Anda pelanggan setia dan pengunjung pertama, nikmati potongan harga langsung untuk berbagai produk favorit. Jangan sampai ketinggalan!
                        </p>
                        <ul class="list-unstyled mb-3">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Ribuan produk pilihan</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Harga dijamin termurah</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Pengiriman cepat dan aman</li>
                        </ul>
                        <a href="{{ route('katalog.index') }}" class="btn btn-success btn-lg mt-2 rounded-pill">
                            Lihat Katalog & Klaim Diskonnya! <i class="fas fa-tags ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true, offset: 50 }); // AOS lebih responsif

    document.addEventListener("DOMContentLoaded", function () {
        const modalId = 'promoModal';
        const lastShown = localStorage.getItem('popupShownAt');
        const now = new Date();

        // Tampilkan modal hanya sekali per hari
        if (!lastShown || new Date(lastShown).toDateString() !== now.toDateString()) {
            setTimeout(function () {
                const promoModal = new bootstrap.Modal(document.getElementById(modalId));
                promoModal.show();
                localStorage.setItem('popupShownAt', now);
            }, 3000); // Tampilkan setelah 3 detik
        }

        // Auto-play carousel
        var myCarousel = document.querySelector('#promoCarousel');
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000, // Ganti slide setiap 5 detik
            pause: 'hover' // Pause saat hover
        });
    });
</script>

@endsection