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
                    <form action="{{ route('user.index') }}" method="GET" class="mb-3">
                        <div class="row align-items-center">
                            {{-- Search Bar --}}
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" id="searchInput"
                                        value="{{ request('search') }}" placeholder="Cari Nama/Email/ID User..."
                                        aria-label="Search">
                                    <button type="submit" class="input-group-text" id="basic-addon2">
                                        {{-- Ikon Search SVG --}}
                                        <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd"></path>
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
                                {{-- Header Card --}}
                                <div class="d-flex align-items-start mb-3">
                                    {{-- Avatar / Initial --}}
                                    <div class="avatar-circle me-3">
                                        <span class="avatar-text">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    {{-- User Info --}}
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-0 fw-bold">{{ $user->name }}</h5>
                                        <p class="card-subtitle mb-1 text-muted small">
                                            <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                                        </p>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                                            <i class="fas fa-user-tag me-1"></i> {{ ucfirst($user->role ?? 'N/A') }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-2">

                                {{-- User Details --}}
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt me-2 text-success"></i>
                                        <span><strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}</span>
                                    </div>

                                    <div class="mb-2">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-key me-2 text-warning"></i>
                                            <span><strong>Password Hash:</strong></span>
                                        </div>
                                        {{-- Password Hash --}}
                                        <div class="bg-light rounded p-2 border">
                                            <code class="text-dark d-block small" style="word-break: break-all;">
                                                {{ Str::limit($user->password, 30) }}
                                            </code>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-info-circle me-1"></i> Hash dikunci dengan bcrypt
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="mt-auto pt-2">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
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
                                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                        Konfirmasi Hapus User
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle fa-2x me-3"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                                                <p class="mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Data yang dihapus tidak dapat dikembalikan!
                                    </p>
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
                        <div class="card border-dashed text-center py-5">
                            <div class="card-body">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="card-title">Belum ada data user</h5>
                                <p class="card-text text-muted">Silakan tambah user baru untuk mulai</p>
                                <a href="{{ route('user.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i> Tambah User Pertama
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        .avatar-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .avatar-text {
            line-height: 1;
        }

        .card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #0d6efd;
        }

        .card-title {
            color: #2c3e50;
            font-weight: 600;
        }

        .card-subtitle {
            font-size: 0.85rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .border-dashed {
            border: 2px dashed #dee2e6;
            border-radius: 12px;
        }

        .btn-group .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .btn-group .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        @media (max-width: 768px) {
            .avatar-circle {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .card-title {
                font-size: 1rem;
            }
        }
    </style>
@endsection