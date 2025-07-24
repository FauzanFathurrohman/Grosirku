@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg" style="width: 600px;">
        <div class="card-body text-center">
            <h4 class="mb-4">Verifikasi Email</h4>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success">
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <p>Silakan periksa email Anda dan klik link verifikasi untuk melanjutkan.</p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Kirim Ulang Link Verifikasi</button>
            </form>

            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
