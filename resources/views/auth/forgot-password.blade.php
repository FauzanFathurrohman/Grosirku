@extends('layouts.app')

@section('content')

<div class="forgot-container">
    <h2 class="mb-3">Lupa Password</h2>
    <p class="mb-4 text-muted">Masukkan email Anda untuk mendapatkan link reset password.</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3 text-start">
            <input type="email" name="email" id="email" placeholder="Email Terdaftar"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>

    <div class="mt-3">
        <a href="{{ url('/') }}" class="text-muted" style="font-size: 0.85rem;">www.Grosirku.com</a>
    </div>
</div>
@endsection
