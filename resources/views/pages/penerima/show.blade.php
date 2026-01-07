@extends('layout.guest.app')

@section('title', 'Detail Penerima Bantuan')

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

        /* Status Box Custom */
        .status-verified {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid #e1e8ed;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, #4834d4, #686de0);
            border: none;
            box-shadow: 0 4px 10px rgba(72, 52, 212, 0.2);
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
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Informasi Penerima</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Data resmi warga yang telah ditetapkan sebagai penerima bantuan.</p>
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
                                        <h5 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-id-card me-2"></i>Informasi Identitas
                                        </h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="35%" class="text-muted">Nama Lengkap</td>
                                                <td>: <strong>{{ $penerima->warga->nama ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">NIK</td>
                                                <td>: {{ $penerima->warga->no_ktp ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">No. Telepon</td>
                                                <td>: {{ $penerima->warga->telp ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="text-success fw-bold mb-3">
                                            <i class="fas fa-ribbon me-2"></i>Program Diikuti
                                        </h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="35%" class="text-muted">Nama Program</td>
                                                <td>: <span class="text-success fw-bold">{{ $penerima->program->nama_program ?? '-' }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tahun Anggaran</td>
                                                <td>: {{ $penerima->program->tahun ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Jenis Bantuan</td>
                                                <td>: {{ $penerima->program->jenis_bantuan ?? 'Sosial' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- BAWAH: Status Verifikasi --}}
                            <div class="p-4 bg-light">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-clipboard-check me-2 text-primary"></i>Status Keanggotaan
                                </h5>

                                <div class="status-verified shadow-sm">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                                <i class="fas fa-check-double fa-2x text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-1 fw-bold text-dark">Penerima Manfaat Aktif</h6>
                                            <p class="mb-0 small text-muted">
                                                Warga ini terdaftar secara resmi sebagai penerima manfaat program {{ $penerima->program->nama_program }}. 
                                                Data divalidasi pada {{ $penerima->created_at->translatedFormat('d F Y') }}.
                                            </p>
                                        </div>
                                        <div class="col-md-auto mt-3 mt-md-0">
                                            <span class="badge bg-success rounded-pill px-4 py-2">Terverifikasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER: Action Buttons --}}
                            <div class="card-footer bg-white p-4 border-top-0 d-flex justify-content-center gap-3">
                                <a class="btn btn-secondary px-5 rounded-pill fw-bold" href="{{ route('penerima.index') }}">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                                <form action="{{ route('penerima.destroy', $penerima->penerima_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penerima ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger px-4 rounded-pill fw-bold">
                                        <i class="fas fa-trash-alt me-2"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection