@extends('layout.guest.app')

@section('title', 'Tambah Penerima')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Penyaluran Bantuan</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah Penerima</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Tetapkan warga yang berhak menerima bantuan dari program yang tersedia.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4">

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

                            <form action="{{ route('penerima.store') }}" method="POST">
                                @csrf

                                {{-- Pilih Warga --}}
                                <div class="mb-4">
                                    <label class="form-label"><strong>Pilih Warga Penerima:</strong></label>
                                    <select name="warga_id" class="form-select" required>
                                        <option value="">-- Cari Nama Warga --</option>
                                        @foreach ($warga as $w)
                                            {{-- Menggunakan $w->id sesuai kode asli penerima Anda --}}
                                            <option value="{{ $w->id }}" {{ old('warga_id') == $w->id ? 'selected' : '' }}>
                                                {{ $w->nama }} (NIK: {{ $w->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pilih Program --}}
                                <div class="mb-4">
                                    <label class="form-label"><strong>Pilih Program Bantuan:</strong></label>
                                    <select name="program_id" class="form-select" required>
                                        <option value="">-- Pilih Program --</option>
                                        @foreach ($program as $p)
                                            <option value="{{ $p->program_id }}" {{ old('program_id') == $p->program_id ? 'selected' : '' }}>
                                                {{ $p->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Keterangan --}}
                                <div class="mb-4">
                                    <label class="form-label"><strong>Keterangan (Opsional):</strong></label>
                                    <textarea name="keterangan" class="form-control" rows="4" 
                                              placeholder="Tambahkan catatan penyaluran bantuan disini...">{{ old('keterangan') }}</textarea>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="d-flex justify-content-between mt-5">
                                    <a class="btn btn-secondary px-4 rounded-pill" href="{{ route('penerima.index') }}">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                        <i class="fas fa-save me-2"></i> Simpan Data
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