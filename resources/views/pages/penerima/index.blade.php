@extends('layout.guest.app')

@section('title', 'Data Penerima Bantuan')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            {{-- 1. JUDUL HALAMAN --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Distribusi Bantuan</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Penerima Bantuan</h2>
                        <p class="wow fadeInUp text-white" data-wow-delay=".6s">Daftar warga yang telah disetujui menerima bantuan
                            sosial.</p>
                    </div>
                </div>
            </div>

            {{-- 2. ACTION BAR (SEARCH & TOMBOL) --}}
            <div class="container mt-4">
                <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold mb-0" style="color: #2d3436;">
                                <i class="fas fa-hand-holding-heart me-2" style="color: #FF6B81;"></i>Data Penerima
                            </h3>
                        </div>

                        <div class="action-bar-container">
                            {{-- FORM SEARCH --}}
                            <form action="{{ route('penerima.index') }}" method="GET" class="flex-grow-1">
                                <div class="search-combined-group shadow-sm">
                                    {{-- Input Text --}}
                                    <input type="text" name="cari" class="form-control shadow-none"
                                        placeholder="Cari Nama Warga atau Program..." value="{{ request('cari') }}">

                                    {{-- Tombol Cari --}}
                                    <button type="submit" class="btn btn-inner-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- TOMBOL TAMBAH --}}
                            <a class="btn-add-warga shadow-sm" href="{{ route('penerima.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Input Penerima
                            </a>

                            {{-- Tombol Reset --}}
                            @if (request('cari'))
                                <a href="{{ route('penerima.index') }}"
                                    class="btn btn-light border d-flex align-items-center shadow-sm"
                                    style="height:48px; border-radius:12px;" title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- ALERT SUCCESS/ERROR --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- 3. GRID DATA (CARD STYLE) --}}
            <div class="row g-4 mb-5">
                @forelse ($penerima as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card shadow-sm h-100 border-0 citizen-card"
                            style="border-radius: 15px; overflow: hidden;">
                            <div class="card-body d-flex flex-column p-4">
                                {{-- Header: Nama & Program --}}
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0 text-dark">
                                        {{ $item->warga->nama ?? 'Warga Terhapus' }}</h5>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill small"
                                        style="background-color: rgba(13, 110, 253, 0.1);">
                                        {{ $item->program->nama_program ?? 'Umum' }}
                                    </span>
                                </div>

                                <h6 class="card-subtitle mb-3 text-muted small">
                                    <i class="fas fa-calendar-check me-1"></i> Disetujui:
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                </h6>

                                <hr class="opacity-50">

                                {{-- Data Detail (Mirip gaya Index Warga) --}}
                                <p class="card-text mb-2">
                                    <i class="fas fa-id-card me-2 text-secondary"></i>
                                    <strong>No. KTP:</strong> {{ $item->warga->no_ktp ?? '-' }}
                                </p>

                                <p class="card-text mb-3">
                                    <i class="fas fa-info-circle me-2 text-secondary"></i>
                                    <strong>Keterangan:</strong><br>
                                    <span
                                        class="text-muted small">{{ Str::limit($item->keterangan ?: 'Tidak ada keterangan', 80) }}</span>
                                </p>

                                {{-- Action Buttons --}}
                                <div class="mt-auto pt-2">
                                    <div class="btn-group w-100 gap-2" role="group">
                                        {{-- Jika ingin ada tombol Detail seperti warga --}}
                                        <a href="{{ route('penerima.show', $item->penerima_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>

                                        <a href="{{ route('penerima.edit', $item->penerima_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        <button type="button" class="btn border-0 rounded-3"
                                            style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->penerima_id }}">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL DELETE (Tetap Sama) --}}
                    <div class="modal fade" id="deleteModal{{ $item->penerima_id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Hapus <strong>{{ $item->warga->nama }}</strong> dari daftar penerima bantuan?</p>
                                    <div class="alert alert-warning border-0"
                                        style="background-color: rgba(255, 193, 7, 0.1);">
                                        <small>Data yang dihapus tidak dapat dikembalikan!</small>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('penerima.destroy', $item->penerima_id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay=".7s">
                        <div class="alert alert-light border-0 shadow-sm p-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="mb-0 text-muted">Belum ada data penerima bantuan.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            {{-- 4. PAGINATION --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay=".5s">
                    {!! $penerima->appends(request()->query())->links() !!}
                </div>
            </div>
        </div>
    </section>

    <style>
        /* 1. Background Halaman: Gradasi Pink ke Putih (Konsisten) */
        body {
            background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Memastikan section transparan agar background body terlihat */
        .features.section {
            background: transparent;
        }

        /* 2. Action Bar: Glassmorphism Efek Pink */
        .action-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 15px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 107, 129, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* 3. Search Group */
        .search-combined-group {
            display: flex;
            flex-grow: 1;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 107, 129, 0.2);
            background: #fff;
        }

        .search-combined-group .form-control {
            border: none;
            height: 48px;
            padding: 0 15px;
            box-shadow: none !important;
        }

        /* 4. Buttons (Search & Add) */
        .btn-inner-search {
            background-color: #FF6B81;
            /* Pink sesuai tema */
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
            /* Hijau Konsisten untuk Tombol Tambah */
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

        /* 5. Citizen Card (Kartu Penerima) */
        .citizen-card {
            background: #ffffff;
            border: none !important;
            border-radius: 20px !important;
            /* Sudut lebih lembut */
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .citizen-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

        /* 6. Action Buttons inside Card */
        .btn-group .btn {
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            border-radius: 8px !important;
        }

        .btn-group .btn:hover {
            filter: brightness(0.95);
            transform: translateY(-2px);
        }

        /* 7. Responsive Mobile */
        @media (max-width: 991px) {
            .action-bar-container {
                flex-direction: column;
                align-items: stretch;
                background: rgba(255, 255, 255, 0.95);
            }

            .search-combined-group {
                flex-direction: column;
                border: none;
                gap: 10px;
                background: transparent;
            }

            .search-combined-group .form-control,
            .btn-inner-search {
                max-width: 100%;
                border-radius: 10px !important;
                border: 1px solid rgba(255, 107, 129, 0.2);
            }

            .btn-inner-search {
                padding: 12px;
            }

            .btn-add-warga {
                justify-content: center;
            }
        }
    </style>

@endsection
