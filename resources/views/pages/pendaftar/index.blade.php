@extends('layout.guest.app')

@section('title', 'Data Pendaftar Bantuan')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Pendaftaran</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Data Penerima Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Daftar warga yang telah didaftarkan ke dalam program
                            bantuan.</p>
                    </div>
                </div>
            </div>


            {{-- Title & Add Button --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Data Pendaftar</h3>
                    <a class="btn btn-success" href="{{ route('pendaftar.create') }}">
                        <i class="fas fa-plus me-1"></i> Tambah Pendaftar
                    </a>
                </div>
            </div>

            {{-- Search Bar dan Reset Button --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".8s">
                <div class="col-lg-12">
                    <form action="{{ route('pendaftar.index') }}" method="GET">
                        <div class="input-group">
                            {{-- Input Pencarian --}}
                            <input type="text" name="q" class="form-control"
                                placeholder="Cari berdasarkan Nama Warga..." value="{{ request('q') }}">

                            {{-- Dropdown Status Filter --}}
                            <select name="status" class="form-select" style="max-width:200px">
                                <option value="">Semua Status</option>
                                @if(!empty($statuses) && is_array($statuses))
                                    @foreach($statuses as $s)
                                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                @endif
                            </select>

                            {{-- Tombol Cari --}}
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>

                            {{-- Tombol Reset (Hanya muncul jika ada query atau status) --}}
                            @if (request('q') || request('status'))
                                <a href="{{ route('pendaftar.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Grid Data Pendaftar --}}
            <div class="row g-4">
                @forelse ($pendaftar as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".{{ ($loop->iteration % 4) + 1 }}s">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">

                                {{-- Nama Warga --}}
                                <h5 class="card-title fw-bold mb-1">{{ $item->warga->nama ?? 'Warga Terhapus' }}</h5>
                                <small class="text-muted mb-3">
                                    <i class="fas fa-id-card me-1"></i> {{ $item->warga->nik ?? '-' }}
                                </small>

                                <hr>

                                {{-- Nama Program --}}
                                <p class="card-text mb-2">
                                    <i class="fas fa-box-open me-2 text-primary"></i>
                                    <strong>Program:</strong> <br>
                                    <span
                                        class="ms-4 text-dark">{{ $item->program->nama_program ?? 'Program Terhapus' }}</span>
                                </p>

                                {{-- Status Seleksi --}}
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-info-circle me-2 text-warning"></i>
                                        <strong>Status:</strong>
                                    </div>
                                    <span
                                        class="badge rounded-pill ms-4 
                                        {{ $item->status == 'Diterima' ? 'bg-success' : ($item->status == 'Ditolak' ? 'bg-danger' : 'bg-secondary') }}">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('pendaftar.edit', ['pendaftar' => $item->id]) }}"
                                            class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $item->id }}">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus pendaftaran ini?</p>
                                    <div class="alert alert-warning">
                                        <strong>Warga:</strong> {{ $item->warga->nama ?? '-' }}<br>
                                        <strong>Program:</strong> {{ $item->program->nama_program ?? '-' }}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('pendaftar.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <div class="alert alert-secondary text-center wow fadeInUp" data-wow-delay=".2s">
                            <p class="mb-0">Belum ada data pendaftaran.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                    {!! $pendaftar->links() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
