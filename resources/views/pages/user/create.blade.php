@extends('layout.guest.app')

@section('title', 'Tambah User Baru')

@section('content')

<section id="features" class="features section">
    <div class="container">
        {{-- SECTION TITLE (disesuaikan untuk halaman 'Tambah User') --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Pengguna</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah User Baru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Silakan isi detail pengguna baru pada formulir di bawah ini dengan lengkap dan benar.</p>
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

                        {{-- Form Start --}}
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Field Nama Lengkap --}}
                            <div class="mb-3">
                                <label for="name" class="form-label"><strong>Nama Lengkap:</strong></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label"><strong>Alamat Email:</strong></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Contoh: budi@example.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Password & Konfirmasi dalam satu baris (Layout 2 Kolom) --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label"><strong>Password:</strong></label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password aman" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label"><strong>Konfirmasi Password:</strong></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                                </div>
                            </div>

                            {{-- Profile Picture Upload --}}
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label"><strong>Foto Profil (opsional):</strong></label>
                                <div class="d-flex align-items-center gap-3">
                                    <img id="createPreview" src="https://via.placeholder.com/150" alt="Preview" class="img-thumbnail" style="max-width:150px">
                                    <div class="flex-grow-1">
                                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="form-control @error('profile_picture') is-invalid @enderror">
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengunggah foto profil.</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Aksi (Kanan Bawah) --}}
                            <div class="text-end mt-4">
                                <a class="btn btn-secondary" href="{{ route('user.index') }}"> Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan User</button>
                            </div>
                        </form>
                        {{-- Form End --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.getElementById('profile_picture')?.addEventListener('change', function (e) {
        const [file] = this.files;
        if (file) {
            document.getElementById('createPreview').src = URL.createObjectURL(file);
        }
    });
</script>
@endpush