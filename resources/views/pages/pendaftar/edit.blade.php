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
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- FORM UTAMA --}}
                            <form action="{{ route('pendaftar.update', $pendaftar->pendaftar_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Program --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Program Bantuan:</strong></label>
                                    <select name="program_id" class="form-select">
                                        @foreach ($programs as $prog)
                                            <option value="{{ $prog->program_id }}" {{ $pendaftar->program_id == $prog->program_id ? 'selected' : '' }}>
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
                                            <option value="{{ $w->warga_id }}" {{ $pendaftar->warga_id == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} - {{ $w->no_ktp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status & Keterangan --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Status:</strong></label>
                                        <select name="status_seleksi" class="form-select">
                                            @foreach(['Pending', 'Verifikasi', 'Diterima', 'Ditolak'] as $status)
                                                <option value="{{ $status }}" {{ $pendaftar->status_seleksi == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Keterangan:</strong></label>
                                        <input type="text" name="keterangan" class="form-control" value="{{ $pendaftar->keterangan }}">
                                    </div>
                                </div>

                                {{-- Upload Baru --}}
                                <div class="mb-4">
                                    <label class="form-label text-primary"><strong>Tambah File Pendukung:</strong></label>
                                    <input type="file" name="files[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="text-muted">Format: JPG, PNG, PDF. Bisa pilih lebih dari satu file.</small>
                                </div>

                                {{-- List File yang Sudah Ada --}}
                                @if ($pendaftar->file && $pendaftar->file->count() > 0)
                                    <div class="mb-4">
                                        <label class="form-label"><strong>Berkas Terlampir:</strong></label>
                                        <div class="list-group shadow-sm">
                                            @foreach ($pendaftar->file as $file)
                                                <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $ext = strtolower(pathinfo($file->filename, PATHINFO_EXTENSION));
                                                            $icon = in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image text-success' : 'fa-file-pdf text-danger';
                                                        @endphp
                                                        <i class="fas {{ $icon }} me-3 fs-4"></i>
                                                        <div>
                                                            <div class="fw-bold text-dark">{{ $file->filename }}</div>
                                                            <small class="text-muted uppercase">{{ strtoupper($ext) }} • {{ number_format($file->size / 1024, 2) }} KB</small>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        {{-- Button ini memicu form di luar tag form utama --}}
                                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="if(confirm('Hapus file ini?')) { document.getElementById('delete-file-{{ $file->id }}').submit(); }">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between mt-5 border-top pt-3">
                                    <a class="btn btn-secondary" href="{{ route('pendaftar.index') }}">Kembali</a>
                                    <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                                </div>
                            </form>
                            {{-- AKHIR FORM UTAMA --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FORM TERSEMBUNYI UNTUK HAPUS FILE (Diletakkan di luar form utama agar tidak nested) --}}
    @if ($pendaftar->file)
        @foreach ($pendaftar->file as $file)
            <form id="delete-file-{{ $file->id }}" action="{{ route('pendaftar.files.destroy', $file->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif

@endsection