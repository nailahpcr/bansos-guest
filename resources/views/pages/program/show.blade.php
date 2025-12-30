@extends('layout.guest.app')

@section('title', 'Detail Program: ' . $program->nama_program)

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

        /* Info Utama */
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
            border-radius: 0 0 15px 15px;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2);
            min-height: 400px;
        }

        /* Buttons Custom */
        .btn-primary {
            background: linear-gradient(45deg, #4834d4, #686de0);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(45deg, #f0932b, #ffbe76);
            border: none;
            color: white !important;
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
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Detail Program</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{ $program->nama_program }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Informasi lengkap mengenai program bantuan sosial.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    {{-- Alert Flash Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 shadow-sm"
                            role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-0">

                            {{-- ATAS: Info Utama --}}
                            <div class="p-4 border-bottom bg-white">
                                <div class="row">
                                    <div class="col-md-7 border-end">
                                        <h5 class="text-primary fw-bold mb-3"><i
                                                class="fas fa-info-circle me-2"></i>Informasi Umum</h5>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="30%" class="text-muted">Kode Program</td>
                                                <td>: <span
                                                        class="badge bg-light text-dark border">{{ $program->kode }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tahun</td>
                                                <td>: {{ $program->tahun }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Anggaran</td>
                                                <td>: <strong class="text-success">Rp
                                                        {{ number_format($program->anggaran, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-5 ps-md-4 mt-3 mt-md-0">
                                        <h5 class="text-secondary fw-bold mb-3"><i
                                                class="fas fa-align-left me-2"></i>Deskripsi</h5>
                                        <p class="small text-muted" style="text-align: justify;">
                                            {{ $program->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- BAWAH: Manajemen Berkas --}}
                            <div class="p-4 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold m-0"><i class="fas fa-paperclip me-2 text-primary"></i>Dokumen
                                        Lampiran</h5>
                                    @if (request()->routeIs('kelola-program.show'))
                                        <div class="btn-group">
                                            <a href="{{ route('kelola-program.edit', $program) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-3 me-2">
                                                <i class="fas fa-edit"></i> Edit Program
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    {{-- Kolom Kiri: Action Berkas --}}
                                    <div class="col-md-4">
                                        @if ($program->file)
                                            <div class="list-group shadow-sm rounded-3 overflow-hidden mb-3">
                                                @php
                                                    $ext = pathinfo($program->file, PATHINFO_EXTENSION);
                                                    $isImage = in_array(strtolower($ext), [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'webp',
                                                    ]);
                                                    $filePath = asset('storage/' . $program->file);
                                                @endphp
                                                <div class="list-group-item active border-0 d-flex align-items-center py-3">
                                                    <i
                                                        class="fas {{ $isImage ? 'fa-image' : 'fa-file-pdf' }} fa-lg me-3"></i>
                                                    <div class="text-truncate">
                                                        <small class="d-block fw-bold text-truncate">Dokumen
                                                            Lampiran</small>
                                                        <small class="text-uppercase"
                                                            style="font-size: 0.7rem;">{{ $ext }} File</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-grid gap-2">
                                                <a href="{{ $filePath }}" download
                                                    class="btn btn-primary rounded-pill fw-bold">
                                                    <i class="fas fa-download me-1"></i> Unduh File
                                                </a>

                                                @if (request()->routeIs('kelola-program.show'))
                                                    <form action="{{ route('kelola-program.update', $program) }}"
                                                        method="POST" onsubmit="return confirm('Hapus file ini?')">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="nama_program"
                                                            value="{{ $program->nama_program }}">
                                                        <input type="hidden" name="kode" value="{{ $program->kode }}">
                                                        <input type="hidden" name="tahun" value="{{ $program->tahun }}">
                                                        <input type="hidden" name="anggaran"
                                                            value="{{ $program->anggaran }}">
                                                        <input type="hidden" name="hapus_file" value="1">
                                                        <button type="submit"
                                                            class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                                                            <i class="fas fa-trash me-1"></i> Hapus File
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-4 border rounded-4 bg-white shadow-sm mb-3">
                                                <i class="fas fa-file-upload fa-3x text-muted mb-2"></i>
                                                <p class="text-muted small">Belum ada file</p>
                                                @if (request()->routeIs('kelola-program.show'))
                                                    <button class="btn btn-sm btn-success rounded-pill"
                                                        data-bs-toggle="modal" data-bs-target="#uploadModal">
                                                        <i class="fas fa-plus me-1"></i> Unggah Sekarang
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Kolom Kanan: Viewer --}}
                                    <div class="col-md-8 mt-3 mt-md-0">
                                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                                            <div
                                                class="card-header bg-white d-flex justify-content-between align-items-center">
                                                <span class="small fw-bold text-uppercase text-muted"><i
                                                        class="fas fa-search me-1"></i> Preview</span>
                                            </div>
                                            <div class="card-body p-0 d-flex align-items-center justify-content-center"
                                                id="viewer-container">
                                                @if ($program->file)
                                                    @if ($isImage)
                                                        <img src="{{ $filePath }}" class="img-fluid"
                                                            style="max-height: 500px;">
                                                    @elseif($ext == 'pdf')
                                                        <embed src="{{ $filePath }}" type="application/pdf"
                                                            width="100%" height="500px">
                                                    @else
                                                        <div class="text-white text-center p-4">
                                                            <i class="fas fa-file-invoice fa-4x mb-3"></i>
                                                            <p>Preview tidak tersedia.<br>Silakan unduh file.</p>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="text-white text-center p-4">
                                                        <i class="fas fa-eye-slash fa-4x mb-3 text-secondary"></i>
                                                        <p class="text-secondary">Tidak ada dokumen untuk ditampilkan</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER --}}
                            <div class="card-footer bg-white p-4 border-top-0 d-flex justify-content-center">
                                <a class="btn btn-secondary px-5 rounded-pill fw-bold"
                                    href="{{ Route::currentRouteName() == 'kelola-program.show' ? route('kelola-program.index') : route('home') }}">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Upload (Tetap Dipertahankan) --}}
    @if (request()->routeIs('kelola-program.show'))
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">Unggah Lampiran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('kelola-program.update', $program) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="nama_program" value="{{ $program->nama_program }}">
                            <input type="hidden" name="kode" value="{{ $program->kode }}">
                            <input type="hidden" name="tahun" value="{{ $program->tahun }}">
                            <input type="hidden" name="anggaran" value="{{ $program->anggaran }}">

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Pilih File (Gambar/PDF)</label>
                                <input type="file" name="file" class="form-control rounded-3" required>
                                <div class="form-text">Maksimal ukuran file 10MB</div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Berkas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
