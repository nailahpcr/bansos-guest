@extends('layout.guest.app')

@section('title', 'Edit Data User')

@section('content')
<style>
    /* Latar Belakang Gradient Sesuai Edit Program */
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

    /* Button Styling Pill-Shaped */
    .btn-save-changes {
        background-color: #FF6B81;
        border: none;
        color: white;
        padding: 12px 35px;
        border-radius: 50px; /* Seragam dengan edit program */
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
        border-radius: 50px; /* Seragam dengan edit program */
        padding: 12px 25px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-back:hover {
        background-color: #dfe4ea;
        color: #2d3436;
    }

    /* Info Box */
    .info-box {
        background: rgba(255, 255, 255, 0.5);
        padding: 15px;
        border-radius: 15px;
        border: 2px dashed rgba(255, 107, 129, 0.3);
        margin-bottom: 25px;
    }
</style>

<section class="features edit-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                        <i class="fas fa-user-cog me-1"></i> Account Security
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Edit Data Pengguna</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Sesuaikan kredensial login dan tingkat akses pengguna.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="custom-card-edit wow fadeInUp" data-wow-delay=".7s">
                    
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

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="role" class="form-label">
                                    <i class="fas fa-user-shield"></i> Role / Hak Akses
                                </label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="user" {{ (old('role') ?? $user->role) == 'user' ? 'selected' : '' }}>User (Warga)</option>
                                    <option value="admin" {{ (old('role') ?? $user->role) == 'admin' ? 'selected' : '' }}>Admin (Petugas)</option>
                                </select>
                            </div>
                        </div>

                        <div class="info-box">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1" style="color: #FF6B81;"></i>
                                Kosongkan kolom password di bawah jika Anda tidak ingin mengubah kata sandi.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password Baru
                                </label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="********">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-shield-alt"></i> Konfirmasi Password
                                </label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********">
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('user.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
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