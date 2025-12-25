@extends('layout.guest.app')

@section('title', 'Edit Status Verifikasi')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Verifikasi</h3>
                        {{-- Perbaikan: Mengambil nama dari relasi pendaftar->warga --}}
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Update Data:
                            {{ $verifikasi->pendaftar->warga->nama ?? 'Penerima' }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui hasil survei lapangan dan status kelayakan
                            penerima bantuan di bawah ini.</p>
                    </div>
                </div>
            </div>

            {{-- FORM EDIT DATA --}}
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4">

                            {{-- Pesan Error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Oops!</strong> Ada masalah dengan input Anda.
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Form Action: Pastikan menggunakan $verifikasi->id sesuai standar Laravel --}}
                            {{-- Tambahkan enctype karena di Controller kita menangani upload foto --}}
                            <form action="{{ route('verifikasi.update', $verifikasi) }}" method="POST"
                                enctype="multipart/form-data"> @csrf
                                @method('PUT')

                                {{-- INFORMASI PENERIMA (READ ONLY) --}}
                                <div class="alert alert-light border mb-4">
                                    <h6 class="text-muted mb-3"><i class="lni lni-user"></i> Informasi Penerima</h6>
                                    <input type="hidden" name="pendaftar_id" value="{{ $verifikasi->pendaftar_id }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">NIK</label>
                                            <input type="text" class="form-control bg-light"
                                                value="{{ $verifikasi->pendaftar->warga->nik ?? '-' }}" disabled readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Nama Lengkap</label>
                                            <input type="text" class="form-control bg-light"
                                                value="{{ $verifikasi->pendaftar->warga->nama ?? '-' }}" disabled readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Field Petugas --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="petugas" class="form-label"><strong>Nama Petugas:</strong></label>
                                        <select name="petugas" id="petugas"
                                            class="form-select @error('petugas') is-invalid @enderror" required>
                                            <option value="">-- Pilih Petugas --</option>
                                            @php
                                                $daftarPetugas = ['Budi', 'Siti', 'Agus', 'Putri', 'Hendra'];
                                            @endphp
                                            @foreach ($daftarPetugas as $nama)
                                                <option value="{{ $nama }}"
                                                    {{ old('petugas', $verifikasi->petugas ?? '') == $nama ? 'selected' : '' }}>
                                                    {{ $nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('petugas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Field Tanggal Survei --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal" class="form-label"><strong>Tanggal
                                                Verifikasi:</strong></label>
                                        <input type="date" name="tanggal" id="tanggal"
                                            class="form-control @error('tanggal') is-invalid @enderror"
                                            value="{{ old('tanggal', $verifikasi->tanggal) }}" required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Field Skor --}}
                                <div class="mb-3">
                                    <label for="skor" class="form-label"><strong>Skor Penilaian:</strong></label>
                                    <input type="number" name="skor" id="skor"
                                        class="form-control @error('skor') is-invalid @enderror"
                                        value="{{ old('skor', $verifikasi->skor) }}" placeholder="Contoh: 85" required>
                                    @error('skor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Foto Bukti (Tambahan karena ada di Controller) --}}
                                <div class="mb-3">
                                    <label for="file" class="form-label"><strong>Foto Bukti Lapangan:</strong></label>
                                    @if ($verifikasi->file)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $verifikasi->file) }}" width="150"
                                                class="img-thumbnail d-block">
                                            <small class="text-muted">Foto saat ini (kosongkan jika tidak ingin
                                                mengganti)</small>
                                        </div>
                                    @endif
                                    <input type="file" name="file" id="file"
                                        class="form-control @error('file') is-invalid @enderror">
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="text-end mt-4">
                                    <a class="btn btn-secondary" href="{{ route('verifikasi.index') }}"> Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
