@extends('layout.guest.app')

@section('title', 'Edit Status Verifikasi')

@section('content')
    <style>
        #features {
            background: linear-gradient(to bottom, #FFD1DC 0%, #B2E2F2 100%);
            min-height: 100vh;
            padding: 60px 0;
            background-attachment: fixed;
        }

        .card {
            border-radius: 20px;
            border: none;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
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

        .btn-success {
            background: linear-gradient(45deg, #20bf6b, #0fb9b1);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
        }

        .btn-secondary {
            border-radius: 50px;
            padding: 10px 25px;
            background-color: #95afc0;
            border: none;
        }
    </style>

    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Verifikasi</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Edit Data: {{ $verifikasi->pendaftar?->warga?->nama ?? 'Penerima' }} </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui hasil survei lapangan dan status kelayakan
                            penerima bantuan.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4 p-md-5">

                            {{-- Pesan Error Validasi --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                                    <strong>Oops!</strong> Ada masalah dengan input Anda.
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Form Utama - Perbaikan Syntax Error pada Action --}}
                            <form action="{{ route('verifikasi.update', ['verifikasi']) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- INFORMASI PENERIMA --}}
                                <div class="alert alert-info border-0 shadow-sm mb-4 d-flex align-items-center"
                                    style="border-radius: 15px; background: rgba(178, 226, 242, 0.4);">
                                    <i class="fas fa-id-card fa-2x me-3 text-primary"></i>
                                    <div>
                                        <small class="text-uppercase fw-bold text-primary" style="font-size: 0.7rem;">NIK /
                                            Nama Penerima</small>
                                        <p class="mb-0 fw-bold text-dark">
                                            {{ $verifikasi->pendaftar?->warga?->nik ?? '-' }} -
                                            {{ $verifikasi->pendaftar?->warga?->nama ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <input type="hidden" name="pendaftar_id" value="{{ $verifikasi->pendaftar_id }}">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="petugas" class="form-label">Nama Petugas</label>
                                        <select name="petugas" id="petugas"
                                            class="form-select shadow-none @error('petugas') is-invalid @enderror" required>
                                            <option value="">-- Pilih Petugas --</option>
                                            @foreach (['Budi', 'Siti', 'Agus', 'Putri', 'Hendra'] as $nama)
                                                <option value="{{ $nama }}"
                                                    {{ old('petugas', $verifikasi->petugas) == $nama ? 'selected' : '' }}>
                                                    {{ $nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label">Tanggal Verifikasi</label>
                                        <input type="date" name="tanggal" id="tanggal"
                                            class="form-control shadow-none @error('tanggal') is-invalid @enderror"
                                            value="{{ old('tanggal', $verifikasi->tanggal) }}" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="skor" class="form-label">Skor Penilaian</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i
                                                class="fas fa-star text-warning"></i></span>
                                        <input type="number" name="skor" id="skor"
                                            class="form-control shadow-none border-start-0 @error('skor') is-invalid @enderror"
                                            value="{{ old('skor', $verifikasi->skor) }}" placeholder="Contoh: 85" required>
                                    </div>
                                </div>

                                {{-- LIST BERKAS SAAT INI --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Berkas Saat Ini:</label>
                                    @forelse($verifikasi->files as $file)
                                        <div
                                            class="d-flex align-items-center justify-content-between bg-light p-2 mb-2 rounded border">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                <span class="text-truncate"
                                                    style="max-width: 250px;">{{ $file->filename }}</span>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="if(confirm('Hapus berkas ini?')) document.getElementById('delete-file-{{ $file->id }}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted small italic">Tidak ada berkas yang diunggah.</p>
                                    @endforelse
                                </div>

                                {{-- UPLOAD FILE BARU --}}
                                <div class="mb-4">
                                    <label class="form-label text-primary">Tambah Foto Bukti Baru (Multiple)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="fas fa-upload text-muted"></i></span>
                                        <input type="file" name="files[]"
                                            class="form-control shadow-none @error('files.*') is-invalid @enderror" multiple
                                            accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle me-1"></i> Anda dapat memilih lebih dari satu foto
                                        sekaligus.
                                    </small>
                                </div>

                                {{-- BUTTON ACTIONS --}}
                                <div class="d-flex justify-content-between mt-5 border-top pt-4">
                                    <a class="btn btn-secondary px-4 fw-bold shadow-sm"
                                        href="{{ route('verifikasi.index') }}">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                                        <i class="fas fa-save me-2"></i> Simpan Verifikasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FORM HAPUS HIDDEN (Sama seperti logika di pendaftar) --}}
    @if (isset($verifikasi->files) && $verifikasi->files->count() > 0)
        @foreach ($verifikasi->files as $file)
            <form id="delete-file-{{ $file->id }}" action="{{ route('verifikasi.files.destroy', $file->id) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif

@endsection
