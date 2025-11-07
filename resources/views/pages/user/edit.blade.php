@extends('layout.guest.app')
@section('title', 'Edit Pengguna')
@section('content')

<section id="features" class="features section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Formulir Pengguna</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Edit Data: {{ $user->name }}</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui detail pengguna pada formulir di bawah ini.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT') 
                            <div class="mb-3">
                                <label for="name" class="form-label"><strong>Nama Lengkap:</strong></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"><strong>Alamat Email:</strong></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="alert alert-info">
                                <small>Kosongkan password jika tidak ingin mengubahnya.</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label"><strong>Password Baru:</strong></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label"><strong>Konfirmasi Password Baru:</strong></label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update Pengguna</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
