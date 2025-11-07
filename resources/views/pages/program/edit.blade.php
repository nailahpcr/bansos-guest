@extends('layout.guest.app')

@section('title', 'Edit Program Bantuan')

@section('content')

<section id="features" class="features section">
    <div class="container">
        {{-- SECTION TITLE (disesuaikan untuk halaman 'Edit Data') --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Edit</h3>
                    {{-- Menampilkan nama program yang sedang diedit pada judul --}}
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Ubah Detail: {{ $program->nama_program }}</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui informasi program pada formulir di bawah ini jika ada perubahan.</p>
                </div>
            </div>
        </div>

        {{-- FORM EDIT DATA --}}
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

                        {{-- Rute action dan method sudah diperbaiki sesuai struktur admin --}}
                        <form action="{{ route('kelola-program.update', $program->program_id) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

                            {{-- Field Kode Program --}}
                            <div class="mb-3">
                                <label for="kode" class="form-label"><strong>Kode Program:</strong></label>
                                <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $program->kode) }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Nama Program --}}
                            <div class="mb-3">
                                <label for="nama_program" class="form-label"><strong>Nama Program:</strong></label>
                                <input type="text" name="nama_program" id="nama_program" class="form-control @error('nama_program') is-invalid @enderror" value="{{ old('nama_program', $program->nama_program) }}" required>
                                @error('nama_program')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Tahun & Anggaran dalam satu baris --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tahun" class="form-label"><strong>Tahun:</strong></label>
                                    <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $program->tahun) }}" required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anggaran" class="form-label"><strong>Anggaran (Rp):</strong></label>
                                    <input type="number" name="anggaran" id="anggaran" class="form-control @error('anggaran') is-invalid @enderror" value="{{ old('anggaran', $program->anggaran) }}" required>
                                    @error('anggaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Field Deskripsi --}}
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label"><strong>Deskripsi:</strong></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" style="height:120px" name="deskripsi">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="text-end mt-4">
                                <a class="btn btn-secondary" href="{{ route('kelola-program.index') }}"> Batal</a>
                                <button type="submit" class="btn btn-primary">Update Program</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
