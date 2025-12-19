<header class="header navbar-area py-3">
    <style>
        /* Memaksa teks di dalam dropdown berwarna gelap */
        .header .navbar-nav .dropdown-menu .dropdown-item {
            color: #333 !important; /* Warna teks hitam/abu gelap */
            font-weight: 500;
        }

        /* Efek saat mouse diarahkan ke menu dropdown (Hover) */
        .header .navbar-nav .dropdown-menu .dropdown-item:hover {
            color: #fff !important; /* Teks jadi putih */
            background-color: #F53C5E; /* Background jadi pink saat disorot */
        }
    </style>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <nav class="navbar navbar-expand-lg">
                        {{-- 1. LOGO --}}
                        <a class="navbar-brand d-flex align-items-center gap-2 me-3" href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo/logo1-horizontal.png') }}" alt="Logo SiBansos"
                                style="height: 40px; width: auto; object-fit: contain;">
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
                            <ul id="nav" class="navbar-nav ms-auto align-items-center" style="flex-wrap: nowrap;">
                                
                                {{-- HOME --}}
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="py-2 px-2 fs-6">Beranda</a>
                                </li>

                                {{-- DATA MASTER (DROPDOWN) --}}
                                <li class="nav-item dropdown">
                                    <a class="py-2 px-2 fs-6 dropdown-toggle" href="#" id="navbarDropdownMaster" 
                                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Data Master
                                    </a>
                                    <ul class="dropdown-menu shadow border-0" aria-labelledby="navbarDropdownMaster">
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('kelola-program.index') }}">Program</a>
                                            @else <a class="dropdown-item page-scroll" href="#program">Program</a> @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('warga.index') }}">Warga</a>
                                            @else <a class="dropdown-item page-scroll" href="#overview">Warga</a> @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('user.index') }}">User</a>
                                            @else <a class="dropdown-item page-scroll" href="#overview">User</a> @endauth
                                        </li>
                                    </ul>
                                </li>

                                {{-- PENYALURAN (DROPDOWN) --}}
                                <li class="nav-item dropdown">
                                    <a class="py-2 px-2 fs-6 dropdown-toggle" href="#" id="navbarDropdownPenyaluran" 
                                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Penyaluran
                                    </a>
                                    <ul class="dropdown-menu shadow border-0" aria-labelledby="navbarDropdownPenyaluran">
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('pendaftar.index') }}">Pendaftar</a>
                                            @else <a class="dropdown-item page-scroll" href="#overview">Pendaftar</a> @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('verifikasi.index') }}">Verifikasi</a>
                                            @else <a class="dropdown-item page-scroll" href="#overview">Verifikasi</a> @endauth
                                        </li>
                                        <li>
                                            @auth <a class="dropdown-item" href="{{ route('penerima.index') }}">Penerima</a>
                                            @else <a class="dropdown-item page-scroll" href="#overview">Penerima</a> @endauth
                                        </li>
                                        <li>
                                            {{-- Ganti route riwayat di sini --}}
                                            @auth <a class="dropdown-item" href="#">Riwayat</a>
                                            @else <a class="dropdown-item page-scroll" href="#">Riwayat</a> @endauth
                                        </li>
                                    </ul>
                                </li>

                                {{-- ABOUT --}}
                                <li class="nav-item">
                                    @auth <a href="{{ route('about') }}" class="py-2 px-2 fs-6">Tentang Kami</a>
                                    @else <a href="#overview" class="page-scroll py-2 px-2 fs-6">Tentang Kami</a> @endauth
                                </li>

                                {{-- MENU MOBILE (LOGIN/LOGOUT) --}}
                                @guest
                                    <li class="nav-item d-lg-none"><a href="{{ route('register') }}">Daftar</a></li>
                                    <li class="nav-item d-lg-none"><a href="{{ route('login') }}">Masuk</a></li>
                                @endguest
                                @auth
                                    <li class="nav-item d-lg-none"><a href="{{ route('home') }}">Beranda</a></li>
                                    <li class="nav-item d-lg-none">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Logout</a>
                                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                    </li>
                                @endauth
                            </ul>
                        </div>

                        {{-- 4. TOMBOL KANAN (DESKTOP) --}}
                        <div class="button add-list-button d-none d-lg-flex align-items-center ms-lg-3">
                            @guest
                                <a href="{{ route('register') }}" class="btn me-2">Daftar</a>
                                <a href="{{ route('login') }}" class="btn">Masuk</a>
                            @endguest

                            @auth
                                <div class="d-flex align-items-center">
                                    {{-- FOTO PROFIL --}}
                                    @php $fotoProfil = Auth::user()->foto ?? (Auth::user()->warga->foto ?? null); @endphp
                                    @if ($fotoProfil)
                                        <img src="{{ asset('storage/' . $fotoProfil) }}" alt="Profile"
                                            class="rounded-circle shadow-sm"
                                            style="width: 35px; height: 35px; object-fit: cover; border: 2px solid #fff;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=random&color=fff"
                                            alt="Profile" class="rounded-circle shadow-sm"
                                            style="width: 35px; height: 35px; object-fit: cover; border: 2px solid #fff;">
                                    @endif

                                    <span class="text-white fw-bold ms-2 d-none d-xl-block" style="font-size: 0.9rem;">
                                        Halo, {{ explode(' ', Auth::user()->nama)[0] }}
                                    </span>

                                    <a href="{{ route('logout') }}"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center ms-3"
                                        title="Keluar"
                                        style="width: 32px; height: 32px; padding: 0; border-radius: 50%; border-width: 2px;"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </a>
                                    <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                </div>
                            @endauth
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>