@extends('layout.guest.app')

@section('title', 'Tambah Program Bantuan')

@section('content')

<section id="features" class="features section">
    <div class="container">
        {{-- SECTION TITLE (disesuaikan untuk halaman 'Tambah Data') --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Program</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah Program Bantuan Baru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Silakan isi detail program pada formulir di bawah ini dengan lengkap dan benar.</p>
                </div>
            </div>
        </div>

        {{-- FORM PENAMBAHAN DATA --}}
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

                        {{-- Rute action dan kembali sudah diperbaiki sesuai struktur admin --}}
                        <form action="{{ route('kelola-program.store') }}" method="POST">
                            @csrf

                            {{-- Field Kode Program --}}
                            <div class="mb-3">
                                <label for="kode" class="form-label"><strong>Kode Program:</strong></label>
                                <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Contoh: BLT-DANA-DESA-2025" value="{{ old('kode') }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Nama Program --}}
                            <div class="mb-3">
                                <label for="nama_program" class="form-label"><strong>Nama Program:</strong></label>
                                <input type="text" name="nama_program" id="nama_program" class="form-control @error('nama_program') is-invalid @enderror" placeholder="Contoh: Bantuan Langsung Tunai Dana Desa" value="{{ old('nama_program') }}" required>
                                @error('nama_program')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Tahun & Anggaran dalam satu baris --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tahun" class="form-label"><strong>Tahun:</strong></label>
                                    <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Contoh: 2025" value="{{ old('tahun') }}" required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anggaran" class="form-label"><strong>Anggaran (Rp):</strong></label>
                                    <input type="number" name="anggaran" id="anggaran" class="form-control @error('anggaran') is-invalid @enderror" placeholder="Contoh: 150000000" value="{{ old('anggaran') }}" required>
                                    @error('anggaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Field Deskripsi --}}
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label"><strong>Deskripsi:</strong></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" style="height:120px" name="deskripsi" placeholder="Jelaskan secara singkat tujuan dari program bantuan ini">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="text-end mt-4">
                                <a class="btn btn-secondary" href="{{ route('kelola-program.index') }}"> Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Program</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
