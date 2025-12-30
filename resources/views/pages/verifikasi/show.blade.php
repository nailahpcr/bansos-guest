@extends('layout.guest.app')

@section('title', 'Detail Verifikasi: ' . ($verifikasi->pendaftar->warga->nama ?? 'Data'))

@section('content')
    <style>
        /* Background Section & Animation */
        #detail-verifikasi {
            background: linear-gradient(to bottom, #FFD1DC 0%, #B2E2F2 100%);
            min-height: 100vh;
            background-attachment: fixed;
            padding: 50px 0;
        }

        /* Header Styling */
        .section-title h3 {
            color: #ff5876;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-title h2 {
            color: #2d3436;
            font-weight: 800;
        }

        /* Card Styling */
        .card {
            border-radius: 20px !important;
            transition: all 0.3s ease;
            border: none;
        }

        /* Info Utama */
        .text-primary-custom { color: #4834d4 !important; }
        .text-success-custom { color: #20bf6b !important; }

        .border-end-dashed {
            border-right: 2px dashed #dfe6e9 !important;
        }

        /* Badge Status Styling */
        .badge-soft {
            padding: 8px 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 50px;
        }

        /* File List Styling */
        .list-group-item {
            background-color: #ffffff;
            margin-bottom: 8px;
            border-radius: 12px !important;
            border: 1px solid #eee !important;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .list-group-item.active {
            background: linear-gradient(45deg, #4834d4, #686de0) !important;
            border-color: transparent !important;
            box-shadow: 0 4px 15px rgba(72, 52, 212, 0.3);
            color: white !important;
        }

        .list-group-item.active .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
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
            min-height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Buttons Styling */
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
        }

        @media (max-width: 768px) {
            .border-end-dashed {
                border-right: none !important;
                border-bottom: 2px dashed #dfe6e9 !important;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
    </style>

    <section id="detail-verifikasi">
        <div class="container">
            {{-- HEADER --}}
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Detail Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Verifikasi Lapangan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Hasil peninjauan lapangan untuk program bantuan sosial.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card shadow-sm overflow-hidden wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-0">
                            
                            {{-- ATAS: Informasi Utama --}}
                            <div class="p-4 bg-white border-bottom">
                                <div class="row">
                                    {{-- Info Penerima --}}
                                    <div class="col-md-6 border-end-dashed">
                                        <h5 class="text-primary-custom fw-bold mb-3">
                                            <i class="fas fa-user-check me-2"></i>Informasi Penerima
                                        </h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="35%" class="text-muted">Nama Warga</td>
                                                <td>: <strong>{{ $verifikasi->pendaftar->warga->nama ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">NIK</td>
                                                <td>: {{ $verifikasi->pendaftar->warga->no_ktp ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Program</td>
                                                <td>: <span class="text-primary-custom fw-bold">{{ $verifikasi->pendaftar->program->nama_program ?? '-' }}</span></td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{-- Info Hasil Petugas --}}
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="text-success-custom fw-bold mb-3">
                                            <i class="fas fa-clipboard-list me-2"></i>Hasil Petugas
                                        </h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="35%" class="text-muted">Petugas</td>
                                                <td>: {{ $verifikasi->petugas }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tgl Verifikasi</td>
                                                <td>: {{ \Carbon\Carbon::parse($verifikasi->tanggal)->translatedFormat('d F Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Skor Kelayakan</td>
                                                <td>: <span class="badge bg-success rounded-pill px-3">{{ $verifikasi->skor }} Poin</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="mt-4 p-3 bg-light rounded-4 border-start border-4 border-primary">
                                    <small class="fw-bold text-muted d-block mb-1 text-uppercase" style="font-size: 0.7rem;">Catatan Lapangan:</small>
                                    <p class="mb-0 fst-italic">"{{ $verifikasi->catatan ?? 'Tidak ada catatan tambahan.' }}"</p>
                                </div>
                            </div>

                            {{-- BAWAH: Lampiran Bukti --}}
                            <div class="p-4 bg-light">
                                <h5 class="fw-bold mb-4"><i class="fas fa-camera-retro me-2 text-primary-custom"></i>Dokumentasi Lampiran</h5>

                                @if ($verifikasi->file && is_array($verifikasi->file) && count($verifikasi->file) > 0)
                                    <div class="row">
                                        {{-- Sidebar List File --}}
                                        <div class="col-md-4">
                                            <div class="list-group shadow-sm mb-3">
                                                @foreach ($verifikasi->file as $index => $img)
                                                    @php
                                                        $ext = pathinfo($img, PATHINFO_EXTENSION);
                                                        $filename = basename($img);
                                                    @endphp
                                                    <button type="button" 
                                                        class="list-group-item list-group-item-action d-flex align-items-center py-3 file-item {{ $index === 0 ? 'active' : '' }}"
                                                        onclick="previewFile('{{ asset('storage/' . $img) }}', '{{ $ext }}', this)">
                                                        <i class="fas fa-image fa-lg me-3 text-info"></i>
                                                        <div class="text-truncate">
                                                            <small class="d-block fw-bold text-truncate">{{ $filename }}</small>
                                                            <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Bukti Ke-{{ $index + 1 }}</small>
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>
                                            <div class="mt-3">
                                                <a href="{{ route('verifikasi.edit', $verifikasi->verifikasi_id) }}" class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm">
                                                    <i class="fas fa-edit me-1"></i> Edit Dokumentasi
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Viewer Area --}}
                                        <div class="col-md-8">
                                            <div class="card border-0 shadow-sm overflow-hidden h-100">
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                                                    <span class="small fw-bold text-muted text-uppercase"><i class="fas fa-search me-1"></i> Preview Dokumentasi</span>
                                                    <a id="downloadBtn" href="{{ asset('storage/' . $verifikasi->file[0]) }}" download class="btn btn-sm btn-primary rounded-pill px-3">
                                                        <i class="fas fa-download me-1"></i> Simpan
                                                    </a>
                                                </div>
                                                <div class="card-body p-0" id="viewer-container">
                                                    <img src="{{ asset('storage/' . $verifikasi->file[0]) }}" class="img-fluid" id="main-viewer" style="max-height: 500px; object-fit: contain;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-white border text-center py-5 rounded-4 shadow-sm">
                                        <i class="fas fa-image-slash fa-3x mb-3 text-muted d-block"></i>
                                        <h6 class="text-muted">Belum ada foto dokumentasi yang diunggah.</h6>
                                    </div>
                                @endif
                            </div>

                            {{-- FOOTER --}}
                            <div class="card-footer bg-white p-4 border-top-0 d-flex justify-content-center">
                                <a href="{{ route('verifikasi.index') }}" class="btn btn-secondary px-5 rounded-pill fw-bold shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function previewFile(url, ext, element) {
            const container = document.getElementById('viewer-container');
            const downloadBtn = document.getElementById('downloadBtn');

            // Toggle Class Active
            document.querySelectorAll('.file-item').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');

            // Update Download Link
            downloadBtn.setAttribute('href', url);

            // Viewer Logic
            const extension = ext.toLowerCase();
            const imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (imageExtensions.includes(extension)) {
                container.innerHTML = `<img src="${url}" class="img-fluid animate__animated animate__fadeIn" style="max-height: 500px; object-fit: contain;">`;
            } else if (extension === 'pdf') {
                container.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="500px">`;
            } else {
                container.innerHTML = `
                    <div class="text-white text-center p-5">
                        <i class="fas fa-file-alt fa-5x mb-3"></i>
                        <h5>Format .${extension.toUpperCase()}</h5>
                        <p>Pratinjau tidak tersedia.</p>
                    </div>`;
            }
        }
    </script>
@endsection