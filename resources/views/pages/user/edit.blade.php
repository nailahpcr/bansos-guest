@extends('layout.guest.app')

@section('content')
    <section id="form-user-cta-section" class="cta-section pt-130 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb-50">
                        <h2>Edit Data User</h2>
                        <p class="mb-30">Ubah data user sesuai dengan informasi terbaru.</p>
                    </div>
                </div>
            </div>

            {{-- Menampilkan Error Validasi --}}
            @if($errors->any())
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <h4 class="alert-heading mb-0">Terjadi Kesalahan!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card card-shadow-sm p-5">
                        {{-- Form diarahkan ke route 'users.update' dengan method PUT/PATCH --}}
                        <form action="{{ route('user.update', $users) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nama --}}
                            <div class="mb-4">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $users->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $users->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <p class="text-muted">Kosongkan kolom password di bawah jika Anda tidak ingin mengubah password.</p>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Konfirmasi Password --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>

                            <button type="submit" class="main-btn btn-hover">Simpan Perubahan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection