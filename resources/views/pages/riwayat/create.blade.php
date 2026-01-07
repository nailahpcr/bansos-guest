@extends('layout.guest.app')

@section('title', 'Tambah Riwayat Verifikasi')

@section('content')
<style>
    /* 1. Background Halaman - Disamakan dengan Pendaftar */
    .riwayat-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #ffafbd 0%, #ffc3a0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    /* 2. Card Glassmorphism */
    .custom-card-glass {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        padding: 40px;
        transition: transform 0.3s ease;
    }

    /* Style Label & Ikon - Warna Pink disesuaikan */
    .form-label {
        font-weight: 700;
        color: #4a4a4a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-label i {
        color: #FF6B81;
        background: rgba(255, 107, 129, 0.1);
        padding: 8px;
        border-radius: 10px;
        font-size: 0.9rem;
        width: 35px;
        text-align: center;
    }

    /* Input Styling */
    .form-control, .form-select {
        border: 1px solid rgba(0, 0, 0, 0.08);
        background-color: rgba(255, 255, 255, 0.8);
        height: 52px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #FF6B81;
        box-shadow: 0 0 0 4px rgba(255, 107, 129, 0.1);
    }

    /* Tombol Utama - Gradasi Pink */
    .btn-save-riwayat {
        background: linear-gradient(45deg, #FF6B81, #ee4e66);
        border: none;
        color: white;
        padding: 12px 35px;
        border-radius: 12px; /* Disamakan dengan pendaftar */
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-save-riwayat:hover {
        box-shadow: 0 8px 20px rgba(255, 107, 129, 0.4);
        transform: translateY(-2px);
        color: white;
    }

    .btn-back {
        background-color: #f8f9fa;
        color: #636e72;
        border: 1px solid #dfe4ea;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .section-title h2 { color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .section-title p { color: rgba(255,255,255,0.9); }
    
    .border-dashed-custom {
        border: 2px dashed #FF6B81;
        background: rgba(255, 107, 129, 0.03);
        border-radius: 15px;
    }
</style>

<section id="features" class="features riwayat-section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 107, 129, 0.2); color: #fff;">
                        <i class="fas fa-history me-1"></i> Pencatatan Riwayat Baru
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah Riwayat Verifikasi</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Arsip data hasil verifikasi lapangan ke dalam sistem riwayat.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                <div class="custom-card-glass wow fadeInUp" data-wow-delay=".8s">

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-times-circle me-2"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('riwayat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Pendaftar --}}
                        <div class="mb-4">
                            <label for="pendaftar_id" class="form-label">
                                <i class="fas fa-clipboard-list"></i> Subjek Verifikasi
                            </label>
                            <select name="pendaftar_id" id="pendaftar_id" class="form-select @error('pendaftar_id') is-invalid @enderror">
                                <option value="">-- Pilih Nama Pendaftar / Warga --</option>
                                @foreach ($pendaftar as $item)
                                    <option value="{{ $item->pendaftar_id }}" {{ old('pendaftar_id') == $item->pendaftar_id ? 'selected' : '' }}>
                                        {{ $item->warga->nama ?? 'N/A' }} — Program: {{ $item->program->nama_program ?? 'Program Umum' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendaftar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            {{-- Petugas --}}
                            <div class="col-md-6 mb-4">
                                <label for="petugas" class="form-label">
                                    <i class="fas fa-id-badge"></i> Petugas Pelaksana
                                </label>
                                <input type="text" name="petugas" id="petugas" class="form-control @error('petugas') is-invalid @enderror" 
                                    placeholder="Nama lengkap petugas" value="{{ old('petugas') }}">
                                @error('petugas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-4">
                                <label for="tanggal" class="form-label">
                                    <i class="fas fa-calendar-check"></i> Tanggal Selesai
                                </label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Skor --}}
                        <div class="mb-4">
                            <label for="skor" class="form-label">
                                <i class="fas fa-star"></i> Skor Kelayakan Akhir
                            </label>
                            <input type="number" name="skor" id="skor" class="form-control @error('skor') is-invalid @enderror" 
                                placeholder="Range 0 - 100" value="{{ old('skor') }}" min="0" max="100">
                            @error('skor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Berkas Dokumen --}}
                        <div class="mb-4">
                            <label for="file" class="form-label">
                                <i class="fas fa-file-alt"></i> Lampiran Berkas Riwayat
                            </label>
                            <div class="p-4 border-dashed-custom text-center">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <input type="file" name="files[]" id="file" class="form-control mb-2" multiple>
                                <small class="text-muted d-block mt-2">Format: <strong>JPG, PNG, PDF</strong>. Maksimal 10MB per file.</small>
                            </div>
                            @error('files') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('riwayat.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-save-riwayat shadow">
                                <i class="fas fa-save me-2"></i> Simpan ke Riwayat
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection