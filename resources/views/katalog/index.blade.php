@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa; /* Latar belakang lebih terang */
    }
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 40px;
        color: #28a745; /* Warna hijau untuk judul */
        font-size: 2.5rem;
        font-weight: 700;
    }
    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 100px;
        height: 5px;
        background-color: #28a745;
        border-radius: 5px;
    }

    /* Style untuk Form Filter */
    .filter-section {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
    }
    .filter-section .form-control,
    .filter-section .form-select {
        border-radius: 10px;
        border-color: #ced4da;
        padding: 10px 15px;
    }
    .filter-section .btn-primary {
        background-color: #28a745;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    .filter-section .btn-primary:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    .filter-section .btn-secondary { /* Untuk tombol reset jika ditambahkan */
        border-radius: 10px;
        padding: 10px 20px;
    }


    /* Style untuk Product Card */
    .product-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
    }
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    .product-card .card-img-top {
        height: 220px; /* Tinggi gambar produk yang seragam */
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        filter: grayscale(0%); /* Efek grayscale */
        transition: filter 0.3s ease;
    }
    .product-card:hover .card-img-top {
        filter: grayscale(0%); /* Menghilangkan grayscale saat hover */
    }
    .product-card .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
    }
    .product-card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #343a40;
        height: 50px; /* Tinggi tetap untuk judul */
        overflow: hidden;
        margin-bottom: 8px;
    }
    .product-card .price-badge {
        font-size: 1.1rem;
        font-weight: bold;
        background-color: #28a745;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 10px;
    }
    .product-card .card-text {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.5;
        min-height: 40px; /* Tinggi minimal untuk deskripsi singkat */
        overflow: hidden;
        margin-bottom: 10px;
    }
    .product-card .rating-stars {
        color: #ffc107; /* Warna bintang emas */
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    .product-card .stock-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        z-index: 10;
        background-color: rgba(220, 53, 69, 0.9); /* Merah gelap transparan */
        color: white;
    }
    .product-card .no-image-placeholder {
        background-color: #e9ecef;
        color: #6c757d;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .product-card .quantity-input {
        width: 70px;
        text-align: center;
        border-radius: 8px;
        border: 1px solid #ced4da;
    }
    .product-card .btn-add-cart {
        background-color: #28a745;
        border: none;
        border-radius: 10px;
        padding: 10px 15px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .product-card .btn-add-cart:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }
    .product-card .btn-add-cart:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }

    /* Pagination Styling */
    .pagination .page-item .page-link {
        border-radius: 8px;
        margin: 0 4px;
        color: #28a745;
        border: 1px solid #28a745;
        transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }
    .pagination .page-item .page-link:hover {
        background-color: #28a745;
        color: #fff;
        border-color: #28a745;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        border-color: #dee2e6;
    }

    /* No Product Found Alert */
    .alert-info {
        background-color: #e0f7fa;
        color: #007bff;
        border-color: #b3e5fc;
        border-radius: 10px;
        padding: 20px;
        font-size: 1.1rem;
    }

    /* Responsif */
    @media (max-width: 767px) {
        .section-title {
            font-size: 2rem;
        }
        .filter-section {
            padding: 15px;
        }
        .filter-section .col-md-2 {
            margin-top: 10px;
        }
        .product-card .card-img-top,
        .product-card .no-image-placeholder {
            height: 180px;
        }
        .product-card .card-title {
            font-size: 1.1rem;
            height: auto; /* Allow height to adjust for smaller screens */
            min-height: unset;
        }
        .product-card .price-badge {
            font-size: 1rem;
            padding: 6px 10px;
        }
        .product-card .card-text {
            font-size: 0.85rem;
            min-height: unset;
        }
        .product-card .btn-add-cart {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
    }
</style>

<div class="container py-5">
    <h2 class="section-title text-center" data-aos="fade-up">Katalog Produk</h2>
    <p class="text-center text-muted mb-5 lead" data-aos="fade-up" data-aos-delay="100">Temukan berbagai kebutuhan grosir dengan harga terbaik.</p>

    <div class="filter-section shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <form method="GET" action="{{ route('katalog.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5 col-lg-4">
                <label for="search-input" class="form-label visually-hidden">Cari produk...</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-pill"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" id="search-input" class="form-control border-start-0 rounded-end-pill" placeholder="Cari nama produk..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <label for="category-select" class="form-label visually-hidden">Pilih Kategori</label>
                <select name="category" id="category-select" class="form-select rounded-pill">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-lg-2 d-grid">
                <button class="btn btn-primary rounded-pill" type="submit">
                    <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                </button>
            </div>
            @if(request('q') || request('category'))
            <div class="col-md-3 col-lg-3 d-grid">
                <a href="{{ route('katalog.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-x-circle me-1"></i> Reset Filter
                </a>
            </div>
            @endif
        </form>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="card h-100 product-card">
                    {{-- Stok habis --}}
                    @if($product->stock <= 0)
                        <span class="stock-badge animate__animated animate__fadeInDown">Stok Habis</span>
                    @endif

                    {{-- Gambar --}}
                    @if($product->image)
                        <img src="{{ asset('uploads/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="no-image-placeholder">
                            <i class="bi bi-image-fill me-2"></i> Tidak ada gambar
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <span class="price-badge">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <p class="card-text">{{ Str::limit($product->description, 70) }}</p>

                        {{-- Rating Dummy (bisa diganti dengan data asli) --}}
                        <div class="rating-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <i class="bi bi-star"></i>
                            <small class="text-muted ms-1">(4.5)</small>
                        </div>

                        {{-- Form Keranjang --}}
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-auto">
                            @csrf
                            <div class="d-flex align-items-center mb-3">
                                <label for="quantity_{{ $product->id }}" class="form-label m-0 me-2 small text-muted">Jumlah:</label>
                                <input type="number" name="quantity" id="quantity_{{ $product->id }}" class="form-control form-control-sm quantity-input" value="1" min="1" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            </div>
                            <button class="btn btn-success w-100 btn-add-cart" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus-fill me-1"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5" data-aos="fade-in" data-aos-delay="300">
                <div class="alert alert-info d-inline-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill fs-3 me-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1">Produk Tidak Ditemukan!</h4>
                        <p class="mb-0">Maaf, tidak ada produk yang cocok dengan pencarian atau filter Anda.</p>
                        <a href="{{ route('katalog.index') }}" class="alert-link fw-bold mt-2 d-inline-block">Lihat Semua Produk</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="400">
        {{ $products->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 100 }); // Inisialisasi AOS
</script>

@endsection