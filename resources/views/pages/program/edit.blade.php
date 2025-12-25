@extends('layout.guest.app')

@section('title', 'Edit Program Bantuan')

@section('content')
    <style>
        /* Konsistensi tema dengan halaman Warga */
        .edit-section {
            padding: 80px 0;
            background-color: #fcfcfc;
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
            box-shadow: 0 20px 40px rgba(255, 107, 129, 0.1);
            padding: 40px;
        }

        /* Style Label dengan Ikon */
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
            /* Warna ikon pink sesuai tema */
            font-size: 1.1rem;
            width: 25px;
            text-align: center;
        }

        /* Input & Select Styling */
        .form-control,
        .form-select {
            border: 1px solid rgba(255, 107, 129, 0.2);
            height: 52px;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        /* Khusus untuk textarea agar tingginya menyesuaikan */
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

        /* Button Styling */
        .btn-save-changes {
            background-color: #FF6B81;
            border: none;
            color: white;
            padding: 12px 35px;
            border-radius: 12px;
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
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-back:hover {
            background-color: #dfe4ea;
            color: #2d3436;
        }

        .upload-container {
            background: rgba(255, 107, 129, 0.05);
            padding: 20px;
            border-radius: 15px;
            border: 2px dashed rgba(255, 107, 129, 0.3);
        }

        .existing-file-item {
            background: white;
            border-radius: 10px;
            padding: 8px 15px;
            margin-bottom: 8px;
            border: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>

    <section class="features edit-section">
        <div class="container">
            {{-- Judul Halaman --}}
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <div class="section-title">
                        <span class="badge rounded-pill px-3 py-2 mb-3"
                            style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                            <i class="fas fa-edit me-1"></i> Panel Administrasi
                        </span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Ubah Detail Program</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Sesuaikan informasi program bantuan
                            <strong>{{ $program->nama_program }}</strong> di bawah ini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-8">
                    <div class="custom-card-edit">

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 p-3 mb-4"
                                style="background-color: rgba(255, 71, 87, 0.1); color: #ff4757;">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('kelola-program.update', $program->program_id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Kode Program --}}
                                <div class="col-md-6 mb-4">
                                    <label for="kode" class="form-label">
                                        <i class="fas fa-barcode"></i> Kode Program
                                    </label>
                                    <input type="text" name="kode" id="kode"
                                        class="form-control @error('kode') is-invalid @enderror"
                                        value="{{ old('kode', $program->kode) }}" required placeholder="Contoh: PRG-001">
                                </div>

                                {{-- Nama Program --}}
                                <div class="col-md-6 mb-4">
                                    <label for="nama_program" class="form-label">
                                        <i class="fas fa-hand-holding-heart"></i> Nama Program
                                    </label>
                                    <input type="text" name="nama_program" id="nama_program"
                                        class="form-control @error('nama_program') is-invalid @enderror"
                                        value="{{ old('nama_program', $program->nama_program) }}" required
                                        placeholder="Masukkan nama program">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Tahun --}}
                                <div class="col-md-6 mb-4">
                                    <label for="tahun" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Tahun Anggaran
                                    </label>
                                    <input type="number" name="tahun" id="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', $program->tahun) }}" required>
                                </div>

                                {{-- Anggaran --}}
                                <div class="col-md-6 mb-4">
                                    <label for="anggaran" class="form-label">
                                        <i class="fas fa-wallet"></i> Anggaran (Rp)
                                    </label>
                                    <input type="number" name="anggaran" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror"
                                        value="{{ old('anggaran', $program->anggaran) }}" required
                                        placeholder="Contoh: 50000000">
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label for="deskripsi" class="form-label">
                                        <i class="fas fa-align-left"></i> Deskripsi Program
                                    </label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                        placeholder="Tuliskan detail mengenai program bantuan ini...">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                                </div>
                            </div>

                            {{-- Lampiran Dokumen --}}
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-file-alt"></i> Lampiran Dokumen
                                    </label>

                                    <div class="upload-container">
                                        {{-- Tampilkan File yang Sudah Ada --}}
                                        @if (!empty($program->file))
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-2 font-weight-bold">File Saat
                                                    Ini:</small>

                                                <div
                                                    class="existing-file-item shadow-sm p-2 border rounded d-flex justify-content-between align-items-center">
                                                    <span class="small text-truncate" style="max-width: 80%;">
                                                        <i class="fas fa-file-alt me-2 text-primary"></i>
                                                        {{ basename($program->file) }}
                                                    </span>
                                                    <a href="{{ asset('storage/' . $program->file) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info py-0">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Input File Baru --}}
                                        <div class="form-group">
                                            <small class="text-muted d-block mb-2 italic">Unggah file baru (opsional, akan
                                                menambah file yang ada):</small>
                                            <input type="file" name="file"
                                                class="form-control @error('file') is-invalid @enderror">
                                            class="form-control @error('file.*')
is-invalid
@enderror" multiple
                                            accept=".pdf,.doc,.docx,.jpg,.png">
                                            @error('file.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-2" style="font-size: 0.75rem; color: #888;">
                                                <i class="fas fa-info-circle me-1"></i> Format didukung: PDF, DOCX, JPG,
                                                PNG (Max 2MB/file)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('kelola-program.index') }}" class="btn btn-back shadow-sm">
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
@endsection
