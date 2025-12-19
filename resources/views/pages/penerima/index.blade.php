@extends('layout.guest.app')

@section('title', 'Data Penerima Bantuan')

@section('content')

    <section id="features" class="features section">
        <div class="container">

            {{-- 1. JUDUL HALAMAN --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Distribusi Bantuan</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Penerima Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            Daftar warga yang telah disetujui menerima bantuan sosial.
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. ACTION BAR (TOMBOL & SEARCH) --}}
            <div class="row mb-5">
                {{-- Tombol Tambah --}}
                <div class="col-12 text-center mb-3">
                    <a class="btn btn-primary wow fadeInUp" data-wow-delay=".8s"
                        href="{{ route('penerima.create') }}">
                        <i class="fas fa-plus me-1"></i> Input Penerima Baru
                    </a>
                </div>

                {{-- Search Bar --}}
                <div class="col-md-6 offset-md-3 wow fadeInUp" data-wow-delay=".9s">
                    <form action="{{ route('penerima.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="cari" class="form-control" 
                                placeholder="Cari nama warga atau program..." 
                                value="{{ request('cari') }}">
                            
                            <button class="btn btn-dark" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>

                            @if(request('cari'))
                                <a href="{{ route('penerima.index') }}" class="btn btn-danger" title="Reset">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success wow fadeInUp" data-wow-delay=".7s">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 3. GRID DATA --}}
            <div class="row">

                @forelse ($penerima as $item)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                            
                            {{-- FOTO WARGA (Placeholder / Asli) --}}
                            <div class="feature-icon" style="height: auto; width: 100%; border-radius: 0; background: transparent; padding: 0;">
                                @if (!empty($item->warga->foto))
                                    <img src="{{ asset('storage/' . $item->warga->foto) }}"
                                        style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                                @else
                                    <div style="width: 100%; height: 150px; background-color: #f1f3f5; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 15px;">
                                        <i class="lni lni-gift" style="font-size: 3rem; color: #28a745;"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- NAMA & PROGRAM --}}
                            <h3>{{ $item->warga->nama ?? 'Warga Terhapus' }}</h3>
                            
                            <p class="text-primary mb-2" style="font-weight: 600; font-size: 0.9rem;">
                                <i class="lni lni-offer"></i> {{ $item->program->nama_program ?? 'Program Terhapus' }}
                            </p>

                            <hr style="opacity: 0.1; margin: 10px 0;">

                            {{-- KETERANGAN --}}
                            <p class="small text-muted mb-3">
                                <strong>Keterangan:</strong> <br>
                                {{ $item->keterangan ?: '-' }}
                            </p>
                            
                            <p class="text-end text-muted" style="font-size: 0.75rem;">
                                <i class="lni lni-timer"></i> Disetujui: {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                            </p>

                            {{-- TOMBOL AKSI --}}
                            <div class="action-buttons mt-3 pt-3 border-top text-center">
                                
                                <a href="{{ route('penerima.edit', $item->penerima_id) }}"
                                    class="btn btn-sm btn-info text-white mb-1" title="Edit">
                                    <i class="lni lni-pencil"></i> Edit
                                </a>

                                <form action="{{ route('penerima.destroy', $item->penerima_id) }}" method="POST"
                                    class="d-inline-block mb-1"
                                    onsubmit="return confirm('Hapus data penerima ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="lni lni-trash-can"></i> Hapus
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center wow fadeInUp" style="padding: 3rem;">
                            <i class="lni lni-empty-file mb-3" style="font-size: 3rem;"></i>
                            <h4>Belum ada data penerima bantuan.</h4>
                            @if(request('cari'))
                                <p>Pencarian "{{ request('cari') }}" tidak ditemukan.</p>
                            @endif
                        </div>
                    </div>
                @endforelse

            </div>

            {{-- 4. PAGINATION --}}
            <div class="mt-5 d-flex justify-content-center">
                {!! $penerima->appends(request()->query())->links() !!}
            </div>
            
        </div>
    </section>

@endsection