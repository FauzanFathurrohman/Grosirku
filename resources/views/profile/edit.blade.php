@extends('layouts.app')

@section('title', 'Edit Profil Pengguna - Grosirku')

@push('styles')
<style>
    /* Custom styles for profile page */
    body {
        background-color: #f8f9fa; /* Light grey background */
    }

    .card {
        border-radius: 1rem; /* More rounded corners */
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1); /* Stronger shadow */
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .profile-avatar-lg {
        width: 120px;
        height: 120px;
        border: 3px solid #0d6efd; /* Border warna primary Bootstrap */
        object-fit: cover;
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.2); /* Shadow yang lebih menonjol */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .profile-avatar-lg:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
    }

    .form-label {
        font-weight: 600; /* Label form lebih bold */
        color: #343a40; /* Warna teks label yang lebih gelap */
        margin-bottom: 0.5rem;
    }

    .form-control-lg {
        padding: 0.75rem 1.25rem; /* Padding lebih besar untuk input */
        border-radius: 0.75rem; /* Sudut lebih membulat */
        font-size: 1.1rem;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0a58ca;
        border-color: #0a53be;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
    }

    .btn-outline-secondary {
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.1);
    }

    .btn-danger {
        font-weight: 500;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.2);
    }

    .btn-warning { /* Gaya untuk tombol ubah kata sandi */
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529; /* Teks gelap agar kontras dengan kuning */
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.2);
    }

    /* Modal styling */
    .modal-content {
        border-radius: 1.25rem; /* Lebih membulat */
        border: none;
        overflow: hidden;
    }
    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
    }
    .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
    }
    .modal-body {
        padding: 2rem;
    }
    .modal-footer {
        padding: 1.5rem;
        border-top: none;
    }

    /* Password toggle button styles */
    .input-group .toggle-btn {
        background-color: #e9ecef; /* Light grey background */
        border: 1px solid #ced4da;
        border-left: none;
        border-top-right-radius: 0.75rem; /* Match input border-radius */
        border-bottom-right-radius: 0.75rem; /* Match input border-radius */
        padding: 0.75rem 1.25rem;
        cursor: pointer;
        color: #6c757d;
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    .input-group .toggle-btn:hover {
        background-color: #dee2e6;
        color: #495057;
    }
    .input-group .form-control:focus + .toggle-btn {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        {{-- Bagian Edit Informasi Profil --}}
        <div class="col-lg-8 col-md-10 mb-5">
            <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5" data-aos="fade-up" data-aos-duration="800">
                <div class="card-body">
                    <h2 class="text-center fw-bold mb-4 text-primary">
                        <i class="bi bi-person-circle me-2"></i> Kelola Profil Anda
                    </h2>
                    <p class="text-center text-muted mb-5">
                        Perbarui informasi pribadi dan foto profil Anda di sini.
                    </p>

                    @if(session('error')) {{-- Menggunakan nama sesi yang lebih umum --}}
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- Pesan error validasi untuk form update profil (jika ada) --}}
                    @if ($errors->updateProfileInformation->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Ada kesalahan dalam input Anda. Mohon periksa kembali.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Foto Profil --}}
                        <div class="mb-4 text-center">
                            <label for="photo-upload" class="form-label d-block mb-3 fw-bold">Foto Profil</label>
                            <img id="profile-preview"
                                src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/default-avatar.png') }}"
                                alt="Foto Profil" class="rounded-circle mb-3 profile-avatar-lg shadow-sm">

                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                                <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                    id="photo-upload" name="photo" accept="image/*">

                                @if($user->photo)
                                    {{-- Tombol Hapus Foto yang memicu modal --}}
                                    <button type="button" class="btn btn-danger d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#deletePhotoModal">
                                        <i class="bi bi-trash-fill me-2"></i> Hapus Foto
                                    </button>
                                @endif
                            </div>
                            @error('photo')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save-fill me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle-fill me-2"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bagian Ubah Kata Sandi --}}
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                <div class="card-body">
                    <h2 class="text-center fw-bold mb-4 text-warning">
                        <i class="bi bi-key-fill me-2"></i> Ubah Kata Sandi
                    </h2>
                    <p class="text-center text-muted mb-5">
                        Pastikan akun Anda tetap aman dengan kata sandi yang kuat dan unik.
                    </p>

                    {{-- Pesan Status (Success/Error) untuk update password --}}
                    @if(session('password_success')) {{-- Menggunakan nama sesi yang lebih spesifik dan umum --}}
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('password_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('password_error')) {{-- Menggunakan nama sesi yang lebih spesifik dan umum --}}
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('password_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- Pesan error validasi untuk form update password (jika ada) --}}
                    @if ($errors->updatePassword->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Ada kesalahan dalam perubahan kata sandi Anda. Mohon periksa kembali.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT') {{-- Metode PUT untuk update password --}}

                        {{-- Kata Sandi Saat Ini --}}
                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-bold">Kata Sandi Saat Ini</label>
                            <div class="input-group">
                                <input id="current_password" type="password" name="current_password"
                                    class="form-control form-control-lg @error('current_password', 'updatePassword') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="Masukkan kata sandi Anda saat ini">
                                <button class="toggle-btn" type="button" onclick="togglePassword('current_password')" aria-label="Toggle current password visibility">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kata Sandi Baru --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Kata Sandi Baru</label>
                            <div class="input-group">
                                <input id="password" type="password" name="password"
                                    class="form-control form-control-lg @error('password', 'updatePassword') is-invalid @enderror"
                                    autocomplete="new-password" placeholder="Buat kata sandi baru">
                                <button class="toggle-btn" type="button" onclick="togglePassword('password')" aria-label="Toggle new password visibility">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Kata Sandi Baru --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Kata Sandi Baru</label>
                            <div class="input-group">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control form-control-lg @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                    autocomplete="new-password" placeholder="Konfirmasi kata sandi baru Anda">
                                <button class="toggle-btn" type="button" onclick="togglePassword('password_confirmation')" aria-label="Toggle password confirmation visibility">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-arrow-clockwise me-2"></i> Ubah Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Foto --}}
<div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title" id="deletePhotoModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus Foto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="lead mb-4">Apakah Anda yakin ingin menghapus foto profil Anda?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer justify-content-center border-top-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                {{-- Form DELETE untuk menghapus foto --}}
                <form action="{{ route('profile.photo.delete') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoUpload = document.getElementById('photo-upload');
        const profilePreview = document.getElementById('profile-preview');

        // Fungsi untuk menampilkan preview gambar yang diunggah
        if (photoUpload) {
            photoUpload.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file dipilih, kembali ke avatar default atau yang sudah ada
                    // Menggunakan logic yang sama seperti di Blade untuk path default
                    profilePreview.src = "{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/default-avatar.png') }}";
                }
            });
        }
    });

    // Fungsi untuk toggle password visibility
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i'); // Get the icon within the next sibling (button)

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-fill');
            icon.classList.add('bi-eye-slash-fill');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash-fill');
            icon.classList.add('bi-eye-fill');
        }
    }
</script>
@endpush
