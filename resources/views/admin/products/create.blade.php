@extends('layouts.app')

@section('title', 'Tambah & Kelola Produk')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5; /* Latar belakang abu-abu muda */
    }

    .header-section {
        background: linear-gradient(to right, #007bff, #0056b3); /* Gradien biru */
        color: white;
        padding: 30px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(0, 123, 255, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap; /* Untuk responsif */
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
    .header-section .btn-outline-light {
        color: white;
        border-color: rgba(255, 255, 255, 0.5);
    }
    .header-section .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Card Form */
    .product-form-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }

    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px; /* Jarak antara label dan ikon */
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
        background-color: #e9ecef;
        border-color: #ced4da;
        font-weight: 600;
        color: #495057;
    }
    .form-control[type="file"] {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    textarea.form-control {
        resize: vertical; /* Hanya bisa resize vertikal */
    }

    /* Alert Error */
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .alert-danger ul {
        list-style: disc;
        padding-left: 25px;
    }
    .alert-danger li {
        margin-bottom: 5px;
    }

    /* Action Buttons */
    .form-action-buttons .btn {
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-action-buttons .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .form-action-buttons .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .form-action-buttons .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #343a40 !important; /* Agar teks tidak putih */
    }
    .form-action-buttons .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
    .form-action-buttons .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .form-action-buttons .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    /* Responsif */
    @media (max-width: 767px) {
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
        .header-section .btn {
            width: 100%;
        }
        .product-form-card {
            padding: 20px;
        }
        .form-action-buttons {
            flex-direction: column;
            align-items: stretch;
            gap: 10px !important; /* Menimpa gap flex-wrap */
        }
    }
</style>

<div class="container py-5">
    <div class="header-section mb-5 px-4" data-aos="fade-down">
        <h2>
            <i class="bi bi-box-seam-fill"></i> Kelola Data Produk
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-speedometer2 me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Form Tambah Produk --}}
    <div class="product-form-card" data-aos="fade-up" data-aos-delay="400">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="image" class="form-label"><i class="bi bi-image-fill"></i> Foto Produk</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="form-label"><i class="bi bi-tag-fill"></i> Nama Produk</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Beras Pandan Wangi 5kg" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="form-label"><i class="bi bi-currency-dollar"></i> Harga Produk</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Contoh: 65000" step="1" value="{{ old('price') }}" required>
                    {{-- Ubah step="0.01" menjadi step="1" jika harga selalu bilangan bulat --}}
                </div>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="form-label"><i class="bi bi-boxes"></i> Stok Produk</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="Jumlah stok tersedia" value="{{ old('stock') }}" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="form-label"><i class="bi bi-list-nested"></i> Kategori Produk</label>
                <select name="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="form-label"><i class="bi bi-file-earmark-text-fill"></i> Deskripsi Produk</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Tulis deskripsi produk secara detail..." >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end flex-wrap gap-3 form-action-buttons">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Tambah Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-warning text-dark">
                    <i class="bi bi-pencil-square"></i> Kelola Daftar Produk
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-house-door"></i> Kembali ke Dashboard
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 }); // Inisialisasi AOS
</script>
@endsection