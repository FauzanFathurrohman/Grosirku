@extends('layouts.app')

@section('title', 'Login - Grosirku') {{-- Judul spesifik untuk halaman login --}}

@section('content')

{{-- Konten ini sekarang akan dibungkus oleh .auth-card di layouts/app.blade.php --}}

    <div class="auth-header">
        <h2 class="mb-1">Selamat Datang Kembali!</h2>
        <p class="text-muted">Silakan masukkan detail akun Anda</p>
    </div>

    {{-- Menampilkan pesan status dari sesi (misalnya setelah reset password berhasil) --}}
    @if(session('status'))
        <div class="alert alert-success mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
        </div>
    @endif

    {{-- Menampilkan pesan error dari sesi (misalnya login gagal) --}}
    @if(session('error'))
        <div class="alert alert-danger mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group text-start">
            {{-- Label untuk aksesibilitas, disembunyikan secara visual karena ada placeholder --}}
            <label for="email" class="form-label visually-hidden">Alamat Email</label>
            <input type="email" name="email" id="email" placeholder="Alamat Email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                {{-- Menampilkan pesan validasi error untuk email --}}
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-start">
            <label for="password" class="form-label visually-hidden">Kata Sandi</label>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Kata Sandi"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="current-password">
                {{-- Tombol untuk menampilkan/menyembunyikan password, menggunakan fungsi global dari app.blade.php --}}
                <button class="toggle-btn" type="button" onclick="togglePassword('password')" aria-label="Toggle password visibility">
                    <i class="bi bi-eye-fill"></i> {{-- Menggunakan Bootstrap Icon --}}
                </button>
            </div>
            @error('password')
                {{-- Menampilkan pesan validasi error untuk password --}}
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 form-check text-start">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Ingat saya di perangkat ini</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>

        {{-- Link Lupa Kata Sandi, hanya tampil jika rute password.request ada --}}
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link d-block mb-3">Lupa Kata Sandi Anda?</a>
        @endif

        <div class="mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="register-link">Daftar sekarang</a>
        </div>

        <div class="site-link-container">
            <a href="{{ url('/') }}" class="site-link">www.Grosirku.com</a>
        </div>
    </form>

@endsection

{{-- Tidak perlu script tambahan di sini, sudah di app.blade.php --}}
{{-- Tidak perlu style tambahan di sini, sudah di app.blade.php --}}
