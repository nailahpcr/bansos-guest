@extends('layout.guest.app')

@section('title', 'Kelola Pendaftar Bantuan')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            {{-- HEADER SECTION --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Manajemen Pendaftar</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Pendaftar Bantuan</h2>
                        <p class="wow fadeInUp text-white" data-wow-delay=".6s">Kelola dan tinjau status pendaftaran warga
                            pada program
                            bantuan.</p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR: SEARCH & FILTER --}}
            <div class="container mt-4">
                <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold mb-0" style="color: #2d3436;">
                                <i class="fas fa-users me-2" style="color: #FF6B81;"></i>Data Pendaftar
                            </h3>
                        </div>

                        <div class="action-bar-container">
                            {{-- FORM SEARCH & FILTER --}}
                            <form action="{{ route('pendaftar.index') }}" method="GET" class="flex-grow-1">
                                <div class="search-combined-group shadow-sm">
                                    {{-- Filter Status --}}
                                    <select name="status_seleksi" class="form-select shadow-none">
                                        <option value="">Semua Status</option>
                                        <option value="pending"
                                            {{ request('status_seleksi') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="diterima"
                                            {{ request('status_seleksi') == 'diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="ditolak"
                                            {{ request('status_seleksi') == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>

                                    {{-- Input Text --}}
                                    <input type="text" name="q" class="form-control shadow-none"
                                        placeholder="Cari Nama atau NIK Pendaftar..." value="{{ request('q') }}">

                                    {{-- Tombol Cari --}}
                                    <button type="submit" class="btn btn-inner-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            {{-- TOMBOL TAMBAH --}}
                            <a class="btn-add-warga shadow-sm" href="{{ route('pendaftar.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Pendaftar
                            </a>

                            {{-- Tombol Reset --}}
                            @if (request('q') || request('status_seleksi'))
                                <a href="{{ route('pendaftar.index') }}"
                                    class="btn btn-light border d-flex align-items-center shadow-sm"
                                    style="height:48px; border-radius:12px;" title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- STATISTIK --}}
            <div class="row g-4 py-3 justify-content-center">
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px;">
                        <div class="card-body p-4 position-relative">
                            <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 60px; height: 60px; background: rgba(13, 110, 253, 0.1);">
                                    <i class="fas fa-user-friends fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <div class="text-uppercase mb-1 fw-bold" style="font-size: 0.7rem; color: #0d6efd;">
                                        Total Pendaftar</div>
                                    <h2 class="h3 mb-0 fw-bold text-dark">{{ $pendaftar->total() }}</h2>
                                    <small class="text-muted">Orang terdata</small>
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
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <div class="text-uppercase mb-1 fw-bold" style="font-size: 0.7rem; color: #2ecc71;">
                                        Status Filter</div>
                                    <h2 class="h3 mb-0 fw-bold text-dark">
                                        {{ request('status_seleksi') ? ucfirst(request('status_seleksi')) : 'Semua' }}</h2>
                                    <small class="text-muted">Kategori terpilih</small>
                                </div>
                            </div>
                            <div class="bg-decoration" style="background: #2ecc71;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DAFTAR PENDAFTAR (CARD STYLE) --}}
            <div class="row g-4 mt-2">
                @forelse ($pendaftar as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                        <div class="card shadow-sm h-100 border-0 applicant-card">

                            {{-- WRAPPER GAMBAR/FILE --}}
                            <div class="applicant-image-wrapper">
                                {{-- Mengambil file pertama dari relasi 'files' --}}
                                @php
                                    $firstFile = $item->files->first();
                                @endphp

                                @if ($firstFile && Storage::disk('public')->exists($firstFile->path))
                                    @php
                                        $extension = pathinfo($firstFile->path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), [
                                            'jpg',
                                            'jpeg',
                                            'png',
                                            'gif',
                                            'webp',
                                        ]);
                                    @endphp

                                    @if ($isImage)
                                        {{-- Menampilkan Gambar Pertama --}}
                                        <img src="{{ asset('storage/' . $firstFile->path) }}" alt="Lampiran Pendaftar"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{-- Jika file pertama bukan gambar (misal PDF) --}}
                                        <div class="text-center">
                                            <i class="fas fa-file-pdf fa-3x text-danger opacity-50"></i>
                                            <p class="mb-0 text-muted mt-2" style="font-size: 0.75rem;">Dokumen Berkas</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- Placeholder jika benar-benar tidak ada file di relasi --}}
                                    <div class="text-center">
                                        <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                                        <p class="mb-0 text-muted mt-2" style="font-size: 0.75rem;">Tidak ada lampiran</p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0">
                                        {{ $item->warga?->nama ?? 'Nama Tidak Tersedia' }}
                                    </h5>
                                    {{-- Badge Status --}}
                                    @php
                                        $statusColor = [
                                            'verifikasi' => 'bg-warning text-dark',
                                            'diterima' => 'bg-success',
                                            'ditolak' => 'bg-danger',
                                        ];
                                    @endphp
                                    <span
                                        class="badge rounded-pill {{ $item->status_seleksi == 'Diterima' ? 'bg-success' : ($item->status_seleksi == 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        <i
                                            class="fas {{ $item->status_seleksi == 'Diterima' ? 'fa-check-circle' : ($item->status_seleksi == 'Ditolak' ? 'fa-times-circle' : 'fa-clock') }} me-1"></i>
                                        {{ $item->status_seleksi ?? '-' }}
                                    </span>
                                </div>
                                <h6 class="card-subtitle mb-3 text-muted">
                                    <i class="fas fa-id-card me-1"></i> {{ $item->warga->no_ktp ?? 'NIK Tidak Ada' }}
                                </h6>
                                <hr class="opacity-50">

                                <p class="card-text mb-2">
                                    <i class="fas fa-box me-2 text-secondary"></i>
                                    <strong>Program:</strong> {{ $item->program->nama_program }}
                                </p>
                                <p class="card-text mb-2">
                                    <i class="fas fa-clock me-2 text-secondary"></i>
                                    <strong>Tgl Daftar:</strong> {{ $item->tanggal_daftar->format('d M Y') }}
                                </p>
                                {{-- Menampilkan Daftar Nama File/Lampiran --}}
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-paperclip me-1"></i> Lampiran ({{ $item->files->count() }}):
                                    </small>
                                    <div class="file-list-index">
                                        @forelse ($item->files as $file)
                                            @php
                                                $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                $isPdf = strtolower($ext) === 'pdf';
                                            @endphp
                                            <div class="d-flex align-items-center mb-1 bg-light p-1 rounded border">
                                                <i class="fas {{ $isPdf ? 'fa-file-pdf text-danger' : 'fa-image text-info' }} me-2"
                                                    style="font-size: 0.8rem;"></i>
                                                <span class="text-truncate" style="font-size: 0.75rem; max-width: 180px;"
                                                    title="{{ $file->filename }}">
                                                    {{ $file->filename }}
                                                </span>
                                            </div>
                                        @empty
                                            <small class="text-muted italic" style="font-size: 0.7rem;">Tidak ada file
                                                diunggah</small>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="mt-auto pt-3">
                                    <div class="btn-group w-100 gap-2">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('pendaftar.show', $item->pendaftar_id ?? $item->id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0;"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Tombol Edit (Baru) --}}
                                        <a href="{{ route('pendaftar.edit', $item->pendaftar_id ?? $item->id) }}"
                                            class="btn border-0 rounded-3"
                                            style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;"
                                            title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <button type="button" class="btn border-0 rounded-3"
                                            style="background-color: rgba(220, 53, 69, 0.15); color: #dc3545;"
                                            data-bs-toggle="modal" data-bs-target="#deletePendaftar{{ $item->id }}"
                                            title="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
                                    <strong>{{ $item->warga->nama }}</strong>?
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('pendaftar.destroy', $item) }}" method="POST">
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
                            <p class="mb-0 text-muted">Belum ada data pendaftar yang ditemukan.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp">
                    <div class="mt-4">
                        {{ $pendaftar->links() }}
                    </div>
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

        .features.section {
            background: transparent;
        }

        /* 2. Action Bar & Search Group (Efek Glassmorphism) */
        .action-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 15px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .search-combined-group {
            display: flex;
            flex-grow: 1;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
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
            border-right: 1px solid #eee;
            background-color: #f8f9fa;
            font-weight: 500;
        }

        /* 3. Button Search & Add (Warna Pink & Hijau Konsisten) */
        .btn-inner-search {
            background-color: #FF6B81;
            color: white;
            border: none;
            padding: 0 25px;
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

        /* 4. Applicant Cards (Identik dengan Citizen Card) */
        .applicant-card {
            background: #ffffff;
            border: none !important;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .applicant-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        /* Styling Gambar Pendaftar */
        .applicant-image-wrapper {
            width: 100%;
            height: 200px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .applicant-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .applicant-card:hover .applicant-image-wrapper img {
            transform: scale(1.1);
        }

        /* 5. Status Badge Modern */
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            /* Lebih membulat agar modern */
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-pending {
            background-color: #fff3cd !important;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .bg-diterima {
            background-color: #d4edda !important;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .bg-ditolak {
            background-color: #f8d7da !important;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* 6. File List & Scrollbar */
        .file-list-index {
            max-height: 80px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .file-list-index::-webkit-scrollbar {
            width: 4px;
        }

        .file-list-index::-webkit-scrollbar-thumb {
            background: #ffbdc9;
            border-radius: 4px;
        }

        /* 7. Responsive Data */
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
            .search-combined-group .form-control {
                max-width: 100%;
                border-radius: 10px !important;
                border: 1px solid #eee;
            }
        }
    </style>

@endsection
