@extends('layout.guest.app')

@section('title', 'Riwayat Penyaluran Bantuan')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            {{-- JUDUL HALAMAN --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Monitoring Bantuan</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Riwayat Penyaluran</h2>
                        <p class="wow fadeInUp text-white" data-wow-delay=".6s">Pantau distribusi dan bukti penyaluran
                            bantuan kepada
                            warga secara transparan.</p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR: SEARCH & ADD BUTTON --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-12">
                    <div class="action-bar-container">
                        {{-- FORM SEARCH --}}
                        <form action="{{ route('riwayat.index') }}" method="GET" class="flex-grow-1">
                            <div class="search-combined-group shadow-sm">
                                <input type="text" name="q" class="form-control shadow-none"
                                    placeholder="Cari Nama Penerima atau Program..." value="{{ request('q') }}">
                                <button type="submit" class="btn btn-inner-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        {{-- TOMBOL TAMBAH --}}
                        <a class="btn-add-warga shadow-sm" href="{{ route('riwayat.create') }}">
                            <i class="fas fa-plus-circle me-2"></i> Catat Penyaluran
                        </a>

                        @if (request('q'))
                            <a href="{{ route('riwayat.index') }}"
                                class="btn btn-light border d-flex align-items-center shadow-sm"
                                style="height:48px; border-radius:12px;" title="Reset">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="opacity-25 mb-4">

            {{-- DAFTAR RIWAYAT (1 BARIS = 3 CARD DENGAN col-lg-4) --}}
            <div class="row g-4">
                @forelse ($riwayats as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card shadow-sm h-100 border-0 riwayat-card">

                            {{-- IMAGE / BUKTI --}}
                            <div class="riwayat-image-wrapper">
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
                                        <img src="{{ asset('storage/' . $item->file) }}" alt="Bukti Penyaluran">
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
                                    <span class="badge-step text-uppercase">Tahap {{ $item->tahap_ke }}</span>
                                    <small class="text-muted"><i class="far fa-calendar-alt"></i>
                                        {{ date('d/m/Y', strtotime($item->tanggal)) }}</small>
                                </div>

                                <h5 class="fw-bold text-dark mb-1 text-truncate"
                                    title="{{ $item->program->nama_program ?? 'Program' }}">
                                    {{ $item->program->nama_program ?? 'Program Bantuan' }}
                                </h5>
                                <p class="text-primary mb-3" style="font-size: 0.85rem;">
                                    <i class="fas fa-user-circle me-1"></i> {{ $item->penerima->nama_lengkap ?? 'N/A' }}
                                </p>

                                <hr class="opacity-50 mt-0">

                                <div class="mb-4">
                                    <small class="text-muted d-block mb-1">Nilai Bantuan:</small>
                                    <span class="fw-bold text-success" style="font-size: 1.1rem;">Rp
                                        {{ number_format($item->nilai, 0, ',', '.') }}</span>
                                </div>

                                {{-- TOMBOL AKSI (STYLE PROGRAM) --}}
                                <div class="mt-auto">
                                    <div class="btn-group w-100 gap-2">
                                        <a href="{{ route('riwayat.show', $item->penyaluran_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('riwayat.edit', $item->penyaluran_id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('riwayat.destroy', $item->penyaluran_id) }}" method="POST"
                                            class="d-inline flex-grow-1">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn border-0 rounded-3 w-100"
                                                style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                                onclick="return confirm('Hapus riwayat ini?')" title="Hapus">
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
                        <i class="fas fa-info-circle fa-3x text-muted opacity-25 mb-3"></i>
                        <p class="text-muted">Data penyaluran tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {!! $riwayats->appends(request()->except('page'))->links() !!}
                </div>
            </div>
        </div>
    </section>

    <style>
        /* 1. Background Halaman: Gradasi Pink ke Putih */
        body {
            background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Memastikan section transparan agar background body terlihat */
        .features.section {
            background: transparent;
        }

        /* 2. Judul Section (Memastikan scannability di atas background pink) */
        .section-title h2 {
            color: #000000 !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-title h3 {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .section-title p {
            color: rgba(255, 255, 255, 0.85) !important;
        }

        /* 3. Toolbar: Glassmorphism Style */
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
            /* Hijau untuk aksi positif/tambah */
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

        /* 4. Riwayat Card Styling */
        .riwayat-card {
            background: #ffffff;
            border: none !important;
            border-radius: 20px !important;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .riwayat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

        /* 5. Image Wrapper Style */
        .riwayat-image-wrapper {
            width: 100%;
            height: 200px;
            background-color: #f1f2f6;
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

        .badge-step {
            background: rgba(255, 107, 129, 0.1);
            color: #FF6B81;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
        }

        /* 6. Buttons inside Card */
        .btn-group .btn {
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            border-radius: 8px !important;
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

            .btn-add-warga {
                justify-content: center;
            }
        }
    </style>

@endsection
