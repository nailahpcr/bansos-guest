@extends('layout.guest.app')

@section('title', 'Kelola Program Bantuan')

@section('content')
<style>
    /* 1. Background Halaman: Gradasi Pink ke Putih (Sama dengan Warga) */
    body {
        background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
        min-height: 100vh;
    }

    .features.section {
        background: transparent;
    }

    /* 2. Action Bar & Search Group */
    .action-bar-container {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #ffffff;
        padding: 15px 20px;
        border-radius: 20px;
        border: 1px solid rgba(255, 107, 129, 0.1);
    }
    .search-combined-group {
        display: flex;
        flex-grow: 1;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .search-combined-group .form-select, 
    .search-combined-group .form-control {
        border: none; 
        height: 48px;
    }
    .search-combined-group .form-select { 
        max-width: 160px; 
        background-color: #f8f9fa; 
        border-right: 1px solid #eee;
    }
    .btn-inner-search { 
        background: #FF6B81; 
        color: #fff; 
        padding: 0 20px; 
        border: none; 
        transition: 0.3s;
    }
    .btn-inner-search:hover { background: #ee4e66; color: #fff; }

    /* 3. Action Buttons */
    .btn-add-program {
        background: #2ecc71; 
        color: #fff; 
        height: 48px; 
        display: flex; 
        align-items: center;
        padding: 0 20px; 
        border-radius: 12px; 
        font-weight: 600; 
        text-decoration: none; 
        transition: 0.3s;
        white-space: nowrap;
    }
    .btn-add-program:hover { background: #27ae60; color: #fff; transform: translateY(-2px); }

    /* 4. Statistics Cards */
    .stat-card { transition: 0.3s; border-radius: 15px; overflow: hidden; border: none !important; }
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .bg-decoration {
        position: absolute; bottom: -20px; right: -20px; width: 100px; height: 100px;
        background: currentColor; border-radius: 50%; opacity: 0.05; z-index: 1;
    }

    /* 5. Program Cards */
    .program-card { transition: 0.3s; border-radius: 15px; overflow: hidden; }
    .program-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .program-image-wrapper { height: 180px; overflow: hidden; position: relative; }
    .program-image-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    
    .btn-light-info { background: rgba(13, 202, 240, 0.1); color: #0dcaf0; border: none; }
    .btn-light-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: none; }
    .btn-light-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: none; }

    /* Responsive */
    @media (max-width: 991px) {
        .action-bar-container { flex-direction: column; align-items: stretch; }
        .search-combined-group { flex-direction: column; border: none; gap: 10px; }
        .search-combined-group .form-select, 
        .search-combined-group .form-control {
            max-width: 100%; border-radius: 10px !important; border: 1px solid #eee;
        }
        .btn-add-program { justify-content: center; }
    }
</style>

<section id="features" class="features section">
    <div class="container">
        {{-- HEADER TITLE --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Manajemen Program</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Program Bantuan</h2>
                    <p class="wow fadeInUp text-white" data-wow-delay=".6s">Kelola dan pantau program bantuan yang tersedia untuk warga.</p>
                </div>
            </div>
        </div>

        {{-- ACTION BAR: SEARCH & ADD --}}
        <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
            <div class="col-12">
                <div class="action-bar-container shadow-sm">
                    <form action="{{ route('kelola-program.index') }}" method="GET" class="flex-grow-1">
                        <div class="search-combined-group">
                            <select name="tahun" class="form-select shadow-none">
                                <option value="">Semua Tahun</option>
                                @foreach ($available_years as $year)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                        Tahun {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="q" class="form-control shadow-none" placeholder="Cari Nama atau Kode Program..." value="{{ request('q') }}">
                            <button type="submit" class="btn btn-inner-search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="d-flex gap-2">
                        <a class="btn-add-program" href="{{ route('kelola-program.create') }}">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Program
                        </a>
                        @if (request('q') || request('tahun'))
                            <a href="{{ route('kelola-program.index') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="width: 48px; border-radius: 12px;">
                                <i class="fas fa-sync-alt text-muted"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- SUCCESS NOTIFICATION --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 15px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- STATISTICS CARDS --}}
        <div class="row g-4 mb-5">
            <div class="col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="card stat-card shadow-sm">
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                            <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: rgba(13, 110, 253, 0.1);">
                                <i class="fas fa-layer-group fa-2x text-primary"></i>
                            </div>
                            <div>
                                <div class="text-uppercase mb-1 fw-bold text-primary" style="font-size: 0.7rem; letter-spacing: 1px;">Total Program</div>
                                <h2 class="h3 mb-0 fw-bold text-dark">{{ $programs->total() }}</h2>
                            </div>
                        </div>
                        <div class="bg-decoration" style="color: #0d6efd"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 wow fadeInUp" data-wow-delay=".5s">
                <div class="card stat-card shadow-sm">
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                            <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: rgba(46, 204, 113, 0.1);">
                                <i class="fas fa-calendar-check fa-2x text-success"></i>
                            </div>
                            <div>
                                <div class="text-uppercase mb-1 fw-bold text-success" style="font-size: 0.7rem; letter-spacing: 1px;">Filter Tahun Aktif</div>
                                <h2 class="h3 mb-0 fw-bold text-dark">{{ request('tahun') ?: date('Y') }}</h2>
                            </div>
                        </div>
                        <div class="bg-decoration" style="color: #2ecc71"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LIST DATA (CARD STYLE) --}}
        <div class="row g-4">
            @forelse ($programs as $program)
                <div class="col-md-6 col-lg-4 wow fadeInUp">
                    <div class="card program-card border-0 shadow-sm h-100">
                        {{-- Image Logic --}}
                        <div class="program-image-wrapper bg-light">
                            @php
                                $filePath = $program->file;
                                $isImage = $filePath && in_array(pathinfo($filePath, PATHINFO_EXTENSION), ['jpg','jpeg','png','webp']);
                            @endphp
                            @if ($isImage)
                                <img src="{{ asset('storage/' . $filePath) }}" alt="Program">
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center h-100 opacity-25">
                                    <i class="fas fa-image fa-3x"></i>
                                    <span class="small mt-2">No Image</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold text-truncate mb-1">{{ $program->nama_program }}</h5>
                            <h6 class="card-subtitle mb-3 text-muted small"><i class="fas fa-tag me-1"></i> {{ $program->kode }}</h6>
                            <hr class="my-3 opacity-25">
                            
                            <div class="mb-4">
                                <p class="mb-1 small text-muted"><i class="fas fa-calendar-alt me-2"></i>Tahun: {{ $program->tahun }}</p>
                                <p class="mb-1 small text-muted"><i class="fas fa-money-bill-wave me-2"></i>Rp {{ number_format($program->anggaran, 0, ',', '.') }}</p>
                                <p class="mb-0 small text-muted text-truncate"><i class="fas fa-info-circle me-2"></i>{{ Str::limit($program->deskripsi, 50) }}</p>
                            </div>

                            <div class="btn-group w-100 gap-2">
                                <a href="{{ route('kelola-program.show', $program->program_id) }}" class="btn btn-light-info flex-fill rounded-3 py-2"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('kelola-program.edit', $program->program_id) }}" class="btn btn-light-warning flex-fill rounded-3 py-2"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-light-danger flex-fill rounded-3 py-2" data-bs-toggle="modal" data-bs-target="#delProg{{ $program->program_id }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Delete --}}
                <div class="modal fade" id="delProg{{ $program->program_id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-body text-center p-4">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h5 class="fw-bold">Hapus Program?</h5>
                                <p class="small text-muted">Yakin ingin menghapus <strong>{{ $program->nama_program }}</strong>?</p>
                                <div class="d-flex gap-2 mt-4">
                                    <button type="button" class="btn btn-light flex-fill rounded-pill" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('kelola-program.destroy', $program->program_id) }}" method="POST" class="flex-fill">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100 rounded-pill">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3" alt="Empty">
                    <p class="text-white">Data program tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-5 d-flex justify-content-center">
            {!! $programs->appends(request()->except('page'))->links() !!}
        </div>
    </div>
</section>
@endsection