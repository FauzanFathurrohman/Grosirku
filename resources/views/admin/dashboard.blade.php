@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5; /* Latar belakang abu-abu muda */
    }

    .dashboard-header {
        background: linear-gradient(to right, #007bff, #0056b3); /* Gradien biru */
        color: white;
        padding: 40px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(0, 123, 255, 0.2);
    }
    .dashboard-header h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .dashboard-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .action-buttons-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Jarak antar tombol */
        margin-top: 20px;
    }
    .action-buttons-group .btn {
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .action-buttons-group .btn-outline-secondary {
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
    }
    .action-buttons-group .btn-outline-secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }
    .action-buttons-group .btn-outline-success {
        border-color: #28a745;
        color: #28a745;
    }
    .action-buttons-group .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }
    .action-buttons-group .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }
    .action-buttons-group .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }
    .action-buttons-group .btn-primary,
    .action-buttons-group .btn-warning,
    .action-buttons-group .btn-info {
        color: white;
    }


    /* Statistik Card */
    .card-statistic {
        border-radius: 15px; /* Sedikit lebih kecil dari header */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
        background-color: white;
        height: 100%; /* Pastikan tingginya sama */
    }

    .card-statistic:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .card-statistic .card-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        height: 100%;
    }

    .card-statistic .icon {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 3rem; /* Lebih besar */
        opacity: 0.15;
        color: rgba(255,255,255,0.7); /* Warna ikon disesuaikan dengan background */
    }

    .card-statistic h5 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: #f8f9fa; /* Warna teks untuk statistik */
        font-weight: 500;
        z-index: 1; /* Pastikan teks di atas ikon */
    }

    .card-statistic h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0;
        color: white; /* Warna angka statistik */
        z-index: 1;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(45deg, #28a745 0%, #218838 100%);
    }
    .bg-gradient-danger {
        background: linear-gradient(45deg, #dc3545 0%, #a71d2a 100%);
    }

    /* Bagian Daftar (Penjualan/Produk) */
    .section-heading {
        font-size: 1.8rem;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }
    .section-heading .bi {
        margin-right: 12px;
        color: #007bff;
    }

    .list-group-item {
        border: 1px solid #e9ecef; /* Border lebih jelas */
        border-radius: 8px; /* Sudut sedikit melengkung */
        margin-bottom: 8px;
        padding: 15px 20px;
        transition: all 0.2s ease;
        background-color: #fff;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
        border-color: #cce5ff;
    }
    .list-group-item:last-child {
        margin-bottom: 0;
    }
    .list-group-item .item-label {
        font-weight: 600;
        color: #495057;
    }
    .list-group-item .item-value {
        font-weight: bold;
        font-size: 1.1rem;
    }
    .list-group-item .item-value.text-success {
        color: #28a745 !important;
    }
    .list-group-item .item-value.text-primary {
        color: #007bff !important;
    }

    .empty-state {
        background-color: #e9f5ff;
        color: #007bff;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 500;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* Filter form */
    .filter-form-group {
        background-color: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        display: flex;
        align-items: flex-end;
        gap: 15px;
        margin-bottom: 40px; /* Jarak dengan statistik */
    }
    .filter-form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
        display: block;
    }
    .filter-form-group .form-select {
        border-radius: 8px;
        border-color: #ced4da;
        padding: 0.6rem 1rem;
        height: auto;
    }
    .filter-form-group .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        height: auto;
    }

    /* Responsif */
    @media (max-width: 991px) {
        .dashboard-header {
            padding: 30px 0;
        }
        .dashboard-header h1 {
            font-size: 2.2rem;
        }
        .dashboard-header p {
            font-size: 1rem;
        }
        .action-buttons-group {
            flex-direction: column;
            gap: 8px;
        }
        .action-buttons-group .btn {
            width: 100%; /* Tombol memenuhi lebar */
        }
        .filter-form-group {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .filter-form-group .form-select,
        .filter-form-group .btn {
            width: 100%;
        }
        .card-statistic .card-body {
            padding: 1.5rem;
        }
        .card-statistic h3 {
            font-size: 2rem;
        }
        .section-heading {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .list-group-item {
            padding: 12px 15px;
            font-size: 0.9rem;
        }
        .list-group-item .item-value {
            font-size: 1rem;
        }
    }

    @media (max-width: 575px) {
        .dashboard-header {
            padding: 25px 0;
            text-align: center;
        }
        .dashboard-header h1 {
            font-size: 1.8rem;
        }
        .dashboard-header p {
            font-size: 0.9rem;
        }
        .card-statistic .icon {
            font-size: 2.5rem;
            top: 10px;
            right: 15px;
        }
    }

</style>

<div class="container py-5">
    <div class="dashboard-header text-center mb-5" data-aos="fade-down">
        <div class="container">
            <h1><i class="bi bi-speedometer2 me-3"></i>Dashboard Admin</h1>
            <p class="lead">Selamat datang di panel admin Anda. Kelola toko dan lihat statistik penjualan!</p>
            <div class="action-buttons-group">
                <a class="btn btn-outline-light" href="{{ route('admin.export.pdf') }}" data-aos="zoom-in" data-aos-delay="100">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
                </a>
                <a class="btn btn-light text-primary" href="{{ route('admin.products.create') }}" data-aos="zoom-in" data-aos-delay="400">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
                </a>
                {{-- Perhatikan bahwa route('admin.products.store') adalah untuk menyimpan, bukan mengedit.
                     Asumsi Anda ingin link ke daftar produk untuk diedit, biasanya admin.products.index --}}
                <a class="btn btn-warning" href="{{ route('admin.products.index') }}" data-aos="zoom-in" data-aos-delay="500">
                    <i class="bi bi-pencil-square me-2"></i> Kelola Produk
                </a>
                <a class="btn btn-info text-white" href="{{ route('admin.orders.index') }}" data-aos="zoom-in" data-aos-delay="600">
                    <i class="bi bi-graph-up me-2"></i> Laporan Penjualan
                </a>
            </div>
        </div>
    </div>


    <div class="row g-4">
        {{-- TOP 5 PRODUK TERLARIS --}}
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="1200">
            <div class="card shadow p-4 rounded-3 h-100">
                <h4 class="section-heading"><i class="bi bi-fire"></i> 5 Produk Terlaris</h4>
                <ul class="list-group list-group-flush">
                    @forelse ($topProducts as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="item-label">{{ $product->name }}</span>
                            <span class="item-value text-primary">{{ $product->total_qty }} terjual</span>
                        </li>
                    @empty
                        <li class="list-group-item empty-state">Belum ada produk terjual.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 }); // Inisialisasi AOS
</script>
@endsection