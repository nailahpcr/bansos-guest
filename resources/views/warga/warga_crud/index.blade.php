@extends('layout.layout')

@section('title', 'Manajemen Data Warga')

@section('content')

    <section id="features" class="features section">
        <div class="container">

            {{-- SECTION TITLE (Tidak berubah) --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Kelola data warga yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>

            {{-- HEADER HALAMAN & TOMBOL TAMBAH (Tidak berubah) --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Daftar Warga</h3>
                    <a class="btn btn-success" href="{{ route('warga.create') }}"> {{-- Perbaikan kecil pada href --}}
                        <i class="fas fa-plus me-1"></i> Tambah Warga
                    </a>
                </div>
            </div>

            {{-- PESAN SUKSES (FLASH MESSAGE) (Tidak berubah) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ========================================================== --}}
            {{-- INI ADALAH TAMPILAN CARD (PENGGANTI TABEL) --}}
            {{-- ========================================================== --}}
            <div class="row g-4"> {{-- g-4 memberikan jarak antar kartu --}}
                @forelse ($wargas as $warga)
                    {{-- Setiap kartu berada di dalam kolom agar responsif --}}
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".{{ ($loop->iteration % 4) + 1 }}s">
                        <div class="card shadow-sm h-100"> {{-- h-100 membuat tinggi kartu dalam satu baris sama --}}
                            <div class="card-body d-flex flex-column"> {{-- flex-column untuk mendorong tombol ke bawah --}}

                                {{-- Judul dan Subjudul Kartu --}}
                                <h5 class="card-title">{{ $warga->nama }}</h5>
                                <h6 class="card-subtitle mb-3 text-muted">
                                    <i class="fas fa-id-card me-1"></i> {{ $warga->no_ktp }}
                                </h6>

                                <hr>

                                {{-- Detail Data Warga --}}
                                <p class="card-text mb-2">
                                    <i class="fas fa-venus-mars me-2 text-secondary"></i>
                                    <strong>Jenis Kelamin:</strong> {{ $warga->jenis_kelamin }}
                                </p>
                                <p class="card-text mb-2">
                                    <i class="fas fa-pray me-2 text-secondary"></i>
                                    <strong>Agama:</strong> {{ $warga->agama }}
                                </p>
                                <p class="card-text mb-3">
                                    <i class="fas fa-phone me-2 text-secondary"></i>
                                    <strong>No. Telp:</strong> {{ $warga->telp ?? 'Tidak ada' }}
                                </p>

                                {{-- Tombol Aksi di bagian bawah kartu --}}
                                <div class="mt-auto">
                                    <a href="{{ route('warga.show', $warga->warga_id) }}" class="btn btn-success w-100">
                                        <i class="fas fa-eye me-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Pesan jika tidak ada data warga --}}
                    <div class="col-12">
                        <div class="alert alert-secondary text-center wow fadeInUp" data-wow-delay=".2s">
                            <p class="mb-0">Belum ada data warga yang bisa ditampilkan.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION LINKS (Tidak berubah) --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                    {{-- Pastikan controller Anda menggunakan ->paginate() --}}
                    {!! $wargas->links() !!}
                </div>
            </div>

        </div>
    </section>
@endsection
