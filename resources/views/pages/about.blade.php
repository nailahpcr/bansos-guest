@extends('layout.guest.app')

@section('content')
    {{-- 1. STYLE TAMBAHAN UNTUK MENYERAGAMKAN FONT --}}
    <style>
        /* Mengimpor font Poppins dari Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        /* Memaksa semua elemen menggunakan font yang sama */
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a,
        div,
        span {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Membuat teks paragraf sedikit lebih renggang agar mudah dibaca */
        p {
            line-height: 1.6;
            color: #555;
            /* Warna abu gelap agar tidak terlalu tajam di mata */
        }
    </style>

    <div class="container py-5">

        

        {{-- HEADER SECTION --}}
        <div class="container py-5">

            <div class="row">

                <div class="col-12">

                    <div class="section-title">

                        <h3 class="wow zoomIn" data-wow-delay=".2s">Tentang Kami</h3>

                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Dedikasi Untuk Pelayanan</h2>

                    </div>

                </div>

            </div>

            {{-- PENGANTAR SINGKAT --}}
            <section class="mb-5 p-5 bg-white rounded shadow-sm text-center border">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <p class="fs-5 m-0 fw-normal">
                            <span class="fw-bold text-success">Program Bina Desa</span> adalah sistem informasi yang
                            dirancang
                            untuk mentransformasi tata kelola program pembangunan di tingkat desa. Fokus utama kami adalah
                            memastikan <span class="fw-bold">transparansi data</span> dan <span class="fw-bold">efisiensi
                                penyaluran</span> bantuan serta pelatihan bagi warga desa.
                        </p>
                    </div>
                </div>
            </section>

            {{-- MODUL INTI --}}
            <section class="mb-5">
                <h3 class="text-center mb-5 fw-bold text-dark wow fadeInUp">Tiga Modul Inti Sistem</h3>
                <div class="row g-4"> {{-- g-4 memberikan jarak antar kolom --}}

                    {{-- Modul 1: Program --}}
                    <div class="col-md-4 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card h-100 shadow-sm border-0 bg-light hover-effect">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-boxes fa-3x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Manajemen Program</h5>
                                <p class="card-text small">
                                    Mengelola data program (anggaran, deskripsi, kode) agar tercatat resmi dan terpusat
                                    dengan
                                    rapi.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Modul 2: Warga --}}
                    <div class="col-md-4 wow fadeInUp" data-wow-delay=".4s">
                        <div class="card h-100 shadow-sm border-0 bg-light hover-effect">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-user-check fa-3x text-info"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Partisipasi & Pengajuan</h5>
                                <p class="card-text small">
                                    Memudahkan warga mengajukan diri ke program yang relevan secara mandiri dan transparan.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Modul 3: Laporan --}}
                    <div class="col-md-4 wow fadeInUp" data-wow-delay=".6s">
                        <div class="card h-100 shadow-sm border-0 bg-light hover-effect">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-chart-line fa-3x text-warning"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Laporan & Akuntabilitas</h5>
                                <p class="card-text small">
                                    Menjamin transparansi anggaran dan memantau hasil penyaluran bantuan secara real-time.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>


                <a href="#" class="btn btn-success btn-lg px-5 rounded-pill shadow fw-bold wow zoomIn"
                    data-wow-delay=".4s">
                    <i class="fas fa-hand-point-right me-2"></i> Kunjungi Daftar Program
                </a>
            </section>

        </div>
    @endsection
