@extends('layout.guest.app')

@section('title', 'Beranda - Sistem Informasi Bantuan Desa')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-pink: #FF6B81;
            --dark-text: #2d3436;
            --light-bg: #fff5f6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            overflow-x: hidden;
        }

        /* --- Hero Section --- */
        .hero-area {
            background: linear-gradient(135deg, #FF6B81 0%, #ff8e9e 100%);
            padding: 120px 0 160px;
            color: white;
            position: relative;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-slide-img {
            height: 450px;
            object-fit: cover;
            border: 8px solid rgba(255, 255, 255, 0.2);
        }

        .btn-hover-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            background-color: #fff !important;
        }


        /* --- Stats Section (Floating Cards) --- */
        .stat-card {
            padding: 40px 30px;
            border-radius: 25px;
            transition: all 0.4s ease;
            border: none;
            color: white;
            /* Mengubah teks menjadi putih agar kontras dengan gradasi */
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Efek Hover: Sedikit membesar dan bayangan lebih dalam */
        .stat-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Mengatur Ikon agar tetap terlihat bagus di atas gradasi */
        .stat-card i {
            color: rgba(255, 255, 255, 0.8) !important;
            margin-bottom: 15px;
        }

        /* Mengatur teks deskripsi di bawah angka */
        .stat-card p {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
            font-size: 0.9rem;
        }

        /* Variasi Gradasi Warna */
        .card-blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .card-green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .card-yellow {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }

        .card-pink {
            background: linear-gradient(135deg, #ff6b81 0%, #ff9a9e 100%);
        }

        /* Opsional: Menambahkan pola lingkaran halus di background kartu */
        .stat-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: -1;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-pink);
        }

        /* --- Step/Alur Section (Adopted from About Card) --- */
        .step-card {
            background: rgb(255, 255, 255);
            padding: 40px 30px;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 107, 129, 0.1);
            height: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1;
        }

        .step-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(255, 107, 129, 0.15);
            border-color: var(--primary-pink);
        }

        .step-num {
            position: absolute;
            top: -10px;
            right: 10px;
            font-size: 5rem;
            font-weight: 800;
            color: #ff6b81;
            z-index: -1;
        }

        /* --- FAQ & Accordion --- */
        .accordion-item {
            border: none;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            border-radius: 15px !important;
            overflow: hidden;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--light-bg);
            color: var(--primary-pink);
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-pink);
        }

        /* --- Kotak Saran (Contact Card) --- */
        .contact-card {
            background: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 107, 129, 0.1);
        }

        .form-control-custom {
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid #eee;
            background: #fdfdfd;
        }

        .form-control-custom:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 129, 0.1);
        }

        .btn-pink {
            background-color: var(--primary-pink);
            color: white;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
        }

        .btn-pink:hover {
            background-color: #e8566d;
            color: white;
            transform: scale(1.02);
        }

        /* --- Success Message Overlay --- */
        .success-message-css {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: none;
            /* Default hidden */
            align-items: center;
            justify-content: center;
            z-index: 10;
            padding: 20px;
        }

        /* Logika CSS saja untuk simulasi kirim pesan via anchor #success */
        #success:target .success-message-css {
            display: flex;
        }

        #success:target .form-saran-container,
        #success:target .contact-card h3,
        #success:target .contact-card p {
            display: none;
        }

        /* --- Background Blobs (Like About Page) --- */
        .custom-cta-section {
            position: relative;
            padding: 120px 0;
            /* Menggunakan gambar Anda */
            background: url('{{ asset('assets/images/about/desa (1).jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            /* Gambar ikut bergerak saat scroll */
            border-radius: 60px 60px 0 0;
            margin-top: -50px;
            overflow: hidden;
        }

        /* Overlay agar teks terbaca jelas */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        .content-wrapper {
            position: relative;
            z-index: 2;
        }

        .fw-black {
            font-weight: 900 !important;
            letter-spacing: -1px;
        }

        .text-highlight {
            color: #FF6B81;
        }

        .text-white-opacity {
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 1.15rem;
            line-height: 1.8;
        }

        .cta-badge {
            background: rgba(255, 107, 129, 0.2);
            border: 1px solid #FF6B81;
            color: #FF6B81;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-cta-pink {
            background-color: #FF6B81;
            color: white;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-cta-pink:hover {
            background-color: white;
            color: #FF6B81;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 107, 129, 0.3);
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            .custom-cta-section {
                padding: 80px 0;
                border-radius: 40px 40px 0 0;
            }

            .display-4 {
                font-size: 2.2rem;
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
                {{-- Warga Terdaftar --}}
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="stat-card card-blue text-center">
                        <i class="lni lni-users fs-1 mb-3"></i>
                        <h2 class="fw-bold text-white">1.250+</h2>
                        <p class="mb-0">Warga Terdaftar</p>
                    </div>
                </div>

                {{-- Program Aktif --}}
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="stat-card card-green text-center">
                        <i class="lni lni-layers fs-1 mb-3"></i>
                        <h2 class="fw-bold text-white">12</h2>
                        <p class="mb-0">Program Aktif</p>
                    </div>
                </div>

                {{-- Anggaran --}}
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                    <div class="stat-card card-yellow text-center">
                        <i class="lni lni-coin fs-1 mb-3"></i>
                        <h2 class="fw-bold text-white">1.2 M</h2>
                        <p class="mb-0">Anggaran Tersalurkan</p>
                    </div>
                </div>

                {{-- Tepat Sasaran --}}
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                    <div class="stat-card card-pink text-center">
                        <i class="lni lni-target fs-1 mb-3"></i>
                        <h2 class="fw-bold text-white">100%</h2>
                        <p class="mb-0">Tepat Sasaran</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alur Bantuan Section (Solid Background) --}}
    <section class="section" style="background: rgb(255, 226, 226);">
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
    {{-- Informasi Tambahan dengan Background Gambar --}}
    <section class="section custom-cta-section">
        <div class="overlay"></div> {{-- Lapisan pelindung teks --}}
        <div class="container content-wrapper text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8 wow zoomIn">
                    {{-- Badge --}}
                    <span class="badge px-4 py-2 rounded-pill mb-3 cta-badge">
                        Visi & Misi Desa
                    </span>

                    {{-- Judul dengan penekanan --}}
                    <h1 class="display-4 fw-black text-white mb-4">
                        BERSAMA <span class="text-highlight">MEMBANGUN</span> DESA
                    </h1>

                    {{-- Deskripsi --}}
                    <p class="lead text-white-opacity mb-5">
                        Sistem ini dikelola secara transparan oleh Pemerintah Desa untuk
                        memastikan kesejahteraan seluruh warga melalui tata kelola digital yang modern.
                    </p>

                    {{-- Tombol --}}
                    <a href="#contact" class="btn btn-cta-pink px-5 py-3 rounded-pill fw-bold shadow-lg">
                        Hubungi Kami <i class="lni lni-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>
    </section>
@endsection
