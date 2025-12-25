@extends('layout.guest.app')

@section('title', 'Catat Riwayat Penyaluran')

@section('content')
<style>
    /* Background Halaman */
    .history-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #ffafbd 0%, #ffc3a0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    /* Card Glassmorphism */
    .custom-card-glass {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        padding: 40px;
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
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 52px;
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
        border-radius: 50px;
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
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .section-title h2 { color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .section-title p { color: rgba(255,255,255,0.9); }
</style>

<section id="features" class="features history-section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 255, 255, 0.2); color: #fff;">
                        <i class="fas fa-history me-1"></i> Log Penyaluran
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Catat Penyaluran Baru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Dokumentasikan bukti penyaluran bantuan kepada warga penerima manfaat.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="custom-card-glass wow fadeInUp" data-wow-delay=".8s">

                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('riwayat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Program Bantuan --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-hand-holding-heart"></i> Program Bantuan
                            </label>
                            <select name="program_id" class="form-select" required>
                                <option value="">-- Pilih Program --</option>
                                @foreach ($programs as $p)
                                    <option value="{{ $p->program_id }}">{{ $p->nama_program }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Penerima --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-user-check"></i> Nama Penerima
                            </label>
                            <select name="penerima_id" class="form-select" required>
                                <option value="">-- Pilih Penerima --</option>
                                @foreach ($penerimas as $w)
                                    <option value="{{ $w->penerima_id }}">
                                        {{ $w->warga->nama ?? 'Nama Tidak Ditemukan' }} — [NIK: {{ $w->warga->no_ktp ?? '-' }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Baris Tahap & Tanggal --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-layer-group"></i> Tahap Ke
                                </label>
                                <select name="tahap_ke" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Tahap --</option>
                                    <option value="1">Tahap 1</option>
                                    <option value="2">Tahap 2</option>
                                    <option value="3">Tahap 3</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Penyaluran
                                </label>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        {{-- Nilai Bantuan --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave"></i> Nilai Bantuan (Rp)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px;">Rp</span>
                                <input type="number" name="nilai" class="form-control border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="Contoh: 300000" required>
                            </div>
                        </div>

                        {{-- Bukti Foto --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-camera"></i> Bukti Foto Penyaluran
                            </label>
                            <div class="p-4 border-dashed rounded-3 text-center" style="border: 2px dashed #FF6B81; background: rgba(255, 107, 129, 0.03);">
                                <input type="file" name="bukti_penyaluran" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block">Unggah foto dokumentasi saat warga menerima bantuan.</small>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('riwayat.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-save shadow w-50">
                                <i class="fas fa-save me-2"></i> Simpan Penyaluran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection