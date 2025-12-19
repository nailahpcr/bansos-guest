@extends('layout.guest.app')

{{-- Ubah Title Halaman --}}
@section('title', 'Edit Status Verifikasi')

@section('content')

<section id="features" class="features section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Verifikasi</h3>
                    {{-- Menampilkan nama penerima yang sedang diverifikasi --}}
                    {{-- Pastikan controller mengirim variable $verifikasi --}}
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Update Status: {{ $verifikasi->nama_penerima ?? 'Penerima' }}</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui hasil survei lapangan dan status kelayakan penerima bantuan di bawah ini.</p>
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
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form Action ke route update verifikasi --}}
                        {{-- Asumsi primary key adalah 'verifikasi_id' sesuai gambar database sebelumnya --}}
                        <form action="{{ route('verifikasi.update', $verifikasi->verifikasi_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- INFORMASI PENERIMA (READ ONLY / NON-EDITABLE) --}}
                            {{-- Kita kunci field ini agar petugas tidak salah ubah data personal --}}
                            <div class="alert alert-light border mb-4">
                                <h6 class="text-muted mb-3"><i class="lni lni-user"></i> Informasi Penerima</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">NIK</label>
                                        <input type="text" class="form-control bg-light" value="{{ $verifikasi->pendaftar->nik ?? '-' }}" disabled readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Nama Lengkap</label>
                                        <input type="text" class="form-control bg-light" value="{{ $verifikasi->pendaftar->nama ?? '-' }}" disabled readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- INPUT HASIL VERIFIKASI --}}
                            
                            {{-- Field Tanggal Survei --}}
                            <div class="mb-3">
                                <label for="tanggal" class="form-label"><strong>Tanggal Verifikasi:</strong></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $verifikasi->tanggal) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Status Kelayakan (Dropdown) --}}
                            <div class="mb-3">
                                <label for="status" class="form-label"><strong>Status Kelayakan:</strong></label>
                                <select name="status" id="status" class="form-control form-select @error('status') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Status --</option>
                                    <option value="Layak" {{ old('status', $verifikasi->status ?? '') == 'Layak' ? 'selected' : '' }}>Layak / Disetujui</option>
                                    <option value="Tidak Layak" {{ old('status', $verifikasi->status ?? '') == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak / Ditolak</option>
                                    <option value="Pending" {{ old('status', $verifikasi->status ?? '') == 'Pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Skor (Optional, sesuai database Anda ada kolom skor) --}}
                            <div class="mb-3">
                                <label for="skor" class="form-label"><strong>Skor Penilaian:</strong></label>
                                <input type="number" name="skor" id="skor" class="form-control @error('skor') is-invalid @enderror" value="{{ old('skor', $verifikasi->skor) }}" placeholder="Contoh: 85">
                                @error('skor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Catatan --}}
                            <div class="mb-3">
                                <label for="catatan" class="form-label"><strong>Catatan Surveyor:</strong></label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" style="height:120px" name="catatan" placeholder="Tuliskan temuan lapangan...">{{ old('catatan', $verifikasi->catatan) }}</textarea>
                                @error('catatan')
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