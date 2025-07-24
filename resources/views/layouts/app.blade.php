<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Grosirku - Solusi Grosir Anda')</title>

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS (dengan integrity dan crossorigin) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Bootstrap Icons CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- AOS (Animate On Scroll) CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Custom Styles for Layout & Auth Pages --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5; /* Warna latar belakang yang lembut dan modern untuk seluruh situs */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex-grow: 1; /* Konten utama akan mengisi ruang di antara header dan footer */
            padding-top: 30px; /* Jaga padding atas */
            padding-bottom: 30px; /* Jaga padding bawah */
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 6px 15px rgba(0,0,0,.08); /* Sedikit lebih kuat, elegan */
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .navbar-brand {
            font-weight: 700;
            color: #2c3e50 !important;
            font-size: 1.8rem;
            transition: color 0.3s ease;
        }
        .navbar-brand:hover {
            color: #0d6efd !important; /* Biru primer Bootstrap */
        }
        .navbar-brand img {
            filter: drop-shadow(2px 2px 3px rgba(0,0,0,0.1));
        }
        .nav-link {
            font-weight: 500;
            color: #5f6e7d !important;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        .nav-link:hover {
            color: #0d6efd !important; /* Biru primer Bootstrap */
            transform: translateY(-2px);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -5px; /* Sesuaikan jika perlu */
            width: 0;
            height: 2px;
            background-color: #0d6efd; /* Biru primer Bootstrap */
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: calc(100% - 1.5rem);
        }
        .nav-link.active {
            color: #0d6efd !important;
            font-weight: 600;
        }
        .btn-outline-primary {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
            border-color: #0d6efd; /* Gunakan warna primary Bootstrap */
            color: #0d6efd; /* Gunakan warna primary Bootstrap */
        }
        .btn-outline-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
            background-color: #0d6efd; /* Mengisi warna saat hover */
            color: white !important; /* Teks jadi putih saat hover */
        }
        .btn-primary {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            background-color: #0d6efd; /* Warna primary Bootstrap */
            border-color: #0d6efd;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0a58ca; /* Varian gelap primary Bootstrap */
            border-color: #0a53be;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }
        .rounded-circle {
            border: 2px solid #0d6efd; /* Border dengan warna primary Bootstrap */
            object-fit: cover;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .rounded-circle:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.6);
        }
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,.15);
            padding: 10px 0;
        }
        .dropdown-item {
            font-weight: 400;
            color: #495057;
            padding: 10px 20px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: #e9ecef;
            color: #1a1a1a;
        }
        .dropdown-item i {
            color: #6c757d;
            margin-right: 0.75rem;
        }
        .dropdown-item:hover i {
            color: #0d6efd; /* Warna ikon berubah ke primary Bootstrap */
        }

        /* Alert styling */
        .alert {
            margin-top: 1.5rem;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        .alert i {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }
        .alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; }
        .alert-danger { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .alert-warning { background-color: #fff3cd; border-color: #ffeeba; color: #856404; }
        .alert-info { background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460; }

        .footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 30px 0;
            margin-top: auto;
            border-top: 1px solid #3a506b;
        }
        .footer a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #5faee3;
            text-decoration: underline;
        }

        /* Auth Pages Specific Styles */
        .auth-card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* Menggunakan min-height 100% untuk mengisi sisa ruang vertikal */
            /* Ini akan bekerja karena body adalah flex-column dan main flex-grow: 1 */
            min-height: 100%;
            padding: 30px 0; /* Memberi padding atas/bawah agar tidak terlalu mepet */
        }
        .auth-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px; /* Lebar maksimal form */
            text-align: center;
            animation: fadeInScale 0.6s ease-out forwards; /* AOS effect custom */
        }
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .auth-header h2 {
            font-weight: 700;
            color: #0d6efd; /* Warna primary Bootstrap */
            margin-bottom: 10px;
        }
        .auth-header p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 18px;
            border: 1px solid #dee2e6;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Input group untuk password toggle */
        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group .toggle-btn {
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
            border-left: 0;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #6c757d;
            display: flex; /* Untuk centering ikon */
            align-items: center;
            justify-content: center;
        }
        .input-group .toggle-btn:hover {
            background-color: #dee2e6;
            color: #343a40;
        }

        .form-check-input {
            border-radius: 5px; /* Sedikit membulat */
            border: 1px solid #ced4da;
            width: 1.25em; /* Ukuran kotak checkbox */
            height: 1.25em;
            margin-top: 0.25em;
            vertical-align: top;
            background-color: #fff;
            appearance: none; /* Reset default appearance */
            -webkit-appearance: none;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            outline: 0;
        }

        .form-check-label {
            color: #6c757d;
            font-size: 0.95rem;
            margin-left: 5px; /* Spasi dari checkbox */
            cursor: pointer;
        }

        .forgot-link, .register-link, .site-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease, text-decoration 0.2s ease;
        }
        .forgot-link:hover, .register-link:hover, .site-link:hover {
            color: #0a58ca;
            text-decoration: underline;
        }

        .site-link-container {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        /* Responsive adjustments for auth cards */
        @media (max-width: 575.98px) {
            .auth-card {
                padding: 30px 20px; /* Lebih kecil di mobile */
                margin: 0 15px; /* Memberi sedikit ruang di samping */
            }
        }

        /* Responsive adjustments for overall layout */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                padding-bottom: 1rem;
                padding-top: 1rem;
            }
            .nav-link::after {
                display: none;
            }
            .navbar-nav .nav-item:not(:last-child) {
                margin-bottom: 0.5rem;
            }
            .navbar-nav .btn {
                width: 100%;
            }
            .navbar-nav .btn.me-lg-2 {
                margin-right: 0 !important;
                margin-bottom: 0.5rem;
            }
            .navbar-brand {
                font-size: 1.5rem;
            }
            .navbar-brand img {
                height: 40px;
            }
            #navbarDropdown .d-none.d-lg-inline {
                display: none !important;
            }
            #navbarDropdown .rounded-circle {
                margin-right: 0 !important;
            }
        }
    </style>

    {{-- Stack for page-specific styles --}}
    @stack('styles')
</head>
<body>
    {{-- Navbar Section --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                {{-- Pastikan path logo ini benar. Contoh: 'img/logo.png' harus di 'public/img/logo.png' --}}
                <img src="{{ asset('img/logo.png') }}" alt="Grosirku" height="45" class="me-2"> Grosirku
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('katalog*') ? 'active' : '' }}" href="{{ route('katalog.index') }}">
                            <i class="bi bi-grid-fill me-1"></i> Katalog
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('cart*') ? 'active' : '' }}" href="{{ route('cart.cart') }}">
                                <i class="bi bi-cart-fill me-1"></i> Keranjang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                <i class="bi bi-box-seam-fill me-1"></i> Pesanan Saya
                            </a>
                        </li>
                        @can('isAdmin') {{-- Pastikan gate 'isAdmin' sudah terdefinisi di AuthServiceProvider --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-sliders me-1"></i> Dashboard Admin
                                </a>
                            </li>
                        @endcan
                    @endauth
                </ul>

                <ul class="navbar-nav align-items-lg-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary me-lg-2 mb-2 mb-lg-0" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white" href="{{ route('register') }}">
                                <i class="bi bi-person-plus-fill me-1"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- Pastikan path default avatar ini benar. Contoh: 'img/default-avatar.png' harus di 'public/img/default-avatar.png' --}}
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('img/default-avatar.png') }}"
                                    alt="Profil Pengguna" width="40" height="40" class="rounded-circle me-2">
                                <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle"></i> Edit Profil
                                    </a>
                                </li>
                                {{-- Jika ada halaman dashboard terpisah, bisa ditambahkan di sini --}}
                                {{-- <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer"></i> Dashboard
                                    </a>
                                </li> --}}
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content Section --}}
    <main class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-up">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-up">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert" data-aos="fade-up">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert" data-aos="fade-up">
                <i class="bi bi-info-circle-fill"></i>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Conditional wrapping for Auth pages --}}
        @if(Request::is('login') || Request::is('register') || Request::is('password/*'))
            <div class="auth-card-container">
                <div class="auth-card" data-aos="fade-up">
                    @yield('content')
                </div>
            </div>
        @else
            @yield('content')
        @endif
    </main>

    {{-- Footer Section --}}
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Grosirku - All rights reserved | Developed by <a href="https://github.com/FauzanFathurrohman" target="_blank" rel="noopener noreferrer">Fauzan Fathurrohman</a></p>
        </div>
    </footer>

    {{-- Bootstrap Bundle with Popper (dengan integrity dan crossorigin) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-quad',
        });

        // Function for password toggle (moved here for global access)
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
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

    {{-- Stack for page-specific scripts --}}
    @stack('scripts')
</body>
</html>
