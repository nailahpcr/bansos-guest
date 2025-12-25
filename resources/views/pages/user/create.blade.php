@extends('layout.guest.app')

@section('title', 'Tambah User Baru')

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

    /* 2. Card Glassmorphism */
    .custom-card-register {
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
        outline: none;
    }

    /* Tombol Utama (Pink Gradasi) */
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

    /* Header Styling */
    .section-title h2 {
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .section-title p {
        color: rgba(255, 255, 255, 0.9);
    }

    .preview-container {
        border: 2px dashed rgba(255, 107, 129, 0.3);
        padding: 10px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.5);
    }
</style>

<section id="features" class="features register-section">
    <div class="container">
        {{-- Header Halaman --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                        <i class="fas fa-users-cog me-1"></i> Manajemen Pengguna
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah User Baru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Silakan isi detail pengguna baru pada formulir di bawah ini.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                <div class="custom-card-register wow fadeInUp" data-wow-delay=".8s">

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger p-3 mb-4" style="border-radius: 15px;">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Oops! Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama & Email --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Alamat Email
                                </label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="budi@example.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        {{-- Password & Konfirmasi --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Minimal 8 karakter" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-shield-alt"></i> Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="form-control" placeholder="Ulangi password" required>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="mb-4">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag"></i> Role Pengguna
                            </label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        {{-- Buttons --}}
                        <div class="row mt-5">
                            <div class="col-md-4 mb-2">
                                <a href="{{ route('user.index') }}" class="btn btn-back w-100 shadow-sm text-center">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-8 mb-2">
                                <button type="submit" class="btn btn-register w-100 shadow">
                                    <i class="fas fa-save me-2"></i> Simpan Pengguna Baru
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