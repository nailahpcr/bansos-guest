@extends('layout.guest.app')

@section('title', 'Manajemen Data User')

@section('content')

    <section id="features" class="features section">
        <div class="container">
            {{-- Section Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen User</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Pengguna</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Kelola data pengguna yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>

            {{-- Filter, Search, & Add Button --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-lg-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                        <h3 class="mb-2 mb-md-0">Daftar User</h3>
                        <a class="btn btn-success" href="{{ route('user.create') }}">
                            <i class="fas fa-plus me-1"></i> Tambah User
                        </a>
                    </div>
                    
                    {{-- SEARCH FORM --}}
                    {{-- Form ini akan mengirimkan request GET untuk mencari data --}}
                    <form action="{{ route('user.index') }}" method="GET" class="mb-3">
                        <div class="row align-items-center">
                            {{-- Search Bar --}}
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" id="searchInput" 
                                           value="{{ request('search') }}" placeholder="Cari Nama/Email/ID User..." aria-label="Search">
                                    <button type="submit" class="input-group-text" id="basic-addon2">
                                        {{-- Ikon Search SVG --}}
                                        <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Tombol Reset Search (Opsional) --}}
                            @if (request('search'))
                            <div class="col-auto mt-2 mt-md-0">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                            @endif
                        </div>
                    </form>
                    {{-- END SEARCH FORM --}}

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

            {{-- Grid Data User --}}
            <div class="row g-4">
                @forelse ($users as $user)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".{{ ($loop->iteration % 4) + 1 }}s">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                {{-- Nama & Email --}}
                                <h5 class="card-title fw-bold">{{ $user->name }}</h5>
                                <h6 class="card-subtitle mb-3 text-muted">
                                    <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                                </h6>

                                <hr>

                                {{-- Tanggal Bergabung (Dengan Ikon Kalender) --}}
                                <p class="card-text mb-2">
                                    <i class="fas fa-calendar-alt me-2 text-success"></i>
                                    <strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}
                                </p>

                                {{-- Password Hash (Dengan Ikon Kunci) --}}
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-key me-2 text-warning"></i>
                                        <strong>Password Hashed:</strong>
                                    </div>
                                    {{-- Box kode hash agar terlihat rapi --}}
                                    <div class="bg-light rounded p-2 border" style="background-color: #f8f9fa;">
                                        <code class="text-dark d-block" style="word-break: break-all; font-size: 0.85rem;">
                                            {{ Str::limit($user->password, 25) }}
                                        </code>
                                    </div>
                                </div>

                                {{-- Tombol Aksi (Group Style) --}}
                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Delete Confirmation Modal --}}
                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                        Konfirmasi Hapus Data User
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus user berikut?</p>
                                    <div class="alert alert-warning">
                                        <strong>Nama:</strong> {{ $user->name }}<br>
                                        <strong>Email:</strong> {{ $user->email }}
                                    </div>
                                    <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Batal
                                    </button>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
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
                            <p class="mb-0">Belum ada data user yang ditemukan.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                    {{-- Pastikan pagination menyertakan parameter pencarian yang ada --}}
                    {!! $users->appends(request()->query())->links() !!}
                </div>
            </div>

        </div>
    </section>
@endsection