@extends('layout.guest.app')

@section('title', 'Kelola Program Bantuan')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Program</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Program Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Kelola dan pantau program bantuan yang tersedia untuk
                            warga.</p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR: SEARCH & ADD BUTTON (SAMA DENGAN WARGA) --}}
            <div class="container mt-4">
                <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold mb-0" style="color: #2d3436;">
                                <i class="fas fa-hand-holding-heart me-2" style="color: #FF6B81;"></i>Daftar Program
                            </h3>
                        </div>

                        <div class="action-bar-container">
                            {{-- FORM SEARCH --}}
                            <form action="{{ route('kelola-program.index') }}" method="GET" class="flex-grow-1">
                                <div class="search-combined-group shadow-sm">
                                    {{-- Dropdown Filter Tahun --}}
                                    <select name="tahun" class="form-select shadow-none">
                                        <option value="">Semua Tahun</option>
                                        @foreach ($available_years as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                Tahun {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Input Text --}}
                                    <input type="text" name="q" class="form-control shadow-none"
                                        placeholder="Cari Nama atau Kode Program..." value="{{ request('q') }}">

                                    {{-- Tombol Cari --}}
                                    <button type="submit" class="btn btn-inner-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- TOMBOL TAMBAH --}}
                            <a class="btn-add-warga shadow-sm" href="{{ route('kelola-program.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Program
                            </a>

                            {{-- Tombol Reset --}}
                            @if (request('q') || request('tahun'))
                                <a href="{{ route('kelola-program.index') }}"
                                    class="btn btn-light border d-flex align-items-center shadow-sm"
                                    style="height:48px; border-radius:12px;" title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- CSS SAMA DENGAN WARGA --}}
            <style>
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

                /* Statistik Card Styling */
                .stat-card {
                    transition: all 0.3s ease-in-out;
                }

                .stat-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
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

                /* Program Card Styling */
                .program-card {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    border-radius: 15px;
                    overflow: hidden;
                }

                .program-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
                }

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

            <hr>

            {{-- PESAN NOTIFIKASI --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- STATISTIK (SAMA DENGAN WARGA) --}}
            <div class="row g-4 py-3 justify-content-center">
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px;">
                        <div class="card-body p-4 position-relative">
                            <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 60px; height: 60px; background: rgba(13, 110, 253, 0.1);">
                                    <i class="fas fa-layer-group fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <div class="text-uppercase mb-1 fw-bold" style="font-size: 0.7rem; color: #0d6efd;">
                                        Total Program</div>
                                    <h2 class="h3 mb-0 fw-bold text-dark">{{ $programs->total() }}</h2>
                                    <small class="text-muted">Program bantuan aktif</small>
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
                                    style="width: 60px; height: 60px; background: rgba(46, 204, 113, 0.1);">
                                    <i class="fas fa-calendar-check fa-2x text-success"></i>
                                </div>
                                <div>
                                    <div class="text-uppercase mb-1 fw-bold" style="font-size: 0.7rem; color: #2ecc71;">
                                        Tahun Aktif</div>
                                    <h2 class="h3 mb-0 fw-bold text-dark">{{ request('tahun') ?: date('Y') }}</h2>
                                    <small class="text-muted">Filter tahun saat ini</small>
                                </div>
                            </div>
                            <div class="bg-decoration" style="background: #2ecc71;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DAFTAR PROGRAM (CARD STYLE SAMA DENGAN WARGA) --}}
            <div class="row g-4 mt-2">
                @forelse ($programs as $program)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                        <div class="card shadow-sm h-100 border-0 program-card">
                            {{-- Image Handling Terpadu --}}
                            @php
                                // 1. Cek apakah ada file di kolom 'file' dan apakah tipenya gambar
                                $filePath = $program->file;
                                $isImage =
                                    $filePath &&
                                    in_array(pathinfo($filePath, PATHINFO_EXTENSION), [
                                        'jpg',
                                        'jpeg',
                                        'png',
                                        'webp',
                                        'gif',
                                    ]);

                                // 2. Cek relasi media (sebagai cadangan jika Anda memakai Spatie)
                                $imageMedia = $program->media
                                    ? $program->media->filter(fn($item) => Str::startsWith($item->mime_type, 'image/'))
                                    : collect();
                            @endphp

                            <div class="program-image-wrapper"
                                style="width: 100%; height: 180px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; overflow: hidden; border-bottom: 1px solid #eee;">
                                @if ($isImage)
                                    {{-- Jika gambar ada di kolom 'file' --}}
                                    <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $program->nama_program }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @elseif ($imageMedia->isNotEmpty())
                                    {{-- Jika gambar ada di relasi media --}}
                                    <img src="{{ asset('storage/uploads/program_bantuan/' . $imageMedia->first()->file_name) }}"
                                        alt="{{ $program->nama_program }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{-- Placeholder jika tidak ada gambar sama sekali --}}
                                    <div class="text-center">
                                        <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                                        <p class="mb-0 text-muted mt-2" style="font-size: 0.7rem;">Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold text-dark mb-1">{{ $program->nama_program }}</h5>
                                <h6 class="card-subtitle mb-3 text-muted">
                                    <i class="fas fa-tag me-1"></i> {{ $program->kode }}
                                </h6>
                                <hr class="opacity-50">

                                <p class="card-text mb-2">
                                    <i class="fas fa-calendar-alt me-2 text-secondary"></i>
                                    <strong>Tahun:</strong> {{ $program->tahun }}
                                </p>
                                <p class="card-text mb-2">
                                    <i class="fas fa-money-bill-wave me-2 text-secondary"></i>
                                    <strong>Anggaran:</strong> Rp {{ number_format($program->anggaran, 0, ',', '.') }}
                                </p>
                                <p class="card-text text-muted mb-4" style="font-size: 0.9rem;">
                                    {{ Str::limit($program->deskripsi, 85) }}
                                </p>

                                <div class="mt-auto">
                                    <div class="btn-group w-100 gap-2" role="group">
                                        <a href="{{ route('kelola-program.show', $program) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kelola-program.edit', $program->program_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn border-0 rounded-3"
                                            style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteProgram{{ $program->program_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Partisipasi Button (Full Width di bawah button group) --}}
                                    @if (Auth::user())
                                        <div class="mt-2">
                                            @if (Auth::user()->ProgramBantuan->contains('program_id', $program->program_id))
                                                <form
                                                    action="{{ route('kelola-program.batalkan', $program->program_id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-warning w-100 rounded-3 fw-bold"
                                                        style="font-size: 0.8rem;"
                                                        onclick="return confirm('Batalkan?')">BATALKAN</button>
                                                </form>
                                            @else
                                                <form action="{{ route('kelola-program.ajukan', $program->program_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold"
                                                        style="font-size: 0.8rem;">IKUTI PROGRAM</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Hapus (Sama dengan Warga) --}}
                    <div class="modal fade" id="deleteProgram{{ $program->program_id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Hapus Program</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus program
                                    <strong>{{ $program->nama_program }}</strong>?
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('kelola-program.destroy', $program->program_id) }}"
                                        method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center wow fadeInUp">
                        <div class="alert alert-light border-0 shadow-sm p-5">
                            <p class="mb-0 text-muted">Belum ada program bantuan yang ditemukan.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp">
                    {!! $programs->appends(request()->except('page'))->links() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
