@extends('layout.guest.app')

@section('title', 'Tambah Pendaftar')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Pendaftaran Baru</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftarkan Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Hubungkan warga dengan program bantuan yang tersedia.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('pendaftar.store') }}" method="POST">
                                @csrf

                                {{-- Pilih Program --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Pilih Program Bantuan:</strong></label>
                                    <select name="program_id" class="form-select" required>
                                        <option value="">-- Pilih Program --</option>
                                        @foreach ($programs as $prog)
                                            <option value="{{ $prog->program_id }}">{{ $prog->nama_program }}
                                                ({{ $prog->tahun }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pilih Warga --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Pilih Warga:</strong></label>
                                    <select name="warga_id" class="form-select" required>
                                        <option value="">-- Pilih Warga --</option>
                                        @foreach ($wargas as $w)
                                            <option value="{{ $w->warga_id }}">{{ $w->nama }} - {{ $w->no_ktp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status & Keterangan --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Status Awal:</strong></label>
                                        <select name="status" class="form-select">
                                            <option value="Pending">Pending</option>
                                            <option value="Verifikasi">Verifikasi</option>
                                            <option value="Diterima">Diterima</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Keterangan (Opsional):</strong></label>
                                        <input type="text" name="keterangan" class="form-control"
                                            placeholder="Catatan tambahan...">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a class="btn btn-secondary" href="{{ route('pendaftar.index') }}">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
