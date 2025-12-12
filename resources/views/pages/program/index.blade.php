@extends('layout.guest.app')

@section('title', 'Kelola Program Bantuan')

@section('content')

    <section id="features" class="features section">
        <div class="container">

            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Program</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Kelola Program Bantuan</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Anda dapat membuat,
                            mengubah, dan menghapus program bantuan</p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL TAMBAH PROGRAM --}}
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <a class="btn btn-primary wow fadeInUp" data-wow-delay=".8s"
                        href="{{ route('kelola-program.create') }}">
                        <i class="fas fa-plus me-1"></i> Tambah Program Baru
                    </a>
                </div>
            </div>

            {{-- PESAN SUKSES --}}
            @if (session('success'))
                <div class="alert alert-success wow fadeInUp" data-wow-delay=".7s">
                    {{ session('success') }}
                </div>
            @endif

            {{-- DAFTAR PROGRAM (GRID KARTU) --}}
            <div class="row">

                @forelse ($programs as $program)
                    <div class="col-lg-4 col-md-6 col-12">
                        {{-- Ini adalah style 'single-feature' yang Anda gunakan di home --}}
                        <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                            @php
                                $imageMedia = $program->media->filter(function ($item) {
                                    return Str::startsWith($item->mime_type, 'image/');
                                });
                            @endphp
                            @if ($imageMedia->isNotEmpty())
                                @php $firstImage = $imageMedia->first(); @endphp
                                <img src="{{ asset('storage/uploads/program_bantuan/' . $firstImage->file_name) }}"
                                    alt="{{ $firstImage->caption ?: $program->nama_program }}"
                                    style="width: 100%; height: 150px; object-fit: cover; margin-bottom: 10px;">
                            @else
                                <div
                                    style="width: 100%; height: 150px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; border: 1px solid #dee2e6;">
                                    <i class="lni lni-image" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                            @endif

                            <h3>{{ $program->nama_program }}</h3>
                            <p class="mb-2"><strong>Kode:</strong> {{ $program->kode }} | <strong>Tahun:</strong>
                                {{ $program->tahun }}</p>
                            <p>{{ Str::limit($program->deskripsi, 100) }}</p>
                            <p><strong>Anggaran:</strong> Rp {{ number_format($program->anggaran, 0, ',', '.') }}</p>


                            <div class="action-buttons mt-3">

                                {{-- Tombol Detail --}}
                                <a href="{{ route('kelola-program.show', $program) }}"
                                    class="btn btn-sm btn-success text-white mb-1">
                                    Detail 
                                </a>

                                {{-- Tombol Edit (Gunakan SPAN agar tidak bentrok) --}}
                                <a href="{{ route('kelola-program.edit', $program->program_id) }}"
                                    class="btn btn-sm btn-info text-white mb-1">
                                    <span class="fas fa-pencil-alt"></span> Edit
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('kelola-program.destroy', $program->program_id) }}" method="POST"
                                    class="d-inline-block mb-1"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <span class="fas fa-trash"></span> Hapus
                                    </button>
                                </form>

                                {{-- Tombol Partisipasi --}}
                                @if (Auth::user())
                                    @if (Auth::user()->programBantuans->contains($program->program_id))
                                        <form action="{{ route('kelola-program.batalkan', $program->program_id) }}"
                                            method="POST" class="d-inline-block mb-1"
                                            onsubmit="return confirm('Batalkan partisipasi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-warning">Batalkan Program</button>
                                        </form>
                                    @else
                                        <form action="{{ route('kelola-program.ajukan', $program->program_id) }}"
                                            method="POST" class="d-inline-block mb-1"
                                            onsubmit="return confirm('Ikuti program ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Ikuti Program</button>
                                        </form>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center wow fadeInUp">
                            Belum ada program yang Anda buat. Silakan klik tombol "Tambah Program Baru".
                        </div>
                    </div>
                @endforelse

            </div>

            {{-- Link Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {!! $programs->links() !!}
            </div>
        </div>
    </section>
@endsection
