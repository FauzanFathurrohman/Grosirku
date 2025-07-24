@extends('layouts.app')

@section('title', 'Daftar Pesanan Masuk (Admin) - Grosirku')

@section('content')

{{-- Hapus semua link CDN CSS/JS di sini, karena sudah di-load di layouts/app.blade.php --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}
{{-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> --}}

@push('styles')
<style>
    /* Custom styles for admin orders page */
    body {
        background-color: #f0f2f5; /* Light grey background */
    }

    .header-section {
        background: linear-gradient(to right, #0d6efd, #007bff); /* Menggunakan primary Bootstrap color */
        color: white;
        padding: 30px 0;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(13, 110, 253, 0.2); /* Shadow sesuai warna primary */
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
    .header-section .btn-light-outline {
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }
    .header-section .btn-light-outline:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: white;
    }

    /* Empty State Alert */
    .alert-info-empty {
        background-color: #e6f7ff; /* Light blue */
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
    .alert-info-empty .bi {
        font-size: 3rem;
        color: #007bff;
    }
    .alert-info-empty p {
        margin-bottom: 0;
    }

    /* Table Styling */
    .table-container {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        padding: 15px 15px;
        vertical-align: middle;
        text-align: center;
    }
    .table thead th:first-child { text-align: left; }
    .table thead th:nth-child(2) { text-align: left; }
    .table thead th:nth-child(3) { text-align: left; }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table tbody td {
        padding: 15px 15px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        color: #343a40;
        text-align: center;
    }
    .table tbody td:first-child,
    .table tbody td:nth-child(2),
    .table tbody td:nth-child(3),
    .table tbody td:nth-child(8), /* Alamat */
    .table tbody td:nth-child(9) { /* Catatan */
        text-align: left;
    }

    /* Product List in cell */
    .table tbody td ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .table tbody td ul li {
        margin-bottom: 3px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }
    .table tbody td ul li .text-muted {
        font-size: 0.8rem;
        white-space: nowrap;
    }

    /* Status Badges */
    .badge-status {
        padding: 0.5em 0.8em;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    /* Order Status colors */
    .badge-pending { background-color: #ffc107; color: #343a40; } /* Yellow */
    .badge-proses { background-color: #0dcaf0; color: white; } /* Info/Light Blue */
    .badge-dikirim { background-color: #0d6efd; color: white; } /* Primary/Blue */
    .badge-selesai { background-color: #198754; color: white; } /* Success/Green */
    .badge-dibatalkan { background-color: #dc3545; color: white; } /* Danger/Red */
    .badge-dikembalikan { background-color: #6c757d; color: white; } /* Secondary/Grey */
    .badge-default { background-color: #6c757d; color: white; } /* Default secondary */

    /* Payment Status colors */
    .badge-belum-dibayar { background-color: #dc3545; color: white; }
    .badge-sudah-dibayar { background-color: #198754; color: white; } /* Success/Green */

    /* Dropdown and Button in table */
    .table form .form-select-sm {
        font-size: 0.85rem;
        padding: 0.4rem 1rem;
        border-radius: 0.3rem;
    }
    .table form .btn-sm {
        font-size: 0.85rem;
        padding: 0.4rem 1rem;
        border-radius: 0.3rem;
    }
    .table form button.w-100 {
        margin-top: 5px;
    }

    /* Print Button */
    .btn-print {
        background-color: #6f42c1; /* Purple */
        border-color: #6f42c1;
        color: white;
        transition: background-color 0.3s ease;
    }
    .btn-print:hover {
        background-color: #563d7c;
        border-color: #563d7c;
        color: white;
    }

    /* Responsive Table (Card-like layout on small screens) */
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
        .header-section .btn {
            width: 100%;
        }

        .table thead {
            display: none;
        }
        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }
        .table tr {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
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
            word-wrap: break-word;
        }
        .table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: calc(50% - 30px);
            text-align: left;
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .table tbody td:first-child {
            padding-top: 15px;
        }
        .table tbody td:last-child {
            padding-bottom: 15px;
        }
        .table tbody td:nth-child(3) ul {
            text-align: right;
            padding-left: 0;
        }
        .table tbody td:nth-child(3) ul li {
            justify-content: flex-end;
        }
        .table tbody td:nth-child(3)::before {
            align-self: flex-start;
            padding-top: 8px;
        }

        /* Adjustments for update forms in responsive view */
        .table tbody td form {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: flex-end;
        }
        .table tbody td form button.w-100 {
            width: auto !important;
            align-self: flex-end;
            margin-top: 0;
        }
    }
</style>
@endpush

<div class="container py-5">
    <div class="header-section mb-5" data-aos="fade-down">
        <h2>
            <i class="bi bi-box-seam-fill"></i> Pesanan Masuk
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light-outline" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-speedometer2 me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Pesan Status (Success/Error) --}}
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="alert alert-info-empty shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-inbox-fill"></i>
            <p>Belum ada pesanan masuk saat ini.</p>
            <p class="text-muted small">Cek kembali nanti atau kunjungi <a href="{{ route('admin.orders.index') }}" class="alert-link">halaman laporan penjualan</a>.</p>
        </div>
    @else
    <div class="table-container shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="300">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status Pesanan</th>
                        <th scope="col">Ubah Status</th>
                        <th scope="col">Waktu Pesanan</th>
                        <th scope="col">Alamat Pengiriman</th>
                        <th scope="col">Catatan</th>
                        <th scope="col">Metode Pembayaran</th>
                        <th scope="col">Info Pembayaran</th> {{-- Mengganti 'Bank' dengan 'Info Pembayaran' --}}
                        <th scope="col">Status Pembayaran</th>
                        <th scope="col">Aksi</th> {{-- Mengganti 'Cetak' dengan 'Aksi' untuk potensi aksi lain --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr data-aos="fade-up" data-aos-delay="{{ 50 * $loop->iteration }}">
                        <td data-label="ID Pesanan" class="fw-bold">#{{ $order->id }}</td>
                        {{-- Perbaikan: Gunakan operator null coalescing untuk user --}}
                        <td data-label="Pelanggan">{{ $order->user->name ?? 'Pengguna Dihapus' }}</td>
                        <td data-label="Detail Produk">
                            <ul class="list-unstyled">
                                {{-- Perbaikan: Gunakan @forelse untuk items --}}
                                @forelse ($order->items as $item)
                                    <li>
                                        {{-- Perbaikan: Gunakan operator null coalescing untuk product --}}
                                        <span>{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</span>
                                        <span class="text-muted">(x{{ $item->quantity }})</span>
                                    </li>
                                @empty
                                    <li>Tidak ada produk dalam pesanan ini.</li>
                                @endforelse
                            </ul>
                        </td>
                        <td data-label="Total Harga" class="text-success fw-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td data-label="Status Pesanan">
                            <span class="badge badge-status badge-{{ Str::slug($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td data-label="Ubah Status Pesanan">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select form-select-sm mb-1">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                    <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Telah Dikirim</option>
                                    <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="dikembalikan" {{ $order->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary mt-2 w-100"><i class="bi bi-arrow-clockwise me-1"></i> Update</button>
                            </form>
                        </td>
                        <td data-label="Waktu Pesanan"><i class="bi bi-clock me-1"></i>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td data-label="Alamat Pengiriman">{{ $order->shipping_address }}</td>
                        <td data-label="Catatan">{{ $order->note ?? '-' }}</td>
                        <td data-label="Metode Pembayaran">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td> {{-- Format agar lebih rapi --}}
                        <td data-label="Info Pembayaran">
                            @if ($order->payment_method == 'virtual_account')
                                {{ $order->bank_tujuan ?? 'N/A' }} {{-- Asumsi bank_tujuan menyimpan bank VA --}}
                            @elseif ($order->payment_method == 'qris')
                                QRIS
                            @elseif ($order->payment_method == 'cod')
                                COD
                            @else
                                -
                            @endif
                        </td>
                        <td data-label="Status Pembayaran">
                            <span class="badge badge-status badge-{{ Str::slug($order->payment_status) }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            <form action="{{ route('admin.orders.updatePayment', $order->id) }}" method="POST" class="mt-2">
                                @csrf
                                <select name="payment_status" class="form-select form-select-sm mb-1">
                                    <option value="belum dibayar" {{ $order->payment_status == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                    <option value="sudah dibayar" {{ $order->payment_status == 'sudah dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-success mt-2 w-100"><i class="bi bi-check-circle me-1"></i> Update</button>
                            </form>
                        </td>
                        <td data-label="Aksi">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info mb-1 w-100">
                                <i class="bi bi-eye-fill me-1"></i>Detail
                            </a>
                            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-sm btn-print w-100">
                                <i class="bi bi-printer-fill me-1"></i>Struk
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@endsection
