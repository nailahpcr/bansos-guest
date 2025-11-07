@extends('layout.guest.app')

@section('title', 'Manajemen Data Warga')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Kelola data warga yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Daftar Warga</h3>
                    <a class="btn btn-success" href="{{ route('warga.create') }}">
                        <i class="fas fa-plus me-1"></i> Tambah Warga
                    </a>
                </div>
            </div>

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

            <div class="row g-4">
                @forelse ($wargas as $warga)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".{{ ($loop->iteration % 4) + 1 }}s">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $warga->nama }}</h5>
                                <h6 class="card-subtitle mb-3 text-muted">
                                    <i class="fas fa-id-card me-1"></i> {{ $warga->no_ktp }}
                                </h6>
                                <hr>
                                <p class="card-text mb-2">
                                    <i class="fas fa-venus-mars me-2 text-secondary"></i>
                                    <strong>Jenis Kelamin:</strong> {{ $warga->jenis_kelamin }}
                                </p>
                                <p class="card-text mb-2">
                                    <i class="fas fa-pray me-2 text-secondary"></i>
                                    <strong>Agama:</strong> {{ $warga->agama }}
                                </p>
                                <p class="card-text mb-3">
                                    <i class="fas fa-phone me-2 text-secondary"></i>
                                    <strong>No. Telp:</strong> {{ $warga->telp ?? 'Tidak ada' }}
                                </p>

                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('warga.show', $warga->warga_id) }}" class="btn btn-info">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $warga->warga_id }}">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $warga->warga_id }}" tabindex="-1"
                         aria-labelledby="deleteModalLabel{{ $warga->warga_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $warga->warga_id }}">
                                        Konfirmasi Hapus Data Warga
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus data warga berikut?</p>
                                    <div class="alert alert-warning">
                                        <strong>Nama:</strong> {{ $warga->nama }}<br>
                                        <strong>No. KTP:</strong> {{ $warga->no_ktp }}<br>
                                        <strong>Jenis Kelamin:</strong> {{ $warga->jenis_kelamin }}<br>
                                        <strong>Agama:</strong> {{ $warga->agama }}
                                    </div>
                                    <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Batal
                                    </button>
                                    <form action="{{ route('warga.destroy', $warga->warga_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i> Ya, Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <div class="alert alert-secondary text-center wow fadeInUp" data-wow-delay=".2s">
                            <p class="mb-0">Belum ada data warga yang bisa ditampilkan.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                    {!! $wargas->links() !!}
                </div>
            </div>

        </div>
    </section>
@endsection
