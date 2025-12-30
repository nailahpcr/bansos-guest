@extends('layout.guest.app')

@section('title', 'Edit Program Bantuan')

@section('content')
    <style>
        /* Background Konsisten dengan Edit Pendaftar */
        .edit-section {
            padding: 80px 0;
            background: linear-gradient(to bottom, #FFD1DC 0%, #B2E2F2 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        .section-title h2 {
            color: #2d3436;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Glassmorphism Card Style */
        .custom-card-edit {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            border: 1px solid rgba(255, 107, 129, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            color: #4a4a4a;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #FF6B81;
            font-size: 1.1rem;
            width: 25px;
            text-align: center;
        }

        .form-control,
        .form-select {
            border: 1px solid rgba(255, 107, 129, 0.2);
            height: 52px;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        textarea.form-control {
            height: auto !important;
            min-height: 120px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #FF6B81;
            box-shadow: 0 0 0 4px rgba(255, 107, 129, 0.1);
            outline: none;
        }

        .btn-save-changes {
            background-color: #FF6B81;
            border: none;
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-save-changes:hover {
            background-color: #ee4e66;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 129, 0.3);
            color: white;
        }

        .btn-back {
            background-color: #f1f2f6;
            color: #57606f;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
        }

        .upload-container {
            background: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 15px;
            border: 2px dashed rgba(255, 107, 129, 0.3);
        }

        .existing-file-item {
            background: white;
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 10px;
            border: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }

        .existing-file-item:hover {
            transform: scale(1.01);
        }
    </style>

    <section class="features edit-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <div class="section-title">
                        <span class="badge rounded-pill px-3 py-2 mb-3"
                            style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                            <i class="fas fa-edit me-1"></i> Panel Administrasi
                        </span>
                        <h2 class="wow fadeInUp">Edit Program :{{ $program->nama_program }}</h2>
                        <p class="wow fadeInUp">Sesuaikan informasi program bantuan</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="custom-card-edit">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 mb-4"
                                role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('kelola-program.update', $program->program_id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="kode" class="form-label"><i class="fas fa-barcode"></i> Kode
                                        Program</label>
                                    <input type="text" name="kode" id="kode" class="form-control"
                                        value="{{ old('kode', $program->kode) }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="nama_program" class="form-label"><i class="fas fa-hand-holding-heart"></i>
                                        Nama Program</label>
                                    <input type="text" name="nama_program" id="nama_program" class="form-control"
                                        value="{{ old('nama_program', $program->nama_program) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="tahun" class="form-label"><i class="fas fa-calendar-alt"></i> Tahun
                                        Anggaran</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        value="{{ old('tahun', $program->tahun) }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="anggaran" class="form-label"><i class="fas fa-wallet"></i> Anggaran
                                        (Rp)</label>
                                    <input type="number" name="anggaran" id="anggaran" class="form-control"
                                        value="{{ old('anggaran', $program->anggaran) }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label"><i class="fas fa-align-left"></i> Deskripsi
                                    Program</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            </div>

                            {{-- BAGIAN LAMPIRAN DOKUMEN --}}
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-file-image"></i> Lampiran Dokumen</label>
                                <div class="upload-container">

                                    {{-- Tampilkan File yang Sudah Ada --}}
                                    @if (!empty($program->file))
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-2 fw-bold">Berkas Saat Ini:</small>
                                            <div class="existing-file-item shadow-sm">
                                                <div class="d-flex align-items-center overflow-hidden">
                                                    <i class="fas fa-file-image text-danger me-3 fs-4"></i>
                                                    <span
                                                        class="text-dark fw-600 text-truncate">{{ basename($program->file) }}</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ asset('storage/' . $program->file) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- Tombol Hapus File --}}
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="if(confirm('Hapus lampiran?')) { document.getElementById('delete-file-form').submit(); }">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <small class="text-muted d-block mb-2 italic">Unggah berkas baru (opsional):</small>
                                        <input type="file" name="file"
                                            class="form-control @error('file') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx,.jpg,.png">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <a href="{{ route('kelola-program.index') }}" class="btn btn-back">
                                    <i class="fas fa-arrow-left me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-save-changes shadow">
                                    <i class="fas fa-sync-alt me-2"></i> Update Program
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Form Hapus File Program (Terpisah) --}}
    @if (!empty($program->file))
        <form id="delete-program-file" action="{{ route('kelola-program.destroy', $program->program_id) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif

@endsection
