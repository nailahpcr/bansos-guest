@extends('layout.guest.app')

@section('title', 'Detail Pendaftar')

@section('content')
    <section id="features" class="features section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            {{-- HEADER --}}
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Detail Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Informasi Pendaftaran</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Detail lengkap pendaftaran warga di program bantuan.</p>
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
                                        <h5 class="text-primary fw-bold mb-3"><i class="fas fa-user-circle me-2"></i>Informasi Warga</h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr><td width="30%" class="text-muted">Nama</td><td>: <strong>{{ $pendaftar->warga->nama ?? '-' }}</strong></td></tr>
                                            <tr><td class="text-muted">NIK</td><td>: {{ $pendaftar->warga->no_ktp ?? '-' }}</td></tr>
                                            <tr><td class="text-muted">No. Hp</td><td>: {{ $pendaftar->warga->no_hp ?? '-' }}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="text-success fw-bold mb-3"><i class="fas fa-box-open me-2"></i>Informasi Program</h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr><td width="30%" class="text-muted">Program</td><td>: <span class="text-success fw-bold">{{ $pendaftar->program->nama_program ?? '-' }}</span></td></tr>
                                            <tr><td class="text-muted">Tahun</td><td>: {{ $pendaftar->program->tahun ?? '-' }}</td></tr>
                                            <tr><td class="text-muted">Status</td><td>: 
                                                <span class="badge rounded-pill {{ $pendaftar->status_seleksi == 'Diterima' ? 'bg-success' : ($pendaftar->status_seleksi == 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                    {{ $pendaftar->status_seleksi ?? '-' }}
                                                </span>
                                            </td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- BAWAH: Manajemen Berkas --}}
                            <div class="p-4 bg-light">
                                <h5 class="fw-bold mb-4"><i class="fas fa-folder-open me-2 text-primary"></i>Berkas Lampiran</h5>
                                
                                @if ($pendaftar->files && $pendaftar->files->count() > 0)
                                    <div class="row">
                                        {{-- List File --}}
                                        <div class="col-md-4">
                                            <div class="list-group shadow-sm rounded-3 overflow-hidden">
                                                @foreach ($pendaftar->files as $file)
                                                    @php
                                                        $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                                                    @endphp
                                                    <button type="button" 
                                                        class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 file-item {{ $loop->first ? 'active' : '' }}"
                                                        onclick="previewFile('{{ asset('storage/' . $file->path) }}', '{{ $ext }}', this)">
                                                        <i class="fas {{ $isImage ? 'fa-image text-info' : 'fa-file-pdf text-danger' }} fa-lg me-3"></i>
                                                        <div class="text-truncate">
                                                            <small class="d-block fw-bold text-truncate">{{ $file->filename }}</small>
                                                            <small class="text-muted text-uppercase" style="font-size: 0.7rem;">{{ $ext }} File</small>
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>
                                            <div class="mt-3">
                                                <a href="{{ route('pendaftar.edit', $pendaftar->pendaftar_id) }}" class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm">
                                                    <i class="fas fa-edit me-1"></i> Perbarui Berkas
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Viewer Area --}}
                                        <div class="col-md-8 mt-3 mt-md-0">
                                            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100" style="min-height: 500px;">
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                                    <span class="small fw-bold text-uppercase text-muted"><i class="fas fa-search me-1"></i> Preview Berkas</span>
                                                    <a id="downloadBtn" href="{{ asset('storage/' . $pendaftar->files[0]->path) }}" download class="btn btn-sm btn-primary rounded-pill px-3">
                                                        <i class="fas fa-download me-1"></i> Download
                                                    </a>
                                                </div>
                                                <div class="card-body p-0 bg-secondary d-flex align-items-center justify-content-center" id="viewer-container">
                                                    {{-- Default Preview (First File) --}}
                                                    @php 
                                                        $firstFile = $pendaftar->files[0];
                                                        $firstExt = pathinfo($firstFile->path, PATHINFO_EXTENSION);
                                                    @endphp
                                                    
                                                    @if(in_array($firstExt, ['jpg', 'jpeg', 'png', 'webp']))
                                                        <img src="{{ asset('storage/' . $firstFile->path) }}" class="img-fluid" id="main-viewer">
                                                    @elseif($firstExt == 'pdf')
                                                        <embed src="{{ asset('storage/' . $firstFile->path) }}" type="application/pdf" width="100%" height="500px" id="main-viewer">
                                                    @else
                                                        <div class="text-white text-center p-4">
                                                            <i class="fas fa-file-invoice fa-4x mb-3"></i>
                                                            <p>File ini tidak mendukung pratinjau langsung.<br>Silakan unduh untuk melihat isi.</p>
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
                                <a class="btn btn-secondary px-5 rounded-pill fw-bold" href="{{ route('pendaftar.index') }}">
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

    <style>
        .file-item.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
        .file-item.active i, .file-item.active small {
            color: white !important;
        }
        .file-item {
            transition: all 0.2s;
            cursor: pointer;
        }
        .object-fit-cover { object-fit: cover; }
        #viewer-container {
            min-height: 600px;
            background: #525659;
        }
        .zoom-img {
            transition: transform .2s;
        }
        .zoom-img:hover {
            transform: scale(1.05);
        }
    </style>
@endsection