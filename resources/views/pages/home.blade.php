@extends('layout.guest.app')

@section('title', 'Bantuan Sosial & Bina Desa')

@section('content')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    {{-- Bagian Hero --}}
    <section id="home" class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h1 class="wow fadeInLeft" data-wow-delay=".4s">Mewujudkan Kesejahteraan Melalui Bantuan Sosial dan
                            Pemanfaatan.</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s">Kami berkomitmen untuk membangun masyarakat desa yang
                            mandiri, sejahtera, dan berdaya saing melalui program-program yang tepat sasaran dan
                            berkelanjutan.</p>
                        <div class="button wow fadeInLeft" data-wow-delay=".8s">
                            <a href="#features" class="btn">Lihat Program Kami</a>
                            <a href="{{ url('/kontak') }}" class="btn btn-alt">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        <img src="{{ asset('guest/assets/images/hero/kegiatan-desa.jpg') }}" alt="Kegiatan Bina Desa">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".2s"> {{-- Menggunakan fadeInRight untuk gambar --}}
                    <div class="about-image text-center text-lg-start"> {{-- Sesuaikan perataan gambar --}}
                        <img src="{{ asset('assets/images/about/about-image.jpg') }}" alt="Tentang Kami Appvila"
                            class="img-fluid" />
                    </div>
                </div>

                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".4s">
                    <div class="about-content text-end">
                        <div class="section-title">
                            <span class="sub-title">About Us</span>
                            <h2 class="mb-25">Mengenal Appvila Lebih Dekat</h2>
                        </div>
                        <p class="mb-35">
                            Appvila adalah sebuah inisiatif yang lahir dari kepedulian untuk membangun komunitas desa yang
                            mandiri dan sejahtera. Kami percaya bahwa setiap desa memiliki potensi luar biasa yang dapat
                            dikembangkan melalui
                            program yang tepat sasaran dan berkelanjutan.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="features" class="features section">
        {{-- ... (Konten fitur Anda tetap sama) ... --}}
    </section>

    {{-- Bagian Fitur / Program Unggulan --}}
    <section id="features" class="features section">
        <div class="container">

            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Program</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Kelola Program Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Di halaman ini, Anda (sebagai warga) dapat membuat,
                            mengubah, dan menghapus program bantuan.</p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL TAMBAH PROGRAM --}}
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <a class="btn btn-primary wow fadeInUp" data-wow-delay=".8s" href="{{ route('kelola-program.create') }}">
                        <i class="fas fa-plus me-1"></i> Tambah Program Baru
                    </a>
                </div>
            </div>

            {{-- PESAN SUKSES --}}
            @if (session('success'))
                <div class="alert alert-success wow fadeInUp" data-wow-delay=".7s">
                    {{ session('success') }}
                </div>
            @endif

            {{-- DAFTAR PROGRAM (GRID KARTU) --}}
            <div class="row">

                @forelse ($programs as $program)
                    <div class="col-lg-4 col-md-6 col-12">
                        {{-- Ini adalah style 'single-feature' yang Anda gunakan di home --}}
                        <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                            <i class="lni lni-package"></i>

                            <h3>{{ $program->nama_program }}</h3>
                            <p class="mb-2"><strong>Kode:</strong> {{ $program->kode }} | <strong>Tahun:</strong>
                                {{ $program->tahun }}</p>
                            <p>{{ Str::limit($program->deskripsi, 100) }}</p>
                            <p><strong>Anggaran:</strong> Rp {{ number_format($program->anggaran, 0, ',', '.') }}</p>

                        
                            <div class="action-buttons mt-3">

                                {{-- Tombol Edit (Link Biasa) --}}
                                <a href="{{ route('kelola-program.edit', $program->program_id) }}"
                                    class="btn btn-sm btn-info text-white d-inline-block mb-1">Edit</a>

                                {{-- Tombol Hapus (Form Terpisah) --}}
                                <form action="{{ route('kelola-program.destroy', $program->program_id) }}" method="POST"
                                    class="d-inline-block mb-1"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>

                                {{-- Tombol Kondisional (Ikuti / Batalkan) --}}
                                {{-- Cek apakah Warga yang login sudah mengikuti program ini --}}
                                @if (Auth::user() && Auth::user()->programBantuans->contains($program->program_id))
                                    {{-- JIKA SUDAH IKUT: Tampilkan form dengan tombol "Batalkan Partisipasi" --}}
                                    <form action="{{ route('program.batalkan', $program->program_id) }}" method="POST"
                                        class="d-inline-block mb-1"
                                        onsubmit="return confirm('Anda yakin ingin membatalkan partisipasi di program ini?');">
                                        @csrf
                                        @method('DELETE') {{-- Penting! Memberitahu Laravel ini adalah request DELETE --}}
                                        <button type="submit" class="btn btn-sm btn-warning">Batalkan Partisipasi</button>
                                    </form>
                                @else
                                    {{-- JIKA BELUM IKUT: Tampilkan form dengan tombol "Ikuti Program" --}}
                                    <form action="{{ route('program.ajukan', $program->program_id) }}" method="POST"
                                        class="d-inline-block mb-1"
                                        onsubmit="return confirm('Anda yakin ingin mengikuti program ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Ikuti Program</button>
                                    </form>
                                @endif

                            </div>
                            {{-- =================== AKHIR PERUBAHAN =================== --}}

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center wow fadeInUp">
                            Belum ada program yang Anda buat. Silakan klik tombol "Tambah Program Baru".
                        </div>
                    </div>
                @endforelse

            </div>

            {{-- Link Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {!! $programs->links() !!}
            </div>
        </div>
    </section>

    {{-- Bagian Call to Action / Ajakan Kolaborasi --}}
    <section class="section call-action">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                    <div class="cta-content">
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">Jadilah Bagian Dari Perubahan Positif di Desa</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">Setiap kontribusi Anda, besar maupun kecil, akan sangat
                            berarti bagi pembangunan dan kesejahteraan masyarakat. Mari bergerak bersama kami.</p>
                        <div class="button wow fadeInUp" data-wow-delay=".6s">
                            <a href="{{ url('/donasi') }}" class="btn">Donasi Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
