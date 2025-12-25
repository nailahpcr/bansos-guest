@extends('layout.guest.app')

@section('title', 'Input Verifikasi Lapangan')

@section('content')
<style>
    /* 1. Background Halaman */
    .verification-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #ffafbd 0%, #ffc3a0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    /* 2. Card Glassmorphism */
    .custom-card-glass {
        background: rgba(255, 255, 255, 0.9);
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

    /* Input Styling */
    .form-control, .form-select {
        border: 1px solid rgba(0, 0, 0, 0.08);
        background-color: rgba(255, 255, 255, 0.8);
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

    /* Text Area Custom */
    textarea.form-control {
        border-radius: 15px;
        padding: 15px;
    }

    .section-title h2 { color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .section-title p { color: rgba(255,255,255,0.9); }
</style>

<section id="features" class="features verification-section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 255, 255, 0.2); color: #fff;">
                        <i class="fas fa-search-location me-1"></i> Form Survei Lapangan
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Input Data Verifikasi</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Masukan hasil survei dan penilaian verifikasi data pendaftar dengan akurat.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                <div class="custom-card-glass wow fadeInUp" data-wow-delay=".8s">

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                            <strong><i class="fas fa-times-circle me-2"></i>Terjadi Kesalahan!</strong> Mohon periksa kembali inputan Anda.
                        </div>
                    @endif

                    <form action="{{ route('verifikasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Pendaftar --}}
                        <div class="mb-4">
                            <label for="pendaftar_id" class="form-label">
                                <i class="fas fa-user-check"></i> Nama Pendaftar (Warga)
                            </label>
                            <select name="pendaftar_id" id="pendaftar_id" class="form-select p-3 @error('pendaftar_id') is-invalid @enderror">
                                <option value="">-- Pilih Pendaftar --</option>
                                @foreach ($pendaftar as $item)
                                    <option value="{{ $item->pendaftar_id }}" {{ old('pendaftar_id') == $item->pendaftar_id ? 'selected' : '' }}>
                                        {{ $item->warga->nama ?? 'Warga ID: ' . $item->warga_id }} — [{{ $item->program->nama_program ?? 'Program' }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('pendaftar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            {{-- Petugas --}}
                            <div class="col-md-6 mb-4">
                                <label for="petugas" class="form-label">
                                    <i class="fas fa-user-shield"></i> Nama Petugas
                                </label>
                                <select name="petugas" id="petugas" class="form-select p-3 @error('petugas') is-invalid @enderror" required>
                                    <option value="">-- Pilih Petugas --</option>
                                    @php $daftarPetugas = ['Budi', 'Siti', 'Agus', 'Putri', 'Hendra']; @endphp
                                    @foreach ($daftarPetugas as $nama)
                                        <option value="{{ $nama }}" {{ old('petugas') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                                @error('petugas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-4">
                                <label for="tanggal" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Verifikasi
                                </label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control p-3 @error('tanggal') is-invalid @enderror" 
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Skor --}}
                        <div class="mb-4">
                            <label for="skor" class="form-label">
                                <i class="fas fa-chart-line"></i> Skor Penilaian (0-100)
                            </label>
                            <input type="number" name="skor" id="skor" class="form-control p-3 @error('skor') is-invalid @enderror" 
                                placeholder="Masukkan skor kelayakan" value="{{ old('skor') }}">
                            @error('skor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label for="catatan" class="form-label">
                                <i class="fas fa-edit"></i> Catatan Lapangan
                            </label>
                            <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" 
                                rows="4" placeholder="Tuliskan temuan atau catatan penting di lapangan...">{{ old('catatan') }}</textarea>
                            @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Upload File --}}
                        <div class="mb-4">
                            <label for="file" class="form-label">
                                <i class="fas fa-camera"></i> Foto Bukti Lapangan
                            </label>
                            <div class="p-3 border-dashed rounded-3" style="border: 2px dashed #FF6B81; background: rgba(255, 107, 129, 0.05);">
                                <input type="file" name="file[]" id="file" class="form-control" multiple accept="image/*">
                                <small class="text-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i> Anda dapat memilih lebih dari satu foto sekaligus.</small>
                            </div>
                            @error('file') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('verifikasi.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-save shadow">
                                <i class="fas fa-check-circle me-2"></i> Simpan Verifikasi
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection