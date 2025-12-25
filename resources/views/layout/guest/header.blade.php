<header class="header navbar-area py-2 sticky-top">
    <style>
        /* 1. Kustomisasi Navbar Utama */
        .header {
            background: rgba(255, 107, 129, 1);
            backdrop-filter: blur(10px);
            /* Efek Glassmorphism */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* 2. Link Navigasi */
        .navbar-nav .nav-item .nav-link {
            color: #444 !important;
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #F53C5E !important;
        }

        /* Underline effect saat hover */
        .navbar-nav .nav-item .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #F53C5E;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-item .nav-link:hover::after {
            width: 80%;
        }

        /* 3. Dropdown Menu Modern */
        .header .navbar-nav .dropdown-menu {
            display: block;
            visibility: hidden;
            opacity: 0;
            transform: translateY(15px);
            transition: all 0.3s ease;
            border-radius: 12px;
            padding: 10px;
            margin-top: 10px;
        }

        .header .navbar-nav .nav-item:hover .dropdown-menu {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .header .navbar-nav .dropdown-menu .dropdown-item {
            color: #555 !important;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 15px;
            transition: all 0.2s ease;
        }

        .header .navbar-nav .dropdown-menu .dropdown-item:hover {
            color: #fff !important;
            background-color: #F53C5E;
            transform: translateX(5px);
        }

        /* 4. Tombol Login/Daftar Pastel Style */
        .header .btn {
            border-radius: 50px;
            font-weight: 600;
            padding: 8px 22px;
            transition: all 0.3s ease;
        }

        .header .btn-primary-custom {
            background-color: #F53C5E;
            color: white;
            border: none;
        }

        .header .btn-primary-custom:hover {
            background-color: #d63351;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 60, 94, 0.3);
        }

        .header .btn-outline-custom {
            border: 2px solid #F53C5E;
            color: #F53C5E;
        }

        .header .btn-outline-custom:hover {
            background-color: rgba(245, 60, 94, 0.05);
            color: #f53d5f;
        }

        /* 5. Profile User */
        .user-greeting {
            color: #333;
            font-size: 0.9rem;
            letter-spacing: 0.2px;
        }

        .profile-img-container {
            position: relative;
        }

        .profile-img-container::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background: #28a745;
            border: 2px solid #fff;
            border-radius: 50%;
            bottom: 0;
            right: 0;
        }
    </style>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <nav class="navbar navbar-expand-lg">

                        {{-- 1. LOGO --}}
                        <a class="navbar-brand d-flex align-items-center me-4" href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo/logo1-horizontal.png') }}" alt="Logo SiBansos"
                                style="height: 45px; width: auto; object-fit: contain;">
                        </a>

                        {{-- 2. TOGGLER MOBILE --}}
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        {{-- 3. MENU ITEMS --}}
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto align-items-center">

                                {{-- HOME --}}
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="py-2 px-3 fs-6">Beranda</a>
                                </li>

                                {{-- DATA MASTER (DROPDOWN) --}}
                              <li class="nav-item dropdown">
                                    <a class="py-2 px-3 fs-6 dropdown-toggle" href="#" id="navbarDropdownMaster" role="button">
                                        Data Master
                                    </a>
                                    <ul class="dropdown-menu shadow border-0">
                                        <li>
                                            @auth 
                                                @if (Auth::user()->role === 'admin')
                                                    <a class="dropdown-item" href="{{ route('kelola-program.index') }}">
                                                        <i class="fas fa-tasks me-2 small"></i> Program
                                                    </a>
                                                @else
                                                    <a class="dropdown-item" href="{{ route('program-warga.indexWarga') }}">
                                                        <i class="fas fa-tasks me-2 small"></i> Program
                                                    </a>
                                                @endif
                                            @else
                                                <a class="dropdown-item page-scroll" href="#program">Program</a>
                                            @endauth
                                        </li>
                                        
                                        {{-- Menu Warga & User hanya muncul/aktif linknya untuk Admin --}}
                                        <li>
                                            @auth
                                                @if (Auth::user()->role === 'admin')
                                                    <a class="dropdown-item" href="{{ route('warga.index') }}">
                                                        <i class="fas fa-users me-2 small"></i> Warga
                                                    </a>
                                                @else
                                                    {{-- Link non-aktif atau profile untuk warga biasa --}}
                                                    <a class="dropdown-item" href="#"><i class="fas fa-user me-2 small"></i> Profil Saya</a>
                                                @endif
                                            @else
                                                <a class="dropdown-item page-scroll" href="#overview">Warga</a>
                                            @endauth
                                        </li>

                                        @auth
                                            @if(Auth::user()->role === 'admin')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.index') }}">
                                                    <i class="fas fa-user-shield me-2 small"></i> User
                                                </a>
                                            </li>
                                            @endif
                                        @endauth
                                    </ul>
                                </li>

                                {{-- PENYALURAN (DROPDOWN) --}}
                                <li class="nav-item dropdown">
                                    <a class="py-2 px-3 fs-6 dropdown-toggle" href="#"
                                        id="navbarDropdownPenyaluran" role="button" aria-expanded="false">
                                        Penyaluran
                                    </a>
                                    <ul class="dropdown-menu shadow border-0"
                                        aria-labelledby="navbarDropdownPenyaluran">
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('pendaftar.index') }}"><i
                                                        class="fas fa-file-import me-2 small"></i> Pendaftar</a>
                                            @else
                                            <a class="dropdown-item page-scroll" href="#overview">Pendaftar</a> @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('verifikasi.index') }}"><i
                                                        class="fas fa-check-double me-2 small"></i> Verifikasi</a>
                                            @else
                                                <a class="dropdown-item page-scroll" href="#overview">Verifikasi</a>
                                            @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('penerima.index') }}"><i
                                                        class="fas fa-user-check me-2 small"></i> Penerima</a>
                                            @else
                                            <a class="dropdown-item page-scroll" href="#overview">Penerima</a> @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('riwayat.index') }}"><i
                                                        class="fas fa-history me-2 small"></i> Riwayat</a>
                                            @else
                                            <a class="dropdown-item page-scroll" href="#">Riwayat</a> @endauth
                                        </li>
                                    </ul>
                                </li>

                                {{-- ABOUT --}}
                                <li class="nav-item">
                                    @auth <a href="{{ route('about') }}" class="py-2 px-3 fs-6">Tentang Kami</a>
                                    @else
                                    <a href="#overview" class="page-scroll py-2 px-3 fs-6">Tentang Kami</a> @endauth
                                </li>

                                {{-- MENU MOBILE (LOGIN/LOGOUT) --}}
                                @guest
                                    <li class="nav-item d-lg-none"><a href="{{ route('register') }}">Daftar</a></li>
                                    <li class="nav-item d-lg-none"><a href="{{ route('login') }}">Masuk</a></li>
                                @endguest
                                @auth
                                    <li class="nav-item d-lg-none"><a href="{{ route('home') }}">Beranda</a></li>
                                    <li class="nav-item d-lg-none">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Keluar</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>

                        {{-- 4. TOMBOL KANAN (DESKTOP) --}}
                        <div class="button add-list-button d-none d-lg-flex align-items-center ms-lg-3">
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-outline-custom me-2">Daftar</a>
                                <a href="{{ route('login') }}" class="btn btn-primary-custom">Masuk</a>
                            @endguest

                            @auth
                                <div class="d-flex align-items-center">
                                    {{-- FOTO PROFIL --}}
                                    <div class="profile-img-container">
                                        @php $fotoProfil = Auth::user()->foto ?? (Auth::user()->warga->foto ?? null); @endphp
                                        @if ($fotoProfil)
                                            <img src="{{ asset('storage/' . $fotoProfil) }}" alt="Profile"
                                                class="rounded-circle shadow-sm"
                                                style="width: 38px; height: 38px; object-fit: cover; border: 2px solid #F53C5E;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=F53C5E&color=fff"
                                                alt="Profile" class="rounded-circle shadow-sm"
                                                style="width: 38px; height: 38px; object-fit: cover; border: 2px solid #F53C5E;">
                                        @endif
                                    </div>

                                    <div class="ms-2 d-none d-xl-block">
                                        <span class="user-greeting fw-bold d-block" style="line-height: 1;">
                                            Halo, {{ explode(' ', Auth::user()->name)[0] }}
                                        </span>
                                        <small class="text-muted" style="font-size: 0.7rem;">Aktif</small>
                                        
                                        {{--Session Last Login --}}
                                        @if (session('last_login'))
                                            <small class="text-muted" style="font-size: 0.6rem; line-height: 1.2;">
                                                Login terakhir: {{ session('last_login') }}
                                            </small>
                                        @endif
                                    </div>

                                    <a href="{{ route('logout') }}"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center ms-3"
                                        title="Keluar" style="width: 35px; height: 35px; padding: 0; border-radius: 50%;"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                        <i class="fas fa-power-off"></i>
                                    </a>
                                    <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">@csrf</form>
                                </div>
                            @endauth
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
