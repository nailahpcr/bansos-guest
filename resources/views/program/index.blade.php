@extends('layout.layout')

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
                        <p class="wow fadeInUp" data-wow-delay=".6s">Di halaman ini, Anda (sebagai warga) dapat membuat,
                            mengubah, dan menghapus program bantuan.</p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL TAMBAH PROGRAM --}}
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <a class="btn btn-primary wow fadeInUp" data-wow-delay=".8s" href="{{ route('program.create') }}">
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
                            <i class="lni lni-package"></i>

                            <h3>{{ $program->nama_program }}</h3>
                            <p class="mb-2"><strong>Kode:</strong> {{ $program->kode }} | <strong>Tahun:</strong>
                                {{ $program->tahun }}</p>
                            <p>{{ Str::limit($program->deskripsi, 100) }}</p>
                            <p><strong>Anggaran:</strong> Rp {{ number_format($program->anggaran, 0, ',', '.') }}</p>

                            {{-- ===================== PERUBAHAN DI SINI ===================== --}}
                            {{-- TOMBOL AKSI DIPISAH MENJADI BEBERAPA FORM/LINK --}}
                            <div class="action-buttons mt-3">

                                {{-- Tombol Edit (Link Biasa) --}}
                                <a href="{{ route('program.edit', $program->program_id) }}"
                                    class="btn btn-sm btn-info text-white d-inline-block mb-1">Edit</a>

                                {{-- Tombol Hapus (Form Terpisah) --}}
                                <form action="{{ route('program.destroy', $program->program_id) }}" method="POST"
                                    class="d-inline-block mb-1"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini? Ini adalah data CRUD Anda.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>

                                {{-- Tombol Kondisional (Ikuti / Batalkan) --}}
                                {{-- Cek apakah Warga yang login sudah mengikuti program ini --}}
                                @if (Auth::user() && Auth::user()->programBantuans->contains($program->program_id))
                                    {{-- JIKA SUDAH IKUT: Tampilkan form dengan tombol "Batalkan Partisipasi" --}}
                                    <form action="{{ route('program.batalkan', $program->program_id) }}" method="POST"
                                        class="d-inline-block mb-1"
                                        onsubmit="return confirm('Anda yakin ingin membatalkan partisipasi di program ini?');">
                                        @csrf
                                        @method('DELETE') {{-- Penting! Memberitahu Laravel ini adalah request DELETE --}}
                                        <button type="submit" class="btn btn-sm btn-warning">Batalkan Partisipasi</button>
                                    </form>
                                @else
                                    {{-- JIKA BELUM IKUT: Tampilkan form dengan tombol "Ikuti Program" --}}
                                    <form action="{{ route('program.ajukan', $program->program_id) }}" method="POST"
                                        class="d-inline-block mb-1"
                                        onsubmit="return confirm('Anda yakin ingin mengikuti program ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Ikuti Program</button>
                                    </form>
                                @endif  

                            </div>
                            {{-- =================== AKHIR PERUBAHAN =================== --}}

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
