@extends('layout.guest.app')

@section('title', 'Edit Data Warga')

@section('content')
<style>
    /* Konsistensi tema dengan Index */
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
        gap: 8px; /* Jarak antara ikon dan teks */
    }

    .form-label i {
        color: #FF6B81; /* Warna ikon pink sesuai tema */
        font-size: 1.1rem;
        width: 25px;
        text-align: center;
    }

    /* Input & Select Styling */
    .form-control, .form-select {
        border: 1px solid rgba(255, 107, 129, 0.2);
        height: 52px;
        border-radius: 12px;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
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
        border: 1px solid rgba(0,0,0,0.05);
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
    }

    .btn-back:hover {
        background-color: #dfe4ea;
        color: #2d3436;
    }

    /* Form Text (Optional info) */
    .form-text {
        font-size: 0.8rem;
        color: #a0a0a0;
        margin-left: 33px;
    }
</style>

<section class="features edit-section">
    <div class="container">
        {{-- Judul Halaman --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                        <i class="fas fa-user-edit me-1"></i> Update Database
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Edit Data Warga</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Pastikan data warga seperti NIK dan Nama sudah sesuai dengan dokumen asli.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center wow fadeInUp" data-wow-delay=".7s">
            <div class="col-lg-8">
                <div class="custom-card-edit">
                    
                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 p-3 mb-4" style="background-color: rgba(255, 71, 87, 0.1); color: #ff4757;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama Lengkap --}}
                            <div class="col-md-6 mb-4">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                       value="{{ old('nama', $warga->nama) }}" required placeholder="Masukkan nama lengkap">
                            </div>

                            {{-- No KTP --}}
                            <div class="col-md-6 mb-4">
                                <label for="no_ktp" class="form-label">
                                    <i class="fas fa-id-card"></i> No. KTP (NIK)
                                </label>
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                       value="{{ old('no_ktp', $warga->no_ktp) }}" required placeholder="16 Digit NIK">
                            </div>
                        </div>

                        <div class="row">
                            {{-- Jenis Kelamin --}}
                            <div class="col-md-6 mb-4">
                                <label for="jenis_kelamin" class="form-label">
                                    <i class="fas fa-venus-mars"></i> Jenis Kelamin
                                </label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            {{-- Agama --}}
                            <div class="col-md-6 mb-4">
                                <label for="agama" class="form-label">
                                    <i class="fas fa-pray"></i> Agama
                                </label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="">Pilih Agama</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ old('agama', $warga->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Pekerjaan --}}
                            <div class="col-md-6 mb-4">
                                <label for="pekerjaan" class="form-label">
                                    <i class="fas fa-briefcase"></i> Pekerjaan
                                </label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                       value="{{ old('pekerjaan', $warga->pekerjaan) }}" required placeholder="Contoh: Pegawai Swasta">
                            </div>

                            {{-- Telepon --}}
                            <div class="col-md-6 mb-4">
                                <label for="telp" class="form-label">
                                    <i class="fas fa-phone-alt"></i> No.Telepon
                                </label>
                                <input type="text" class="form-control" id="telp" name="telp"
                                       value="{{ old('telp', $warga->telp) }}" placeholder="08xxxx">
                            </div>
                        </div>

                        {{-- Email--}}
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Alamat Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', $warga->email) }}" placeholder="email@contoh.com">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a href="{{ route('warga.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                            </a>
                            <button type="submit" class="btn btn-save-changes shadow">
                                <i class="fas fa-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection