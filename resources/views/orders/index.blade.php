@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya - Grosirku')

@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Latar belakang lebih terang */
    }
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 40px;
        color: #0d6efd; /* Warna primary Bootstrap untuk judul */
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
        width: 120px;
        height: 5px;
        background-color: #0d6efd; /* Warna primary Bootstrap */
        border-radius: 5px;
    }

    /* Card untuk setiap pesanan */
    .order-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    /* Header Card */
    .order-card .card-header {
        background: linear-gradient(90deg, #0d6efd 0%, #007bff 100%); /* Gradien primary Bootstrap */
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 1.25rem 1.5rem;
        font-size: 1.15rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap; /* Allow wrapping on small screens */
    }
    .order-card .card-header strong {
        font-size: 1.25rem;
        margin-right: 15px; /* Spacing for order ID */
    }
    .order-card .card-header small {
        opacity: 0.9;
        font-size: 0.9rem;
    }
    .order-card .card-header .order-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Badge Status */
    .status-badge {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
        border-radius: 20px;
        min-width: 90px;
        text-align: center;
        font-weight: bold;
        text-transform: capitalize; /* Pastikan status tampil rapi */
    }
    /* Order Status colors (sesuaikan dengan yang di admin/orders.blade.php) */
    .status-badge.bg-pending { background-color: #ffc107; color: #343a40; } /* Warning */
    .status-badge.bg-proses { background-color: #0dcaf0; color: white; } /* Info/Light Blue */
    .status-badge.bg-dikirim { background-color: #0d6efd; color: white; } /* Primary/Blue */
    .status-badge.bg-selesai { background-color: #198754; color: white; } /* Success/Green */
    .status-badge.bg-dibatalkan { background-color: #dc3545; color: white; } /* Danger/Red */
    .status-badge.bg-dikembalikan { background-color: #6c757d; color: white; } /* Secondary/Grey */
    /* Payment Status colors (tambahan jika perlu) */
    .status-badge.bg-belum-dibayar { background-color: #dc3545; color: white; }
    .status-badge.bg-sudah-dibayar { background-color: #198754; color: white; }
    .status-badge.bg-menunggu-verifikasi { background-color: #ffc107; color: #343a40; } /* Warning for pending verification */


    /* Card Body (Informasi Detail Pesanan) */
    .order-card .card-body {
        padding: 1.5rem;
    }
    .order-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 15px 30px;
    }
    .order-info-grid p {
        margin-bottom: 0;
        font-size: 0.95rem;
        color: #555;
        display: flex;
        align-items: flex-start;
    }
    .order-info-grid p strong {
        color: #343a40;
        margin-right: 8px;
        min-width: 120px;
    }
    .order-info-grid .icon {
        font-size: 1.1rem;
        color: #0d6efd; /* Menggunakan warna primary Bootstrap */
        margin-right: 10px;
        flex-shrink: 0;
    }

    /* List Produk Dipesan */
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
        color: #0d6efd; /* Menggunakan warna primary Bootstrap */
        font-size: 1rem;
    }
    .product-thumbnail {
        width: 60px; /* Slightly larger thumbnail */
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

    /* Total Harga */
    .total-price-section {
        background-color: #e6f7ff; /* Latar belakang primary muda */
        padding: 1.25rem 1.5rem;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0d6efd; /* Warna primary Bootstrap */
    }
    .total-price-section h5 {
        margin-bottom: 0;
        font-size: 1.25rem;
    }
    .total-price-section strong {
        font-size: 1.5rem;
        color: #0d6efd;
    }

    /* Alert Jika Kosong */
    .alert-empty-orders {
        background-color: #e0f7fa;
        color: #007bff;
        border-color: #b3e5fc;
        border-radius: 15px;
        padding: 40px;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .alert-empty-orders .bi {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #007bff;
    }
    .alert-empty-orders a {
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .alert-empty-orders a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Animasi Fade In */
    .fade-in {
        animation: fadeIn 0.8s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Payment Status Timeline (simple) - NEW STYLES */
    .payment-status-timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 40px;
        position: relative;
        padding: 0 10px; /* Slightly less padding for better fit in card */
    }
    .payment-status-timeline::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 4px;
        background-color: #e9ecef;
        transform: translateY(-50%);
        z-index: 0;
    }
    .timeline-step {
        text-align: center;
        flex: 1;
        position: relative;
        z-index: 1;
    }
    .timeline-step .icon {
        width: 45px; /* Slightly smaller icons for card fit */
        height: 45px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.3rem; /* Adjusted font size */
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .timeline-step.active .icon {
        background-color: #0d6efd; /* Primary blue */
        color: white;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4);
    }
    .timeline-step.completed .icon {
        background-color: #28a745; /* Success green */
        color: white;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
    }
    .timeline-step .label {
        font-size: 0.85rem; /* Adjusted font size */
        color: #6c757d;
        font-weight: 500;
    }
    .timeline-step.active .label,
    .timeline-step.completed .label {
        color: #343a40;
        font-weight: bold;
    }

    /* Responsif */
    @media (max-width: 767px) {
        .section-title {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .order-card .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            font-size: 1rem;
            padding: 1rem;
        }
        .order-card .card-header strong {
            font-size: 1.1rem;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.4em 0.6em;
            min-width: 70px;
        }
        .order-card .card-body {
            padding: 1rem;
        }
        .order-info-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .order-info-grid p {
            font-size: 0.85rem;
            flex-direction: column;
            align-items: flex-start;
        }
        .order-info-grid p strong {
            margin-right: 0;
            margin-bottom: 5px;
            min-width: unset;
        }
        .order-info-grid .icon {
            margin-bottom: 5px;
        }
        .total-price-section {
            font-size: 1rem;
            padding: 1rem;
        }
        .total-price-section strong {
            font-size: 1.2rem;
        }
        .alert-empty-orders {
            padding: 30px;
            font-size: 1rem;
        }
        .alert-empty-orders .bi {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .product-thumbnail {
            width: 40px;
            height: 40px;
        }
        /* Responsive for timeline */
        .payment-status-timeline {
            flex-wrap: wrap;
            justify-content: center;
            padding: 0;
        }
        .timeline-step {
            flex-basis: 30%; /* Adjust as needed for 3-4 steps per row */
            margin-bottom: 20px;
        }
        .timeline-step:nth-child(even) {
            margin-top: 20px; /* Stagger steps for better look on small screens */
        }
        .timeline-step .icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }
        .timeline-step .label {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')

<div class="container py-5">
    <h2 class="section-title" data-aos="fade-up">Riwayat Pesanan</h2>

    @if ($orders->isEmpty())
        <div class="alert alert-info alert-empty-orders fade-in" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-box-seam"></i>
            <p class="mb-3">Sepertinya Anda belum memiliki riwayat pesanan.</p>
            <p>Yuk, temukan produk menarik dan mulai berbelanja!</p>
            <a href="{{ route('katalog.index') }}" class="btn btn-primary btn-lg rounded-pill mt-3">
                <i class="bi bi-shop me-2"></i> Jelajahi Katalog
            </a>
        </div>
    @else
        @foreach ($orders as $order)
            <div class="order-card fade-in" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="card-header">
                    <div>
                        <strong>Pesanan #{{ $order->id }}</strong>
                        @if (Auth::check() && Auth::user()->is_admin ?? false)
                            <br><small>Pelanggan: {{ $order->user->name ?? 'Pengguna Dihapus' }}</small>
                        @endif
                    </div>
                    <div class="order-header-right">
                        <span class="status-badge bg-{{ Str::slug($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                        <span class="status-badge bg-{{ Str::slug($order->payment_status) }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Payment Status Timeline --}}
                    <div class="payment-status-timeline">
                        <div class="timeline-step completed">
                            <div class="icon"><i class="bi bi-receipt"></i></div>
                            <div class="label">Pesanan Dibuat</div>
                        </div>
                        <div class="timeline-step {{ $order->payment_status === 'sudah dibayar' ? 'completed' : ($order->payment_status === 'menunggu verifikasi' ? 'active' : '') }}">
                            <div class="icon"><i class="bi bi-wallet"></i></div>
                            <div class="label">Pembayaran</div>
                        </div>
                        <div class="timeline-step {{ $order->status === 'proses' || $order->status === 'dikirim' || $order->status === 'selesai' ? 'completed' : ($order->status === 'pending' && $order->payment_status === 'sudah dibayar' ? 'active' : '') }}">
                            <div class="icon"><i class="bi bi-box-seam"></i></div>
                            <div class="label">Diproses</div>
                        </div>
                        <div class="timeline-step {{ $order->status === 'dikirim' || $order->status === 'selesai' ? 'completed' : ($order->status === 'proses' ? 'active' : '') }}">
                            <div class="icon"><i class="bi bi-truck"></i></div>
                            <div class="label">Dikirim</div>
                        </div>
                        <div class="timeline-step {{ $order->status === 'selesai' ? 'completed' : ($order->status === 'dikirim' ? 'active' : '') }}">
                            <div class="icon"><i class="bi bi-check-circle"></i></div>
                            <div class="label">Selesai</div>
                        </div>
                    </div>

                    <div class="order-info-grid mb-4">
                        <p><i class="icon bi bi-calendar-check"></i> <strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        <p><i class="icon bi bi-geo-alt-fill"></i> <strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
                        <p><i class="icon bi bi-credit-card-fill"></i> <strong>Metode Pembayaran:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</p>

                        @if ($order->bank_tujuan)
                            <p><i class="icon bi bi-bank"></i> <strong>Bank Tujuan:</strong> {{ $order->bank_tujuan }}</p>
                        @endif
                        @if ($order->virtual_account ?? false)
                            <p><i class="icon bi bi-credit-card-2-front"></i> <strong>VA Bank:</strong> {{ $order->virtual_account }}</p>
                        @endif
                        @if ($order->note)
                            <p><i class="icon bi bi-info-circle-fill"></i> <strong>Catatan:</strong> {{ $order->note }}</p>
                        @endif
                        @if ($order->proof_of_payment_image)
                            <p><i class="icon bi bi-image"></i> <strong>Bukti Pembayaran:</strong> <a href="{{ asset('uploads/proofs/' . $order->proof_of_payment_image) }}" target="_blank">Lihat Bukti</a></p>
                        @endif
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3 fw-bold text-primary"><i class="bi bi-box-fill me-2"></i>Produk Dipesan</h5>
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

                <div class="total-price-section">
                    <h5>Total Pembayaran:</h5>
                    <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>

                <div class="card-footer bg-light text-end py-3 px-4">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-eye me-2"></i> Lihat Detail Pesanan
                    </a>
                    @if ($order->payment_status === 'belum dibayar' && $order->payment_method !== 'cod')
                        <a href="{{ route('checkout.success', ['order_id' => $order->id]) }}" class="btn btn-warning text-dark rounded-pill px-4 ms-2">
                            <i class="bi bi-wallet me-2"></i> Selesaikan Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-5">
            {{-- Jika Anda menggunakan pagination, tambahkan di sini --}}
            {{-- Contoh: {{ $orders->links('pagination::bootstrap-5') }} --}}
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // AOS initialization (if not already in layouts/app.blade.php)
    // if (typeof AOS !== 'undefined') {
    //     AOS.init({ duration: 800, once: true, offset: 50 });
    // }
</script>
@endpush
