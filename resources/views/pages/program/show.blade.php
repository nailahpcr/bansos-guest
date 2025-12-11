{{-- resources/views/pages/program/show.blade.php --}}
@extends('layout.guest.app')

@section('title', 'Detail Program: ' . $program->nama_program)

@section('content')
<section id="detail-program" class="section">
    <div class="container">
        {{-- Tombol Kembali --}}
        @if(Route::currentRouteName() == 'kelola-program.show')
            <a href="{{ route('kelola-program.index') }}" class="btn btn-secondary mb-4">
        @else
            <a href="{{ route('home') }}" class="btn btn-secondary mb-4">
        @endif
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
            {{-- Kolom Kiri: Detail Program --}}
            <div class="{{ request()->routeIs('kelola-program.show') ? 'col-md-6' : 'col-12' }}">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-info-circle me-1"></i> Informasi Program
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Kode:</strong></td>
                                <td>{{ $program->kode }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tahun:</strong></td>
                                <td>{{ $program->tahun }}</td>
                            </tr>
                            <tr>
                                <td><strong>Anggaran:</strong></td>
                                <td>Rp {{ number_format($program->anggaran, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        
                        <h6 class="mt-3">Deskripsi:</h6>
                        <p>{{ $program->deskripsi }}</p>

                        {{-- Tombol Edit hanya untuk Admin --}}
                        @if(request()->routeIs('kelola-program.show'))
                            <a href="{{ route('kelola-program.edit', $program) }}" class="btn btn-warning mt-2">
                                <i class="fas fa-edit me-1"></i> Edit Program
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Upload hanya untuk Admin --}}
            @if(request()->routeIs('kelola-program.show'))
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-upload me-1"></i> Unggah Dokumen
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kelola-program.uploadMedia', $program) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file_program" class="form-label">Pilih File (Max 10MB)</label>
                                    <input type="file" class="form-control @error('file_program') is-invalid @enderror" 
                                           id="file_program" name="file_program" required>
                                    @error('file_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="caption" class="form-label">Keterangan (Opsional)</label>
                                    <input type="text" class="form-control" id="caption" name="caption" 
                                           placeholder="Contoh: Proposal, Laporan, dll.">
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-cloud-upload-alt me-1"></i> Unggah File
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        {{-- Daftar Media Terkait --}}
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-paperclip me-1"></i> 
                    Dokumen Terkait ({{ $media->count() }} file)
                </div>
                <small>Klik nama file untuk melihat/download</small>
            </div>
            <div class="card-body">
                @if ($media->isEmpty())
                    <p class="text-center text-muted py-4">
                        <i class="fas fa-folder-open fa-2x mb-3"></i><br>
                        Belum ada dokumen untuk program ini.
                    </p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Keterangan</th>
                                    <th>Tipe</th>
                                    <th>Ukuran</th>
                                    {{-- Kolom Aksi HANYA untuk Admin --}}
                                    @if(request()->routeIs('kelola-program.show'))
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($media as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ asset('storage/uploads/program_bantuan/' . $item->file_name) }}" 
                                               target="_blank" class="text-decoration-none">
                                                <i class="fas {{ Str::contains($item->mime_type, 'image') ? 'fa-image text-primary' : 'fa-file-alt text-secondary' }} me-2"></i>
                                                {{ $item->file_name }}
                                            </a>
                                        </td>
                                        <td>{{ $item->caption ?: '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item->mime_type }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $filePath = storage_path('app/public/uploads/program_bantuan/' . $item->file_name);
                                                $fileSize = file_exists($filePath) ? round(filesize($filePath) / 1024, 1) . ' KB' : '-';
                                            @endphp
                                            {{ $fileSize }}
                                        </td>
                                        {{-- Tombol Hapus HANYA untuk Admin --}}
                                        @if(request()->routeIs('show'))
                                            <td>
                                                <form action="{{ route('deleteMedia', $item->media_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Hapus file ini? Tindakan tidak dapat dibatalkan.')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

<style>
.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}
</style>
@endsection