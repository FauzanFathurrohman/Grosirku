@extends('layouts.app')

@section('title', 'Manajemen Pesanan Admin - Grosirku')

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
    .filter-card {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
    }
    .filter-card .form-control,
    .filter-card .form-select {
        border-radius: 8px;
        padding: 10px 15px;
    }
    .filter-card .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: bold;
    }
    .order-table-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow-x: auto; /* For responsive tables */
    }
    .order-table-card .table {
        margin-bottom: 0;
    }
    .order-table-card .table thead th {
        background-color: #0d6efd;
        color: white;
        border-bottom: none;
        padding: 15px;
        vertical-align: middle;
    }
    .order-table-card .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #eee;
    }
    .order-table-card .table tbody tr:last-child td {
        border-bottom: none;
    }
    .status-badge {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
        border-radius: 20px;
        min-width: 90px;
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

    .no-orders-found {
        background-color: #fff;
        border-radius: 15px;
        padding: 50px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .no-orders-found .bi {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 20px;
    }
    .pagination .page-item .page-link {
        border-radius: 8px;
        margin: 0 4px;
        color: #0d6efd;
        border-color: #0d6efd;
        transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    .pagination .page-item .page-link:hover {
        background-color: #0a58ca;
        border-color: #0a58ca;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <h2 class="section-title" data-aos="fade-down">Manajemen Pesanan</h2>

    {{-- Filter and Search Section --}}
    <div class="filter-card" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Pesanan/Pelanggan</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="ID Pesanan, Nama, Email..." value="{{ $request->search }}">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status Pesanan</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    @foreach($allOrderStatuses as $status)
                        <option value="{{ $status }}" {{ $request->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="payment_status" class="form-label">Status Pembayaran</label>
                <select class="form-select" id="payment_status" name="payment_status">
                    <option value="">Semua Status Pembayaran</option>
                    @foreach($allPaymentStatuses as $status)
                        <option value="{{ $status }}" {{ $request->payment_status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </form>
    </div>

    {{-- Order List Table --}}
    @if ($orders->isEmpty())
        <div class="no-orders-found" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-box-seam"></i>
            <h4 class="mt-3">Tidak ada pesanan ditemukan.</h4>
            <p class="text-muted">Coba ubah kriteria pencarian atau filter Anda.</p>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary mt-3">Reset Filter</a>
        </div>
    @else
        <div class="order-table-card" data-aos="fade-up" data-aos-delay="200">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }} <br><small class="text-muted">{{ $order->user->email ?? '' }}</small></td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge bg-{{ Str::slug($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge bg-{{ Str::slug($order->payment_status) }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white rounded-pill">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4" data-aos="fade-up" data-aos-delay="300">
            {{ $orders->appends($request->except('page'))->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
{{-- AOS init is already in layouts/app.blade.php --}}
@endpush
