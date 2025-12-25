@extends('layout.guest.app')

@section('title', 'Tambah Program Bantuan')

@section('content')
    <style>
        /* 1. Background Halaman dengan Gradasi Pink Lembut */
        .register-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffafbd 0%, #ffc3a0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        /* 2. Card dengan warna Putih Transparan (rgba 255, 255, 255, 0.9) */
        .custom-card-register {
            background: rgba(255, 255, 255, 0.9);
            /* Sesuai permintaan Anda */
            backdrop-filter: blur(15px);
            /* Efek buram di belakang card */
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            padding: 40px;
            transition: transform 0.3s ease;
        }

        .custom-card-register:hover {
            transform: translateY(-5px);
        }

        /* Style Label & Ikon */
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

        /* Input & Select Styling */
        .form-control,
        .form-select {
            border: 1px solid rgba(0, 0, 0, 0.08);
            background-color: rgba(255, 255, 255, 0.8);
            height: 52px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #FF6B81;
            box-shadow: 0 0 0 4px rgba(255, 107, 129, 0.1);
            background-color: #fff;
            outline: none;
        }

        /* Tombol Simpan dengan Gradasi Pink */
        .btn-register {
            background: linear-gradient(45deg, #FF6B81, #ee4e66);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-register:hover {
            box-shadow: 0 8px 20px rgba(255, 107, 129, 0.4);
            transform: scale(1.02);
            color: white;
        }

        /* Tombol Kembali */
        .btn-back {
            background-color: #f8f9fa;
            color: #636e72;
            border: 1px solid #dfe4ea;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #f1f2f6;
            color: #2d3436;
        }

        /* Penyesuaian Header agar Kontras dengan Background Gradasi */
        .section-title h2 {
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-title p {
            color: rgba(255, 255, 255, 0.9);
        }

        input[type="file"]::file-selector-button {
            background: #FF6B81;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            margin-right: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="file"]::file-selector-button:hover {
            background: #ee4e66;
        }

        .upload-container {
            background: rgba(255, 255, 255, 0.5);
            padding: 15px;
            border-radius: 12px;
            border: 2px dashed rgba(255, 107, 129, 0.3);
        }
    </style>

    <section id="features" class="features register-section">
        <div class="container">
            {{-- Header Halaman --}}
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <div class="section-title">
                        <span class="badge rounded-pill px-3 py-2 mb-3"
                            style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                            <i class="fas fa-folder-plus me-1"></i> Manajemen Program
                        </span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah Program Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Lengkapi formulir di bawah ini untuk membuat program
                            bantuan sosial baru.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11">
                    <div class="custom-card-register wow fadeInUp" data-wow-delay=".8s">

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger p-3 mb-4">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Oops! Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>- {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('kelola-program.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Baris 1: Kode & Nama Program --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="kode" class="form-label">
                                        <i class="fas fa-barcode"></i> Kode Program
                                    </label>
                                    <input type="text" name="kode" id="kode"
                                        class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}"
                                        required placeholder="Contoh: BLT-2025">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="nama_program" class="form-label">
                                        <i class="fas fa-hand-holding-heart"></i> Nama Program
                                    </label>
                                    <input type="text" name="nama_program" id="nama_program"
                                        class="form-control @error('nama_program') is-invalid @enderror"
                                        value="{{ old('nama_program') }}" required placeholder="Nama lengkap program">
                                </div>
                            </div>

                            {{-- Baris 2: Tahun & Anggaran --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="tahun" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Tahun Anggaran
                                    </label>
                                    <select name="tahun" id="tahun"
                                        class="form-select @error('tahun') is-invalid @enderror" required>
                                        <option value="">Pilih Tahun...</option>
                                        @php
                                            $tahunSekarang = date('Y');
                                        @endphp
                                        @for ($i = $tahunSekarang; $i >= $tahunSekarang - 5; $i--)
                                            <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="anggaran" class="form-label">
                                        <i class="fas fa-wallet"></i> Anggaran (Rp)
                                    </label>
                                    <input type="number" name="anggaran" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror"
                                        value="{{ old('anggaran') }}" required placeholder="Contoh: 150000000">
                                </div>
                            </div>

                            {{-- Baris 3: Deskripsi --}}
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">
                                    <i class="fas fa-align-left"></i> Deskripsi Program
                                </label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                    placeholder="Jelaskan detail dan tujuan bantuan ini...">{{ old('deskripsi') }}</textarea>
                            </div>

                            {{-- Baris 4: Upload Lampiran (Multiple) --}}
                            <div class="mb-4">
                                <label for="file" class="form-label">
                                    <i class="fas fa-file-upload"></i> File Dokumen 
                                </label>
                                <div class="upload-container">
                                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle me-1"></i> Format: PDF, DOCX, JPG, PNG.
                                    </small>
                                    @error('file.*')
                                        <div class="invalid-feedback d-block">Salah satu file tidak valid atau terlalu besar.
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Action Buttons --}}
                            <div class="row mt-4">
                                <div class="col-md-4 mb-2">
                                    <a href="{{ route('kelola-program.index') }}" class="btn btn-back w-100 shadow-sm">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <button type="submit" class="btn btn-register w-100 shadow">
                                        <i class="fas fa-save me-2"></i> Simpan Program Baru
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
