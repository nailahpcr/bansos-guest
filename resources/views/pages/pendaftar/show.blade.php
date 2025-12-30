@extends('layout.guest.app')

@section('title', 'Detail Pendaftar')

@section('content')
    <style>
        /* Background Section & Animation */
        #features {
            background: linear-gradient(to bottom, #FFD1DC 0%, #B2E2F2 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Header Styling */
        .section-title h3 {
            color: #ff5876;
            /* Warna Pink khas Create */
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-title h2 {
            color: #2d3436;
            font-weight: 800;
        }

        /* Header Styling */
        .section-title h3 {
            color: #ff5876;
            /* Warna Pink khas Create */
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-title h2 {
            color: #2d3436;
            font-weight: 800;
        }

        /* Card Styling */
        .citizen-card,
        .card {
            border-radius: 20px !important;
            transition: all 0.3s ease;
        }

        /* Info Utama (Warna Biru & Hijau Soft) */
        .text-primary {
            color: #4834d4 !important;
        }

        .text-success {
            color: #20bf6b !important;
        }

        .border-end {
            border-right: 2px dashed #dfe6e9 !important;
        }

        /* Badge Status Styling */
        .badge {
            padding: 8px 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* File List Styling */
        .list-group-item {
            background-color: #ffffff;
            margin-bottom: 8px;
            border-radius: 12px !important;
            border: 1px solid #eee !important;
            transition: all 0.2s ease;
        }

        .list-group-item.active {
            background: linear-gradient(45deg, #4834d4, #686de0) !important;
            border-color: transparent !important;
            box-shadow: 0 4px 15px rgba(72, 52, 212, 0.3);
        }

        .list-group-item:hover:not(.active) {
            transform: translateX(5px);
            background-color: #f1f2f6;
        }

        /* Viewer Area */
        #viewer-container {
            background: #2d3436 !important;
            border-radius: 0 0 15px 15px;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: #ffffff !important;
            border-bottom: 2px solid #f1f2f6 !important;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, #4834d4, #686de0);
            border: none;
            box-shadow: 0 4px 10px rgba(72, 52, 212, 0.2);
        }

        .btn-warning {
            background: linear-gradient(45deg, #f0932b, #ffbe76);
            border: none;
            color: white !important;
        }

        .btn-secondary {
            background: #95afc0;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustment */
        @media (max-width: 768px) {
            .border-end {
                border-right: none !important;
                border-bottom: 2px dashed #dfe6e9 !important;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
    </style>

    <section id="features" class="features section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            {{-- HEADER --}}
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Detail Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Informasi Pendaftaran</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Detail lengkap pendaftaran warga di program bantuan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-0">
                            {{-- ATAS: Info Utama --}}
                            <div class="p-4 border-bottom bg-white">
                                <div class="row align-items-center">
                                    <div class="col-md-6 border-end">
                                        <h5 class="text-primary fw-bold mb-3"><i
                                                class="fas fa-user-circle me-2"></i>Informasi Warga</h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="30%" class="text-muted">Nama</td>
                                                <td>: <strong>{{ $pendaftar->warga->nama ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">NIK</td>
                                                <td>: {{ $pendaftar->warga->no_ktp ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">No. Hp</td>
                                                <td>: {{ $pendaftar->warga->telp ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="text-success fw-bold mb-3"><i class="fas fa-box-open me-2"></i>Informasi
                                            Program</h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="30%" class="text-muted">Program</td>
                                                <td>: <span
                                                        class="text-success fw-bold">{{ $pendaftar->program->nama_program ?? '-' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tahun</td>
                                                <td>: {{ $pendaftar->program->tahun ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Status</td>
                                                <td>:
                                                    <span
                                                        class="badge rounded-pill {{ $pendaftar->status_seleksi == 'Diterima' ? 'bg-success' : ($pendaftar->status_seleksi == 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                        {{ $pendaftar->status_seleksi ?? '-' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- BAWAH: Manajemen Berkas --}}
                            <div class="p-4 bg-light">
                                <h5 class="fw-bold mb-4"><i class="fas fa-folder-open me-2 text-primary"></i>Berkas Lampiran
                                </h5>

                                @if ($pendaftar->files && $pendaftar->files->count() > 0)
                                    <div class="row">
                                        {{-- List File --}}
                                        <div class="col-md-4">
                                            <div class="list-group shadow-sm rounded-3 overflow-hidden">
                                                @foreach ($pendaftar->files as $file)
                                                    @php
                                                        $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png','pdf']);
                                                    @endphp
                                                    <button type="button"
                                                        class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 file-item {{ $loop->first ? 'active' : '' }}"
                                                        onclick="previewFile('{{ asset('storage/' . $file->path) }}', '{{ $ext }}', this)">
                                                        <i
                                                            class="fas {{ $isImage ? 'fa-image text-info' : 'fa-file-pdf text-danger' }} fa-lg me-3"></i>
                                                        <div class="text-truncate">
                                                            <small
                                                                class="d-block fw-bold text-truncate">{{ $file->filename }}</small>
                                                            <small class="text-muted text-uppercase"
                                                                style="font-size: 0.7rem;">{{ $ext }} File</small>
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>
                                            <div class="mt-3">
                                                <a href="{{ route('pendaftar.edit', $pendaftar->pendaftar_id) }}"
                                                    class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm">
                                                    <i class="fas fa-edit me-1"></i> Perbarui Berkas
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Viewer Area --}}
                                        <div class="col-md-8 mt-3 mt-md-0">
                                            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100"
                                                style="min-height: 500px;">
                                                <div
                                                    class="card-header bg-white d-flex justify-content-between align-items-center">
                                                    <span class="small fw-bold text-uppercase text-muted"><i
                                                            class="fas fa-search me-1"></i> Preview Berkas</span>
                                                    <a id="downloadBtn"
                                                        href="{{ asset('storage/' . $pendaftar->files[0]->path) }}"
                                                        download class="btn btn-sm btn-primary rounded-pill px-3">
                                                        <i class="fas fa-download me-1"></i> Download
                                                    </a>
                                                </div>
                                                <div class="card-body p-0 bg-secondary d-flex align-items-center justify-content-center"
                                                    id="viewer-container">
                                                    {{-- Default Preview (First File) --}}
                                                    @php
                                                        $firstFile = $pendaftar->files[0];
                                                        $firstExt = pathinfo($firstFile->path, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if (in_array($firstExt, ['jpg', 'jpeg', 'png', 'pdf']))
                                                        <img src="{{ asset('storage/' . $firstFile->path) }}"
                                                            class="img-fluid" id="main-viewer">
                                                    @elseif($firstExt == 'pdf')
                                                        <embed src="{{ asset('storage/' . $firstFile->path) }}"
                                                            type="application/pdf" width="100%" height="500px"
                                                            id="main-viewer">
                                                    @else
                                                        <div class="text-white text-center p-4">
                                                            <i class="fas fa-file-invoice fa-4x mb-3"></i>
                                                            <p>File ini tidak mendukung pratinjau langsung.<br>Silakan unduh
                                                                untuk melihat isi.</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
                                        <i class="fas fa-file-circle-exclamation fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Tidak ada berkas yang diunggah untuk pendaftar ini.</h6>
                                    </div>
                                @endif
                            </div>

                            {{-- FOOTER --}}
                            <div class="card-footer bg-white p-4 border-top-0 d-flex justify-content-center gap-2">
                                <a class="btn btn-secondary px-5 rounded-pill fw-bold"
                                    href="{{ route('pendaftar.index') }}">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Script untuk Preview Interaktif --}}
    <script>
        function previewFile(url, ext, element) {
            const container = document.getElementById('viewer-container');
            const downloadBtn = document.getElementById('downloadBtn');

            // Ubah tombol aktif
            document.querySelectorAll('.file-item').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');

            // Update Link Download
            downloadBtn.setAttribute('href', url);

            // Logika Viewer
            if (['jpg', 'jpeg', 'png', 'webp'].includes(ext.toLowerCase())) {
                container.innerHTML = `<img src="${url}" class="img-fluid zoom-img" style="max-height: 80vh;">`;
            } else if (ext.toLowerCase() === 'pdf') {
                container.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="600px">`;
            } else {
                container.innerHTML = `
                    <div class="text-white text-center p-5">
                        <i class="fas fa-file-alt fa-5x mb-3"></i>
                        <h5>Tipe berkas .${ext.toUpperCase()}</h5>
                        <p>Format ini memerlukan aplikasi eksternal. Silakan klik download.</p>
                    </div>`;
            }
        }
    </script>


@endsection
