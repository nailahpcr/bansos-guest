@extends('layout.layout')

@section('title', 'Manajemen Data Warga')

@section('content')

    <section id="features" class="features section">
        <div class="container">

            {{-- SECTION TITLE (Diadaptasi dari kode Anda) --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Kelola data warga yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>

            {{-- HEADER HALAMAN & TOMBOL TAMBAH --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Daftar Warga</h3>
                    {{-- Tombol ini mengarah ke rute 'data-warga.create' --}}
                    <a class="btn btn-success" href="# route('warga.create') }}">
                        <i class="fas fa-plus me-1"></i> Tambah Warga
                    </a>
                </div>
            </div>

            {{-- PESAN SUKSES (FLASH MESSAGE) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show wow fadeInUp" data-wow-delay=".8s"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- INI ADALAH TAMPILAN "LIST" (TABEL) PENGGANTI CARD --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".9s">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>No. KTP</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Agama</th>
                                            <th>No. Telp</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($wargas as $warga)
                                            <tr>
                                                {{-- Penomoran yang benar untuk pagination --}}
                                                <th>{{ $loop->iteration + ($wargas->currentPage() - 1) * $wargas->perPage() }}
                                                </th>
                                                <td>{{ $warga->no_ktp }}</td>
                                                <td>{{ $warga->nama }}</td>
                                                <td>{{ $warga->jenis_kelamin }}</td>
                                                <td>{{ $warga->agama }}</td>
                                                <td>{{ $warga->telp ?? '-' }}</td> {{-- Tampilkan '-' jika telp kosong --}}
                                                <td class="text-center">
                                                    <a href="{{ route('warga.show', $warga->warga_id) }}"
                                                        class="btn btn-sm btn-success text-white">Lihat</a>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Belum ada data warga.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PAGINATION LINKS --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                    {{-- Pastikan controller Anda menggunakan ->paginate() --}}
                    {!! $wargas->links() !!}
                </div>
            </div>

        </div>
    </section>
@endsection
