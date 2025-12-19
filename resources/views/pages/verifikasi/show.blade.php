@extends('layout.guest.app')

@section('title', 'Detail Verifikasi: ' . $verifikasi->nama_penerima)

@section('content')
    <section id="detail-verifikasi" class="section">
        <div class="container">
            {{-- Tombol Kembali --}}
            <a href="{{ route('verifikasi.index') }}" class="btn btn-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>

            <h2>Detail Verifikasi Lapangan</h2>
            <p class="text-muted">Verifikasi untuk Program: <strong>{{ $verifikasi->program->nama_program ?? '-' }}</strong></p>
            <hr>

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                {{-- Kolom Kiri: Informasi Utama --}}
                <div class="col-lg-12">
                    
                    {{-- Card 1: Detail Data Verifikasi --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-clipboard-check me-1"></i> Data Verifikasi & Penerima
                            </div>
                            {{-- Tombol Edit Status/Data jika diperlukan --}}
                            @if (request()->routeIs('verifikasi.show'))
                                <a href="{{ route('verifikasi.edit', $verifikasi->id) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                                    <i class="fas fa-edit me-1"></i> Update Status
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title text-muted mb-3">Informasi Penerima</h5>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td style="width: 140px;"><strong>Nama Penerima:</strong></td>
                                            <td>{{ $verifikasi->nama_penerima }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIK:</strong></td>
                                            <td>{{ $verifikasi->nik }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td>{{ $verifikasi->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. Telepon:</strong></td>
                                            <td>{{ $verifikasi->no_telepon ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title text-muted mb-3">Status & Surveyor</h5>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td style="width: 140px;"><strong>Tanggal Survei:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($verifikasi->tanggal_verifikasi)->translatedFormat('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Surveyor:</strong></td>
                                            <td>{{ $verifikasi->user->name ?? 'Admin' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($verifikasi->status == 'disetujui' || $verifikasi->status == 'layak')
                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Layak / Disetujui</span>
                                                @elseif($verifikasi->status == 'ditolak' || $verifikasi->status == 'tidak_layak')
                                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Tidak Layak</span>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Catatan:</strong></td>
                                            <td>{{ $verifikasi->catatan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Bukti Lapangan (Media) --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-camera me-1"></i> Bukti Lapangan ({{ $media->count() }} file)
                            </div>
                            @if (request()->routeIs('verifikasi.show'))
                                <button type="button" class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <i class="fas fa-upload me-1"></i> Unggah Bukti
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            @if ($media->isEmpty())
                                <p class="text-center text-muted py-4">
                                    <i class="fas fa-images fa-2x mb-3"></i><br>
                                    Belum ada bukti foto/dokumen untuk verifikasi ini.
                                </p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Preview</th>
                                                <th>Keterangan</th>
                                                <th>Tipe/Ukuran</th>
                                                @if (request()->routeIs('verifikasi.show'))
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
                                                            {{-- Asumsi path penyimpanan ada di folder 'verifikasi' --}}
                                                            @php $imagePath = storage_path('app/public/uploads/verifikasi/' . $item->file_name); @endphp
                                                            @if(file_exists($imagePath))
                                                                <img src="{{ asset('storage/uploads/verifikasi/' . $item->file_name) }}" 
                                                                     alt="{{ $item->caption }}" 
                                                                     style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" 
                                                                     class="rounded border img-thumbnail"
                                                                     onclick="window.open('{{ asset('storage/uploads/verifikasi/' . $item->file_name) }}', '_blank')">
                                                            @else
                                                                <i class="fas fa-image text-muted fa-2x"></i>
                                                            @endif
                                                        @else
                                                            <a href="{{ asset('storage/uploads/verifikasi/' . $item->file_name) }}" target="_blank" class="text-decoration-none text-primary">
                                                                <i class="fas fa-file-pdf fa-2x"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->caption ?: '-' }}</td>
                                                    <td>
                                                        <span class="badge bg-light text-dark mb-1">{{ $item->mime_type }}</span><br>
                                                        <small class="text-muted">
                                                            @php
                                                                $filePath = storage_path('app/public/uploads/verifikasi/' . $item->file_name);
                                                                echo file_exists($filePath) ? round(filesize($filePath) / 1024, 1) . ' KB' : '-';
                                                            @endphp
                                                        </small>
                                                    </td>
                                                    @if (request()->routeIs('verifikasi.show'))
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                {{-- Edit --}}
                                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMediaModal{{ $item->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                {{-- Hapus --}}
                                                                <form action="{{ route('verifikasi.deleteMedia', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus bukti ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
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
            </div>
        </div>
    </section>

    {{-- Styling CSS (Sama dengan Program) --}}
    <style>
        .table th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; }
        .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, .02); }
        .btn-sm i { font-size: 0.875rem; }
        .btn-outline-primary:hover, .btn-outline-primary:focus { background-color: #0d6efd; color: white; }
        .btn-outline-danger:hover, .btn-outline-danger:focus { background-color: #dc3545; color: white; }
        .btn-group .btn { padding: 0.25rem 0.5rem; }
    </style>

    {{-- Modal Upload Bukti --}}
    @if (request()->routeIs('verifikasi.show'))
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-cloud-upload-alt me-2"></i> Unggah Bukti Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('verifikasi.uploadMedia', $verifikasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Foto/Dokumen</label>
                            <input type="file" class="form-control" name="file_bukti" accept="image/*,application/pdf" required>
                            <div class="form-text">Format: JPG, PNG, PDF. Max 10MB.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="caption" placeholder="Contoh: Foto Rumah Depan, KTP, dll.">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Edit Caption Media --}}
    @if (request()->routeIs('verifikasi.show'))
        @foreach ($media as $item)
            <div class="modal fade" id="editMediaModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Keterangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('verifikasi.updateMedia', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan Bukti</label>
                                    <input type="text" class="form-control" name="caption" value="{{ $item->caption }}" placeholder="Masukkan keterangan">
                                    <div class="form-text">File: {{ $item->file_name }}</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Script Konfirmasi Hapus & Validasi File --}}
    @if (request()->routeIs('verifikasi.show'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfirmasi Hapus yang lebih aman
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                form.onsubmit = function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus bukti ini? Tindakan ini tidak dapat dibatalkan.')) {
                        this.submit();
                    }
                };
            });

            // Validasi ukuran file client-side
            const fileInput = document.querySelector('input[name="file_bukti"]');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.size > 10 * 1024 * 1024) { // 10MB
                        alert('Ukuran file terlalu besar (Max 10MB).');
                        this.value = '';
                    }
                });
            }
        });
    </script>
    @endif

@endsection