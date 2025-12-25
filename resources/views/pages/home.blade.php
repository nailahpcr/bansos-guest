@extends('layout.guest.app')

@section('title', 'Bantuan Sosial & Bina Desa')

@section('content')
    {{-- Hero Section --}}
    <section id="home" class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h1 class="wow fadeInLeft" data-wow-delay=".4s">Bantuan Sosial & Pemberdayaan Desa.</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s">Membangun masyarakat desa yang mandiri dan sejahtera melalui penyaluran bantuan yang transparan, tepat sasaran, dan berkelanjutan.</p>
                        <div class="button wow fadeInLeft" data-wow-delay=".8s">
                            <a href="#features" class="btn shadow-lg">Eksplorasi Program <i class="lni lni-chevron-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12 col-12">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        <div id="heroCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel" style="border-radius: 20px; overflow: hidden;">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                            </div>

                            <div class="carousel-inner">
                                <div class="carousel-item active" data-bs-interval="4000">
                                    <img src="{{ asset('assets/images/about/program8.jpg') }}" class="d-block w-100 hero-carousel-img" alt="Bantuan Sosial">
                                    <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); border-radius: 10px;">
                                        <h5>Penyaluran Tepat Sasaran</h5>
                                        <p>Memastikan setiap bantuan sampai ke tangan yang berhak.</p>
                                    </div>
                                </div>
                                <div class="carousel-item" data-bs-interval="4000">
                                    <img src="{{ asset('assets/images/about/bantuan1.jpg') }}" class="d-block w-100 hero-carousel-img" alt="Kegiatan Desa">
                                </div>
                                <div class="carousel-item" data-bs-interval="4000">
                                    <img src="{{ asset('assets/images/about/bantuan2.jpg') }}" class="d-block w-100 hero-carousel-img" alt="Pemberdayaan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Program Unggulan Section --}}
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Daftar Bantuan</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Program Unggulan Kami</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Sistem transparansi bantuan untuk meningkatkan kesejahteraan warga desa.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @forelse($programs as $program)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration * 2 }}s">
                        <div class="card h-100 border-0 shadow-sm custom-program-card">
                            {{-- Image Wrapper --}}
                            <div class="program-img-container">
                                @if ($program->file && in_array(pathinfo($program->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
                                    <img src="{{ asset('storage/' . $program->file) }}" class="card-img-top" alt="{{ $program->nama_program }}">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image fa-3x opacity-25"></i>
                                    </div>
                                @endif
                                <div class="program-tag">Tahun {{ $program->tahun }}</div>
                            </div>

                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">
                                    <a href="{{ route('program.public.show', $program->program_id) }}" class="text-dark text-decoration-none hover-primary">
                                        {{ $program->nama_program }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-4">{{ Str::limit($program->deskripsi, 90) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-4">
                                    <span class="small text-muted font-weight-bold">Anggaran:</span>
                                    <span class="fw-bold text-success">Rp {{ number_format($program->anggaran, 0, ',', '.') }}</span>
                                </div>

                                <a href="{{ route('program.public.show', $program->program_id) }}" class="btn btn-primary-soft w-100 fw-bold">
                                    Lihat Detail <i class="lni lni-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada program bantuan yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="section call-action">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                    <div class="cta-content text-center">
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">Jadilah Bagian Dari Perubahan Positif</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">Setiap program dirancang untuk memberikan dampak nyata. Mari bersama-sama membangun desa yang lebih baik.</p>
                        <div class="button mt-4 wow fadeInUp" data-wow-delay=".6s">
                            <a href="#home" class="btn btn-outline-light px-5 py-3 rounded-pill">Kembali ke Atas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Hero Carousel */
        .hero-carousel-img { height: 480px; object-fit: cover; }
        
        /* Program Card Styles */
        .custom-program-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .custom-program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .program-img-container {
            position: relative;
            height: 200px;
            background: #f8f9fa;
            overflow: hidden;
        }
        .program-img-container img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .no-image-placeholder {
            height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;
        }
        .program-tag {
            position: absolute; top: 15px; right: 15px;
            background: rgba(13, 110, 253, 0.9); color: white;
            padding: 5px 15px; border-radius: 30px; font-size: 12px; font-weight: bold;
        }
        .hover-primary:hover { color: #0d6efd !important; }
        
        /* Soft Button Style */
        .btn-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: none;
            padding: 12px;
            border-radius: 12px;
            transition: 0.3s;
        }
        .btn-primary-soft:hover {
            background-color: #0d6efd;
            color: white;
        }
    </style>
@endsection