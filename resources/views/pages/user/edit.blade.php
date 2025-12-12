@extends('layout.guest.app')

@section('title', 'Edit Data User')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen User</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Edit Data Pengguna</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui informasi akun pengguna yang terdaftar.</p>
                    </div>
                </div>
            </div>

            {{-- FORM EDIT --}}
            <div class="row justify-content-center wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            {{-- Error Handling --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Form Start --}}
                            {{-- Pastikan parameter route sesuai dengan controller Anda ($users atau $user) --}}
                            <form action="{{ route('user.update', $users->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Baris 1: Nama & Email --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $users->name) }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $users->email) }}" required>
                                    </div>
                                </div>


                                {{-- Divider untuk Password --}}
                                <div class="alert alert-light border mt-2 mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Kosongkan kolom password di bawah jika tidak ingin mengubahnya.
                                    </small>
                                </div>

                                {{-- Baris 2: Password & Konfirmasi --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="********">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="********">
                                    </div>
                                </div>

                                {{-- Tombol Aksi (Style Warga) --}}
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('edit_profile_picture')?.addEventListener('change', function (e) {
        const [file] = this.files;
        if (file) {
            document.getElementById('editPreview').src = URL.createObjectURL(file);
        }
    });
</script>
@endpush
