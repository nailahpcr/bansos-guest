@extends('layout.layout')

@section('title', 'Bantuan Sosial & Bina Desa')

@section('content')

    {{-- Bagian Hero --}}
    <section id="home" class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h1 class="wow fadeInLeft" data-wow-delay=".4s">Mewujudkan Kesejahteraan Melalui Bantuan Sosial dan Pemanfaatan.</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s">Kami berkomitmen untuk membangun masyarakat desa yang mandiri, sejahtera, dan berdaya saing melalui program-program yang tepat sasaran dan berkelanjutan.</p>
                        <div class="button wow fadeInLeft" data-wow-delay=".8s">
                            <a href="#features" class="btn">Lihat Program Kami</a>
                            <a href="{{ url('/kontak') }}" class="btn btn-alt">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        {{-- Ganti gambar dengan yang lebih relevan, misal: kegiatan di desa atau penyerahan bantuan --}}
                        <img src="{{ asset('guest/assets/images/hero/kegiatan-desa.jpg') }}" alt="Kegiatan Bina Desa">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian Fitur / Program Unggulan --}}
    <section id="features" class="features section">
        <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Fokus Program</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Membangun Desa, Memberdayakan Masyarakat.</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Program kami dirancang untuk menyentuh berbagai aspek kehidupan masyarakat demi menciptakan perubahan yang positif dan langgeng.</p>
                </div>
            </div>
        </div>

        {{-- Menampilkan pesan sukses setelah operasi CRUD --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success wow fadeInUp" data-wow-delay=".7s">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Tombol Tambah Program, hanya muncul untuk user yang sudah login --}}
        @auth
        <div class="row mb-4">
            <div class="col-12 text-center">
                <a class="btn btn-primary wow fadeInUp" data-wow-delay=".8s" href="{{ route('program.create') }}">
                    <i class="lni lni-plus"></i> Tambah Program Baru
                </a>
            </div>
        </div>
        @endauth


        <div class="row">
            {{-- Loop untuk menampilkan setiap program dari database --}}
            @foreach ($programs as $program)
            <div class="col-lg-4 col-md-6 col-12">
                {{-- Menambahkan delay animasi yang berbeda untuk setiap item --}}
                <div class="single-feature wow fadeInUp" data-wow-delay="{{ 0.2 + ($loop->iteration % 3) * 0.2 }}s">
                    {{-- Ganti ikon sesuai kebutuhan, atau tambahkan kolom 'icon' di database Anda --}}
                    <i class="lni lni-bullhorn"></i>
                    <h3>{{ $program->nama_program }} ({{ $program->tahun }})</h3>
                    <p>{{ $program->deskripsi }}</p>
                    <p><strong>Anggaran:</strong> Rp {{ number_format($program->anggaran, 0, ',', '.') }}</p>
                    
                    {{-- Tombol Aksi (Edit & Hapus), hanya muncul untuk user yang sudah login --}}
                    @auth
                    <div class="action-buttons mt-3">
                        <form action="{{ route('program.destroy', $program->program_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                            <a class="btn btn-sm btn-info" href="{{ route('program.edit', $program->program_id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        {{-- Link untuk Pagination, jika data lebih dari 10 --}}
        <div class="row mt-5">
            <div class="col-12">
                {!! $programs->links() !!}
            </div>
        </div>

    </div>
    </section>

    {{-- POTONGAN KONTEN LAIN SEPERTI ACHIEVEMENT, PRICING, DLL MASUKKAN DI SINI --}}
    {{-- ... (lanjutkan copy-paste section lain dari HTML asli ke sini) ... --}}
    
    {{-- Bagian Call to Action / Ajakan Kolaborasi --}}
    <section class="section call-action">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                    <div class="cta-content">
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">Jadilah Bagian Dari Perubahan Positif di Desa</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">Setiap kontribusi Anda, besar maupun kecil, akan sangat berarti bagi pembangunan dan kesejahteraan masyarakat. Mari bergerak bersama kami.</p>
                        <div class="button wow fadeInUp" data-wow-delay=".6s">
                            <a href="{{ url('/donasi') }}" class="btn">Donasi Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection