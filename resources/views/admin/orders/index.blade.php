@extends('layouts.app')

@section('title', 'Laporan Penjualan & Pesanan')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5; /* Light grey background */
    }

    .header-section {
        background: linear-gradient(to right, #6f42c1, #563d7c); /* Purple gradient */
        color: white;
        padding: 30px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(111, 66, 193, 0.2);
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
    .header-section .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #343a40 !important;
    }
    .header-section .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    /* Stats Cards */
    .stats-card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 40px;
        justify-content: center;
    }
    .stat-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        padding: 25px;
        flex: 1; /* Allows cards to grow and shrink */
        min-width: 180px; /* Minimum width before wrapping */
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }
    .stat-card strong {
        display: block;
        font-size: 1.1rem;
        color: #495057;
        margin-bottom: 8px;
    }
    .stat-card span {
        font-size: 2rem;
        font-weight: 700;
        color: #007bff; /* Primary color for numbers */
    }
    .stat-card.red span { color: #dc3545; }
    .stat-card.green span { color: #28a745; }
    .stat-card.blue span { color: #007bff; }
    .stat-card.orange span { color: #fd7e14; }
    .stat-card.purple span { color: #6f42c1; }


    /* Nav Tabs */
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 30px;
    }
    .nav-tabs .nav-item .nav-link {
        color: #6c757d;
        font-weight: 600;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-item .nav-link.active {
        color: #007bff;
        border-color: #007bff;
        background-color: transparent;
    }
    .nav-tabs .nav-item .nav-link:hover:not(.active) {
        color: #0056b3;
        border-color: rgba(0, 123, 255, 0.2);
    }

    /* Search Form */
    .search-form {
        margin-bottom: 30px;
    }
    .search-form .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .search-form .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    /* Table Styling */
    .table-container {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden; /* Important for border-radius */
    }

    .table {
        margin-bottom: 0;
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

    /* Status Badges */
    .badge-status {
        padding: 0.5em 0.8em;
        border-radius: 50px; /* Pill shape */
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .badge-unpaid { background-color: #ffc10720; color: #ffc107; } /* Light yellow with yellow text */
    .badge-need_to_ship { background-color: #007bff20; color: #007bff; } /* Light blue with blue text */
    .badge-sent { background-color: #17a2b820; color: #17a2b8; } /* Light info with info text */
    .badge-completed { background-color: #28a74520; color: #28a745; } /* Light green with green text */
    .badge-cancelled { background-color: #dc354520; color: #dc3545; } /* Light red with red text */
    .badge-returned { background-color: #6f42c120; color: #6f42c1; } /* Light purple with purple text */
    .badge-paid { background-color: #28a74520; color: #28a745; } /* For payment status paid */
    .badge-pending { background-color: #ffc10720; color: #ffc107; } /* For payment status pending */
    .badge-failed { background-color: #dc354520; color: #dc3545; } /* For payment status failed */


    /* Empty State */
    .empty-state {
        background-color: #e6f7ff;
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

    /* Responsive */
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
        .header-section .d-flex.gap-3 {
            flex-direction: column;
            width: 100%;
        }
        .header-section .btn {
            width: 100%;
        }
        .stats-card-container {
            flex-direction: column;
            gap: 15px;
        }
        .stat-card {
            min-width: unset; /* Remove min-width for full column stacking */
            width: 100%;
            padding: 20px;
        }
        .stat-card span {
            font-size: 1.8rem;
        }
        .nav-tabs {
            flex-wrap: wrap; /* Allow tabs to wrap */
            justify-content: center;
        }
        .nav-tabs .nav-item {
            flex: 1 1 auto; /* Make items flexible */
            text-align: center;
        }
        .nav-tabs .nav-item .nav-link {
            padding: 10px 15px;
        }
        .table thead {
            display: none; /* Hide table header on small screens */
        }
        .table, .table tbody, .table tr, .table td {
            display: block; /* Make each row and cell a block */
            width: 100%;
        }
        .table tr {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            background-color: white;
            padding: 15px;
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
        .table tbody td.actions-cell {
            text-align: center; /* Center actions */
            padding-top: 15px;
            padding-bottom: 15px;
        }
        .table tbody td.actions-cell .d-flex {
            justify-content: center;
        }
    }

    @media (max-width: 575px) {
        .stat-card strong {
            font-size: 1rem;
        }
        .stat-card span {
            font-size: 1.5rem;
        }
        .header-section h2 {
            font-size: 1.8rem;
        }
        .header-section h2 .bi {
            font-size: 2rem;
        }
    }
</style>

<div class="container py-5">
    <div class="header-section mb-5" data-aos="fade-down">
        <h2>
            <i class="bi bi-receipt-cutoff"></i> Laporan Penjualan & Pesanan
        </h2>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.export.orders.pdf') }}" class="btn btn-light-outline" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
            </a>
            <a href="{{ route('admin.export.orders.excel') }}" class="btn btn-light-outline" data-aos="zoom-in" data-aos-delay="200">
                <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
            </a>
            {{-- Assuming 'create' route for orders is admin.orders.create --}}
            <a href="{{ route('admin.orders.create') }}" class="btn btn-warning" data-aos="zoom-in" data-aos-delay="300">
                <i class="bi bi-plus-circle me-2"></i> Buat Pesanan Baru
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light-outline" data-aos="zoom-in" data-aos-delay="400">
                <i class="bi bi-speedometer2 me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="stats-card-container mb-5" data-aos="fade-up" data-aos-delay="500">
        <div class="stat-card blue" data-aos="zoom-in" data-aos-delay="600">
            <strong><i class="bi bi-graph-up me-2"></i> Total Pesanan Hari Ini</strong>
            <span>{{ $stats['today_orders'] ?? 0 }}</span>
        </div>
        <div class="stat-card purple" data-aos="zoom-in" data-aos-delay="700">
            <strong><i class="bi bi-box-seam me-2"></i> Total Item Terjual</strong>
            <span>{{ $stats['total_items'] ?? 0 }}</span>
        </div>
        <div class="stat-card green" data-aos="zoom-in" data-aos-delay="800">
            <strong><i class="bi bi-truck me-2"></i> Pesanan Terkirim</strong>
            <span>{{ $stats['fulfilled'] ?? 0 }}</span>
        </div>
        <div class="stat-card orange" data-aos="zoom-in" data-aos-delay="900">
            <strong><i class="bi bi-patch-check me-2"></i> Pesanan Terantar</strong>
            <span>{{ $stats['delivered'] ?? 0 }}</span>
        </div>
        <div class="stat-card red" data-aos="zoom-in" data-aos-delay="1000">
            <strong><i class="bi bi-arrow-return-left me-2"></i> Pengembalian</strong>
            <span>{{ $stats['returns'] ?? 0 }}</span>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4" data-aos="fade-up" data-aos-delay="1100">
        <div class="card-body p-0">
            <ul class="nav nav-tabs justify-content-center pt-3 px-3">
                @foreach([
                    'all' => ['label' => 'Semua', 'icon' => 'list-ul'],
                    'pending' => ['label' => 'Menunggu Pembayaran', 'icon' => 'clock'],
                    'processing' => ['label' => 'Perlu Dikirim', 'icon' => 'box-arrow-in-right'],
                    'shipped' => ['label' => 'Terkirim', 'icon' => 'truck'],
                    'completed' => ['label' => 'Selesai', 'icon' => 'check-circle'],
                    'cancelled' => ['label' => 'Dibatalkan', 'icon' => 'x-circle'],
                    'returned' => ['label' => 'Dikembalikan', 'icon' => 'arrow-return-left']
                ] as $key => $data)
                    <li class="nav-item">
                        <a class="nav-link {{ request('status', 'all') === $key ? 'active' : '' }}"
                           href="{{ route('admin.orders.index', ['status' => $key, 'search' => request('search')]) }}">
                           <i class="bi bi-{{ $data['icon'] }} me-2"></i> {{ $data['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


    <div class="table-container shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="1200">
        <div class="card-body">
            <form method="GET" class="search-form d-flex align-items-center gap-3">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" placeholder="Cari pesanan (ID, Customer)..." class="form-control border-start-0" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary d-none d-md-block"><i class="bi bi-funnel"></i> Filter</button>
            </form>

            @if(count($orders) > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Pembayaran</th>
                            <th>Jumlah Item</th>
                            <th>Pengiriman</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr data-aos="fade-up" data-aos-delay="{{ 50 * $loop->iteration }}">
                            <td data-label="ID Pesanan">#{{ $order->id }}</td>
                            <td data-label="Pelanggan">{{ $order->user->name }}</td>
                            <td data-label="Tanggal">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td data-label="Total Harga">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td data-label="Status Pembayaran">
                                <span class="badge badge-status badge-{{ Str::slug($order->payment_status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                </span>
                            </td>
                            <td data-label="Jumlah Item">{{ $order->items->sum('quantity') }}</td>
                            <td data-label="Metode Pengiriman">
                                {{ ucfirst(str_replace('_', ' ', $order->delivery_method ?? 'Unknown')) }}
                            </td>
                            <td data-label="Status Pesanan">
                                <span class="badge badge-status badge-{{ Str::slug($order->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td data-label="Aksi" class="actions-cell">
                                <div class="d-flex gap-2">
                                    {{-- Assuming a 'show' route for order details --}}
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    {{-- Assuming an 'edit' route for order --}}
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning text-dark" title="Edit Pesanan">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    {{-- Example for update status dropdown (optional, more complex) --}}
                                    {{-- <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $order->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Ubah Status
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                            <li><a class="dropdown-item" href="#">Menunggu Pembayaran</a></li>
                                            <li><a class="dropdown-item" href="#">Perlu Dikirim</a></li>
                                            <li><a class="dropdown-item" href="#">Terkirim</a></li>
                                            <li><a class="dropdown-item" href="#">Selesai</a></li>
                                            <li><a class="dropdown-item" href="#">Dibatalkan</a></li>
                                            <li><a class="dropdown-item" href="#">Dikembalikan</a></li>
                                        </ul>
                                    </div> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-box-fill"></i>
                    <p>Tidak ada pesanan yang ditemukan untuk filter ini.</p>
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle me-2"></i> Buat Pesanan Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 }); // Initialize AOS
</script>
@endsection