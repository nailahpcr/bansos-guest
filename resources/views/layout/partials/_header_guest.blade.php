<header class="header navbar-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{-- Saya asumsikan path logo Anda benar --}}
                            <img src="{{ asset('guest/assets/images/logo/white-logo.svg') }}" alt="Logo">
                        </a>
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                {{-- Menu Navigasi standar Anda --}}
                                <li class="nav-item">
                                    <a href="#home" class="page-scroll active" aria-label="Toggle navigation">Home</a>
                                </li>
                                <li class="nav-item">
                                    {{-- Menggunakan route 'home' dari file rute Anda untuk Guest --}}
                                    @guest
                                    <a href="#program" class="page-scroll active" aria-label="Toggle navigation">Program</a>
                                    @endguest
                                    @auth
                                    <a href="{{ route('program.index') }}" aria-label="Toggle navigation">Program</a>
                                    @endauth
                                </li>
                                <li class="nav-item">
                                    @guest
                                    <a href="#overview" class="page-scroll" aria-label="Toggle navigation">Data Warga</a>
                                    @endguest
                                    @auth
                                    <a href="{{ route('warga.index') }}" aria-label="Toggle navigation">Data Warga</a>
                                    @endauth
                                </li>
                                <li class="nav-item">
                                    <a href="#pricing" class="page-scroll" aria-label="Toggle navigation">Data Pendaftar</a>
                                </li>
                                 <li class="nav-item">
                                    <a href="#team" class="page-scroll" aria-label="Toggle navigation">Team</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#blog" class="page-scroll" aria-label="Toggle navigation">Blog</a>
                                </li>

                                {{-- ================================================= --}}
                                {{-- LOGIKA KONDISIONAL UNTUK TAMPILAN MOBILE --}}
                                {{-- ================================================= --}}
                                {{-- Tombol-tombol ini hanya akan muncul di tampilan mobile (di dalam menu collapse) --}}
                                @guest
                                    <li class="nav-item d-lg-none">
                                        <a href="{{ route('register') }}" aria-label="Toggle navigation">Daftar</a>
                                    </li>
                                    <li class="nav-item d-lg-none">
                                        <a href="{{ route('login') }}" aria-label="Toggle navigation">Masuk</a>
                                    </li>
                                @endguest

                                @auth
                                    <li class="nav-item d-lg-none">
                                        {{-- Menggunakan route 'home' sebagai dashboard Warga --}}
                                        <a href="{{ route('home') }}" aria-label="Toggle navigation">Dashboard Saya</a>
                                    </li>
                                    <li class="nav-item d-lg-none">
                                        {{-- Link Logout di mobile --}}
                                        <a href="{{ route('logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" 
                                           aria-label="Toggle navigation">
                                            Logout
                                        </a>
                                        {{-- Form Logout yang aman (tersembunyi) --}}
                                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endauth
                                {{-- ================================================= --}}
                                {{-- AKHIR DARI LOGIKA MOBILE --}}
                                {{-- ================================================= --}}

                            </ul>
                        </div> 
                        
                        {{-- ================================================= --}}
                        {{-- LOGIKA KONDISIONAL UNTUK TAMPILAN DESKTOP --}}
                        {{-- ================================================= --}}
                        {{-- Tombol-tombol ini hanya akan muncul di desktop (di luar menu collapse) --}}
                        <div class="button add-list-button d-none d-lg-flex">
                            @guest
                                {{-- Tampilkan "Daftar" dan "Masuk" jika belum login --}}
                                <a href="{{ route('register') }}" class="btn">Daftar</a>
                                <a href="{{ route('login') }}" class="btn">Masuk</a>
                            @endguest

                            @auth
                                {{-- Tampilkan Nama Warga dan Tombol Logout jika sudah login --}}
                                {{-- Kita menggunakan 'Auth::user()->nama' karena model login Anda adalah Warga --}}
                                <span class="text-white me-3" style="white-space: nowrap;">
                                    Halo, {{ Auth::user()->nama }}
                                </span>
                                
                                {{-- Tombol Logout yang aman (wajib menggunakan form) --}}
                                <a href="{{ route('logout') }}" class="btn"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                    Logout
                                </a>
                                {{-- Form Logout yang aman (tersembunyi) --}}
                                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endauth
                        </div>
                        {{-- ================================================= --}}
                        {{-- AKHIR DARI LOGIKA DESKTOP --}}
                        {{-- ================================================= --}}

                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
