@extends('layout.guest.app')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            {{-- SECTION TITLE (disesuaikan untuk halaman Registrasi) --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Buat Akun Baru</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Selamat Bergabung</h2>
                        {{-- DIUBAH: Teks lebih umum --}}
                        <p class="wow fadeInUp" data-wow-delay=".6s">Daftarkan akun Anda untuk mendapatkan akses ke
                            sistem.</p>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Oops! Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM REGISTRASI --}}
            <div class="row justify-content-center">
                {{-- DIUBAH: Dibuat lebih lebar untuk menampung form --}}
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('warga.store') }}">
                                @csrf

                                {{-- Field Nama --}}
                                <div class="mb-3">
                                    <label for="nama" class="form-label"><strong>Nama Lengkap:</strong></label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama') }}" required autofocus>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- =================================== --}}
                                {{--           FIELD BARU DIMULAI        --}}
                                {{-- =================================== --}}

                                {{-- Field No. KTP --}}
                                <div class="mb-3">
                                    <label for="no_ktp" class="form-label"><strong>No. KTP:</strong></label>
                                    <input type="text" name="no_ktp" id="no_ktp"
                                        class="form-control @error('no_ktp') is-invalid @enderror"
                                        value="{{ old('no_ktp') }}" required>
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- Field Jenis Kelamin --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label"><strong>Jenis
                                                Kelamin:</strong></label>
                                        <select name="jenis_kelamin" id="jenis_kelamin"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                            <option value="">Pilih...</option>
                                            <option value="Laki-laki"
                                                {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Field Agama --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="agama" class="form-label"><strong>Agama:</strong></label>
                                        <select name="agama" id="agama"
                                            class="form-select @error('agama') is-invalid @enderror" required>
                                            <option value="">Pilih...</option>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>
                                                Islam</option>
                                            <option value="Kristen Protestan"
                                                {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen
                                                Protestan</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>
                                                Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>
                                                Hindu</option>
                                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>
                                                Buddha</option>
                                            <option value="Khonghucu"
                                                {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                        </select>
                                        @error('agama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Field Pekerjaan (Opsional) --}}
                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label"><strong>Pekerjaan:</strong></label>
                                    <input type="text" name="pekerjaan" id="pekerjaan"
                                        class="form-control @error('pekerjaan') is-invalid @enderror"
                                        value="{{ old('pekerjaan') }}">
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Telepon (Opsional) --}}
                                <div class="mb-3">
                                    <label for="telp" class="form-label"><strong>No. Telepon:</strong></label>
                                    <input type="text" name="telp" id="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        value="{{ old('telp') }}">
                                    @error('telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- =================================== --}}
                                {{--          FIELD BARU BERAKHIR        --}}
                                {{-- =================================== --}}


                                {{-- Field Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label"><strong>Alamat Email:</strong></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Password --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label"><strong>Password:</strong></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Konfirmasi Password --}}
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label"><strong>Konfirmasi
                                            Password:</strong></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                                </div>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
