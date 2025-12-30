@extends('layout.guest.app')

@section('title', 'Data Verifikasi Lapangan')

@section('content')
<style>
    /* 1. Background Halaman: Gradasi Pink ke Putih */
    body {
        background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
        min-height: 100vh;
        background-attachment: fixed;
    }

    .features.section { background: transparent; }

    /* 2. Action Bar & Search Group */
    .action-bar-container {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        padding: 15px 20px;
        border-radius: 20px;
        border: 1px solid rgba(13, 110, 253, 0.2);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .search-combined-group {
        display: flex;
        flex-grow: 1;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(13, 110, 253, 0.1);
        background: #fff;
    }

    .search-combined-group .form-control, .search-combined-group .form-select {
        border: none;
        height: 48px;
        box-shadow: none !important;
    }

    .btn-inner-search {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 0 20px;
    }

    .btn-add-verifikasi {
        background-color: #2ecc71;
        color: white;
        height: 48px;
        display: flex;
        align-items: center;
        padding: 0 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    /* 3. Card Styling */
    .riwayat-card {
        background: #ffffff;
        border: none !important;
        border-radius: 20px !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .riwayat-card:hover { transform: translateY(-10px); }

    .riwayat-image-wrapper {
        position: relative;
        height: 200px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .riwayat-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-score-float {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }

    /* Penyesuaian Mobile */
    @media (max-width: 991px) {
        .action-bar-container { flex-direction: column; align-items: stretch; }
        .search-combined-group { flex-direction: column; border: none; gap: 10px; }
    }
</style>

<section id="features" class="features section">
    <div class="container">
        {{-- JUDUL --}}
        <div class="section-title text-center">
            <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Validasi Data</h3>
            <h2 class="wow fadeInUp text-white" data-wow-delay=".4s">Hasil Verifikasi Lapangan</h2>
            <p class="wow fadeInUp text-white" data-wow-delay=".6s">Kelola dan tinjau hasil survei untuk bantuan tepat sasaran.</p>
        </div>

        {{-- TOOLBAR --}}
        <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
            <div class="col-12">
                <div class="action-bar-container">
                    <form action="{{ route('verifikasi.index') }}" method="GET" class="flex-grow-1">
                        <div class="search-combined-group shadow-sm">
                            <select name="status" class="form-select border-end" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="layak" {{ request('status') == 'layak' ? 'selected' : '' }}>Layak (≥ 70)</option>
                                <option value="kurang" {{ request('status') == 'kurang' ? 'selected' : '' }}>Kurang (< 70)</option>
                            </select>

                            <input type="text" name="filter_petugas" class="form-control border-end" 
                                   placeholder="Nama Petugas..." value="{{ request('filter_petugas') }}">

                            <input type="text" name="q" class="form-control" 
                                   placeholder="Cari Nama Warga..." value="{{ request('q') }}">

                            <button type="submit" class="btn btn-inner-search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <a class="btn-add-verifikasi shadow-sm" href="{{ route('verifikasi.create') }}">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Verifikasi
                    </a>
                </div>
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- GRID DATA --}}
        <div class="row g-4">
            @forelse ($verifikasi as $item)
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".2s">
                    <div class="card h-100 riwayat-card">
                        
                        {{-- IMAGE WRAPPER --}}
                        <div class="riwayat-image-wrapper">
                            <div class="badge-score-float">
                                <span class="badge {{ $item->skor >= 70 ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2 shadow-sm">
                                    Skor: {{ $item->skor }}
                                </span>
                            </div>

                            {{-- Ambil file pertama untuk preview gambar --}}
                            @php $firstFile = $item->files->first(); @endphp

                            @if ($firstFile && in_array(strtolower(pathinfo($firstFile->path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/' . $firstFile->path) }}" alt="Bukti">
                            @else
                                <div class="text-center opacity-25">
                                    <i class="fas fa-file-invoice fa-4x text-muted"></i>
                                    <p class="mb-0 mt-2">Tidak ada foto</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-soft-primary text-primary" style="font-size: 0.7rem; font-weight: 800;">VERIFIKASI</span>
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</small>
                            </div>

                            <h5 class="fw-bold mb-1">{{ $item->pendaftar->warga?->nama ?? 'N/A' }}</h5>
                            <p class="text-primary small mb-3">
                                <i class="fas fa-hand-holding-heart me-1"></i> {{ $item->pendaftar->program?->nama_program ?? 'Program Nil' }}
                            </p>

                            <hr class="my-2 opacity-50">

                            {{-- LIST FILE (Seperti Pendaftar) --}}
                            <div class="mb-3">
                                <small class="text-muted d-block mb-2"><i class="fas fa-paperclip me-1"></i> Lampiran ({{ $item->files->count() }}):</small>
                                @forelse ($item->files->take(2) as $file)
                                    <div class="d-flex align-items-center mb-1 bg-light p-1 rounded border" style="font-size: 0.75rem;">
                                        <i class="fas {{ Str::endsWith($file->path, '.pdf') ? 'fa-file-pdf text-danger' : 'fa-image text-info' }} me-2"></i>
                                        <span class="text-truncate">{{ $file->filename }}</span>
                                    </div>
                                @empty
                                    <small class="text-muted italic">Tidak ada file.</small>
                                @endforelse
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block small">Petugas:</small>
                                <span class="fw-bold small"><i class="fas fa-user-check me-1 text-secondary"></i> {{ $item->petugas }}</span>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="mt-auto pt-3 border-top">
                                <div class="btn-group w-100 gap-2">
                                    {{-- Tombol detail --}}
                                    <a href="{{ route('verifikasi.show', $item->verifikasi_id ?? $item->id) }}"
                                        class="btn btn-sm btn-light text-info rounded-3"
                                        style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;" 
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Tombol edit --}}
                                    <a href="{{ route('verifikasi.edit', $item->verifikasi_id ?? $item->id) }}" 
                                        class="btn btn-sm btn-light text-warning rounded-3"
                                        style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;"
                                        title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- Tombol hapus --}}
                                    <button type="button" class="btn border-0 rounded-3"
                                            style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                            data-bs-toggle="modal" data-bs-target="#deletePendaftar{{ $item->id }}"
                                            title="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Hapus --}}
                    <div class="modal fade" id="deletePendaftar{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Hapus Data Pendaftar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data pendaftaran
                                    <strong>{{ $item->pendaftar->warga }}</strong>?
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('verifikasi.destroy', $item) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-3x text-white opacity-25 mb-3"></i>
                    <p class="text-white">Belum ada data verifikasi yang ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-5">
            {!! $verifikasi->appends(request()->except('page'))->links() !!}
        </div>
    </div>
</section>
@endsection