@extends('layout.guest.app')

@section('title', 'Manajemen Data Warga')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Kelola data warga yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>


            {{-- Search Bar, Filter, dan Reset Button --}}
            <div class="container mt-4">
                <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold mb-0" style="color: #2d3436;">
                                <i class="fas fa-users-cog me-2" style="color: #FF6B81;"></i>Daftar Warga
                            </h3>
                        </div>

                        <div class="action-bar-container">
                            {{-- FORM SEARCH --}}
                            <form action="{{ route('warga.index') }}" method="GET" class="flex-grow-1">
                                <div class="search-combined-group shadow-sm">
                                    {{-- Dropdown Filter --}}
                                    <select name="gender" class="form-select shadow-none">
                                        <option value="" {{ request('gender') == '' ? 'selected' : '' }}>Semua Gender
                                        </option>
                                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>

                                    {{-- Input Text --}}
                                    <input type="text" name="search" class="form-control shadow-none"
                                        placeholder="Cari NIK, Nama..." value="{{ request('search') }}">

                                    {{-- Tombol Cari --}}
                                    <button type="submit" class="btn btn-inner-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- TOMBOL TAMBAH (Di samping search bar) --}}
                            <a class="btn-add-warga shadow-sm" href="{{ route('warga.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Warga
                            </a>

                            {{-- Tombol Reset (Muncul hanya jika filter aktif) --}}
                            @if (request('search') || request('gender'))
                                <a href="{{ route('warga.index') }}"
                                    class="btn btn-light border d-flex align-items-center shadow-sm"
                                    style="height:48px; border-radius:12px;" title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <style>
                /* Induk baris search dan button */
                .action-bar-container {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    background: rgba(255, 255, 255, 0.8);
                    backdrop-filter: blur(15px);
                    padding: 15px 20px;
                    border-radius: 20px;
                    border: 1px solid rgba(255, 107, 129, 0.2);
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                }

                /* Group Pencarian */
                .search-combined-group {
                    display: flex;
                    flex-grow: 1;
                    border-radius: 12px;
                    overflow: hidden;
                    border: 1px solid rgba(255, 107, 129, 0.2);
                }

                .search-combined-group .form-select,
                .search-combined-group .form-control {
                    border: none;
                    height: 48px;
                    padding: 0 15px;
                }

                .search-combined-group .form-select {
                    max-width: 160px;
                    border-right: 1px solid rgba(255, 107, 129, 0.1);
                    background-color: #fff;
                    font-weight: 500;
                }

                /* Tombol Cari di dalam grup */
                .btn-inner-search {
                    background-color: #FF6B81;
                    color: white;
                    border: none;
                    padding: 0 20px;
                    transition: 0.3s;
                }

                .btn-inner-search:hover {
                    background-color: #ee4e66;
                    color: white;
                }

                /* Tombol Tambah Warga (Terpisah di samping bar) */
                .btn-add-warga {
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
                    white-space: nowrap;
                }

                .btn-add-warga:hover {
                    background-color: #27ae60;
                    color: white;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
                }

                /* Responsive untuk HP */
                @media (max-width: 991px) {
                    .action-bar-container {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .search-combined-group {
                        flex-direction: column;
                        border: none;
                        gap: 10px;
                    }

                    .search-combined-group .form-select,
                    .search-combined-group .form-control,
                    .btn-inner-search {
                        max-width: 100%;
                        border-radius: 10px !important;
                        border: 1px solid rgba(255, 107, 129, 0.2);
                    }

                    .btn-add-warga {
                        justify-content: center;
                    }
                }
            </style>
            {{-- AKHIR PERUBAHAN UTAMA --}}

            <hr>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4 mb-5 justify-content-center">

                <div class="row g-4 py-3">
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px;">
                            <div class="card-body p-4 position-relative">
                                <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                                    <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px; background: rgba(13, 110, 253, 0.1);">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase mb-1 fw-bold"
                                            style="font-size: 0.7rem; letter-spacing: 1px; color: #0d6efd;">Total Warga
                                        </div>
                                        <h2 class="h3 mb-0 fw-bold text-dark">{{ number_format($totalWarga) }}</h2>
                                        <small class="text-muted">Keseluruhan data warga</small>
                                    </div>
                                </div>
                                <div class="bg-decoration"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px;">
                            <div class="card-body p-4 position-relative">
                                <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                                    <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px; background: rgba(13, 202, 240, 0.1);">
                                        <i class="fas fa-male fa-2x text-info"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase mb-1 fw-bold"
                                            style="font-size: 0.7rem; letter-spacing: 1px; color: #0dcaf0;">Warga Laki-laki
                                        </div>
                                        <h2 class="h3 mb-0 fw-bold text-dark">{{ number_format($totalLakiLaki) }}</h2>
                                        <div class="progress mt-2"
                                            style="height: 5px; width: 100px; background-color: #e9ecef;">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ ($totalLakiLaki / ($totalWarga ?: 1)) * 100 }}%"></div>
                                        </div>
                                        <small
                                            class="text-muted d-block mt-1">{{ number_format(($totalLakiLaki / ($totalWarga ?: 1)) * 100, 1) }}%</small>
                                    </div>
                                </div>
                                <div class="bg-decoration" style="background: #0dcaf0;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                        <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px;">
                            <div class="card-body p-4 position-relative">
                                <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                                    <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px; background: rgba(220, 53, 69, 0.1);">
                                        <i class="fas fa-female fa-2x text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase mb-1 fw-bold"
                                            style="font-size: 0.7rem; letter-spacing: 1px; color: #dc3545;">Warga Perempuan
                                        </div>
                                        <h2 class="h3 mb-0 fw-bold text-dark">{{ number_format($totalPerempuan) }}</h2>
                                        <div class="progress mt-2"
                                            style="height: 5px; width: 100px; background-color: #e9ecef;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ ($totalPerempuan / ($totalWarga ?: 1)) * 100 }}%"></div>
                                        </div>
                                        <small
                                            class="text-muted d-block mt-1">{{ number_format(($totalPerempuan / ($totalWarga ?: 1)) * 100, 1) }}%</small>
                                    </div>
                                </div>
                                <div class="bg-decoration" style="background: #dc3545;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .stat-card {
                        transition: all 0.3s ease-in-out;
                    }

                    .stat-card:hover {
                        transform: translateY(-8px);
                        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
                    }

                    .stat-card:hover .icon-box {
                        transform: scale(1.1);
                        transition: 0.3s;
                    }

                    .bg-decoration {
                        position: absolute;
                        bottom: -20px;
                        right: -20px;
                        width: 100px;
                        height: 100px;
                        background: #0d6efd;
                        border-radius: 50%;
                        opacity: 0.05;
                        z-index: 1;
                    }
                </style>

                <div class="row g-4">
                    @forelse ($wargas as $warga)
                        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                            <div class="card shadow-sm h-100 border-0 citizen-card"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold">{{ $warga->nama }}</h5>
                                    <h6 class="card-subtitle mb-3 text-muted">
                                        <i class="fas fa-id-card me-1"></i> {{ $warga->no_ktp }}
                                    </h6>
                                    <hr class="opacity-50">
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

                                    <div class="mt-auto">
                                        <div class="btn-group w-100 gap-2" role="group">
                                            <a href="{{ route('warga.show', $warga->warga_id) }}"
                                                class="btn border-0 rounded-3"
                                                style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                            <a href="{{ route('warga.edit', $warga->warga_id) }}"
                                                class="btn border-0 rounded-3"
                                                style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <button type="button" class="btn border-0 rounded-3"
                                                style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $warga->warga_id }}">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal{{ $warga->warga_id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data <strong>{{ $warga->nama }}</strong>?</p>
                                        <div class="alert alert-warning border-0"
                                            style="background-color: rgba(255, 193, 7, 0.1);">
                                            <small>Data yang dihapus tidak dapat dikembalikan!</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('warga.destroy', $warga->warga_id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Ya,
                                                Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center wow fadeInUp" data-wow-delay=".7s">
                            <div class="alert alert-light border-0 shadow-sm p-5">
                                <p class="mb-0 text-muted">Belum ada data warga yang bisa ditampilkan.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <style>
                    .citizen-card {
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                    }

                    .citizen-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
                    }

                    .btn-group .btn {
                        font-weight: 600;
                        font-size: 0.85rem;
                        transition: all 0.2s;
                    }

                    .btn-group .btn:hover {
                        filter: brightness(0.9);
                        transform: translateY(-2px);
                    }
                </style>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                        {!! $wargas->appends(request()->except('page'))->links() !!}
                    </div>
                </div>

            </div>

    </section>
@endsection
