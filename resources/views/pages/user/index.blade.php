@extends('layout.guest.app')

@section('title', 'Manajemen Data User')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            {{-- Section Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Manajemen User</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Pengguna</h2>
                        <p class="wow fadeInUp text-white" data-wow-delay=".6s">Kelola data pengguna yang terdaftar dalam
                            sistem.</p>
                    </div>
                </div>
            </div>

            {{-- Filter, Search, & Add Button --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-12">
                    <div class="action-bar-container shadow-sm">
                        {{-- Form Search & Filter --}}
                        <form action="{{ route('user.index') }}" method="GET" class="flex-grow-1">
                            <div class="search-combined-group">
                                {{-- Filter Role --}}
                                <select name="role" class="form-select shadow-none">
                                    <option value="" {{ request('role') == '' ? 'selected' : '' }}>Semua Role</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>

                                {{-- Input Search --}}
                                <input type="text" name="search" class="form-control shadow-none"
                                    placeholder="Cari Nama atau Email..." value="{{ request('search') }}">

                                {{-- Tombol Submit di dalam input group --}}
                                <button type="submit" class="btn btn-inner-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        {{-- Tombol Tambah & Reset --}}
                        <div class="d-flex gap-2">
                            <a class="btn-add-warga" href="{{ route('user.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah User
                            </a>

                            @if (request('search') || request('role'))
                                <a href="{{ route('user.index') }}"
                                    class="btn btn-light border d-flex align-items-center justify-content-center btn-reset-custom">
                                    <i class="fas fa-sync-alt text-muted"></i>
                                </a>
                            @endif
                        </div>
                    </div>
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
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
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
            @if ($users->hasPages())
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center wow fadeInUp" data-wow-delay="1s">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        /* 1. Background Halaman: Gradasi Pink ke Putih */
        body {
            background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .features.section {
            background: transparent;
            /* Memastikan background section tidak menutupi gradasi body */
        }

        .avatar-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--gradient-pink) !important;
            /* Memastikan background berwarna */

            /* Teknik Flexbox untuk memusatkan huruf tepat di tengah */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            /* Styling Teks */
            color: #d13434 !important;
            /* Warna huruf putih terang */
            font-weight: 700;
            font-size: 1.4rem;
            text-transform: uppercase;

            /* Efek Bayangan agar lebih pop-out */
            box-shadow: 0 4px 10px rgba(255, 88, 118, 0.3);
            flex-shrink: 0;
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .card:hover {
            transform: translateY(-7px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08) !important;
        }


        /* 2. Action Bar & Search Group */
        .action-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 107, 129, 0.1);
        }

        .search-combined-group {
            display: flex;
            flex-grow: 1;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .search-combined-group .form-select,
        .search-combined-group .form-control {
            border: none;
            height: 48px;
        }

        .search-combined-group .form-select {
            max-width: 160px;
            background-color: #f8f9fa;
            border-right: 1px solid #eee;
        }

        .btn-inner-search {
            background: #FF6B81;
            color: #fff;
            padding: 0 20px;
            border: none;
            transition: 0.3s;
        }

        .btn-inner-search:hover {
            background: #ee4e66;
            color: #fff;
        }

        /* 3. Action Buttons */
        .btn-add-warga {
            background: #2ecc71;
            color: #fff;
            height: 48px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            white-space: nowrap;
        }

        .btn-add-warga:hover {
            background: #27ae60;
            color: #fff;
            transform: translateY(-2px);
        }

        /* 4. Statistics Cards */
        .stat-card {
            transition: 0.3s;
            border-radius: 15px;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .bg-decoration {
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: currentColor;
            border-radius: 50%;
            opacity: 0.05;
            z-index: 1;
        }

        /* 5. Citizen Cards */
        .citizen-card {
            transition: 0.3s;
            border-radius: 15px;
        }

        .citizen-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .btn-light-info {
            background: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
            border: none;
        }

        .btn-light-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: none;
        }

        .btn-light-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: none;
        }

        /* 6. Responsive Data */
        @media (max-width: 991px) {
            .action-bar-container {
                flex-direction: column;
                align-items: stretch;
            }

            .search-combined-group {
                flex-direction: column;
                border: none;
                gap: 10px;
            }

            .search-combined-group .form-select,
            .search-combined-group .form-control {
                max-width: 100%;
                border-radius: 10px !important;
                border: 1px solid #eee;
            }

            .btn-add-warga {
                justify-content: center;
            }
        }
    </style>
    
@endsection
