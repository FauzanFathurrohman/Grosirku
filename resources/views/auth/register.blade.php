@extends('layouts.app')

@section('title', 'Daftar - Grosirku')

@section('content')

    <div class="auth-header">
        <h2 class="mb-1">Ayo Bergabung!</h2>
        <p class="text-muted">Daftarkan akun Anda sekarang untuk memulai.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group text-start">
            <label for="name" class="form-label visually-hidden">Nama Lengkap</label>
            <input type="text" name="name" id="name" placeholder="Nama Lengkap Anda" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-start">
            <label for="email" class="form-label visually-hidden">Alamat Email</label>
            <input type="email" name="email" id="email" placeholder="Alamat Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-start">
            <label for="password" class="form-label visually-hidden">Kata Sandi Baru</label>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Buat Kata Sandi Baru"
                    class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                <button class="toggle-btn" type="button" onclick="togglePassword('password')" aria-label="Toggle password visibility">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-start">
            <label for="password_confirmation" class="form-label visually-hidden">Konfirmasi Kata Sandi</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                    class="form-control" required autocomplete="new-password">
                <button class="toggle-btn" type="button" onclick="togglePassword('password_confirmation')" aria-label="Toggle password visibility">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>

        <div class="mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="forgot-link">Login sekarang</a>
        </div>

        <div class="site-link-container">
            <a href="{{ url('/') }}" class="site-link">www.Grosirku.com</a>
        </div>
    </form>

@endsection