@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Grosirku')

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-size: 2.2rem;
        font-weight: 700;
    }
    .card-text.lead {
        font-size: 1.1rem;
    }
    .order-id-section {
        background-color: #e6ffe6; /* Light green background */
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }
    .payment-instructions-card {
        background: #f0f8ff; /* Light blue background */
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }
    .payment-instructions-card h5 {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .payment-instructions-card ol {
        list-style: decimal;
        padding-left: 20px;
    }
    .payment-instructions-card ol li {
        margin-bottom: 10px;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .payment-instructions-card .input-group .form-control {
        border-right: none;
    }
    .payment-instructions-card .input-group .btn-info {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    /* Removed product-recommendations styles as the section is removed from this file */

    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border-radius: 50px;
        padding: 10px 25px;
        font-size: 1.1rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-whatsapp:hover {
        background-color: #1DA851;
        color: white;
    }

    /* Styles for Payment Proof Upload */
    .payment-proof-section {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        margin-top: 30px;
        text-align: center;
    }
    .payment-proof-section h5 {
        color: #dc3545; /* Red for attention */
        font-weight: 600;
        margin-bottom: 20px;
    }
    .payment-proof-section .form-control-file {
        border: 2px dashed #0d6efd;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }
    .payment-proof-section .form-control-file:hover {
        border-color: #0a58ca;
    }
    .payment-proof-section .btn-upload {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        padding: 10px 20px;
        margin-top: 15px;
    }
    .payment-proof-section .btn-upload:hover {
        background-color: #0a58ca;
        border-color: #0a58ca;
    }
    .payment-proof-section img.proof-preview {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-top: 20px;
        border: 1px solid #eee;
    }

    /* Countdown Timer Style */
    .countdown-timer {
        font-size: 1.5rem;
        font-weight: bold;
        color: #dc3545; /* Red for urgency */
        margin-top: 15px;
    }
    .countdown-timer span {
        font-size: 2rem;
        color: #0d6efd;
    }

    /* Payment Status Timeline (simple) */
    .payment-status-timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 40px;
        position: relative;
        padding: 0 20px;
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
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.5rem;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .timeline-step.active .icon {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4);
    }
    .timeline-step.completed .icon {
        background-color: #28a745;
        color: white;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
    }
    .timeline-step .label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }
    .timeline-step.active .label,
    .timeline-step.completed .label {
        color: #343a40;
        font-weight: bold;
    }

    /* What's Next Section */
    .whats-next-section {
        background-color: #eaf7ed; /* Light green background */
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-top: 40px;
    }
    .whats-next-section h5 {
        color: #28a745;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .whats-next-section ul {
        list-style: none;
        padding-left: 0;
    }
    .whats-next-section ul li {
        margin-bottom: 10px;
        color: #495057;
    }
    .whats-next-section ul li i {
        color: #28a745;
        margin-right: 10px;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0" data-aos="fade-up">
                <div class="card-header bg-success text-white text-center rounded-top-4 py-4">
                    <i class="bi bi-check-circle-fill display-4 mb-3"></i>
                    <h1 class="card-title mb-0">Pesanan Berhasil Dibuat!</h1>
                    <p class="card-text lead mt-2">Terima kasih telah berbelanja di Grosirku.</p>
                </div>
                <div class="card-body p-5">
                    <div class="text-center order-id-section">
                        <p class="fs-5 text-muted mb-2">Nomor Pesanan Anda:</p>
                        <h2 class="text-success fw-bold display-5 mb-3">{{ $order->id }}</h2>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                            <i class="bi bi-box-seam me-2"></i> Lacak Pesanan Ini
                        </a>
                    </div>

                    <hr class="my-4">

                    {{-- Payment Status Message --}}
                    @if($order->payment_status === 'sudah dibayar')
                        <div class="alert alert-success text-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Pembayaran Anda telah berhasil dikonfirmasi! Pesanan akan segera diproses.
                        </div>
                    @else {{-- Status 'belum dibayar' atau 'menunggu verifikasi' --}}
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Pembayaran Anda belum diterima. Mohon segera selesaikan pembayaran.
                            @if($order->payment_method !== 'cod')
                                <div class="countdown-timer mt-3">
                                    Sisa waktu pembayaran: <span id="countdown"></span>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Payment Status Timeline --}}
                    <div class="payment-status-timeline">
                        <div class="timeline-step completed">
                            <div class="icon"><i class="bi bi-receipt"></i></div>
                            <div class="label">Pesanan Dibuat</div>
                        </div>
                        <div class="timeline-step {{ $order->payment_status === 'sudah dibayar' ? 'completed' : ($order->proof_of_payment_image ? 'active' : '') }}">
                            <div class="icon"><i class="bi bi-wallet"></i></div>
                            <div class="label">Pembayaran</div>
                        </div>
                        <div class="timeline-step {{ $order->status === 'proses' || $order->status === 'dikirim' || $order->status === 'selesai' ? 'completed' : '' }}">
                            <div class="icon"><i class="bi bi-box-seam"></i></div>
                            <div class="label">Diproses</div>
                        </div>
                        <div class="timeline-step {{ $order->status === 'dikirim' || $order->status === 'selesai' ? 'completed' : '' }}">
                            <div class="icon"><i class="bi bi-truck"></i></div>
                            <div class="label">Dikirim</div>
                        </div>
                        <div class="timeline-step {{ $order->status === 'selesai' ? 'completed' : '' }}">
                            <div class="icon"><i class="bi bi-check-circle"></i></div>
                            <div class="label">Selesai</div>
                        </div>
                    </div>


                    <h4 class="mb-3 text-primary">Detail Pesanan</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Belanja
                            <span class="fw-bold fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Metode Pembayaran
                            <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </li>
                        @if($order->payment_method === 'virtual_account' && $order->bank_tujuan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Bank Tujuan
                            <span>{{ $order->bank_tujuan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-column align-items-start">
                            Nomor Virtual Account
                            <div class="input-group mt-2 w-100">
                                <input type="text" id="va_nomor_display" class="form-control text-center fw-bold" readonly value="">
                                <button type="button" class="btn btn-info copy-button" onclick="copyToClipboard('va_nomor_display')"><i class="bi bi-clipboard"></i> Salin</button>
                            </div>
                            <small class="text-muted mt-1">Silakan transfer ke nomor VA di atas.</small>
                        </li>
                        @elseif($order->payment_method === 'qris')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-column align-items-start">
                            QRIS / E-Wallet
                            <img src="{{ asset('images/qris.png') }}" alt="QRIS QR Code" class="img-fluid rounded mt-2" style="max-width: 180px;"/>
                            <small class="text-muted mt-2">Scan QR code untuk pembayaran.</small>
                        </li>
                        @elseif($order->payment_method === 'transfer_bank_manual')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-column align-items-start">
                            Detail Rekening Bank
                            <p class="mt-2 mb-1">Bank: **BCA**</p>
                            <p class="mb-1">Nomor Rekening: **1234567890**</p>
                            <p class="mb-0">Atas Nama: **PT Grosirku Sejahtera**</p>
                            <small class="text-muted mt-1">Mohon transfer sesuai total belanja dan upload bukti.</small>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Alamat Pengiriman
                            <span>{{ $order->shipping_address }}</span>
                        </li>
                        @if($order->note)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Catatan
                            <span>{{ $order->note }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Status Pesanan
                            <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Status Pembayaran
                            <span class="badge {{ $order->payment_status === 'sudah dibayar' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($order->payment_status) }}</span>
                        </li>
                        {{-- Display proof of payment if exists --}}
                        @if($order->proof_of_payment_image)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-column align-items-start">
                            Bukti Pembayaran Anda:
                            <img src="{{ asset('uploads/proofs/' . $order->proof_of_payment_image) }}" alt="Bukti Pembayaran" class="img-fluid proof-preview mt-2" style="max-width: 250px;">
                            @if($order->payment_status === 'belum dibayar')
                                <small class="text-muted mt-1">Bukti pembayaran Anda sedang diverifikasi.</small>
                            @else
                                <small class="text-success mt-1">Pembayaran telah dikonfirmasi berdasarkan bukti ini.</small>
                            @endif
                        </li>
                        @endif
                    </ul>

                    <h5 class="mb-3 text-secondary">Produk dalam Pesanan:</h5>
                    <ul class="list-group mb-4">
                        @foreach($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                    <br>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="fw-bold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Bagian Instruksi Pembayaran & Upload Bukti --}}
                    @if($order->payment_status === 'belum dibayar' && $order->payment_method !== 'cod')
                        <div class="payment-instructions-card mt-5" data-aos="fade-up" data-aos-delay="100">
                            <h5 class="text-center mb-4">Cara Melakukan Pembayaran</h5>
                            {{-- Instruksi VA --}}
                            <div id="va-instructions" style="{{ $order->payment_method === 'virtual_account' ? '' : 'display:none;' }}">
                                <p class="text-center text-muted">Ikuti langkah-langkah berikut untuk menyelesaikan pembayaran melalui Virtual Account {{ $order->bank_tujuan }}:</p>
                                <ol>
                                    <li>Salin Nomor Virtual Account di atas.</li>
                                    <li>Buka aplikasi mobile banking atau internet banking Anda.</li>
                                    <li>Pilih menu "Transfer" atau "Pembayaran Virtual Account".</li>
                                    <li>Masukkan Nomor Virtual Account yang telah disalin.</li>
                                    <li>Pastikan nama penerima adalah "Grosirku" dan jumlah pembayaran sesuai dengan total belanja Anda.</li>
                                    <li>Lanjutkan pembayaran hingga selesai.</li>
                                </ol>
                            </div>
                            {{-- Instruksi QRIS --}}
                            <div id="qris-instructions" style="{{ $order->payment_method === 'qris' ? '' : 'display:none;' }}">
                                <p class="text-center text-muted">Ikuti langkah-langkah berikut untuk menyelesaikan pembayaran melalui QRIS:</p>
                                <ol>
                                    <li>Simpan gambar QRIS di atas atau scan langsung dari aplikasi e-wallet/mobile banking Anda.</li>
                                    <li>Buka aplikasi e-wallet (Dana, OVO, Gopay, LinkAja, ShopeePay, dll.) atau mobile banking Anda.</li>
                                    <li>Pilih fitur "Scan QR" atau "Pembayaran QRIS".</li>
                                    <li>Upload atau scan QR code yang telah disediakan.</li>
                                    <li>Pastikan nama penerima adalah "Grosirku" dan jumlah pembayaran sesuai dengan total belanja Anda.</li>
                                    <li>Lanjutkan pembayaran hingga selesai.</li>
                                </ol>
                            </div>
                            {{-- Instruksi Transfer Bank Manual --}}
                            <div id="manual-transfer-instructions" style="{{ $order->payment_method === 'transfer_bank_manual' ? '' : 'display:none;' }}">
                                <p class="text-center text-muted">Ikuti langkah-langkah berikut untuk menyelesaikan pembayaran melalui Transfer Bank Manual:</p>
                                <ol>
                                    <li>Lakukan transfer sesuai total belanja ke rekening yang tertera di atas.</li>
                                    <li>Pastikan nama penerima adalah "PT Grosirku Sejahtera".</li>
                                    <li>Simpan bukti transfer (screenshot/foto).</li>
                                    <li>Lanjutkan ke bagian "Upload Bukti Pembayaran" di bawah ini.</li>
                                </ol>
                            </div>
                            <p class="text-center mt-4">
                                <small class="text-muted">Pembayaran Anda akan terverifikasi secara otomatis dalam beberapa menit setelah transfer berhasil (untuk VA/QRIS) atau setelah verifikasi manual (untuk transfer bank).</small>
                            </p>
                        </div>

                        {{-- Payment Proof Upload Section --}}
                        @if(!$order->proof_of_payment_image)
                        <div class="payment-proof-section mt-5" data-aos="fade-up" data-aos-delay="200">
                            <h5><i class="bi bi-file-earmark-arrow-up-fill me-2"></i> Upload Bukti Pembayaran</h5>
                            <p class="text-muted">Mohon unggah bukti transfer Anda untuk mempercepat proses verifikasi.</p>
                            <form action="{{ route('orders.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="proof_image" class="form-label visually-hidden">Pilih File Bukti Pembayaran</label>
                                    <input class="form-control form-control-lg form-control-file" type="file" id="proof_image" name="proof_image" accept="image/jpeg,image/png" required>
                                    <small class="form-text text-muted">Format: JPG/PNG, Maks. 2MB.</small>
                                    @error('proof_image')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-upload">
                                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Unggah Bukti
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="payment-proof-section mt-5 bg-light" data-aos="fade-up" data-aos-delay="200">
                            <h5><i class="bi bi-clock-history me-2"></i> Bukti Pembayaran Telah Diunggah</h5>
                            <p class="text-muted">Bukti pembayaran Anda sedang dalam proses verifikasi oleh tim kami. Mohon tunggu konfirmasi lebih lanjut.</p>
                        </div>
                        @endif
                    @endif

                    {{-- What's Next Section --}}
                    <div class="whats-next-section mt-5" data-aos="fade-up" data-aos-delay="300">
                        <h5><i class="bi bi-info-circle-fill me-2"></i> Langkah Selanjutnya</h5>
                        <ul>
                            @if($order->payment_status === 'belum dibayar')
                                <li><i class="bi bi-dot"></i> Segera selesaikan pembayaran Anda sebelum waktu habis.</li>
                                @if($order->payment_method === 'transfer_bank_manual' && !$order->proof_of_payment_image)
                                    <li><i class="bi bi-dot"></i> Unggah bukti pembayaran Anda di bagian atas halaman ini.</li>
                                @endif
                                <li><i class="bi bi-dot"></i> Status pembayaran akan diperbarui setelah verifikasi.</li>
                            @else
                                <li><i class="bi bi-dot"></i> Pesanan Anda dengan ID **{{ $order->id }}** telah berhasil dibayar.</li>
                                <li><i class="bi bi-dot"></i> Kami akan segera memproses pesanan Anda.</li>
                            @endif
                            <li><i class="bi bi-dot"></i> Anda akan menerima notifikasi email/SMS (jika diimplementasikan) mengenai status pesanan.</li>
                            <li><i class="bi bi-dot"></i> Kunjungi halaman <a href="{{ route('orders.index') }}">Riwayat Pesanan</a> untuk melacak status pesanan Anda.</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-3 mt-5">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg rounded-pill">
                            <i class="bi bi-list-check me-2"></i> Lihat Riwayat Pesanan
                        </a>
                        <a href="{{ route('katalog.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                            <i class="bi bi-shop me-2"></i> Lanjutkan Belanja
                        </a>
                        <a href="https://wa.me/6282128415128?text=Halo%20admin,%20saya%20ingin%20menanyakan%20status%20pesanan%20saya%20dengan%20nomor%20{{ $order->id }}.%20Mohon%20bantuannya.%20Terima%20kasih." target="_blank" class="btn btn-whatsapp btn-lg rounded-pill mt-3"><i class="bi bi-whatsapp me-2"></i> Hubungi Customer Service
                        </a></a>
                            
                            
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- The product recommendations section was removed from this file as it's typically found on other pages like homepage or product detail --}}

</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menyalin teks ke clipboard (sama seperti di cart.blade.php)
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

    document.addEventListener('DOMContentLoaded', function() {
        // Logika untuk mengisi nomor VA di halaman sukses
        const vaNomorDisplay = document.getElementById('va_nomor_display');
        if (vaNomorDisplay) {
            const paymentMethod = "{{ $order->payment_method }}";
            const bankTujuan = "{{ $order->bank_tujuan }}";

            if (paymentMethod === 'virtual_account' && bankTujuan) {
                const vaMap = {
                    'VA_BCA': '88081234567890', // Nomor VA dummy
                    'VA_BNI': '88099876543210', // Nomor VA dummy
                    'VA_BRI': '88085555555555', // Nomor VA dummy
                    'VA_Mandiri': '88091111111111' // Nomor VA dummy
                };
                vaNomorDisplay.value = vaMap[bankTujuan] || 'Nomor VA tidak tersedia';
            }
        }

        // Countdown Timer (contoh: 24 jam dari created_at)
        const countdownElement = document.getElementById('countdown');
        if (countdownElement) {
            // Pastikan $order->created_at tersedia dan dalam format yang bisa diparse oleh JavaScript
            // Misalnya, 'YYYY-MM-DD HH:MM:SS'
            const orderCreatedAtStr = "{{ $order->created_at }}";
            const orderCreatedAt = new Date(orderCreatedAtStr);

            // Jika orderCreatedAt tidak valid, atau jika Anda ingin batas waktu yang berbeda
            if (isNaN(orderCreatedAt.getTime())) {
                console.error("Invalid order created_at date:", orderCreatedAtStr);
                // Fallback to current time + 24 hours if created_at is invalid
                // const paymentDeadline = new Date(Date.now() + (24 * 60 * 60 * 1000));
                countdownElement.innerHTML = "Waktu pembayaran tidak tersedia.";
                return;
            }

            // Batas waktu pembayaran (misal: 24 jam setelah order dibuat)
            const paymentDeadline = new Date(orderCreatedAt.getTime() + (24 * 60 * 60 * 1000));

            const updateCountdown = setInterval(() => {
                const now = new Date().getTime();
                const distance = paymentDeadline - now;

                if (distance < 0) {
                    clearInterval(updateCountdown);
                    countdownElement.innerHTML = "Waktu pembayaran habis!";
                    // Opsional: Kirim AJAX request ke backend untuk update status order
                    // fetch('/orders/{{ $order->id }}/mark-expired', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let countdownText = '';
                if (days > 0) countdownText += `${days}h `;
                countdownText += `${hours}j ${minutes}m ${seconds}d`;

                countdownElement.innerHTML = countdownText;
            }, 1000);
        }
    });
</script>
@endpush
