@extends('layout.guest.app')

@section('title', 'Manajemen Data Warga')

@section('content')

   {{-- Alert untuk Success Message (Dari Store/Update/Destroy) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            {{-- Tombol Tambah User --}}
            <div class="row mb-4 align-items-center">
                <div class="col-md-12 mb-3 mb-md-0">
                    {{-- DIKOREKSI: Menggunakan route('users.create') --}}
                    <a href="{{ route('user.create') }}" class="main-btn btn-hover">
                        <i class="fas fa-plus me-1"></i> Tambah User
                    </a>
                </div>
            </div>
            
            {{-- Data User dalam Card View --}}
            @if ($users->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    Tidak ada data pengguna yang ditemukan.
                </div>
            @else
                <div class="row">
                    @foreach ($users as $user)
                        {{-- Card untuk setiap user. Responsif: 1 kolom di HP, 3 kolom di Desktop --}}
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card shadow-lg h-100 border-0 rounded-lg">
                                <div class="card-body">
                                    {{-- Badge Nomor Urut --}}
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h4 class="card-title fw-bold text-primary">{{ $user->name }}</h4>
                                        <span class="badge bg-secondary text-white rounded-pill p-2">
                                            No. {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                        </span>
                                    </div>
                                    
                                    <hr class="my-2">

                                    <p class="card-text mb-1">
                                        <i class="fas fa-envelope me-2 text-info"></i> {{ $user->email }}
                                    </p>
                                    <p class="card-text mb-3 text-muted small">
                                        <i class="fas fa-calendar-alt me-2 text-warning"></i> Dibuat: {{ $user->created_at->format('d/m/Y H:i') }}
                                    </p>

                                    {{-- Area Aksi --}}
                                    <div class="d-flex justify-content-end mt-3 border-top pt-3">
                                        {{-- Tombol Edit --}}
                                        {{-- DIKOREKSI: Menggunakan route('users.edit') --}}
                                        <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-outline-info me-2">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        {{-- Form Hapus --}}
                                        {{-- DIKOREKSI: Menggunakan route('users.destroy') --}}
                                        <form action="{{ route('user.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}? Aksi ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</section>
@endsection