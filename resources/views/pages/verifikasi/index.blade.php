@extends('layout.guest.app')

@section('title', 'Data Verifikasi Lapangan')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            {{-- JUDUL --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Validasi Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Hasil Verifikasi Lapangan</h2>
                        <p class="wow fadeInUp text-white" data-wow-delay=".6s">Kelola dan tinjau hasil survei petugas untuk memastikan
                            bantuan tepat sasaran.</p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR: SEARCH & ADD --}}
            <div class="container mt-4">
                <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold mb-0" style="color: #2d3436;">
                                <i class="fas fa-clipboard-check me-2" style="color: #0d6efd;"></i>Daftar Verifikasi
                            </h3>
                        </div>

                        <div class="action-bar-container">
                            {{-- FORM SEARCH & FILTER --}}
                            <form action="{{ route('verifikasi.index') }}" method="GET" class="flex-grow-1">
                                <div class="search-combined-group shadow-sm">
                                    {{-- Dropdown Filter Skor --}}
                                    <select name="filter_skor" class="form-select shadow-none">
                                        <option value="">Semua Skor</option>
                                        <option value="tinggi" {{ request('filter_skor') == 'tinggi' ? 'selected' : '' }}>
                                            Skor Layak (≥ 70)</option>
                                        <option value="rendah" {{ request('filter_skor') == 'rendah' ? 'selected' : '' }}>
                                            Skor Kurang (< 70)</option>
                                    </select>

                                    {{-- Input Text --}}
                                    <input type="text" name="q" class="form-control shadow-none"
                                        placeholder="Cari nama warga atau petugas..." value="{{ request('q') }}">

                                    {{-- Tombol Cari --}}
                                    <button type="submit" class="btn btn-inner-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- TOMBOL TAMBAH --}}
                            <a class="btn-add-verifikasi shadow-sm" href="{{ route('verifikasi.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Verifikasi
                            </a>

                            {{-- Tombol Reset --}}
                            @if (request('q') || request('filter_skor'))
                                <a href="{{ route('verifikasi.index') }}"
                                    class="btn btn-light border d-flex align-items-center shadow-sm btn-reset-filter"
                                    title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- PESAN NOTIFIKASI --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- DAFTAR VERIFIKASI (GRID) --}}
            <div class="row g-4 mt-2">
                @forelse ($verifikasi as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card shadow-sm h-100 border-0 riwayat-card">

                            {{-- IMAGE / BUKTI --}}
                            <div class="riwayat-image-wrapper">
                                {{-- Badge Skor Melayang (Khas Verifikasi) --}}
                                <div class="badge-score-float">
                                    <span
                                        class="badge {{ $item->skor >= 70 ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2">
                                        Skor: {{ $item->skor }}
                                    </span>
                                </div>

                                @if ($item->file)
                                    @php
                                        $extension = pathinfo($item->file, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), [
                                            'jpg',
                                            'jpeg',
                                            'png',
                                            'gif',
                                            'webp',
                                        ]);
                                    @endphp
                                    @if ($isImage)
                                        <img src="{{ asset('storage/' . $item->file) }}" alt="Bukti Verifikasi">
                                    @else
                                        <div class="text-center">
                                            <i class="fas fa-file-alt fa-3x text-muted opacity-25"></i>
                                            <p class="mb-0 text-muted mt-2" style="font-size: 0.7rem;">File Dokumen</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                                        <p class="mb-0 text-muted mt-2" style="font-size: 0.7rem;">Tidak ada foto</p>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                {{-- INFO ATAS --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge-step text-uppercase"
                                        style="background: rgba(13, 110, 253, 0.1); color: #0d6efd; padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">
                                        VERIFIKASI
                                    </span>
                                    <small class="text-muted"><i class="far fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d/m/Y') }}</small>
                                </div>

                                <h5 class="fw-bold text-dark mb-1 text-truncate"
                                    title="{{ $item->pendaftar->warga?->nama }}">
                                    {{ $item->pendaftar->warga?->nama ?? 'Nama Tidak Ada' }}
                                </h5>

                                <p class="text-primary mb-3" style="font-size: 0.85rem;">
                                    <i class="fas fa-hand-holding-heart me-1"></i>
                                    {{ $item->pendaftar->program?->nama_program ?? 'Program Nil' }}
                                </p>

                                <hr class="opacity-50 mt-0">

                                <div class="mb-4">
                                    <small class="text-muted d-block mb-1">Petugas Pemeriksa:</small>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">
                                        <i class="fas fa-user-check me-1 text-secondary"></i> {{ $item->petugas }}
                                    </span>
                                    <p class="text-muted mb-0 mt-2" style="font-size: 0.8rem; font-style: italic;">
                                        "{{ Str::limit($item->catatan, 60) ?? 'Tidak ada catatan.' }}"
                                    </p>
                                </div>

                                {{-- TOMBOL AKSI --}}
                                <div class="mt-auto">
                                    <div class="btn-group w-100 gap-2">
                                        <a href="{{ route('verifikasi.show', $item->verifikasi_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('verifikasi.edit', $item->verifikasi_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('verifikasi.destroy', $item->verifikasi_id) }}"
                                            method="POST" class="d-inline flex-grow-1">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn border-0 rounded-3 w-100"
                                                style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                                onclick="return confirm('Hapus data verifikasi ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-3x text-muted opacity-25 mb-3"></i>
                        <p class="text-muted">Belum ada data verifikasi yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center wow fadeInUp">
                    {!! $verifikasi->appends(request()->except('page'))->links() !!}
                </div>
            </div>
        </div>
    </section>

    <style>
        /* 1. Background Halaman: Gradasi Pink ke Putih (Seragam) */
        body {
            background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Memastikan section transparan agar background body terlihat */
        .features.section {
            background: transparent;
        }

        /* 2. Action Bar: Efek Glassmorphism Biru */
        .action-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 15px 20px;
            border-radius: 20px;
            border: 1px solid rgba(13, 110, 253, 0.2);
            /* Border biru tipis khas verifikasi */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* 3. Search Group */
        .search-combined-group {
            display: flex;
            flex-grow: 1;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(13, 110, 253, 0.1);
            background: #fff;
        }

        .search-combined-group .form-select,
        .search-combined-group .form-control {
            border: none;
            height: 48px;
            box-shadow: none !important;
        }

        .search-combined-group .form-select {
            max-width: 160px;
            border-right: 1px solid rgba(13, 110, 253, 0.1);
            background-color: #f8f9fa;
            font-weight: 500;
        }

        /* 4. Buttons (Search & Add) */
        .btn-inner-search {
            background-color: #0d6efd;
            /* Biru Verifikasi */
            color: white;
            border: none;
            padding: 0 20px;
            transition: 0.3s;
        }

        .btn-inner-search:hover {
            background-color: #0b5ed7;
            color: white;
        }

        .btn-add-verifikasi {
            background-color: #2ecc71;
            /* Hijau Konsisten */
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

        .btn-add-verifikasi:hover {
            background-color: #27ae60;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        /* 5. Verifikasi Cards (Riwayat Card) */
        .riwayat-card {
            background: #ffffff;
            border: none !important;
            border-radius: 20px !important;
            transition: all 0.3s ease;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .riwayat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

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
            transition: transform 0.5s ease;
        }

        .riwayat-card:hover .riwayat-image-wrapper img {
            transform: scale(1.1);
        }

        /* 6. Score Badge */
        .badge-score-float {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
        }

        .badge-score-float .badge {
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.8);
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
            }

            .search-combined-group .form-select,
            .search-combined-group .form-control,
            .btn-inner-search {
                max-width: 100%;
                border-radius: 10px !important;
                border: 1px solid rgba(13, 110, 253, 0.2);
            }

            .btn-inner-search {
                padding: 12px;
            }

            .btn-add-verifikasi {
                justify-content: center;
            }
        }
    </style>

@endsection
