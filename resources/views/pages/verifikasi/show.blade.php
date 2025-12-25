@extends('layout.guest.app')

@section('title', 'Detail Verifikasi: ' . ($verifikasi->warga->nama ?? 'Data'))

@section('content')
    <section id="detail-verifikasi" class="section">
        <div class="container">
            {{-- Tombol Kembali --}}
            <a href="{{ route('verifikasi.index') }}" class="btn btn-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>

            <h2>Detail Verifikasi Lapangan</h2>
            <p class="text-muted">Verifikasi untuk Program:
                <strong>{{ $verifikasi->pendaftar->program->nama_program ?? '-' }}</strong></p>
            <hr>

            <div class="row">
                <div class="col-lg-12">

                    {{-- Card 1: Detail Data Verifikasi --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-clipboard-check me-1"></i> Data Verifikasi & Penerima
                            </div>
                            <a href="{{ route('verifikasi.edit', $verifikasi->verifikasi_id) }}"
                                class="btn btn-warning btn-sm d-flex align-items-center">
                                <i class="fas fa-edit me-1"></i> Update Data
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title text-muted mb-3">Informasi Penerima</h5>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td style="width: 140px;"><strong>Nama Penerima:</strong></td>
                                            <td>{{ $verifikasi->pendaftar->warga->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIK:</strong></td>
                                            <td>{{ $verifikasi->pendaftar->warga->no_ktp ?? '-' }}</td>
                                        </tr>
                                       
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title text-muted mb-3">Hasil Verifikasi</h5>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td style="width: 140px;"><strong>Petugas:</strong></td>
                                            <td>{{ $verifikasi->petugas }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($verifikasi->tanggal)->translatedFormat('d F Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Skor:</strong></td>
                                            <td><span class="badge bg-info text-dark">{{ $verifikasi->skor }} Poin</span>
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

                    {{-- Card 2: Bukti Lapangan (Foto tunggal dari kolom file) --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3">Dokumentasi Hasil Lapangan</h5>
                            @if ($verifikasi->file && is_array($verifikasi->file))
                                <div class="row g-3">
                                    @foreach ($verifikasi->file as $img)
                                        <div class="col-md-4 col-6">
                                            <div class="card border-0 shadow-sm overflow-hidden">
                                                <a href="{{ asset('storage/' . $img) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid"
                                                        style="height: 200px; width: 100%; object-fit: cover;">
                                                </a>
                                                <div class="card-footer bg-white border-0 py-2">
                                                    <small
                                                        class="text-muted text-truncate d-block">{{ basename($img) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-light border text-center">Tidak ada lampiran gambar.</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
