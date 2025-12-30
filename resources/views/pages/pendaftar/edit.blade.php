@extends('layout.guest.app')

@section('title', 'Edit Pendaftar')

@section('content')
<style>
    #features {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 60px 0;
    }
    .card {
        border-radius: 20px;
        border: none;
    }
    .section-title h3 {
        color: #ff5876;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .form-label {
        font-weight: 600;
        color: #2d3436;
    }
    .list-group-item {
        border-radius: 12px !important;
        margin-bottom: 10px;
        border: 1px solid #edf2f7 !important;
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.01);
    }
    .btn-success {
        background: linear-gradient(45deg, #20bf6b, #0fb9b1);
        border: none;
        border-radius: 50px;
    }
    .btn-secondary {
        border-radius: 50px;
    }
</style>

<section id="features" class="features section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Edit Data</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Ubah Status Pendaftaran</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui data pendaftaran warga di program bantuan.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg wow fadeInUp" data-wow-delay=".8s">
                    <div class="card-body p-4 p-md-5">
                        
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('pendaftar.update', $pendaftar->pendaftar_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label">Program Bantuan</label>
                                <select name="program_id" class="form-select shadow-none">
                                    @foreach ($programs as $prog)
                                        <option value="{{ $prog->program_id }}" {{ $pendaftar->program_id == $prog->program_id ? 'selected' : '' }}>
                                            {{ $prog->nama_program }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nama Warga</label>
                                <select name="warga_id" class="form-select shadow-none">
                                    @foreach ($wargas as $w)
                                        <option value="{{ $w->warga_id }}" {{ $pendaftar->warga_id == $w->warga_id ? 'selected' : '' }}>
                                            {{ $w->nama }} - {{ $w->no_ktp }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Status Seleksi</label>
                                    <select name="status_seleksi" class="form-select shadow-none">
                                        @foreach(['Pending', 'Diterima', 'Ditolak'] as $status)
                                            <option value="{{ $status }}" {{ $pendaftar->status_seleksi == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control shadow-none" value="{{ $pendaftar->keterangan }}">
                                </div>
                            </div>

                            {{-- FILE LAMA YANG SUDAH DIUPLOAD --}}
                            @php 
                                // Sesuaikan nama relasi, jika di model Pendaftar namanya files() gunakan $pendaftar->files
                                $files = $pendaftar->files ?? $pendaftar->file; 
                            @endphp

                            @if ($files && $files->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label text-muted small uppercase">Berkas Saat Ini:</label>
                                    <div class="list-group shadow-none">
                                        @foreach ($files as $file)
                                            <div class="list-group-item d-flex justify-content-between align-items-center bg-white border">
                                                <div class="d-flex align-items-center overflow-hidden">
                                                    @php
                                                        $ext = strtolower(pathinfo($file->filename, PATHINFO_EXTENSION));
                                                        $icon = in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image text-info' : 'fa-file-pdf text-danger';
                                                    @endphp
                                                    <i class="fas {{ $icon }} me-3 fs-4"></i>
                                                    <div class="text-truncate">
                                                        <div class="fw-bold text-dark text-truncate">{{ $file->filename }}</div>
                                                        <small class="text-muted">{{ strtoupper($ext) }} File</small>
                                                    </div>
                                                </div>
                                                <div class="ms-3 d-flex gap-2">
                                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn btn-sm btn-light border">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- Tombol Hapus --}}
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="if(confirm('Apakah Anda yakin ingin menghapus file ini secara permanen?')) { document.getElementById('delete-file-{{ $file->file_id ?? $file->id }}').submit(); }">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label text-primary">Tambah File Baru (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-upload text-muted"></i></span>
                                    <input type="file" name="files[]" class="form-control shadow-none" multiple accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                                <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i> Anda dapat memilih lebih dari satu file (JPG, PNG, PDF).</small>
                            </div>

                            <div class="d-flex justify-content-between mt-5 border-top pt-4">
                                <a class="btn btn-secondary px-4 fw-bold" href="{{ route('pendaftar.index') }}">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FORM HAPUS FILE (DI LUAR FORM UTAMA) --}}
@if ($files)
    @foreach ($files as $file)
        {{-- Pastikan route pendaftar.files.destroy sudah terdaftar di web.php --}}
        <form id="delete-file-{{ $file->file_id ?? $file->id }}" action="{{ route('pendaftar.files.destroy', $file->file_id ?? $file->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif

@endsection