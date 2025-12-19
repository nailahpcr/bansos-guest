@extends('layout.guest.app')

@section('title', 'Input Verifikasi Lapangan')

@section('content')

<section id="features" class="features section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Verifikasi</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Input Data Verifikasi Lapangan</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Masukan hasil survei dan penilaian verifikasi data pendaftar di bawah ini.</p>
                </div>
            </div>
        </div>

        {{-- FORM INPUT DATA --}}
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                    <div class="card-body p-4">

                        {{-- Menampilkan pesan error validasi umum --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Oops!</strong> Ada masalah dengan input Anda. Silakan periksa kembali.
                            </div>
                        @endif

                        {{-- Form Action --}}
                        <form action="{{ route('verifikasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Field Pilihan Pendaftar --}}
                            <div class="mb-3">
                                <label for="pendaftar_id" class="form-label"><strong>Nama Pendaftar (Warga):</strong></label>
                                <select name="pendaftar_id" id="pendaftar_id" class="form-control @error('pendaftar_id') is-invalid @enderror">
                                    <option value="">-- Pilih Pendaftar --</option>
                                    @foreach($pendaftar as $item)
                                        <option value="{{ $item->pendaftar_id }}" {{ old('pendaftar_id') == $item->pendaftar_id ? 'selected' : '' }}>
                                            {{ $item->warga->nama ?? 'Warga ID: ' . $item->warga_id }} - ({{ $item->program->nama_program ?? 'Program Lain' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('pendaftar_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Baris Petugas & Tanggal --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="petugas" class="form-label"><strong>Nama Petugas Verifikator:</strong></label>
                                    <input type="text" name="petugas" id="petugas" class="form-control @error('petugas') is-invalid @enderror" placeholder="Nama petugas survei" value="{{ old('petugas') }}">
                                    @error('petugas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label"><strong>Tanggal Verifikasi:</strong></label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}">
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Field Skor --}}
                            <div class="mb-3">
                                <label for="skor" class="form-label"><strong>Skor Penilaian (0-100):</strong></label>
                                <input type="number" name="skor" id="skor" class="form-control @error('skor') is-invalid @enderror" placeholder="Contoh: 85" value="{{ old('skor') }}">
                                @error('skor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Catatan --}}
                            <div class="mb-3">
                                <label for="catatan" class="form-label"><strong>Catatan Lapangan:</strong></label>
                                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" style="height:100px" placeholder="Tuliskan temuan atau catatan penting di lapangan...">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Upload Foto --}}
                            <div class="mb-3">
                                <label for="foto_bukti" class="form-label"><strong>Foto Bukti Lapangan:</strong></label>
                                <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror">
                                <small class="text-muted d-block mt-1">Format: jpg, jpeg, png. Maks: 2MB.</small>
                                @error('foto_bukti')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="text-end mt-4">
                                <a class="btn btn-secondary" href="{{ route('verifikasi.index') }}"> Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection