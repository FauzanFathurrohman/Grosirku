@extends('layouts.app')

@section('title', 'Dashboard Pengguna - Grosirku') {{-- Judul halaman yang lebih spesifik --}}

@section('content')

<div class="container py-5">
    {{-- Bagian Selamat Datang --}}
    <div class="card shadow-lg border-0 rounded-4 mb-5 p-4 p-md-5 bg-gradient-primary text-white" data-aos="fade-up" data-aos-duration="1000">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start">
                <h1 class="display-5 fw-bold mb-3 animate__animated animate__fadeInDown">
                    Halo, {{ Auth::user()->name }}!
                </h1>
                <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                    Selamat datang kembali di dashboard Grosirku. Siap untuk belanja hemat lagi?
                </p>
                <a href="{{ route('katalog.index') }}" class="btn btn-light btn-lg rounded-pill animate__animated animate__bounceIn animate__delay-2s">
                    Mulai Belanja Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                {{-- Ilustrasi atau ikon besar --}}
                <i class="bi bi-shop-window display-1 text-white-50 animate__animated animate__zoomIn animate__delay-1-5s"></i>
            </div>
        </div>
    </div>

    {{-- Bagian Akses Cepat --}}
    <h2 class="text-center fw-bold mb-4 section-title" data-aos="fade-up" data-aos-delay="300">Akses Cepat</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
        {{-- Kartu Katalog --}}
        <div class="col" data-aos="fade-up" data-aos-delay="400">
            <div class="card h-100 shadow-sm border-0 rounded-4 text-center quick-access-card">
                <div class="card-body p-4">
                    <i class="bi bi-grid-fill display-4 mb-3 text-primary"></i>
                    <h5 class="card-title fw-bold">Jelajahi Katalog</h5>
                    <p class="card-text text-muted">Temukan produk terbaru dan promo menarik.</p>
                    <a href="{{ route('katalog.index') }}" class="btn btn-outline-primary btn-sm mt-2">Lihat Katalog <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        {{-- Kartu Keranjang --}}
        <div class="col" data-aos="fade-up" data-aos-delay="500">
            <div class="card h-100 shadow-sm border-0 rounded-4 text-center quick-access-card">
                <div class="card-body p-4">
                    <i class="bi bi-cart-fill display-4 mb-3 text-success"></i>
                    <h5 class="card-title fw-bold">Keranjang Belanja</h5>
                    <p class="card-text text-muted">Periksa item di keranjang Anda sebelum checkout.</p>
                    <a href="{{ route('cart.cart') }}" class="btn btn-outline-success btn-sm mt-2">Lihat Keranjang <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        {{-- Kartu Pesanan Saya --}}
        <div class="col" data-aos="fade-up" data-aos-delay="600">
            <div class="card h-100 shadow-sm border-0 rounded-4 text-center quick-access-card">
                <div class="card-body p-4">
                    <i class="bi bi-box-seam-fill display-4 mb-3 text-info"></i>
                    <h5 class="card-title fw-bold">Pesanan Saya</h5>
                    <p class="card-text text-muted">Lacak status pesanan dan lihat riwayat belanja.</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-info btn-sm mt-2">Lacak Pesanan <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        {{-- Kartu Edit Profil --}}
        <div class="col" data-aos="fade-up" data-aos-delay="700">
            <div class="card h-100 shadow-sm border-0 rounded-4 text-center quick-access-card">
                <div class="card-body p-4">
                    <i class="bi bi-person-circle display-4 mb-3 text-warning"></i>
                    <h5 class="card-title fw-bold">Edit Profil</h5>
                    <p class="card-text text-muted">Perbarui informasi pribadi dan alamat pengiriman.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning btn-sm mt-2">Kelola Profil <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Rekomendasi atau Informasi Tambahan (Opsional) --}}
    <div class="text-center py-4" data-aos="fade-up" data-aos-delay="800">
        <p class="lead text-muted">
            Butuh bantuan atau ada pertanyaan? Kunjungi halaman <a href="{{ route('about.us') }}" class="text-decoration-none fw-bold text-primary">Tentang Kami</a> atau hubungi layanan pelanggan kami.
        </p>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* Custom styles for dashboard specific elements */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd, #007bff); /* Gradien biru yang menarik */
        position: relative;
        overflow: hidden;
    }
    .bg-gradient-primary::before {
        content: '';
        position: absolute;
        top: -20%;
        left: -20%;
        width: 140%;
        height: 140%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
        animation: rotateBg 20s linear infinite;
        z-index: 0;
    }
    @keyframes rotateBg {
        0% { transform: rotate(0deg) scale(1); }
        50% { transform: rotate(180deg) scale(1.1); }
        100% { transform: rotate(360deg) scale(1); }
    }

    .card.bg-gradient-primary h1,
    .card.bg-gradient-primary p {
        position: relative; /* Pastikan teks di atas pseudo-element */
        z-index: 1;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 40px;
        color: #343a40; /* Warna judul yang lebih gelap */
    }
    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: #0d6efd; /* Warna primary Bootstrap */
        border-radius: 5px;
    }

    .quick-access-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .quick-access-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    .quick-access-card .card-body i {
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .quick-access-card:hover .card-body i {
        transform: scale(1.1);
    }

    /* Override Bootstrap button colors for quick access cards to match text */
    .btn-outline-primary {
        color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }
    .btn-outline-success {
        color: #198754;
        border-color: #198754;
    }
    .btn-outline-success:hover {
        background-color: #198754;
        color: white;
    }
    .btn-outline-info {
        color: #0dcaf0;
        border-color: #0dcaf0;
    }
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: white;
    }
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .card.bg-gradient-primary {
            padding: 30px;
        }
        .card.bg-gradient-primary h1 {
            font-size: 2.5rem;
        }
        .card.bg-gradient-primary p {
            font-size: 1rem;
        }
        .btn-light.btn-lg {
            padding: 10px 20px;
            font-size: 1rem;
        }
        .section-title {
            font-size: 1.8rem;
        }
        .quick-access-card .card-body i {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@push('scripts')
{{-- Tidak ada script spesifik di sini selain AOS.init() yang sudah ada di app.blade.php --}}
@endpush
