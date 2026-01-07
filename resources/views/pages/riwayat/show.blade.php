@extends('layout.guest.app')

@section('title', 'Detail Riwayat Penyaluran')

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

        /* Viewer Area */
        #viewer-container {
            background: #2d3436 !important;
            border-radius: 15px;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, #4834d4, #686de0);
            border: none;
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
            .border-end {
                border-right: none !important;
                border-bottom: 2px dashed #dfe6e9 !important;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
    </style>

    <section id="features" class="features section py-5">
        <div class="container">
            {{-- HEADER --}}
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Detail Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Informasi Penyaluran</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Detail bukti penyerahan bantuan kepada penerima.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-0">
                            
                            {{-- BAGIAN ATAS: Info Utama --}}
                            <div class="p-4 border-bottom bg-white">
                                <div class="row align-items-center">
                                    <div class="col-md-6 border-end">
                                        <h5 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-user-check me-2"></i>Data Penerima
                                        </h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="35%" class="text-muted">Nama</td>
                                                <td>: <strong>{{ $riwayat->penerima->warga->nama ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">NIK</td>
                                                <td>: {{ $riwayat->penerima->warga->no_ktp ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">No. Hp</td>
                                                <td>: {{ $riwayat->penerima->warga->telp ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="text-success fw-bold mb-3">
                                            <i class="fas fa-hand-holding-heart me-2"></i>Info Bantuan
                                        </h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="35%" class="text-muted">Program</td>
                                                <td>: <span class="text-success fw-bold">{{ $riwayat->program->nama_program ?? '-' }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tahap</td>
                                                <td>: {{ $riwayat->tahap_ke }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Nilai Diterima</td>
                                                <td>: <strong class="text-dark">Rp {{ number_format($riwayat->nilai, 0, ',', '.') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tanggal</td>
                                                <td>: {{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d F Y') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- BAGIAN BAWAH: Dokumentasi Bukti --}}
                            <div class="p-4 bg-light">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-camera me-2 text-primary"></i>Bukti Dokumentasi Penyaluran
                                </h5>

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                                <span class="small fw-bold text-uppercase text-muted">
                                                    <i class="fas fa-image me-1"></i> Preview Foto
                                                </span>
                                                @if($riwayat->file)
                                                <a href="{{ asset('storage/' . $riwayat->file) }}" download class="btn btn-sm btn-primary rounded-pill px-3">
                                                    <i class="fas fa-download me-1"></i> Download Bukti
                                                </a>
                                                @endif
                                            </div>
                                            <div class="card-body p-0" id="viewer-container">
                                                @if($riwayat->file)
                                                    @php
                                                        $ext = pathinfo($riwayat->file, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                        <img src="{{ asset('storage/' . $riwayat->file) }}" class="img-fluid" alt="Bukti Penyaluran" style="max-height: 500px">
                                                    @elseif(strtolower($ext) == 'pdf')
                                                        <embed src="{{ asset('storage/' . $riwayat->file) }}" type="application/pdf" width="100%" height="500px">
                                                    @else
                                                        <div class="text-white text-center p-5">
                                                            <i class="fas fa-file-alt fa-4x mb-3"></i>
                                                            <p>Format file tidak didukung untuk pratinjau.<br>Silakan unduh file.</p>
                                                        </div>
                                                    @endif
                                                @else
                                                   <div class="row g-3">
    @forelse ($riwayat->files as $file)
        <div class="col-md-4 col-sm-6">
            <div class="card h-100 border-light shadow-sm">
                @php
                    $extension = pathinfo($file->path, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                @endphp

                @if ($isImage)
                    <img src="{{ asset('storage/' . $file->path) }}" class="card-img-top img-thumbnail" 
                         style="height: 200px; object-fit: cover;" alt="Bukti">
                @else
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
                        <span class="text-muted small">{{ $file->filename }}</span>
                    </div>
                @endif
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-external-link-alt"></i> Lihat Full
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-camera-retro fa-3x text-muted mb-3"></i>
            <p class="text-muted">Tidak ada foto bukti yang diunggah.</p>
        </div>
    @endforelse
</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER --}}
                            <div class="card-footer bg-white p-4 border-top-0 d-flex justify-content-center gap-2">
                                <a class="btn btn-secondary px-5 rounded-pill fw-bold" href="{{ route('riwayat.index') }}">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                                <a class="btn btn-primary px-5 rounded-pill fw-bold" href="{{ route('riwayat.edit', $riwayat->penyaluran_id) }}">
                                    <i class="fas fa-edit me-2"></i> Edit Data
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection