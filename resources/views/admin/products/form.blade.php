@extends('layouts.app')

@section('title', 'Edit Produk Barang')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5; /* Light grey background */
    }

    .form-container {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        margin-top: 20px; /* Space from header */
    }

    .header-section {
        background: linear-gradient(to right, #ffc107, #e0a800); /* Warning/Orange gradient */
        color: #343a40; /* Dark text for contrast */
        padding: 30px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding-left: 40px;
        padding-right: 40px;
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

    /* Form styling */
    .form-label {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    /* Image preview */
    .image-preview-container {
        margin-top: 15px;
        border: 2px dashed #ced4da;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        min-height: 150px;
        text-align: center;
        position: relative;
    }
    .image-preview-container img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        object-fit: contain; /* Ensure entire image is visible */
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 10px;
    }
    .image-preview-container .text-muted {
        font-size: 0.9rem;
    }
    .image-preview-container .bi {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 10px;
    }

    /* Buttons */
    .btn {
        padding: 10px 25px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    /* Error handling */
    .invalid-feedback {
        display: block; /* Ensure it's visible */
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
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
        .form-container {
            padding: 25px;
        }
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 10px !important; /* Override default gap for small screens */
        }
        .d-flex.gap-2 .btn {
            width: 100%; /* Make buttons full width */
        }
    }
</style>

<div class="container py-5">
    <div class="header-section mb-5" data-aos="fade-down">
        <h2>
            <i class="bi bi-pencil-square"></i> Edit Produk Barang
        </h2>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary text-dark" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi bi-card-list me-2"></i> Kembali ke Daftar Produk
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary text-dark" data-aos="zoom-in" data-aos-delay="200">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Terjadi Kesalahan!</strong> Mohon periksa kembali input Anda.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="form-container" data-aos="fade-up" data-aos-delay="300">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}"
                       placeholder="Masukkan nama produk..." required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stock" id="stock"
                           class="form-control @error('stock') is-invalid @enderror"
                           value="{{ old('stock', $product->stock) }}"
                           placeholder="Jumlah stok" min="0" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $product->price) }}"
                           placeholder="Harga produk" min="0" step="1" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="5" placeholder="Tulis deskripsi lengkap produk...">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">Foto Produk</label>
                <input type="file" name="image" id="image"
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/*" onchange="previewImage(event);">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="image-preview-container mt-3">
                    @if($product->image)
                        <img src="{{ asset('uploads/products/' . $product->image) }}" alt="Foto Produk Saat Ini" id="image-preview">
                        <small class="text-muted">Foto saat ini. Pilih file baru untuk mengganti.</small>
                    @else
                        <i class="bi bi-image"></i>
                        <p class="text-muted mb-0">Belum ada foto produk. Unggah foto di sini.</p>
                        <img src="#" alt="Pratinjau Gambar Baru" id="image-preview" style="display: none;">
                    @endif
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3 mt-5">
                <button type="submit" class="btn btn-success flex-grow-1">
                    <i class="bi bi-save-fill me-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary flex-grow-1">
                    <i class="bi bi-arrow-left-circle me-2"></i> Batalkan
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 }); // Initialize AOS

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image
            // Hide the placeholder text and icon if they exist
            const placeholderIcon = output.previousElementSibling;
            if (placeholderIcon && placeholderIcon.classList.contains('bi-image')) {
                placeholderIcon.style.display = 'none';
            }
            const placeholderText = output.nextElementSibling; // Might be small text, not p
            if (placeholderText && placeholderText.tagName === 'P') {
                placeholderText.style.display = 'none';
            }
             // Ensure the "Foto saat ini" text is correctly handled after new image selected
             const currentImageText = document.querySelector('.image-preview-container small');
             if (currentImageText) {
                 currentImageText.textContent = 'Gambar baru akan diunggah.';
             }
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Initialize image preview on load if product already has an image
    document.addEventListener('DOMContentLoaded', function() {
        const existingImage = document.getElementById('image-preview');
        if (existingImage && existingImage.src && existingImage.src !== window.location.href) {
            existingImage.style.display = 'block';
            // Hide placeholder if existing image is present
            const placeholderIcon = existingImage.previousElementSibling;
            if (placeholderIcon && placeholderIcon.classList.contains('bi-image')) {
                placeholderIcon.style.display = 'none';
            }
            const placeholderText = existingImage.nextElementSibling;
            if (placeholderText && placeholderText.tagName === 'P') {
                placeholderText.style.display = 'none';
            }
        }
    });

</script>
@endsection