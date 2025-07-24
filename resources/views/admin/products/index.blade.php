@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5; /* Latar belakang abu-abu muda */
    }

    .header-section {
        background: linear-gradient(to right, #28a745, #218838); /* Gradien hijau */
        color: white;
        padding: 30px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(40, 167, 69, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .header-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }
    .header-section h2 .bi {
        font-size: 2.8rem;
        margin-right: 15px;
    }
    .header-section .btn {
        padding: 10px 25px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .header-section .btn-light-outline { /* Custom class for light outline button */
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }
    .header-section .btn-light-outline:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: white;
    }
    .header-section .btn-success {
        background-color: #1a7c36; /* Warna hijau sedikit lebih gelap */
        border-color: #1a7c36;
    }
    .header-section .btn-success:hover {
        background-color: #15622a;
        border-color: #125523;
    }

    /* Alert Success */
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success .bi {
        font-size: 1.5rem;
    }

    /* Table Styling */
    .table-container {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden; /* Penting untuk border-radius tabel */
    }

    .table {
        margin-bottom: 0; /* Hapus margin bawah default tabel */
    }

    .table thead th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        padding: 15px 20px;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        color: #343a40;
    }

    .table tbody td img {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        object-fit: cover; /* Pastikan gambar proporsional */
        height: 60px; /* Tinggi tetap */
        width: 60px; /* Lebar tetap */
    }

    /* Action Buttons within table */
    .table .btn-sm {
        padding: 8px 15px;
        font-size: 0.875rem;
        border-radius: 6px;
        display: inline-flex; /* Agar ikon dan teks sejajar */
        align-items: center;
        gap: 5px;
    }
    .table .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #343a40; /* Agar teks terlihat jelas */
    }
    .table .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
    .table .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .table .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Empty State */
    .empty-state {
        background-color: #e6f7ff; /* Biru muda */
        color: #007bff;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        font-size: 1.2rem;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    .empty-state .bi {
        font-size: 3rem;
        color: #007bff;
    }
    .empty-state p {
        margin-bottom: 0;
    }


    /* Responsif */
    @media (max-width: 991px) {
        .header-section {
            flex-direction: column;
            text-align: center;
            padding: 25px 0;
            gap: 15px;
        }
        .header-section h2 {
            font-size: 2rem;
            flex-direction: column;
            gap: 10px;
        }
        .header-section h2 .bi {
            font-size: 2.2rem;
            margin-right: 0;
        }
        .header-section .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
        }
        .header-section .btn {
            width: 100%;
        }
        .table thead {
            display: none; /* Sembunyikan header tabel di layar kecil */
        }
        .table, .table tbody, .table tr, .table td {
            display: block; /* Buat setiap baris dan sel menjadi blok */
            width: 100%;
        }
        .table tr {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            background-color: white;
            padding: 15px; /* Tambahkan padding ke setiap baris */
        }
        .table tbody td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border: none;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: calc(50% - 30px);
            text-align: left;
            font-weight: 600;
            color: #495057;
        }
        .table tbody td:first-child {
            padding-top: 15px;
        }
        .table tbody td:last-child {
            padding-bottom: 15px;
        }
        .table tbody td:nth-child(2) { /* Untuk kolom foto produk */
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .table tbody td:nth-child(2)::before { /* Label untuk foto */
            content: "Foto:";
        }
    }
</style>

<div class="container py-5">
    <div class="header-section mb-5 px-4" data-aos="fade-down">
        <h2>
            <i class="bi bi-box-seam-fill"></i> Kelola & Edit Produk
        </h2>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.products.create') }}" class="btn btn-light-outline" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light-outline" data-aos="zoom-in" data-aos-delay="200">
                <i class="bi bi-speedometer2 me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3 fade-in" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if(count($products) > 0)
    <div class="table-container shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="400">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Tanggal Ditambahkan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr data-aos="fade-up" data-aos-delay="{{ 100 * $loop->iteration }}">
                        <td data-label="No">{{ $loop->iteration }}</td>
                        <td data-label="Foto Produk">
                            @if($product->image)
                                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px; font-size: 0.8rem; border: 1px dashed #ccc;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td data-label="Nama Produk">{{ $product->name }}</td>
                        <td data-label="Harga">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td data-label="Stok">{{ $product->stock }}</td>
                        <td data-label="Tanggal">{{ $product->created_at->format('d M Y') }}</td>
                        <td data-label="Aksi">
                            <div class="d-flex gap-2 justify-content-end justify-content-md-start">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }} ini? Aksi ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3-fill"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-info empty-state shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-box-fill"></i>
            <p>Belum ada data produk yang tersedia.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle me-2"></i> Tambah Produk Pertama Anda
            </a>
        </div>
    @endif
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 }); // Inisialisasi AOS
</script>
@endsection