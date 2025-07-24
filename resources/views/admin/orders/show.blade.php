@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' (Admin) - Grosirku')

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 40px;
        color: #0d6efd;
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
        width: 150px;
        height: 5px;
        background-color: #0d6efd;
        border-radius: 5px;
    }
    .detail-order-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .detail-order-card .card-header {
        background: linear-gradient(90deg, #0d6efd 0%, #007bff 100%);
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 1.5rem;
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .detail-order-card .card-header h4 {
        margin-bottom: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }
    .detail-order-card .card-header small {
        opacity: 0.9;
        font-size: 0.9rem;
    }
    .status-badge {
        font-size: 0.9rem;
        padding: 0.6em 1em;
        border-radius: 25px;
        min-width: 100px;
        text-align: center;
        font-weight: bold;
        text-transform: capitalize;
    }
    /* Status colors (match with AdminOrderController) */
    .status-badge.bg-pending { background-color: #ffc107; color: #343a40; }
    .status-badge.bg-proses { background-color: #0dcaf0; color: white; }
    .status-badge.bg-dikirim { background-color: #0d6efd; color: white; }
    .status-badge.bg-selesai { background-color: #198754; color: white; }
    .status-badge.bg-dibatalkan { background-color: #dc3545; color: white; }
    .status-badge.bg-dikembalikan { background-color: #6c757d; color: white; }
    .status-badge.bg-belum-dibayar { background-color: #dc3545; color: white; }
    .status-badge.bg-sudah-dibayar { background-color: #198754; color: white; }
    .status-badge.bg-menunggu-verifikasi { background-color: #ffc107; color: #343a40; }

    .detail-order-card .card-body {
        padding: 2rem;
    }
    .order-info-group {
        margin-bottom: 25px;
    }
    .order-info-group .info-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        font-size: 1rem;
        color: #555;
    }
    .order-info-group .info-row:last-child {
        margin-bottom: 0;
    }
    .order-info-group .info-row strong {
        color: #343a40;
        margin-right: 10px;
        min-width: 150px;
        flex-shrink: 0;
    }
    .order-info-group .info-row .icon {
        font-size: 1.2rem;
        color: #0d6efd;
        margin-right: 12px;
        flex-shrink: 0;
    }
    .order-info-group h5 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #0d6efd;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .order-info-group h5 .bi {
        margin-right: 10px;
    }

    .order-products-list .list-group-item {
        border: none;
        border-bottom: 1px solid #eee;
        padding: 1rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-products-list .list-group-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .product-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
        border: 1px solid #eee;
    }
    .no-image-placeholder {
        background-color: #f0f2f5;
        color: #a0a8b4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .order-products-list .product-name {
        font-weight: 600;
        color: #343a40;
    }
    .order-products-list .product-qty-price {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .order-products-list .item-total {
        font-weight: bold;
        color: #0d6efd;
        font-size: 1rem;
    }

    .total-price-section {
        background-color: #e6f7ff;
        padding: 1.5rem 2rem;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.3rem;
        font-weight: 700;
        color: #0d6efd;
    }
    .total-price-section h5 {
        margin-bottom: 0;
        font-size: 1.3rem;
    }
    .total-price-section strong {
        font-size: 1.7rem;
        color: #0d6efd;
    }

    .card-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        flex-wrap: wrap; /* Allow wrapping on small screens */
        gap: 10px; /* Spacing between buttons */
    }
    .card-footer .btn {
        font-weight: bold;
        border-radius: 50px;
        padding: 10px 25px;
    }
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        transition: background-color 0.3s ease;
    }
    .btn-whatsapp:hover {
        background-color: #1DA851;
        color: white;
    }

    .proof-image-display {
        margin-top: 20px;
        text-align: center;
        padding: 20px;
        background-color: #f0f2f5;
        border-radius: 10px;
        border: 1px dashed #ced4da;
    }
    .proof-image-display img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Responsive */
    @media (max-width: 767px) {
        .section-title {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .detail-order-card .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            padding: 1rem;
        }
        .detail-order-card .card-header h4 {
            font-size: 1.3rem;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.4em 0.6em;
            min-width: 70px;
        }
        .detail-order-card .card-body {
            padding: 1.5rem;
        }
        .order-info-group .info-row {
            flex-direction: column;
            align-items: flex-start;
            font-size: 0.9rem;
        }
        .order-info-group .info-row strong {
            margin-right: 0;
            margin-bottom: 5px;
            min-width: unset;
        }
        .order-info-group .info-row .icon {
            margin-right: 0;
            margin-bottom: 5px;
        }
        .order-info-group h5 {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .total-price-section {
            font-size: 1.1rem;
            padding: 1.25rem;
        }
        .total-price-section strong {
            font-size: 1.4rem;
        }
        .card-footer {
            flex-direction: column;
            padding: 1rem;
            gap: 10px;
        }
        .card-footer .btn {
            width: 100%;
        }
        .product-thumbnail {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@section('content')

<div class="container py-5">
    <h2 class="section-title mb-5" data-aos="fade-down">Detail Pesanan (Admin)</h2>

    <div class="detail-order-card" data-aos="fade-up" data-aos-delay="200">
        <div class="card-header">
            <h4>Pesanan #{{ $order->id }}</h4>
            <small>Tanggal Pesan: {{ $order->created_at->format('d M Y H:i') }}</small>
        </div>

        <div class="card-body">
            {{-- Bagian Informasi Umum --}}
            <div class="order-info-group">
                <h5 class="text-primary"><i class="bi bi-info-circle-fill"></i> Informasi Umum</h5>
                <div class="info-row">
                    <i class="icon bi bi-person-fill"></i>
                    <strong>Pelanggan:</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? 'N/A' }})
                </div>
                <div class="info-row">
                    <i class="icon bi bi-geo-alt-fill"></i>
                    <strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}
                </div>
                @if ($order->note)
                <div class="info-row">
                    <i class="icon bi bi-sticky-fill"></i>
                    <strong>Catatan:</strong> {{ $order->note }}
                </div>
                @endif
            </div>

            <hr class="my-4">

            {{-- Bagian Detail Pembayaran --}}
            <div class="order-info-group">
                <h5 class="text-info"><i class="bi bi-wallet-fill"></i> Detail Pembayaran</h5>
                <div class="info-row">
                    <i class="icon bi bi-credit-card-fill"></i>
                    <strong>Metode Pembayaran:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                </div>
                @if($order->bank_tujuan)
                <div class="info-row">
                    <i class="icon bi bi-bank"></i>
                    <strong>Bank Tujuan:</strong> {{ $order->bank_tujuan }}
                </div>
                @endif
                @if($order->payment_method === 'virtual_account' && $order->virtual_account)
                <div class="info-row">
                    <i class="icon bi bi-credit-card-2-front"></i>
                    <strong>Nomor Virtual Account:</strong> {{ $order->virtual_account }}
                </div>
                @endif
                @if($order->payment_method === 'transfer_bank_manual' && ($order->account_number ?? false))
                <div class="info-row">
                    <i class="icon bi bi-list-ol"></i>
                    <strong>No. Rekening:</strong> {{ $order->account_number }}
                </div>
                @endif
                <div class="info-row">
                    <i class="icon bi bi-receipt"></i>
                    <strong>Status Pembayaran:</strong>
                    <span class="badge status-badge bg-{{ Str::slug($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                @if($order->payment_confirmed_at)
                <div class="info-row">
                    <i class="icon bi bi-check-circle-fill"></i>
                    <strong>Waktu Konfirmasi Bayar:</strong> {{ $order->payment_confirmed_at->format('d M Y H:i') }}
                </div>
                @endif
            </div>

            {{-- Tampilkan Bukti Pembayaran jika ada --}}
            @if ($order->proof_of_payment_image)
            <div class="proof-image-display mt-4">
                <h5 class="text-secondary mb-3"><i class="bi bi-image-fill me-2"></i> Bukti Pembayaran</h5>
                <img src="{{ asset('uploads/proofs/' . $order->proof_of_payment_image) }}" alt="Bukti Pembayaran" class="img-fluid">
                <p class="text-muted mt-3 mb-0">
                    @if($order->payment_status === 'belum dibayar')
                        Bukti pembayaran ini sedang dalam proses verifikasi.
                    @else
                        Bukti pembayaran ini telah diverifikasi.
                    @endif
                </p>
            </div>
            @endif

            <hr class="my-4">

            {{-- Bagian Status & Produk --}}
            <div class="order-info-group">
                <h5 class="text-success"><i class="bi bi-truck"></i> Status & Produk</h5>
                <div class="info-row mb-3">
                    <i class="icon bi bi-truck-flatbed"></i>
                    <strong>Status Pesanan:</strong>
                    <span class="badge status-badge bg-{{ Str::slug($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <h6 class="mb-3 fw-bold text-dark"><i class="bi bi-box-seam-fill me-2"></i>Produk Dipesan</h6>
                <ul class="list-group order-products-list">
                    @forelse ($order->items as $item)
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                @if($item->product->image ?? false)
                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Produk' }}" class="product-thumbnail rounded">
                                @else
                                    <div class="product-thumbnail no-image-placeholder rounded">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="product-name">{{ $item->product->name ?? 'Produk Dihapus' }}</div>
                                    <div class="product-qty-price">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="item-total">
                                Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Tidak ada produk dalam pesanan ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="total-price-section">
            <h5>Total Pembayaran:</h5>
            <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Pesanan
            </a>
            
            {{-- Tombol Cetak (Opsional) --}}
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-outline-info mt-3 mt-md-0 ms-md-3">
                <i class="bi bi-printer"></i> Cetak
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- AOS init is already in layouts/app.blade.php --}}
@endpush
