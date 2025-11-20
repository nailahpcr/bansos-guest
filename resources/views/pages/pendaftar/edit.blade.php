@extends('layout.guest.app')

@section('title', 'Edit Pendaftar')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Edit Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Ubah Status Pendaftaran</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui data pendaftaran warga di program bantuan.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4">

                            <form action="{{ route('pendaftar.update', $pendaftar->pendaftar_id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Program (Readonly jika tidak ingin dipindah, atau select jika boleh dipindah) --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Program Bantuan:</strong></label>
                                    <select name="program_id" class="form-select">
                                        @foreach ($programs as $prog)
                                            <option value="{{ $prog->program_id }}"
                                                {{ $pendaftar->program_id == $prog->program_id ? 'selected' : '' }}>
                                                {{ $prog->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Warga --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Nama Warga:</strong></label>
                                    <select name="warga_id" class="form-select">
                                        @foreach ($wargas as $w)
                                            <option value="{{ $w->warga_id }}"
                                                {{ $pendaftar->warga_id == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} - {{ $w->no_ktp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status & Keterangan --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Status:</strong></label>
                                        <select name="status" class="form-select">
                                            <option value="Pending" {{ $pendaftar->status == 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="Verifikasi"
                                                {{ $pendaftar->status == 'Verifikasi' ? 'selected' : '' }}>Verifikasi
                                            </option>
                                            <option value="Diterima"
                                                {{ $pendaftar->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="Ditolak"
                                                {{ $pendaftar->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Keterangan:</strong></label>
                                        <input type="text" name="keterangan" class="form-control"
                                            value="{{ $pendaftar->keterangan }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a class="btn btn-secondary" href="{{ route('pendaftar.index') }}">Kembali</a>
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
