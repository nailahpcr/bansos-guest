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
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(30px, 50px);
            }
        }

        /* Hero Section */
        .hero-about {
            position: relative;
            min-height: 500px;
            display: flex;
            align-items: center;
        }

        /* Memastikan deskripsi tetap putih transparan */
        .hero-about .text-white-50 {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Penyesuaian Responsif */
        @media (max-width: 768px) {
            .hero-about {
                padding: 80px 0 !important;
                border-radius: 0 0 40px 40px !important;
            }

            .display-4 {
                font-size: 2.2rem;
            }
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

        .line-height-lg {
            line-height: 1.8;
        }

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

        .fst-italic {
            font-weight: 300;
            color: #636e72 !important;
        }

        .opacity-90 {
            opacity: 0.9;
        }
    </style>

    <div class="about-page">
        {{-- Elemen Background --}}
        <div class="blob-bg blob-1"></div>
        <div class="blob-bg blob-2"></div>

        {{-- HERO SECTION --}}
        <section class="hero-about text-center position-relative overflow-hidden"
            style="background: url('{{ asset('assets/images/about/desa (1).jpg') }}'); 
           background-size: cover; 
           background-position: center; 
           padding: 150px 0; 
           border-radius: 0 0 80px 80px;">

            {{-- Overlay Gelap agar teks terbaca jelas --}}
            <div class="hero-overlay"
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
               background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 100%); 
               z-index: 1;">
            </div>

            <div class="container" style="position: relative; z-index: 2;">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <span class="badge px-4 py-2 rounded-pill mb-3 wow fadeInDown"
                            style="background-color: #FF6B81; font-weight: 600;">
                            SI-BANSOS DESA
                        </span>

                        <h1 class="display-4 fw-bold mb-4 wow fadeInUp text-white">
                            Membangun Desa yang <br>
                            <span style="color: #FF6B81;">Lebih Terbuka & Adil</span>
                        </h1>

                        <p class="lead text-white-50 line-height-lg wow fadeInUp" data-wow-delay="0.2s">
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
                        <img src="{{ asset('assets/images/about/about1.jpg') }}"
                            class="img-fluid rounded-4 shadow-lg position-relative" style="z-index: 1;" alt="Komitmen Kami">
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

            {{-- SAMBUTAN KEPALA DESA --}}
            <div class="row align-items-center mb-5 py-5 flex-row-reverse">
                <div class="col-lg-5 mb-5 mb-lg-0 wow fadeInRight">
                    <div class="img-frame">
                        {{-- Ganti src dengan foto asli Kepala Desa jika sudah ada --}}
                        <img src="{{ asset('assets/images/about/orank1.jpg') }}"
                            class="img-fluid rounded-4 shadow-lg position-relative"
                            style="z-index: 1; width: 100%; height: 450px; object-fit: cover;" alt="Kepala Desa">
                    </div>
                </div>
                <div class="col-lg-7 pe-lg-5 wow fadeInLeft">
                    <span class="text-uppercase fw-bold mb-2 d-inline-block"
                        style="color: #FF6B81; font-size: 0.8rem; letter-spacing: 2px;">
                        Sambutan Kepala Desa
                    </span>
                    <h2 class="fw-bold mb-4" style="color: #2d3436;">Mewujudkan Desa Mandiri Melalui Digitalisasi</h2>

                    <div class="position-relative">
                        <i class="fas fa-quote-left position-absolute"
                            style="font-size: 3rem; color: rgba(255, 107, 129, 0.1); top: -20px; left: -10px;"></i>
                        <p class="line-height-lg mb-4 text-muted fst-italic ps-4"
                            style="font-size: 1.1rem; border-left: 3px solid #FF6B81;">
                            "Kehadiran SI-BANSOS adalah komitmen kami untuk memastikan tidak ada lagi warga yang tertinggal
                            informasi. Transparansi bukan sekadar janji, tapi kami wujudkan melalui sistem yang bisa
                            dipantau langsung oleh masyarakat. Mari bersama-sama membangun desa yang lebih terbuka dan
                            sejahtera."
                        </p>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold mb-0" style="color: #2d3436;">H. Ahmad Subarjo, S.Sos</h5>
                        <p class="text-muted">Kepala Desa Makmur Sejahtera</p>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4"
                            style="border-color: #FF6B81 !important;">
                            <h4 class="fw-bold mb-0" style="color: #FF6B81;">5+</h4>
                            <small class="text-muted">Tahun Mengabdi</small>
                        </div>
                        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4"
                            style="border-color: #FF6B81 !important;">
                            <h4 class="fw-bold mb-0" style="color: #FF6B81;">24/7</h4>
                            <small class="text-muted">Layanan Digital</small>
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
                            Admin desa menginput program, kode, dan anggaran agar terdokumentasi secara resmi dan
                            transparan.
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
                            Warga memilih program yang sesuai dan mengirim berkas pendaftaran dengan mudah melalui akun
                            mereka.
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
                            Setiap bantuan tercatat secara otomatis, memudahkan warga memantau riwayat penerimaan secara
                            akurat.
                        </p>
                    </div>
                </div>
            </div>

            {{-- CTA SECTION --}}
            <section style="background-color:#FF6B81;" class="p-5 rounded-5 shadow-lg my-5 wow zoomIn">
                <div class="row align-items-center text-white text-center text-lg-start">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-3">Siap Menjadi Bagian dari Perubahan?</h2>
                        <p class="opacity-90 mb-4 mb-lg-0">Daftarkan akun Anda, lengkapi data profil, dan mulailah
                            berpartisipasi dalam program pembangunan desa kami.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ url('/') }}" class="btn btn-lg px-5 rounded-pill fw-bold shadow-sm"
                            style="background-color: #ffffff; color: #FF6B81; border: none; padding-top: 14px; padding-bottom: 14px; transition: 0.3s;">
                            Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </section>

            {{-- SECTION KONTAK DETAIL --}}
            <section class="container py-5 mb-5">
                <div class="row g-4">
                    {{-- Info Kontak Kolom Kiri --}}
                    <div class="col-lg-4 wow fadeInLeft">
                        <div class="p-4 h-100 rounded-5 shadow-sm position-relative overflow-hidden"
                            style="background-color: #ffffff; border: 1px solid rgba(0,0,0,0.05);">
                            <div class="position-relative z-index-1">
                                <h4 class="fw-bold mb-4" style="color: #2d3436;">Hubungi Kami</h4>
                                <p class="text-muted small mb-4">Punya pertanyaan seputar bantuan sosial? Tim kami siap
                                    melayani Anda pada jam kerja.</p>

                                <div class="contact-item d-flex align-items-center mb-4">
                                    <div class="contact-icon-box me-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Lokasi Kantor</small>
                                        <span class="fw-600">Jl. Raya Makmur No. 12, Desa Sejahtera</span>
                                    </div>
                                </div>

                                <div class="contact-item d-flex align-items-center mb-4">
                                    <div class="contact-icon-box me-3">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Telepon/WA</small>
                                        <span class="fw-600">+62 812-3456-7890</span>
                                    </div>
                                </div>

                                <div class="contact-item d-flex align-items-center">
                                    <div class="contact-icon-box me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Email Resmi</small>
                                        <span class="fw-600">halo@sibansos.desa.id</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mini-blob"></div>
                        </div>
                    </div>

                    {{-- Google Maps Kolom Kanan --}}
                    <div class="col-lg-8 wow fadeInRight">
                        <div class="rounded-5 shadow-sm overflow-hidden border border-light bg-white p-2 h-100">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127669.04874052957!2d101.36208316223204!3d0.5143372074360668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac6050630739%3A0x26ca33827ca3e7d4!2sPoliteknik%20Caltex%20Riau!5e0!3m2!1sid!2sid!4v1716123456789!5m2!1sid!2sid"
                                width="100%" height="380" style="border:0; border-radius: 20px;" allowfullscreen=""
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
