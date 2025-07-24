@extends('layouts.app')

@section('title', 'Keranjang Belanja - Grosirku')

@section('content')

{{-- CDN CSS/JS sudah di-load di layouts/app.blade.php, tidak perlu di sini lagi --}}

@push('styles')
<style>
    /* Custom styles for cart page */
    body {
        background-color: #f8f9fa; /* Latar belakang lebih terang */
    }
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 40px;
        color: #0d6efd; /* Menggunakan warna primary Bootstrap untuk judul */
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
    }
    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 100px;
        height: 5px;
        background-color: #0d6efd; /* Menggunakan warna primary Bootstrap */
        border-radius: 5px;
    }

    /* Kartu utama untuk keranjang dan checkout */
    .cart-summary-card, .checkout-form-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    /* Tabel Keranjang */
    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .table-bordered {
        border: none;
    }
    .table-bordered th, .table-bordered td {
        border-color: #e9ecef;
    }
    .table-light th {
        background-color: #e9ecef;
        color: #343a40;
        font-weight: 600;
        font-size: 1.05rem;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Kolom Produk */
    .product-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .product-cell img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .product-name {
        font-weight: 600;
        color: #343a40;
    }

    /* Harga dan Subtotal */
    .price-text {
        font-weight: bold;
        color: #0d6efd; /* Menggunakan warna primary Bootstrap */
        font-size: 1.1rem;
    }
    .total-row {
        background-color: #e6f7ff; /* Latar belakang untuk baris total, lebih terang */
        font-size: 1.3rem;
    }

    /* Input Jumlah Produk */
    .quantity-control .btn-sm {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border-radius: 8px;
        border-color: #ced4da;
        color: #495057;
        transition: all 0.2s ease;
    }
    .quantity-control .btn-sm:hover {
        background-color: #e2e6ea;
        border-color: #dae0e5;
    }
    .quantity-control .form-control-sm {
        width: 60px;
        text-align: center;
        border-radius: 8px;
        padding: 5px 0;
    }

    /* Tombol Hapus */
    .btn-remove {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .btn-remove:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-2px);
    }

    /* Alert Keranjang Kosong */
    .alert-empty-cart {
        background-color: #e0f7fa;
        color: #007bff;
        border-color: #b3e5fc;
        border-radius: 15px;
        padding: 30px;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
    }
    .alert-empty-cart .bi {
        font-size: 4rem;
        margin-bottom: 15px;
        color: #007bff;
    }
    .alert-empty-cart a {
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .alert-empty-cart a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Form Checkout */
    .checkout-form-card label {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 8px;
    }
    .checkout-form-card .form-control,
    .checkout-form-card .form-select {
        border-radius: 10px;
        border-color: #ced4da;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .checkout-form-card .form-control:focus,
    .checkout-form-card .form-select:focus {
        border-color: #0d6efd; /* Warna primary Bootstrap */
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .payment-info-section {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
        background-color: #fdfdfd;
        text-align: center;
        animation: fadeIn 0.6s ease-in-out;
    }
    .payment-info-section img {
        height: 50px;
        margin: 5px 10px;
        filter: grayscale(0%);
        transition: filter 0.3s ease;
    }
    .payment-info-section img:hover {
        filter: grayscale(0%);
    }
    .payment-info-section p {
        font-size: 1.1rem;
        font-weight: 500;
        color: #343a40;
    }
    .payment-info-section .copy-button {
        background-color: #0dcaf0; /* Warna info Bootstrap */
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .payment-info-section .copy-button:hover {
        background-color: #0bafd6;
        transform: translateY(-2px);
    }

    .btn-checkout {
        background-color: #0d6efd; /* Menggunakan warna primary Bootstrap */
        border: none;
        border-radius: 10px;
        padding: 15px 25px;
        font-size: 1.2rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-checkout:hover {
        background-color: #0a58ca;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
    }

    /* Animasi Fade In */
    .fade-in {
        animation: fadeIn 0.8s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsif */
    @media (max-width: 767px) {
        .section-title {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .cart-summary-card, .checkout-form-card {
            padding: 20px;
        }
        .product-cell {
            flex-direction: column;
            align-items: flex-start;
        }
        .product-cell img {
            width: 50px;
            height: 50px;
        }
        .product-name {
            font-size: 1rem;
            text-align: left;
        }
        .price-text {
            font-size: 1rem;
        }
        .quantity-control .btn-sm {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
        .quantity-control .form-control-sm {
            width: 50px;
        }
        .total-row {
            font-size: 1.1rem;
        }
        .alert-empty-cart {
            padding: 20px;
        }
        .alert-empty-cart .bi {
            font-size: 3rem;
        }
        .btn-checkout {
            font-size: 1rem;
            padding: 12px 20px;
        }
    }
</style>
@endpush

<div class="container py-5">
    <h2 class="section-title" data-aos="fade-up">Keranjang Belanja Kamu</h2>

    {{-- Pesan Status (Success/Error) --}}
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="alert alert-info alert-empty-cart fade-in" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-cart-x"></i>
            <p class="mb-3">Ups! Keranjang belanja kamu masih kosong nih.</p>
            <p>Yuk, mulai isi dengan produk-produk menarik dari katalog kami!</p>
            <a href="{{ route('katalog.index') }}" class="btn btn-primary btn-lg text-white rounded-pill mt-3">
                <i class="bi bi-shop me-2"></i>klik di sini untuk berbelanja 
            </a>
        </div>
    @else
        <div class="cart-summary-card" data-aos="fade-up" data-aos-delay="100">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="col-6 col-md-4">Produk</th>
                            <th class="text-center">Harga Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php
                                $productPrice = $item->product->price ?? 0;
                                $subtotal = $productPrice * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr data-aos="fade-in" data-aos-delay="{{ $loop->iteration * 100 }}">
                                <td>
                                    <div class="product-cell">
                                        @if($item->product->image ?? false)
                                            <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Produk' }}" class="img-fluid">
                                        @else
                                            <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px; font-size: 0.8rem;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                        <span class="product-name">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="price-text">Rp {{ number_format($productPrice, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex justify-content-center align-items-center quantity-control">
                                        @csrf
                                        @method('PUT')
                                        {{-- MENAMBAHKAN KEMBALI TOMBOL INCREASE/DECREASE --}}
                                        <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm"><i class="bi bi-dash"></i></button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control form-control-sm text-center mx-1" min="1" onchange="this.form.submit()">
                                        <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm"><i class="bi bi-plus"></i></button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <span class="price-text">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-remove"
                                            data-bs-toggle="modal" data-bs-target="#confirmRemoveModal"
                                            data-item-id="{{ $item->id }}">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="total-row">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Belanja:</td>
                            <td colspan="2" class="fw-bold text-center">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('katalog.index') }}" class="btn btn-outline-primary me-3 rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i> Lanjutkan Belanja
                </a>
                
                <button type="button" class="btn btn-warning rounded-pill"
                        data-bs-toggle="modal" data-bs-target="#confirmClearModal">
                    <i class="bi bi-trash-fill me-2"></i> Kosongkan Keranjang
                </button>
            </div>
        </div>

        <h3 class="section-title mt-5 mb-4" style="font-size: 2rem;" data-aos="fade-up" data-aos-delay="200">Informasi Pengiriman & Pembayaran</h3>

        <div class="checkout-form-card" data-aos="fade-up" data-aos-delay="300">
            <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                @csrf

                <div class="mb-4">
                    <label for="alamat" class="form-label"><i class="bi bi-geo-alt-fill me-2"></i>Alamat Pengiriman Lengkap</label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required placeholder="Contoh: Jl. Merdeka No. 123, RT 001 RW 002, Kel. Sukamaju, Kec. Cihampelas, Kota Bandung, Jawa Barat, 40111">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="metode_pembayaran" class="form-label"><i class="bi bi-wallet-fill me-2"></i>Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required onchange="togglePaymentOptions()">
                        <option value="" disabled {{ old('metode_pembayaran') == '' ? 'selected' : '' }}>Pilih Metode Pembayaran</option>
                        <option value="virtual_account" {{ old('metode_pembayaran') == 'virtual_account' ? 'selected' : '' }}>Virtual Account</option>
                        <option value="qris" {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>QRIS / E-Wallet</option>
                        <option value="cod" {{ old('metode_pembayaran') == 'cod' ? 'selected' : '' }}>Bayar di Tempat (COD)</option>
                    </select>
                    @error('metode_pembayaran')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div id="qris-info" class="payment-info-section" style="display: none;" data-aos="fade-in">
                    <p class="fw-bold mb-3">Scan QR Code di bawah ini untuk melakukan pembayaran:</p>
                    <img src="{{ asset('images/qris.png') }}" alt="QRIS QR Code" class="img-fluid rounded mb-3" style="max-width: 250px;"/>
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <img src="{{ asset('images/dana-logo.png') }}" alt="DANA" title="DANA">
                        <img src="{{ asset('images/ovo-logo.png') }}" alt="OVO" title="OVO">
                        <img src="{{ asset('images/gopay-logo.png') }}" alt="Gopay" title="Gopay">
                        <img src="{{ asset('images/linkaja-logo.png') }}" alt="LinkAja" title="LinkAja">
                        <img src="{{ asset('images/shopeepay-logo.png') }}" alt="ShopeePay" title="ShopeePay">
                    </div>
                    <p class="text-muted mt-3 mb-0 small">Pastikan jumlah pembayaran sesuai dengan total belanja Anda.</p>
                </div>

                <div id="virtual-account-options" class="payment-info-section" style="display: none;" data-aos="fade-in">
                    <div class="mb-3">
                        <label for="va_bank" class="form-label">Pilih Bank Virtual Account</label>
                        <select name="bank_tujuan" id="va_bank" class="form-select @error('bank_tujuan') is-invalid @enderror" onchange="updateVirtualAccount()">
                            <option value="" disabled {{ old('bank_tujuan') == '' ? 'selected' : '' }}>Pilih Bank</option>
                            <option value="VA_BCA" {{ old('bank_tujuan') == 'VA_BCA' ? 'selected' : '' }}>BCA Virtual Account</option>
                            <option value="VA_BNI" {{ old('bank_tujuan') == 'VA_BNI' ? 'selected' : '' }}>BNI Virtual Account</option>
                            <option value="VA_BRI" {{ old('bank_tujuan') == 'VA_BRI' ? 'selected' : '' }}>BRI Virtual Account</option>
                            <option value="VA_Mandiri" {{ old('bank_tujuan') == 'VA_Mandiri' ? 'selected' : '' }}>Mandiri Virtual Account</option>
                        </select>
                        @error('bank_tujuan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="mb-1">Nomor Virtual Account:</p>
                    <div class="input-group mb-2">
                        <input type="text" id="va_nomor" name="va_nomor_input" class="form-control text-center fw-bold" readonly placeholder="Pilih bank untuk melihat nomor virtual account">
                        <button type="button" class="btn btn-info copy-button" onclick="copyToClipboard('va_nomor')"><i class="bi bi-clipboard"></i> Salin</button>
                    </div>
                    <p id="va_pemilik" class="form-text text-muted"></p>
                    <div class="d-flex justify-content-center flex-wrap mt-3 gap-2">
                        <img src="{{ asset('images/bca-min.png') }}" alt="BCA VA" style="height: 35px;">
                        <img src="{{ asset('images/bni-min.png') }}" alt="BNI VA" style="height: 35px;">
                        <img src="{{ asset('images/bri-min.png') }}" alt="BRI VA" style="height: 35px;">
                        <img src="{{ asset('images/livin-min.png') }}" alt="Mandiri VA" style="height: 35px;">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="catatan" class="form-label"><i class="bi bi-file-earmark-text-fill me-2"></i>Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="2" placeholder="Contoh: Tolong kirim sore hari, jangan lupa saus sambal ekstra.">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="button" class="btn btn-primary btn-lg w-100 btn-checkout"
                        data-bs-toggle="modal" data-bs-target="#confirmCheckoutModal">
                    <i class="bi bi-bag-check-fill me-2"></i> Lanjutkan Pembayaran
                </button>
            </form>
        </div>
    @endif
</div>

{{-- Modal Konfirmasi Hapus Item --}}
<div class="modal fade" id="confirmRemoveModal" tabindex="-1" aria-labelledby="confirmRemoveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title" id="confirmRemoveModalLabel"><i class="bi bi-trash-fill me-2"></i> Hapus Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="lead mb-4">Apakah Anda yakin ingin menghapus produk ini dari keranjang?</p>
            </div>
            <div class="modal-footer justify-content-center border-top-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="removeForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Kosongkan Keranjang --}}
<div class="modal fade" id="confirmClearModal" tabindex="-1" aria-labelledby="confirmClearModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-warning text-dark rounded-top-4">
                <h5 class="modal-title" id="confirmClearModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i> Kosongkan Keranjang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="lead mb-4">Apakah Anda yakin ingin mengosongkan seluruh isi keranjang belanja Anda?</p>
            </div>
            <div class="modal-footer justify-content-center border-top-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-warning">Ya, Kosongkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Checkout --}}
<div class="modal fade" id="confirmCheckoutModal" tabindex="-1" aria-labelledby="confirmCheckoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title" id="confirmCheckoutModalLabel"><i class="bi bi-bag-check-fill me-2"></i> Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="lead mb-4">Apakah Anda yakin ingin melanjutkan pembayaran?</p>
                <p class="text-muted small">Pastikan alamat pengiriman dan metode pembayaran sudah benar.</p>
            </div>
            <div class="modal-footer justify-content="center" border-top-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmCheckoutBtn">Ya, Lanjutkan Pembayaran</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan/menyembunyikan opsi pembayaran
    function togglePaymentOptions() {
        const metode = document.getElementById('metode_pembayaran').value;
        const qrisInfo = document.getElementById('qris-info');
        const virtualAccountOptions = document.getElementById('virtual-account-options');

        // Sembunyikan semua bagian info pembayaran terlebih dahulu
        qrisInfo.style.display = 'none';
        virtualAccountOptions.style.display = 'none';

        // Reset nilai input tersembunyi untuk mencegah masalah validasi
        document.getElementById('va_bank').value = '';
        document.getElementById('va_nomor').value = '';
        document.getElementById('va_pemilik').innerText = '';

        if (metode === 'qris') {
            qrisInfo.style.display = 'block';
            if (typeof AOS !== 'undefined') { // Cek jika AOS dimuat
                AOS.refresh();
            }
        } else if (metode === 'virtual_account') {
            virtualAccountOptions.style.display = 'block';
            if (typeof AOS !== 'undefined') { // Cek jika AOS dimuat
                AOS.refresh();
            }
            // Panggil updateVirtualAccount() untuk mengisi nomor VA jika metode ini dipilih
            updateVirtualAccount(); 
        }
    }

    // Fungsi untuk memperbarui info Virtual Account
    function updateVirtualAccount() {
        const vaBank = document.getElementById('va_bank').value;
        const vaNomor = document.getElementById('va_nomor');
        const vaPemilik = document.getElementById('va_pemilik');
        const vaMap = {
            'VA_BCA': { nomor: '88081234567890', pemilik: 'Grosirku BCA' },
            'VA_BNI': { nomor: '88099876543210', pemilik: 'Grosirku BNI' },
            'VA_BRI': { nomor: '88085555555555', pemilik: 'Grosirku BRI' },
            'VA_Mandiri': { nomor: '88091111111111', pemilik: 'Grosirku Mandiri' }
        };
        if (vaMap[vaBank]) {
            vaNomor.value = vaMap[vaBank].nomor;
            vaPemilik.innerText = `Atas nama: ${vaMap[vaBank].pemilik}`;
        } else {
            vaNomor.value = '';
            vaPemilik.innerText = '';
        }
    }

    // Fungsi untuk menyalin teks ke clipboard
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        element.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");

        const copyButton = element.nextElementSibling;
        const originalText = copyButton.innerHTML;
        copyButton.innerHTML = '<i class="bi bi-check-lg"></i> Disalin!';
        setTimeout(() => {
            copyButton.innerHTML = originalText;
        }, 2000);
    }

    // Event listener untuk Modal Hapus Item
    document.getElementById('confirmRemoveModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const itemId = button.getAttribute('data-item-id');
        const form = document.getElementById('removeForm');
        form.action = `{{ url('cart/remove') }}/${itemId}`;
    });

    // Event listener untuk tombol "Lanjutkan Pembayaran" di modal checkout
    document.getElementById('confirmCheckoutBtn').addEventListener('click', function() {
        if (validateCheckout()) {
            document.getElementById('checkoutForm').submit();
        } else {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmCheckoutModal'));
            modal.hide();
        }
    });

    // Validasi Checkout (diperbarui)
    function validateCheckout() {
        const alamat = document.getElementById('alamat').value.trim();
        const metode = document.getElementById('metode_pembayaran').value;
        const vaBankSelected = document.getElementById('va_bank')?.value; 

        if (alamat === '') {
            alert('Alamat pengiriman wajib diisi.');
            return false;
        }
        if (!metode) {
            alert('Pilih metode pembayaran terlebih dahulu.');
            return false;
        }

        if (metode === 'virtual_account' && !vaBankSelected) {
            alert('Pilih bank virtual account.');
            return false;
        }

        return true;
    }

    // Inisialisasi toggle pada pemuatan halaman awal
    document.addEventListener('DOMContentLoaded', function() {
        togglePaymentOptions();
        
        const oldMetode = "{{ old('metode_pembayaran') }}";
        const oldBankTujuan = "{{ old('bank_tujuan') }}";

        if (oldMetode) {
            document.getElementById('metode_pembayaran').value = oldMetode;
            togglePaymentOptions();
            if (oldMetode === 'virtual_account' && oldBankTujuan) {
                document.getElementById('va_bank').value = oldBankTujuan;
                updateVirtualAccount();
            }
        }
    });
</script>
@endpush
