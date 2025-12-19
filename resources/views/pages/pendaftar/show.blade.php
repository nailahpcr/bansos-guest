@extends('layout.guest.app')

@section('title', 'Detail Pendaftar')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Detail Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Informasi Pendaftaran</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Detail lengkap pendaftaran warga di program bantuan.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5><strong>Informasi Warga:</strong></h5>
                                    <p><i class="fas fa-user me-2 text-primary"></i> {{ $pendaftar->warga->nama ?? '-' }}</p>
                                    <p><i class="fas fa-id-card me-2 text-primary"></i> {{ $pendaftar->warga->no_ktp ?? '-' }}</p>
                                    <p><i class="fas fa-phone me-2 text-primary"></i> {{ $pendaftar->warga->no_hp ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5><strong>Informasi Program:</strong></h5>
                                    <p><i class="fas fa-box-open me-2 text-success"></i> {{ $pendaftar->program->nama_program ?? '-' }}</p>
                                    <p><i class="fas fa-calendar me-2 text-success"></i> {{ $pendaftar->program->tahun ?? '-' }}</p>
                                    <p><i class="fas fa-info-circle me-2 text-warning"></i> 
                                        <span class="badge rounded-pill 
                                            {{ $pendaftar->status == 'Diterima' ? 'bg-success' : ($pendaftar->status == 'Ditolak' ? 'bg-danger' : 'bg-secondary') }}">
                                            {{ $pendaftar->status }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            @if($pendaftar->files && $pendaftar->files->count() > 0)
                                <div class="mb-4">
                                    <h5><strong>File Pendukung:</strong></h5>
                                    <div class="list-group">
                                        @foreach($pendaftar->files as $file)
                                            <div class="list-group-item d-flex justify-content-between align-items-center" >

                                                <div class="d-flex align-items-center">
                                                    @if($file->isImage())
                                                    <img src="{{ asset('storage/' . $file->path) }}" 
                                                             alt="{{ $file->filename }}" 
                                                             class="img-thumbnail me-3" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                             <i class="fas fa-image text-primary me-1"></i>
                                                             @elseif($file->mime_type == 'application/pdf')
                                                             <i class="fas fa-file-pdf text-danger me-3 fs-5"></i>
                                                    @elseif(str_contains($file->mime_type, 'word') || str_contains($file->mime_type, 'document'))
                                                        <i class="fas fa-file-word text-primary me-3 fs-5"></i>
                                                    @elseif(str_contains($file->mime_type, 'excel') || str_contains($file->mime_type, 'spreadsheet'))
                                                        <i class="fas fa-file-excel text-success me-3 fs-5"></i>
                                                    @else
                                                    <i class="fas fa-file me-3 fs-5"></i>
                                                    @endif
                                                    
                                                    
                                                    <div>
                                                        <div class="fw-bold">{{ $file->filename }}</div>
                                                        <small class="text-muted">
                                                            {{ $file->created_at->format('d/m/Y H:i') }} • 
                                                            {{ number_format($file->size / 1024, 2) }} KB
                                                        </small>
                                                    </div>
                                                </div>
                                                
                                                <div class="btn-group">
                                                    <a href="{{ asset('storage/' . $file->path) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                    <a href="{{ asset('storage/' . $file->path) }}" 
                                                       download="{{ $file->filename }}"
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($pendaftar->keterangan)
                                <div class="mb-4">
                                    <h5><strong>Keterangan:</strong></h5>
                                    <div class="alert alert-info">
                                        {{ $pendaftar->keterangan }}
                                    </div>
                                </div>
                            @endif

                            <div class="text-center mt-4">
                                <a class="btn btn-secondary" href="{{ route('pendaftar.index') }}">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                                </a>
                                <a class="btn btn-warning" href="{{ route('pendaftar.edit', $pendaftar->pendaftar_id) }}">
                                    <i class="fas fa-edit me-1"></i> Edit Data
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection