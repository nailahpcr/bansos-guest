@extends('layout.guest.app')

@section('title', 'Edit Verifikasi Lapangan')

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
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Ubah Hasil Verifikasi</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui skor dan berkas bukti lapangan hasil survei.</p>
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

                        {{-- NOTE: Menggunakan verifikasi_id sebagai parameter --}}
                        <form action="{{ route('verifikasi.update', $verifikasi->verifikasi_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label">Data Pendaftar (Warga)</label>
                                <select name="pendaftar_id" class="form-select shadow-none">
                                    @foreach ($pendaftar as $p)
                                        <option value="{{ $p->pendaftar_id }}" {{ $verifikasi->pendaftar_id == $p->pendaftar_id ? 'selected' : '' }}>
                                            {{ $p->warga?->nama }} - {{ $p->program?->nama_program }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Skor Kelayakan (0-100)</label>
                                    <input type="number" name="skor" class="form-control shadow-none" value="{{ $verifikasi->skor }}" min="0" max="100">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Petugas Lapangan</label>
                                    <input type="text" name="petugas" class="form-control shadow-none" value="{{ $verifikasi->petugas }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Tanggal Verifikasi</label>
                                <input type="date" name="tanggal" class="form-control shadow-none" value="{{ $verifikasi->tanggal }}">
                            </div>

                            {{-- FILE LAMA YANG SUDAH DIUPLOAD --}}
                            @php 
                                $files = $verifikasi->files; 
                            @endphp

                            @if ($files && $files->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label text-muted small uppercase">Bukti Dokumentasi Saat Ini:</label>
                                    <div class="list-group shadow-none">
                                        @foreach ($files as $file)
                                            <div class="list-group-item d-flex justify-content-between align-items-center bg-white border">
                                                <div class="d-flex align-items-center overflow-hidden">
                                                    @php
                                                        $ext = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                                                        $icon = in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image text-info' : 'fa-file-pdf text-danger';
                                                    @endphp
                                                    <i class="fas {{ $icon }} me-3 fs-4"></i>
                                                    <div class="text-truncate">
                                                        <div class="fw-bold text-dark text-truncate">{{ $file->filename ?? basename($file->path) }}</div>
                                                        <small class="text-muted">{{ strtoupper($ext) }} File</small>
                                                    </div>
                                                </div>
                                                <div class="ms-3 d-flex gap-2">
                                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn btn-sm btn-light border">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- Tombol Hapus File --}}
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="if(confirm('Hapus file bukti ini?')) { document.getElementById('delete-file-{{ $file->verifikasi_file_id ?? $file->id }}').submit(); }">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label text-primary">Tambah Bukti Lapangan Baru (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-camera text-muted"></i></span>
                                    <input type="file" name="files[]" class="form-control shadow-none" multiple accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                                <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i> Pilih foto lokasi atau dokumen PDF hasil verifikasi.</small>
                            </div>

                            <div class="d-flex justify-content-between mt-5 border-top pt-4">
                                <a class="btn btn-secondary px-4 fw-bold" href="{{ route('verifikasi.index') }}">
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

{{-- FORM HAPUS FILE --}}
@if ($files)
    @foreach ($files as $file)
        <form id="delete-file-{{ $file->verifikasi_file_id ?? $file->id }}" action="{{ route('verifikasi.files.destroy', $file->verifikasi_file_id ?? $file->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif

@endsection