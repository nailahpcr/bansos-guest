@extends('layout.guest.app')

@section('title', 'Edit Data Warga')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Edit Data Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Ubah informasi data warga yang terdaftar.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                               value="{{ old('nama', $warga->nama) }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="no_ktp" class="form-label">No. KTP</label>
                                        <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                               value="{{ old('no_ktp', $warga->no_ktp) }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="agama" class="form-label">Agama</label>
                                        <select class="form-select" id="agama" name="agama" required>
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam" {{ old('agama', $warga->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama', $warga->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama', $warga->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama', $warga->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama', $warga->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama', $warga->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="telp" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="telp" name="telp"
                                           value="{{ old('telp', $warga->telp) }}">
                                    <div class="form-text">Opsional - biarkan kosong jika tidak ada</div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('warga.index') }}" class="btn btn-secondary">
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
