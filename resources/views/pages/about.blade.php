@extends('layout.guest.app')

@section('content')
    {{-- 1. STYLE LENGKAP --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        .about-page {
            font-family: 'Poppins', sans-serif;
            color: #2d3436;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            /* Pattern titik-titik halus */
            background-image: radial-gradient(#FF6B81 0.5px, transparent 0.5px);
            background-size: 30px 30px;
        }

        /* Elemen Dekoratif Blobs di Background */
        .blob-bg {
            position: absolute;
            z-index: 0;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .blob-1 {
            top: 10%;
            left: -100px;
            width: 400px;
            height: 400px;
            background: rgba(255, 107, 129, 0.08);
            animation: float 15s infinite alternate;
        }
        .blob-2 {
            bottom: 20%;
            right: -100px;
            width: 500px;
            height: 500px;
            background: rgba(255, 107, 129, 0.05);
            animation: float 20s infinite alternate-reverse;
        }

        @keyframes float {
            from { transform: translate(0, 0); }
            to { transform: translate(30px, 50px); }
        }

        /* Hero Section */
        .hero-about {
            background: linear-gradient(135deg, #fff5f6 0%, #ffffff 100%);
            border-radius: 0 0 80px 80px;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 107, 129, 0.1);
        }

        .hero-bg-icon {
            position: absolute;
            font-size: 18rem;
            color: rgba(255, 107, 129, 0.03);
            bottom: -60px;
            right: -40px;
            transform: rotate(-15deg);
            z-index: 0;
        }

        /* Card Custom Styling */
        .custom-module-card {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 107, 129, 0.1) !important;
            border-radius: 25px !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 1;
        }

        .custom-module-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(255, 107, 129, 0.15) !important;
            border-color: rgba(255, 107, 129, 0.3) !important;
        }

        .card-number {
            position: absolute;
            top: -10px;
            right: 15px;
            font-size: 6rem;
            font-weight: 800;
            color: rgba(255, 107, 129, 0.05);
            z-index: 0;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(255, 107, 129, 0.1);
            color: #FF6B81;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            margin: 0 auto;
            font-size: 2rem;
            transition: 0.4s;
        }

        .custom-module-card:hover .icon-wrapper {
            background: #FF6B81;
            color: #ffffff;
            transform: rotate(10deg) scale(1.1);
        }

        .line-height-lg { line-height: 1.8; }
        
        .img-frame {
            position: relative;
            display: inline-block;
        }
        .img-frame::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: -20px;
            bottom: -20px;
            border: 3px dashed #FF6B81;
            border-radius: 20px;
            z-index: 0;
        }
    </style>

    <div class="about-page">
        {{-- Elemen Background --}}
        <div class="blob-bg blob-1"></div>
        <div class="blob-bg blob-2"></div>

        {{-- HERO SECTION --}}
        <section class="hero-about text-center">
            <i class="fas fa-hand-holding-heart hero-bg-icon"></i>
            <div class="container" style="position: relative; z-index: 1;">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <span class="badge px-4 py-2 rounded-pill mb-3 wow fadeInDown"
                            style="background-color: #FF6B81; font-weight: 600;">SI-BANSOS DESA</span>
                        <h1 class="display-4 fw-bold mb-4 wow fadeInUp">
                            Membangun Desa yang <br>
                            <span style="color: #FF6B81;">Lebih Terbuka & Adil</span>
                        </h1>
                        <p class="lead text-muted line-height-lg wow fadeInUp" data-wow-delay="0.2s">
                            Kami hadir sebagai jembatan digital untuk memastikan setiap bantuan, program, dan pelatihan
                            sampai ke tangan warga yang tepat secara transparan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-5" style="position: relative; z-index: 1;">
            
            {{-- KENAPA SI-BANSOS ADA --}}
            <div class="row align-items-center mb-5 py-5">
                <div class="col-lg-6 mb-5 mb-lg-0 wow fadeInLeft">
                    <div class="img-frame">
                        <img src="{{ asset('assets/images/about/about1.jpg') }}" class="img-fluid rounded-4 shadow-lg position-relative" style="z-index: 1;" alt="Komitmen Kami">
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 wow fadeInRight">
                    <h3 class="fw-bold mb-4" style="color: #2d3436;">Kenapa SI-BANSOS Ada?</h3>
                    <p class="line-height-lg mb-4 text-muted">
                        Dahulu, banyak warga kesulitan mengetahui program apa saja yang sedang berjalan di desa.
                        Dengan sistem ini, kami memastikan keterbukaan informasi bagi seluruh lapisan masyarakat.
                    </p>
                    <div class="d-flex mb-3 align-items-start">
                        <div class="me-3 mt-1">
                            <i class="fas fa-check-circle fa-lg" style="color: #FF6B81;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Tidak ada data yang tertutup</h6>
                            <p class="small text-muted">Semua program bisa dilihat siapa saja secara real-time.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 align-items-start">
                        <div class="me-3 mt-1">
                            <i class="fas fa-check-circle fa-lg" style="color: #FF6B81;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Pendaftaran Mudah</h6>
                            <p class="small text-muted">Cukup melalui perangkat HP, warga bisa mengajukan pendaftaran.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 align-items-start">
                        <div class="me-3 mt-1">
                            <i class="fas fa-check-circle fa-lg" style="color: #FF6B81;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Tepat Sasaran</h6>
                            <p class="small text-muted">Sistem verifikasi memastikan bantuan diterima yang berhak.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARA KERJA SISTEM --}}
            <div class="text-center mb-5 pt-5">
                <span class="text-uppercase fw-bold px-3 py-1 rounded-pill mb-2 d-inline-block"
                    style="font-size: 0.75rem; letter-spacing: 2px; color: #FF6B81; background: rgba(255, 107, 129, 0.1);">
                    Layanan Kami
                </span>
                <h2 class="fw-bold display-6">Cara Kerja Sistem Kami</h2>
                <div class="mx-auto mt-2" style="width: 60px; height: 4px; background: #FF6B81; border-radius: 10px;"></div>
            </div>

            <div class="row g-4 justify-content-center mb-5">
                <div class="col-md-4 text-center wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card h-100 p-4 border-0 shadow-sm custom-module-card">
                        <div class="card-number">01</div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="color: #FF6B81;">Manajemen Program</h5>
                        <p class="text-muted mb-0 px-2 small line-height-lg">
                            Admin desa menginput program, kode, dan anggaran agar terdokumentasi secara resmi dan transparan.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 text-center wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card h-100 p-4 border-0 shadow-sm custom-module-card">
                        <div class="card-number">02</div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="color: #FF6B81;">Pendaftaran Warga</h5>
                        <p class="text-muted mb-0 px-2 small line-height-lg">
                            Warga memilih program yang sesuai dan mengirim berkas pendaftaran dengan mudah melalui akun mereka.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 text-center wow fadeInUp" data-wow-delay="0.5s">
                    <div class="card h-100 p-4 border-0 shadow-sm custom-module-card">
                        <div class="card-number">03</div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="color: #FF6B81;">Laporan Penyaluran</h5>
                        <p class="text-muted mb-0 px-2 small line-height-lg">
                            Setiap bantuan tercatat secara otomatis, memudahkan warga memantau riwayat penerimaan secara akurat.
                        </p>
                    </div>
                </div>
            </div>

            {{-- CTA SECTION --}}
            <section style="background-color:#FF6B81;" class="p-5 rounded-5 shadow-lg my-5 wow zoomIn">
                <div class="row align-items-center text-white text-center text-lg-start">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-3">Siap Menjadi Bagian dari Perubahan?</h2>
                        <p class="opacity-90 mb-4 mb-lg-0">Daftarkan akun Anda, lengkapi data profil, dan mulailah berpartisipasi dalam program pembangunan desa kami.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ url('/') }}" class="btn btn-lg px-5 rounded-pill fw-bold shadow-sm"
                            style="background-color: #ffffff; color: #FF6B81; border: none; padding-top: 14px; padding-bottom: 14px; transition: 0.3s;">
                            Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection