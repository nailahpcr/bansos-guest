@extends('layout.guest.app')

@section('title', 'Buat Akun Baru')

@section('content')
    <style>
        /* 1. Background Halaman dengan Gradasi Pink Lembut (Disamakan dengan Program) */
        .register-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffafbd 0%, #ffc3a0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        /* 2. Card dengan warna Putih Transparan & Glassmorphism */
        .custom-card-register {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            /* Diubah dari 25px ke 30px agar sama */
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

        /* Tombol Daftar dengan Gradasi Pink (Disamakan dengan Program) */
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

        /* Penyesuaian Header agar Kontras dengan Background Gradasi */
        .section-title h2 {
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-title p {
            color: rgba(255, 255, 255, 0.9);
        }

        .alert-danger {
            border-radius: 15px;
            border: none;
            background-color: rgba(255, 71, 87, 0.1);
            color: #ff4757;
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
                            <i class="fas fa-user-plus me-1"></i> Pendaftaran Warga
                        </span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Selamat Bergabung</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Daftarkan akun Anda untuk mendapatkan akses layanan
                            sistem.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11">
                    <div class="custom-card-register wow fadeInUp" data-wow-delay=".8s">

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

                        <form method="POST" action="{{ route('warga.store') }}">
                            @csrf

                            {{-- Baris 1: Nama & NIK --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="nama" class="form-label">
                                        <i class="fas fa-user"></i> Nama Lengkap
                                    </label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        required placeholder="Nama sesuai KTP">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="no_ktp" class="form-label">
                                        <i class="fas fa-id-card"></i> No. KTP (NIK)
                                    </label>
                                    <input type="text" name="no_ktp" id="no_ktp"
                                        class="form-control @error('no_ktp') is-invalid @enderror"
                                        value="{{ old('no_ktp') }}" required placeholder="16 Digit NIK">
                                </div>
                            </div>

                            {{-- Baris 2: Gender & Agama --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="jenis_kelamin" class="form-label">
                                        <i class="fas fa-venus-mars"></i> Jenis Kelamin
                                    </label>
                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="agama" class="form-label">
                                        <i class="fas fa-pray"></i> Agama
                                    </label>
                                    <select name="agama" id="agama"
                                        class="form-select @error('agama') is-invalid @enderror" required>
                                        <option value="">Pilih...</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen Protestan"
                                            {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan
                                        </option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik
                                        </option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu
                                        </option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha
                                        </option>
                                        <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>
                                            Khonghucu</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Baris 3: Pekerjaan & Telepon --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="pekerjaan" class="form-label">
                                        <i class="fas fa-briefcase"></i> Pekerjaan
                                    </label>
                                    <input type="text" name="pekerjaan" id="pekerjaan"
                                        class="form-control @error('pekerjaan') is-invalid @enderror"
                                        value="{{ old('pekerjaan') }}" placeholder="Contoh: Wiraswasta">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="telp" class="form-label">
                                        <i class="fas fa-phone-alt"></i> No. Telepon
                                    </label>
                                    <input type="text" name="telp" id="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        value="{{ old('telp') }}" placeholder="08xxxxxx">
                                </div>
                            </div>

                            {{-- Baris 4: Email --}}
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Alamat Email
                                </label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required placeholder="email@contoh.com">
                            </div>

                            {{-- Baris 5: Password --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock"></i> Password
                                    </label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        placeholder="Minimal 8 karakter">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-shield-alt"></i> Konfirmasi Password
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required placeholder="Ulangi password">
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="row mt-4 mt-3">
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('warga.index') }}"
                                        class="btn btn-light w-100 py-3 fw-bold shadow-sm"
                                        style="border-radius: 12px; color: #57606f;">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button type="submit" class="btn btn-register w-100 shadow">
                                        <i class="fas fa-user-check me-2"></i> Daftar Sekarang
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
