@extends('layout.guest.app')

@section('title', 'Data Pendaftar Bantuan')

@section('content')
    <section id="features" class="features section py-5" style="background-color: #f8f9fa;">
        <div class="container">

            {{-- HEADER SECTION --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Data Pendaftar Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            Kelola data warga yang terdaftar dalam sistem.
                        </p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR: BUTTON & SEARCH --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".5s">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm p-3 rounded-4">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">

                            {{-- Tombol Tambah --}}
                            <a class="btn btn-success px-4 rounded-pill fw-bold" href="{{ route('pendaftar.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Pendaftar
                            </a>

                            {{-- Form Pencarian & Filter --}}
                            <form action="{{ route('pendaftar.index') }}" method="GET"
                                class="d-flex flex-column flex-md-row gap-2 w-100 w-lg-auto">
                                {{-- Dropdown Status --}}
                                <select name="status" class="form-select rounded-pill" style="min-width: 160px;">
                                    <option value="">Semua Status</option>
                                    @if (!empty($statuses) && is_array($statuses))
                                        @foreach ($statuses as $s)
                                            <option value="{{ $s }}"
                                                {{ request('status') == $s ? 'selected' : '' }}>
                                                {{ $s }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                                {{-- Input Search --}}
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control rounded-start-pill ps-3"
                                        placeholder="Cari Nama Warga..." value="{{ request('q') }}">
                                    <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                {{-- Tombol Reset --}}
                                @if (request('q') || request('status'))
                                    <a href="{{ route('pendaftar.index') }}" class="btn btn-outline-secondary rounded-pill"
                                        title="Reset Filter">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ALERTS --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 wow fadeInUp" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- GRID DATA PENDAFTAR --}}
            {{-- PERBAIKAN: Row dibuka DI LUAR loop agar grid berfungsi --}}
            <div class="row g-4">
                
                {{-- PERBAIKAN: Menggunakan @forelse, bukan @foreach --}}
                @forelse ($pendaftar as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".{{ ($loop->iteration % 4) + 2 }}s">
                        <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden hover-card">

                            {{-- Status Badge (Pojok Kanan Atas) --}}
                            <div class="position-absolute top-0 end-0 mt-3 me-3">
                                @php
                                    $badgeClass = match ($item->status) {
                                        'Diterima' => 'bg-success',
                                        'Ditolak' => 'bg-danger',
                                        default => 'bg-warning text-dark',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 shadow-sm">
                                    {{ $item->status }}
                                </span>
                            </div>

                            <div class="card-body p-4 pt-5">
                                {{-- Profil Singkat --}}
                                <div class="d-flex align-items-center mb-4">
                                    <div class="avatar bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm"
                                        style="width: 55px; height: 55px; font-size: 1.5rem;">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0 text-dark">{{ $item->warga->nama ?? 'Warga Terhapus' }}
                                        </h5>
                                        <small class="text-muted"><i class="fas fa-id-card me-1"></i>
                                            {{ $item->warga->nik ?? '-' }}</small>
                                    </div>
                                </div>

                                {{-- Info Program --}}
                                <div class="bg-light p-3 rounded-3 mb-3">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">Program
                                        Bantuan</small>
                                    <p class="mb-0 fw-semibold text-primary text-truncate"
                                        title="{{ $item->program->nama_program ?? '-' }}">
                                        {{ $item->program->nama_program ?? 'Program Terhapus' }}
                                    </p>
                                </div>

                                {{-- Info Tambahan (Berkas) --}}
                                @if ($item->files && $item->files->count() > 0)
                                    <div class="mb-3">
                                        <span class="badge bg-info text-white rounded-pill">
                                            <i class="fas fa-paperclip me-1"></i> {{ $item->files->count() }} Berkas
                                            Terlampir
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Footer Actions --}}
                            <div class="card-footer bg-white border-top-0 p-4 pt-0">
                                <div class="d-grid gap-2 d-flex">

                                    {{-- 1. Tombol DETAIL --}}
                                    <a href="{{ route('pendaftar.show', $item->pendaftar_id) }}"
                                        class="btn btn-outline-info w-100 fw-bold rounded-pill">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>

                                    {{-- 2. Tombol EDIT --}}
                                    <a href="{{ route('pendaftar.edit', $item->pendaftar_id) }}"
                                        class="btn btn-outline-warning w-100 fw-bold rounded-pill">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>

                                    {{-- 3. Tombol HAPUS --}}
                                    <button type="button" class="btn btn-outline-danger w-100 fw-bold rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->pendaftar_id }}">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>

                                </div>
                            </div>

                            {{-- MODAL DELETE (Per Item) --}}
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0">
                                        <div class="modal-body p-4 text-center">
                                            <div class="mb-3 text-danger display-1">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </div>
                                            <h4 class="fw-bold mb-3">Hapus Data Pendaftar?</h4>
                                            <p class="text-muted mb-4">
                                                Anda akan menghapus data pendaftaran untuk
                                                <strong>{{ $item->warga->nama ?? '-' }}</strong>.
                                                Tindakan ini tidak dapat dibatalkan.
                                            </p>
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-light px-4 rounded-pill"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('pendaftar.destroy', $item->pendaftar_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4 rounded-pill">Ya,
                                                        Hapus!</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END MODAL --}}
                        </div>
                    </div>

                {{-- PERBAIKAN: @empty sekarang valid karena berada di dalam @forelse --}}
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 wow fadeInUp">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty"
                                style="width: 80px; opacity: 0.5;">
                            <h5 class="mt-3 text-muted">Data tidak ditemukan.</h5>
                            <p class="text-secondary">Silakan coba kata kunci lain atau tambahkan data baru.</p>
                        </div>
                    </div>
                @endforelse
                {{-- PERBAIKAN: Ditutup dengan @endforelse --}}

            </div> {{-- Penutup ROW grid --}}

            {{-- Pagination --}}
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center wow fadeInUp">
                    {!! $pendaftar->links() !!}
                </div>
            </div>

        </div>
    </section>

    {{-- Sedikit CSS Tambahan untuk Hover Effect --}}
    <style>
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endsection