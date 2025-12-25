@extends('layout.guest.app')

@section('title', 'Tambah Pendaftar')

@section('content')
<style>
    /* 1. Background Halaman */
    .pendaftar-section {
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

    /* Tombol Utama */
    .btn-save {
        background: linear-gradient(45deg, #FF6B81, #ee4e66);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
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
</style>

<section id="features" class="features pendaftar-section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 107, 129, 0.2); color: #fff;">
                        <i class="fas fa-user-plus me-1"></i> Form Pendaftaran
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftarkan Warga</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Hubungkan warga dengan program bantuan yang tersedia secara tepat sasaran.</p>
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

                    <form action="{{ route('pendaftar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Pilih Program --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-hand-holding-heart"></i> Pilih Program Bantuan
                            </label>
                            <select name="program_id" class="form-select @error('program_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Program --</option>
                                @foreach ($programs as $prog)
                                    <option value="{{ $prog->program_id }}" {{ old('program_id') == $prog->program_id ? 'selected' : '' }}>
                                        {{ $prog->nama_program }} — (Tahun {{ $prog->tahun }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilih Warga --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-address-card"></i> Pilih Warga
                            </label>
                            <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach ($wargas as $w)
                                    <option value="{{ $w->warga_id }}" {{ old('warga_id') == $w->warga_id ? 'selected' : '' }}>
                                        {{ $w->nama }} — [NIK: {{ $w->no_ktp }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status & Keterangan --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-info-circle"></i> Status Awal
                                </label>
                                <select name="status_seleksi" class="form-select">
                                    <option value="Pending" {{ old('status_seleksi', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Verifikasi" {{ old('status_seleksi') == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                    <option value="Diterima" {{ old('status_seleksi') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ old('status_seleksi') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-comment-dots"></i> Keterangan (Opsional)
                                </label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Sangat Mendesak" value="{{ old('keterangan') }}">
                            </div>
                        </div>

                        {{-- Upload Files --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-file-upload"></i> Upload File Pendukung
                            </label>
                            <div class="p-4 border-dashed rounded-3 text-center" style="border: 2px dashed #FF6B81; background: rgba(255, 107, 129, 0.03);">
                                <input type="file" name="files[]" class="form-control mb-2" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                                <small class="text-muted d-block">
                                    Format: <strong>JPG, PNG, PDF, DOC, XLS</strong>. Maksimal 10MB per file.
                                </small>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('pendaftar.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-save shadow">
                                <i class="fas fa-save me-2"></i> Daftarkan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection