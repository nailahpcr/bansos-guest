@extends('layout.guest.app')

@section('title', 'Detail Verifikasi Lapangan')

@section('content')
<style>
    #features {
        background: linear-gradient(to bottom, #FFD1DC 0%, #B2E2F2 100%);
        min-height: 100vh;
        background-attachment: fixed;
    }
    .section-title h3 { color: #ff5876; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; }
    .section-title h2 { color: #2d3436; font-weight: 800; }
    .card { border-radius: 20px !important; transition: all 0.3s ease; }
    .text-primary { color: #4834d4 !important; }
    .text-success { color: #20bf6b !important; }
    .border-end { border-right: 2px dashed #dfe6e9 !important; }
    .list-group-item { background-color: #ffffff; margin-bottom: 8px; border-radius: 12px !important; border: 1px solid #eee !important; transition: all 0.2s ease; cursor: pointer; }
    .list-group-item.active { background: linear-gradient(45deg, #4834d4, #686de0) !important; border-color: transparent !important; color: white !important; }
    .list-group-item.active small { color: #eee !important; }
    #viewer-container { background: #2d3436 !important; border-radius: 12px; min-height: 500px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .btn-primary { background: linear-gradient(45deg, #4834d4, #686de0); border: none; }
    @media (max-width: 768px) { .border-end { border-right: none !important; border-bottom: 2px dashed #dfe6e9 !important; margin-bottom: 20px; } }
</style>

<section id="features" class="features section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <div class="section-title">
                    <h3>Hasil Verifikasi</h3>
                    <h2>Detail Verifikasi Lapangan</h2>
                    <p>Informasi hasil peninjauan petugas dan berkas bukti di lapangan.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        {{-- ATAS: Info Utama --}}
                        <div class="p-4 border-bottom bg-white">
                            <div class="row">
                                <div class="col-md-6 border-end">
                                    <h5 class="text-primary fw-bold mb-3"><i class="fas fa-user-check me-2"></i>Data Pendaftar</h5>
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td width="35%" class="text-muted">Nama Warga</td>
                                            <td>: <strong>{{ $verifikasi->pendaftar->warga->nama ?? '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Program</td>
                                            <td>: {{ $verifikasi->pendaftar->program->nama_program ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">NIK</td>
                                            <td>: {{ $verifikasi->pendaftar->warga->no_ktp ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6 ps-md-4">
                                    <h5 class="text-success fw-bold mb-3"><i class="fas fa-clipboard-list me-2"></i>Hasil Lapangan</h5>
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td width="35%" class="text-muted">Skor Kelayakan</td>
                                            <td>: <span class="badge bg-primary fs-6">{{ $verifikasi->skor }} Poin</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Petugas</td>
                                            <td>: {{ $verifikasi->petugas }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tanggal Cek</td>
                                            <td>: {{ \Carbon\Carbon::parse($verifikasi->tanggal)->format('d F Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- BAWAH: Lampiran --}}
                        <div class="p-4 bg-light">
                            <h5 class="fw-bold mb-4"><i class="fas fa-images me-2 text-primary"></i>Dokumentasi & Bukti Lapangan</h5>

                            @if ($verifikasi->files && $verifikasi->files->count() > 0)
                                <div class="row">
                                    {{-- List File --}}
                                    <div class="col-md-4">
                                        <div class="list-group shadow-sm">
                                            @foreach ($verifikasi->files as $file)
                                                @php
                                                    $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                                                @endphp
                                                <button type="button" 
                                                    class="list-group-item list-group-item-action d-flex align-items-center py-3 file-item {{ $loop->first ? 'active' : '' }}"
                                                    onclick="previewFile('{{ asset('storage/' . $file->path) }}', '{{ $ext }}', this)">
                                                    <i class="fas {{ $isImage ? 'fa-image text-info' : 'fa-file-pdf text-danger' }} fa-lg me-3"></i>
                                                    <div class="text-truncate">
                                                        <small class="d-block fw-bold text-truncate">{{ $file->filename }}</small>
                                                        <small class="text-muted text-uppercase" style="font-size: 0.7rem;">{{ $ext }} File</small>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Viewer Area --}}
                                    <div class="col-md-8 mt-3 mt-md-0">
                                        <div class="card border-0 shadow-sm overflow-hidden h-100">
                                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                                <span class="small fw-bold text-uppercase text-muted">Preview Bukti</span>
                                                <a id="downloadBtn" href="{{ asset('storage/' . $verifikasi->files[0]->path) }}" download class="btn btn-sm btn-primary rounded-pill px-3">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                            </div>
                                            <div class="card-body p-0" id="viewer-container">
                                                {{-- Pratinjau default file pertama --}}
                                                @php
                                                    $firstFile = $verifikasi->files[0];
                                                    $firstExt = strtolower(pathinfo($firstFile->path, PATHINFO_EXTENSION));
                                                @endphp

                                                @if (in_array($firstExt, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/' . $firstFile->path) }}" class="img-fluid" style="max-height: 500px;">
                                                @elseif($firstExt == 'pdf')
                                                    <embed src="{{ asset('storage/' . $firstFile->path) }}" type="application/pdf" width="100%" height="500px">
                                                @else
                                                    <div class="text-white text-center">
                                                        <i class="fas fa-file-alt fa-4x mb-2"></i>
                                                        <p>Pratinjau tidak tersedia</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
                                    <i class="fas fa-camera-retro fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Belum ada foto dokumentasi lapangan yang diunggah.</h6>
                                </div>
                            @endif
                        </div>

                        {{-- FOOTER --}}
                        <div class="card-footer bg-white p-4 d-flex justify-content-center gap-3">
                            <a class="btn btn-secondary px-5 rounded-pill fw-bold" href="{{ route('verifikasi.index') }}">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <a class="btn btn-warning px-5 rounded-pill fw-bold" href="{{ route('verifikasi.edit', $verifikasi->verifikasi_id) }}">
                                <i class="fas fa-edit me-2"></i> Edit Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function previewFile(url, ext, element) {
        const container = document.getElementById('viewer-container');
        const downloadBtn = document.getElementById('downloadBtn');

        // Toggle class active
        document.querySelectorAll('.file-item').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');

        // Update Download Link
        downloadBtn.setAttribute('href', url);

        // Update Viewer Content
        const extension = ext.toLowerCase();
        if (['jpg', 'jpeg', 'png', 'webp'].includes(extension)) {
            container.innerHTML = `<img src="${url}" class="img-fluid" style="max-height: 500px; animation: fadeIn 0.5s;">`;
        } else if (extension === 'pdf') {
            container.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="500px">`;
        } else {
            container.innerHTML = `
                <div class="text-white text-center p-5">
                    <i class="fas fa-file-alt fa-5x mb-3"></i>
                    <h5>Format .${ext.toUpperCase()}</h5>
                    <p>Klik tombol download untuk melihat file.</p>
                </div>`;
        }
    }
</script>
@endsection