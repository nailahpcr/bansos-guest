@extends('layout.guest.app')

@section('content')
    <div class="container py-5">
        <header class="text-center mb-5">
            <h1 class="display-4 text-success">About Us</h1>
            <p class="lead text-muted">Aplikasi untuk Pembangunan Desa yang Mandiri dan Sejahtera.</p>
        </header>

        {{-- Pengantar Singkat --}}
        <section class="mb-5 p-4 bg-light rounded shadow-sm text-center">
            <p class="fs-5">
                Program Bina Desa adalah sistem informasi yang dirancang untuk mentransformasi tata kelola program pembangunan di tingkat desa. Fokus utama kami adalah memastikan transparansi data dan efisiensi penyaluran bantuan serta pelatihan bagi warga desa.
            </p>
        </section>

      

        {{-- Modul Inti --}}
        <section class="mb-5">
            <h2 class="text-center mb-4 text-success">Tiga Modul Inti Sistem</h2>
            <div class="row">

                {{-- Modul 1: Program --}}
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-primary">
                        <div class="card-body">
                            <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Manajemen Program</h5>
                            <p class="card-text">
                                Tujuan : Mengelola data program (anggaran, deskripsi, kode) agar tercatat resmi dan terpusat. <br>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Modul 2: Warga --}}
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-info">
                        <div class="card-body">
                            <i class="fas fa-user-check fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Partisipasi & Pengajuan</h5>
                            <p class="card-text">
                                Tujuan : Memudahkan warga mengajukan diri ke program yang relevan. <br>
                            
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Modul 3: Laporan --}}
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-warning">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Laporan & Akuntabilitas</h5>
                            <p class="card-text">
                                Tujuan : Menjamin transparansi anggaran dan hasil penyaluran bantuan. <br>
                               
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    

        {{-- Pilar dan CTA --}}
        <section class="text-center pt-4 border-top">
            <h2 class="mb-3">Pilar Pembangunan Utama</h2>
            <p class="text-muted">Fokus program didukung oleh dua pilar: Pemberdayaan Ekonomi Lokal dan Pembangunan Infrastruktur Desa.</p>
            <a href="#" class="btn btn-lg btn-success mt-3"><i class="fas fa-hand-point-right me-2"></i> Kunjungi Daftar Program</a>
        </section>
    </div>
@endsection