@extends('layout.guest.app')

@section('title', 'Beranda - Sistem Informasi Bantuan Desa')

@section('content')
    <style>
        /* --- Base Setup --- */
        body {
            font-family: 'Inter', sans-serif;
            color: #444;
            overflow-x: hidden;
            background-color: #ffffff;
        }

        /* --- Hero Section: Gradasi Kiri ke Kanan --- */
        .hero-area {
            /* Gradasi dari Pink ke Putih (Kiri ke Kanan) */
            background: linear-gradient(90deg, #ff5876 0%, #ff8e9e 50%, #ffffff 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 25px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .hero-content p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 35px;
        }

        /* Fix Hover Tombol Lihat Capaian */
        .btn-hover-custom {
            transition: all 0.3s ease;
        }

        .btn-hover-custom:hover {
            background-color: #ffffff !important;
            color: #ff5876 !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            border-color: transparent;
        }

        .hero-slide-img {
            height: 450px;
            object-fit: cover;
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
        }

        /* --- Stat Cards --- */
        .stat-card {
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.4s ease;
            border: none;
        }

        .stat-card.card-blue {
            background: #e3f2fd;
        }

        .stat-card.card-green {
            background: #e8f5e9;
        }

        .stat-card.card-yellow {
            background: #fffde7;
        }

        .stat-card.card-pink {
            background: #fce4ec;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05) !important;
        }

        /* --- Step Cards (Alur Bantuan - Solid Background) --- */
        .step-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            position: relative;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .step-card:hover {
            transform: translateY(-10px);
            border-bottom: 4px solid #ff5876;
        }

        .step-num {
            font-size: 3rem;
            font-weight: 900;
            color: rgba(255, 88, 118, 0.1);
            position: absolute;
            top: 10px;
            right: 20px;
        }

        /* --- Kotak Saran Message Fix --- */
        .contact-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        .success-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
            transition: 0.5s;
        }

        #saranSection:target .success-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .btn-pink {
            background: #ff5876;
            color: white;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-pink:hover {
            background: #e04461;
            color: white;
            transform: translateY(-2px);
        }

        .section {
            padding: 80px 0;
        }

        /* --- Styling Pesan Sukses CSS --- */

        .success-message-css {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            /* Warna background pesan sukses */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            /* Tersembunyi */
            pointer-events: none;
            transition: all 0.4s ease-in-out;
            padding: 20px;
        }

        /* Logic Utama: Saat URL mengandung #success */
        #success:target .success-message-css {
            opacity: 1;
            pointer-events: auto;
        }

        /* Opsional: Memberi efek blur/transparan pada form di belakangnya */
        #success:target .form-saran-container,
        #success:target h3,
        #success:target p.text-muted {
            opacity: 0.1;
            filter: blur(4px);
        }

        /* Efek animasi membesar pada ikon ceklis */
        #success:target .success-message-css i {
            animation: bounceIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    {{-- Hero Section --}}
    <section id="home" class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="hero-content">
                        <h1 class="wow fadeInLeft" data-wow-delay=".4s">Selamat Datang di SI-BANSOS Desa.</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s">Membangun masyarakat desa yang mandiri dan sejahtera
                            melalui penyaluran bantuan yang transparan.</p>
                        <div class="button wow fadeInLeft" data-wow-delay=".8s">
                            <a href="#stats" class="btn btn-light btn-lg text-danger fw-bold shadow btn-hover-custom">Lihat
                                Capaian <i class="lni lni-stats-up ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
                    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-4 shadow-lg">
                            <div class="carousel-item active"><img src="{{ asset('assets/images/about/about1.jpg') }}"
                                    class="d-block w-100 hero-slide-img" alt="Slide 1"></div>
                            <div class="carousel-item"><img src="{{ asset('assets/images/about/bantuan1.jpg') }}"
                                    class="d-block w-100 hero-slide-img" alt="Slide 2"></div>
                            <div class="carousel-item"><img src="{{ asset('assets/images/about/bantuan2.jpg') }}"
                                    class="d-block w-100 hero-slide-img" alt="Slide 3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section id="stats" class="section bg-white"
        style="border-radius: 60px 60px 0 0; margin-top: -50px; position: relative;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="stat-card card-blue text-center">
                        <i class="lni lni-users fs-1 text-primary mb-3"></i>
                        <h2 class="fw-bold">1.250+</h2>
                        <p class="mb-0">Warga Terdaftar</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="stat-card card-green text-center">
                        <i class="lni lni-checkmark-circle fs-1 text-success mb-3"></i>
                        <h2 class="fw-bold">12</h2>
                        <p class="mb-0">Program Aktif</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                    <div class="stat-card card-yellow text-center">
                        <i class="lni lni-coin fs-1 text-warning mb-3"></i>
                        <h2 class="fw-bold">4.5M</h2>
                        <p class="mb-0">Anggaran Tersalurkan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                    <div class="stat-card card-pink text-center">
                        <i class="lni lni-map-marker fs-1 text-danger mb-3"></i>
                        <h2 class="fw-bold">100%</h2>
                        <p class="mb-0">Tepat Sasaran</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alur Bantuan Section (Solid Background) --}}
    <section class="section bg-light">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h3 class="wow zoomIn" style="color: #ff5876;">Bagaimana Cara Kerjanya?</h3>
                <h2 class="fw-bold">Alur Penyaluran Bantuan</h2>
                <p class="text-muted">Proses mudah, transparan, dan terpercaya untuk mendapatkan hak bantuan sosial Anda.
                </p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 wow fadeInUp" data-wow-delay=".2s">
                    <div class="step-card">
                        <div class="step-num">01</div>
                        <i class="fas fa-id-card fa-2x mb-3 text-primary"></i>
                        <h5>Registrasi Warga</h5>
                        <p class="small text-muted">Daftarkan akun menggunakan data KTP valid untuk sinkronisasi sistem.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 wow fadeInUp" data-wow-delay=".4s">
                    <div class="step-card">
                        <div class="step-num">02</div>
                        <i class="fas fa-th-list fa-2x mb-3 text-danger"></i>
                        <h5>Pilih Program</h5>
                        <p class="small text-muted">Temukan jenis bantuan yang paling relevan dengan kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 wow fadeInUp" data-wow-delay=".6s">
                    <div class="step-card">
                        <div class="step-num">03</div>
                        <i class="fas fa-user-check fa-2x mb-3 text-success"></i>
                        <h5>Verifikasi Lapangan</h5>
                        <p class="small text-muted">Tim akan berkunjung untuk menjamin bantuan tepat sasaran.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 wow fadeInUp" data-wow-delay=".8s">
                    <div class="step-card">
                        <div class="step-num">04</div>
                        <i class="fas fa-hand-holding-usd fa-2x mb-3 text-info"></i>
                        <h5>Penyaluran</h5>
                        <p class="small text-muted">Bantuan diserahkan secara akuntabel melalui sistem terintegrasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ & KOTAK SARAN SECTION --}}
    <section id="success" class="section bg-white">
        <div class="container">
            <div class="row g-5">
                {{-- FAQ --}}
                <div class="col-lg-6 wow fadeInLeft">
                    <h3 class="fw-bold mb-4" style="color: #ff5876;">Pertanyaan Umum (FAQ)</h3>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f1">
                                    Bagaimana cara mendaftar bantuan?
                                </button>
                            </h2>
                            <div id="f1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Anda cukup mendaftarkan akun di menu Registrasi, lengkapi profil, lalu pilih program
                                    bantuan yang sedang dibuka.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f2">
                                    Apakah pendaftaran ini dipungut biaya?
                                </button>
                            </h2>
                            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Tidak. Seluruh proses pendaftaran hingga penyaluran bantuan dilakukan secara gratis
                                    tanpa pungutan biaya apapun.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f3">
                                    Bagaimana jika pengajuan saya ditolak?
                                </button>
                            </h2>
                            <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Jika ditolak, Anda bisa melihat alasan penolakan di dashboard akun Anda dan mencoba
                                    melengkapi berkas yang kurang pada periode berikutnya.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOTAK SARAN --}}
                <div class="col-lg-6 wow fadeInRight">
                    <div class="contact-card position-relative overflow-hidden">
                        <div class="success-message-css">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                                <h4 class="fw-bold">Terkirim!</h4>
                                <p class="text-muted">Terima kasih atas saran Anda. Kami akan segera meninjau pesan Anda.
                                </p>
                                {{-- Link ini berfungsi untuk reset tampilan (menghapus #success di URL) --}}
                                <a href="#home" class="btn btn-sm btn-pink mt-2">Kirim Lagi</a>
                            </div>
                        </div>

                        <h3 class="fw-bold mb-3" style="color: #ff5876;">Kotak Saran</h3>
                        <p class="text-muted mb-4 small">Bantu kami meningkatkan layanan dengan memberikan saran atau
                            kritik yang membangun.</p>

                        {{-- Form mengarah ke #success --}}
                        <form action="#success" class="form-saran-container">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-custom" placeholder="Nama Lengkap"
                                    required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control form-control-custom" rows="4" placeholder="Tuliskan saran Anda..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-pink w-100 btn-submit-saran">
                                Kirim Saran <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Informasi Tambahan --}}
    <section class="section bg-light">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8 wow zoomIn">
                    <img src="{{ asset('assets/images/about/about-img.png') }}" class="img-fluid rounded-4 mb-4"
                        style="max-width: 300px;" alt="Tentang Kami">
                    <h2 class="fw-bold">Bersama Membangun Desa</h2>
                    <p class="text-muted">Sistem ini dikelola secara transparan oleh Pemerintah Desa untuk
                        memastikan kesejahteraan seluruh warga.</p>
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>
    </section>
@endsection
