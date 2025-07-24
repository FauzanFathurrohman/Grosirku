@extends('layouts.app')

@section('title', 'Reset Kata Sandi - Grosirku')

@section('content')

    {{-- Konten ini akan dibungkus oleh .auth-card di layouts/app.blade.php --}}

    <div class="auth-header">
        <h2 class="mb-1">Atur Ulang Kata Sandi</h2>
        <p class="text-muted">Masukkan kata sandi baru Anda di bawah.</p>
    </div>

    {{-- Pesan status dari sesi (misalnya, setelah berhasil mengirim link reset) --}}
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
        </div>
    @endif

    {{-- Pesan error dari sesi (misalnya, token tidak valid) --}}
    @if (session('error'))
        <div class="alert alert-danger mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- PENTING: method harus POST, dan gunakan @method('PUT') --}}
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT') {{-- Ini yang memberitahu Laravel untuk memperlakukan ini sebagai PUT request --}}

        {{-- Hidden fields untuk token dan email --}}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ old('email', $email) }}">

        {{-- Input Kata Sandi Baru --}}
        <div class="form-group text-start">
            <label for="password" class="form-label visually-hidden">Kata Sandi Baru</label>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Kata Sandi Baru"
                    class="form-control @error('password') is-invalid @enderror"
                    required autocomplete="new-password" autofocus>
                <button class="toggle-btn" type="button" onclick="togglePassword('password')" aria-label="Toggle password visibility">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Konfirmasi Kata Sandi --}}
        <div class="form-group text-start">
            <label for="password_confirmation" class="form-label visually-hidden">Konfirmasi Kata Sandi</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    required autocomplete="new-password">
                <button class="toggle-btn" type="button" onclick="togglePassword('password_confirmation')" aria-label="Toggle password confirmation visibility">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Reset Kata Sandi</button>

        <div class="site-link-container">
            <a href="{{ url('/') }}" class="site-link">www.Grosirku.com</a>
        </div>
    </form>

@endsection

{{-- Tidak perlu script atau style tambahan di sini, sudah di app.blade.php --}}
