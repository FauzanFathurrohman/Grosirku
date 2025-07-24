@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg" style="width: 500px;">
        <div class="card-body">
            <h4 class="text-center mb-4">Konfirmasi Password</h4>
            <p class="text-muted text-center">Sebelum melanjutkan, silakan konfirmasi password Anda.</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required autofocus>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Konfirmasi</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}">Lupa Password?</a>
            </div>
        </div>
    </div>
</div>
@endsection
