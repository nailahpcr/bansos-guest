@extends('layout.guest.app')

@section('title', 'Detail Program: ' . $program->nama_program)

@section('content')
    <section id="detail-program" class="section">
        <div class="container">
            {{-- Tombol Kembali --}}
            @if (Route::currentRouteName() == 'kelola-program.show')
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
                <div class="col-12">
                    {{-- Tabel Detail Program --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle me-1"></i> Detail 
                            </div>
                            @if (request()->routeIs('kelola-program.show'))
                                <a href="{{ route('kelola-program.edit', $program) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                                    <i class="fas fa-edit me-1"></i> Edit Program
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama Program:</strong></td>
                                    <td>{{ $program->nama_program }}</td>
                                </tr>
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
                                <tr>
                                    <td><strong>Deskripsi:</strong></td>
                                    <td>{{ $program->deskripsi }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Tabel Media Terkait --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-paperclip me-1"></i> Dokumen Terkait ({{ $media->count() }} file)
                            </div>
                            @if (request()->routeIs('kelola-program.show'))
                                <button type="button" class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <i class="fas fa-upload me-1"></i> Unggah Gambar
                                </button>
                            @endif
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
                                                <th>Gambar</th>
                                                <th>Keterangan</th>
                                                <th>Tipe</th>
                                                <th>Ukuran</th>
                                                @if (request()->routeIs('kelola-program.show'))
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($media as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if(Str::contains($item->mime_type, 'image'))
                                                            @php $imagePath = storage_path('app/public/uploads/program_bantuan/' . $item->file_name); @endphp
                                                            @if(file_exists($imagePath))
                                                                <img src="{{ asset('storage/uploads/program_bantuan/' . $item->file_name) }}" 
                                                                     alt="{{ $item->caption ?: 'Gambar' }}" 
                                                                     style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" 
                                                                     onclick="window.open('{{ asset('storage/uploads/program_bantuan/' . $item->file_name) }}', '_blank')"
                                                                     class="rounded border">
                                                            @else
                                                                <i class="fas fa-image text-muted fa-2x"></i> (File tidak ditemukan)
                                                            @endif
                                                        @else
                                                            @php $filePathCheck = storage_path('app/public/uploads/program_bantuan/' . $item->file_name); @endphp
                                                            @if(file_exists($filePathCheck))
                                                                <a href="{{ asset('storage/uploads/program_bantuan/' . $item->file_name) }}" 
                                                                   target="_blank" 
                                                                   class="text-decoration-none text-primary">
                                                                    <i class="fas fa-file-alt fa-2x"></i>
                                                                </a>
                                                            @else
                                                                <i class="fas fa-file-alt text-muted fa-2x"></i> (File tidak ditemukan)
                                                            @endif
                                                        @endif
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
                                                    @if (request()->routeIs('kelola-program.show'))
                                                        @if($item->media_id)
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Aksi file">
                                                                {{-- Tombol Edit Media --}}
                                                                <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editMediaModal{{ $item->media_id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                
                                                                {{-- Tombol Hapus Media --}}
                                                                <form action="{{ route('kelola-program.deleteMedia', $item->media_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <td>-</td>
                                                        @endif
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
            </div>

        </div>
    </section>

    <style>
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .02);
        }
        
        /* Styling untuk tombol dengan ikon */
        .btn-sm i {
            font-size: 0.875rem;
        }
        
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background-color: #0d6efd;
            color: white;
        }
        
        .btn-outline-danger:hover, .btn-outline-danger:focus {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        
        /* Styling untuk preview gambar */
        .img-preview {
            transition: transform 0.2s;
            border: 2px solid #dee2e6;
        }
        
        .img-preview:hover {
            transform: scale(1.05);
            border-color: #0d6efd;
        }
        
        /* Styling untuk badge tipe file */
        .badge.bg-light {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    </style>

    {{-- Modal Upload --}}
    @if (request()->routeIs('kelola-program.show'))
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">
                        <i class="fas fa-cloud-upload-alt me-2"></i> Unggah Gambar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelola-program.uploadMedia', $program) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_program" class="form-label">
                                <i class="fas fa-file-image me-1"></i> Pilih Gambar (Max 10MB)
                            </label>
                            <input type="file" class="form-control @error('file_program') is-invalid @enderror" id="file_program" name="file_program" accept="image/*" required>
                            @error('file_program')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i> Format yang didukung: JPG, PNG, GIF
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="caption" class="form-label">
                                <i class="fas fa-comment me-1"></i> Keterangan (Opsional)
                            </label>
                            <input type="text" class="form-control" id="caption" name="caption" placeholder="Contoh: Foto Kegiatan, dll.">
                            <div class="form-text">
                                <i class="fas fa-lightbulb me-1"></i> Berikan deskripsi singkat tentang gambar
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success d-flex align-items-center">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Unggah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Edit Media --}}
    @if (request()->routeIs('kelola-program.show'))
        @foreach ($media as $item)
            @if($item->media_id)
                <div class="modal fade" id="editMediaModal{{ $item->media_id }}" tabindex="-1" aria-labelledby="editMediaModalLabel{{ $item->media_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMediaModalLabel{{ $item->media_id }}">
                                    <i class="fas fa-edit me-2"></i> Edit Keterangan Gambar
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('kelola-program.updateMedia', $item->media_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="caption_{{ $item->media_id }}" class="form-label">
                                            <i class="fas fa-comment me-1"></i> Keterangan Gambar
                                        </label>
                                        <input type="text" class="form-control" id="caption_{{ $item->media_id }}" name="caption" value="{{ $item->caption ?: '' }}" placeholder="Masukkan keterangan gambar">
                                        <div class="form-text">
                                            <i class="fas fa-image me-1"></i> File: {{ $item->file_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    {{-- Script untuk konfirmasi hapus yang lebih baik --}}
    @if (request()->routeIs('kelola-program.show'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan event listener untuk semua form hapus
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                const originalOnsubmit = form.onsubmit;
                form.onsubmit = function(e) {
                    e.preventDefault();
                    
                    // Ambil nama file dari baris tabel
                    const fileName = form.closest('tr').querySelector('td:nth-child(3)').textContent.trim();
                    
                    // Tampilkan SweetAlert atau konfirmasi custom
                    if (confirm(`Apakah Anda yakin ingin menghapus file "${fileName || 'ini'}"?`)) {
                        form.submit();
                    }
                };
            });
            
            // Preview gambar sebelum upload
            const fileInput = document.getElementById('file_program');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                        if (fileSize > 10) {
                            alert('Ukuran file melebihi 10MB. Silakan pilih file yang lebih kecil.');
                            fileInput.value = '';
                        }
                    }
                });
            }
        });
    </script>
    @endif
@endsection