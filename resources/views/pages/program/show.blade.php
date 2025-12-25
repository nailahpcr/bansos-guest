@extends('layout.guest.app')

@section('title', 'Detail Program: ' . $program->nama_program)

@section('content')
    <section id="detail-program" class="section">
        <div class="container">
            {{-- Tombol Kembali --}}
            <a href="{{ Route::currentRouteName() == 'kelola-program.show' ? route('kelola-program.index') : route('home') }}" class="btn btn-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

            <h2>Detail Program Bantuan: {{ $program->nama_program }}</h2>
            <hr>

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                {{-- Sisi Kiri: Detail Informasi --}}
                <div class="col-md-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-info-circle me-1"></i> Detail Informasi</span>
                            @if (request()->routeIs('kelola-program.show'))
                                <a href="{{ route('kelola-program.edit', $program) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit Program
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr><th width="30%">Nama Program</th><td>: {{ $program->nama_program }}</td></tr>
                                <tr><th>Kode</th><td>: {{ $program->kode }}</td></tr>
                                <tr><th>Tahun</th><td>: {{ $program->tahun }}</td></tr>
                                <tr><th>Anggaran</th><td>: Rp {{ number_format($program->anggaran, 0, ',', '.') }}</td></tr>
                                <tr><th>Deskripsi</th><td>: {{ $program->deskripsi }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Lampiran File tunggal --}}
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-paperclip me-1"></i> Lampiran File
                        </div>
                        <div class="card-body text-center">
                            @if($program->file) 
                                @php
                                    $extension = pathinfo($program->file, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $filePath = asset('storage/' . $program->file);
                                @endphp

                                @if($isImage)
                                    <div class="mb-3">
                                        <img src="{{ $filePath }}" class="img-fluid rounded border shadow-sm" style="max-height: 250px; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="mb-3 py-3">
                                        <i class="fas fa-file-alt fa-4x text-secondary mb-2"></i>
                                        <p class="small text-muted text-break">{{ $program->file }}</p>
                                    </div>
                                @endif

                                <div class="d-grid gap-2">
                                    <a href="{{ $filePath }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i> Lihat File
                                    </a>
                                    
                                    @if (request()->routeIs('kelola-program.show'))
                                        {{-- Menggunakan route update untuk menghapus file --}}
                                        <form action="{{ route('kelola-program.update', $program) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                            @csrf
                                            @method('PUT')
                                            {{-- Field wajib agar tidak kena validasi di controller --}}
                                            <input type="hidden" name="nama_program" value="{{ $program->nama_program }}">
                                            <input type="hidden" name="kode" value="{{ $program->kode }}">
                                            <input type="hidden" name="tahun" value="{{ $program->tahun }}">
                                            <input type="hidden" name="anggaran" value="{{ $program->anggaran }}">
                                            
                                            {{-- Flag untuk memberitahu controller bahwa file ingin dihapus --}}
                                            <input type="hidden" name="hapus_file" value="1">
                                            
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash me-1"></i> Hapus File
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="py-5">
                                    <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                                    <p class="text-muted small">Belum ada file terlampir</p>
                                    @if (request()->routeIs('kelola-program.show'))
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                            <i class="fas fa-upload me-1"></i> Unggah File
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Upload --}}
    @if (request()->routeIs('kelola-program.show'))
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelola-program.update', $program) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        {{-- Field wajib --}}
                        <input type="hidden" name="nama_program" value="{{ $program->nama_program }}">
                        <input type="hidden" name="kode" value="{{ $program->kode }}">
                        <input type="hidden" name="tahun" value="{{ $program->tahun }}">
                        <input type="hidden" name="anggaran" value="{{ $program->anggaran }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Pilih File (Gambar/Dokumen)</label>
                            <input type="file" name="file" class="form-control" required>
                            <div class="form-text">Maksimal 10MB</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Lampiran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection