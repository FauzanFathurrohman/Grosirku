@extends('layouts.app') 

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 rounded-4" data-aos="fade-up">
                <div class="card-body text-center">
                    <h1 class="display-4 fw-bold text-success mb-4">Tentang Grosirku</h1>
                    <img src="{{ asset('img/logo.png') }}" alt="Grosirku Logo" class="img-fluid mb-4" style="max-height: 150px;" data-aos="zoom-in" data-aos-delay="200">
                    <p class="lead text-muted mb-4" data-aos="fade-up" data-aos-delay="400">
                        Grosirku adalah platform belanja online yang didedikasikan untuk menyediakan kebutuhan pokok dan barang grosir lainnya dengan harga terbaik, langsung dari kenyamanan rumah Anda.
                    </p>
                    <p class="text-secondary mb-4" data-aos="fade-up" data-aos-delay="600">
                        Kami berkomitmen untuk memberikan pengalaman belanja yang mudah, cepat, aman, dan efisien. Dengan jaringan pemasok terpercaya, kami menjamin kualitas produk dan ketepatan pengiriman untuk setiap pesanan.
                    </p>
                    <hr class="my-4">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="800">
                            <i class="fas fa-eye fa-3x text-success mb-3"></i>
                            <h5 class="fw-bold">Visi Kami</h5>
                            <p class="text-muted">Menjadi platform grosir online terkemuka yang memberdayakan rumah tangga dan UMKM di seluruh Indonesia.</p>
                        </div>
                        <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="1000">
                            <i class="fas fa-bullseye fa-3x text-success mb-3"></i>
                            <h5 class="fw-bold">Misi Kami</h5>
                            <p class="text-muted">Menyediakan akses mudah ke produk berkualitas dengan harga kompetitif, didukung layanan pelanggan prima.</p>
                        </div>
                        <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="1200">
                            <i class="fas fa-heart fa-3x text-success mb-3"></i>
                            <h5 class="fw-bold">Nilai Kami</h5>
                            <p class="text-muted">Integritas, Inovasi, Pelayanan Unggul, dan Keberlanjutan.</p>
                        </div>
                    </div>
                    <hr class="my-4">
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="1400">
                        Terima kasih telah memilih Grosirku sebagai mitra belanja Anda. Kami senantiasa berusaha untuk memberikan yang terbaik.
                    </p>
                    <a href="{{ route('katalog.index') }}" class="btn btn-success btn-lg mt-3" data-aos="zoom-in" data-aos-delay="1600">
                        Mulai Belanja Sekarang <i class="fas fa-shopping-basket ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Anda mungkin ingin menambahkan kembali AOS.init() jika halaman ini tidak langsung di-load dengan AOS global --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true, offset: 50 });
</script>
@endpush