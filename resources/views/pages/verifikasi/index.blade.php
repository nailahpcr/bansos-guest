@extends('layout.guest.app')

@section('title', 'Data Verifikasi Lapangan')

@section('content')

    <section id="features" class="features section">
        <div class="container">

            {{-- 1. JUDUL HALAMAN --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Hasil Survei</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Data Verifikasi Lapangan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            Daftar hasil penilaian dan validasi data warga pendaftar bantuan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. TOOLBAR: TOMBOL & SEARCH --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".5s">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm p-3 rounded-4">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">

                            {{-- Tombol Tambah --}}
                            <a class="btn btn-primary px-4 rounded-pill fw-bold"
                                href="{{ route('verifikasi.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Input Verifikasi Baru
                            </a>

                            {{-- Form Pencarian --}}
                            <form action="{{ route('verifikasi.index') }}" method="GET"
                                class="d-flex flex-column flex-md-row gap-2 w-100 w-lg-auto">

                                {{-- Input Search --}}
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control rounded-start-pill ps-3"
                                        placeholder="Cari nama warga..." value="{{ request('q') }}">
                                    <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                {{-- Tombol Reset --}}
                                @if (request('q'))
                                    <a href="{{ route('verifikasi.index') }}" class="btn btn-outline-danger rounded-pill"
                                        title="Reset Filter">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            {{-- PESAN SUKSES --}}
            @if (session('success'))
                <div class="alert alert-success wow fadeInUp" data-wow-delay=".7s">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 3. GRID DAFTAR DATA --}}
            <div class="row">

                @forelse ($verifikasi as $item)
                    <div class="col-lg-4 col-md-6 col-12">
                        {{-- Kartu Data --}}
                        <div class="single-feature wow fadeInUp" data-wow-delay=".2s">

                            {{-- A. Foto Bukti --}}
                            @if ($item->foto_bukti)
                                <img src="{{ asset('storage/' . $item->foto_bukti) }}" alt="Bukti Lapangan"
                                    style="width: 100%; height: 150px; object-fit: cover; margin-bottom: 10px; border-radius: 4px;">
                            @else
                                <div
                                    style="width: 100%; height: 150px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; border: 1px solid #dee2e6; border-radius: 4px;">
                                    <i class="lni lni-image" style="font-size: 3rem; color: #adb5bd;"></i>
                                </div>
                            @endif

                            {{-- B. Informasi Utama --}}
                            <h3>{{ $item->pendaftar->warga->nama ?? 'Data Warga Hilang' }}</h3>

                            <p class="text-primary mb-2" style="font-weight: 600; font-size: 0.9rem;">
                                <i class="lni lni-offer"></i> {{ $item->pendaftar->program->nama_program ?? '-' }}
                            </p>

                            {{-- C. Detail Skor & Petugas --}}
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark border">
                                    <i class="lni lni-user"></i> {{ Str::limit($item->petugas, 10) }}
                                </span>
                                <span class="badge {{ $item->skor >= 70 ? 'bg-success' : 'bg-warning' }}">
                                    Skor: {{ $item->skor }}
                                </span>
                                <span class="badge bg-secondary">
                                    <i class="lni lni-calendar"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <p class="small text-muted mb-3">
                                {{ Str::limit($item->catatan, 80) ?: 'Tidak ada catatan khusus.' }}
                            </p>

                            {{-- D. Tombol Aksi (DISAMAKAN DENGAN PROGRAM) --}}
                            {{-- Hapus 'pt-3', 'border-top', dan 'justify-content-center' agar rata kiri dan bersih --}}
                            <div class="d-flex flex-wrap gap-1 mt-3">

                                {{-- Lihat Detail (Ubah ke btn-success text-white) --}}
                                <a href="{{ route('verifikasi.show', $item->verifikasi_id) }}"
                                    class="btn btn-sm btn-success text-white mb-1">
                                    <span class="fas fa-eye"></span> Detail
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('verifikasi.edit', $item->verifikasi_id) }}"
                                    class="btn btn-sm btn-info text-white mb-1">
                                    <span class="fas fa-pencil-alt"></span> Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('verifikasi.destroy', $item->verifikasi_id) }}" method="POST"
                                    class="d-inline-block mb-1"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data verifikasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <span class="fas fa-trash"></span> Hapus
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                @empty
                    {{-- Tampilan jika data kosong --}}
                    <div class="col-12">
                        <div class="alert alert-warning text-center wow fadeInUp" style="padding: 3rem;">
                            <i class="lni lni-empty-file mb-3" style="font-size: 3rem;"></i>
                            <h4>Belum ada data verifikasi.</h4>
                            <p>Silakan klik tombol "Input Verifikasi Baru" di atas.</p>
                        </div>
                    </div>
                @endforelse

            </div>

            {{-- 4. PAGINATION LINKS --}}
            <div class="mt-4 d-flex justify-content-center">
                {!! $verifikasi->appends(request()->query())->links() !!}
            </div>

        </div>
    </section>

@endsection