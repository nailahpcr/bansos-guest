@extends('layout.guest.app')

@section('title', 'Tambah Penerima')

@section('content')
<style>
    /* Background Halaman */
    .penerima-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #ffafbd 0%, #ffc3a0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    /* Card Glassmorphism */
    .custom-card-glass {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }

    /* Style Label & Ikon */
    .form-label {
        font-weight: 700;
        color: #4a4a4a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-label i {
        color: #FF6B81;
        background: rgba(255, 107, 129, 0.1);
        padding: 8px;
        border-radius: 10px;
        font-size: 0.9rem;
        width: 35px;
        text-align: center;
    }

    /* Input & Select Styling */
    .form-control, .form-select {
        border: 1px solid rgba(0, 0, 0, 0.08);
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .form-select { height: 52px; }

    .form-control:focus, .form-select:focus {
        border-color: #FF6B81;
        box-shadow: 0 0 0 4px rgba(255, 107, 129, 0.1);
    }

    /* Tombol Utama */
    .btn-save {
        background: linear-gradient(45deg, #FF6B81, #ee4e66);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        box-shadow: 0 8px 20px rgba(255, 107, 129, 0.4);
        transform: translateY(-2px);
        color: white;
    }

    .btn-back {
        background-color: #f8f9fa;
        color: #636e72;
        border: 1px solid #dfe4ea;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .section-title h2 { color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .section-title p { color: rgba(255,255,255,0.9); }
</style>

<section id="features" class="features penerima-section">
    <div class="container">
        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 255, 255, 0.2); color: #fff;">
                        <i class="fas fa-gift me-1"></i> Penyaluran Bantuan
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Tambah Penerima</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Tetapkan warga yang berhak menerima bantuan dari program yang tersedia.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="custom-card-glass wow fadeInUp" data-wow-delay=".8s">

                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('penerima.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Warga --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-user-check"></i> Pilih Warga Penerima
                            </label>
                            <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required>
                                <option value="">-- Cari Nama Warga --</option>
                                @foreach ($warga as $w)
                                    <option value="{{ $w->id }}" {{ old('warga_id') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama }} — [NIK: {{ $w->nik }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('warga_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Pilih Program --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-tasks"></i> Pilih Program Bantuan
                            </label>
                            <select name="program_id" class="form-select @error('program_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Program --</option>
                                @foreach ($program as $p)
                                    <option value="{{ $p->program_id }}" {{ old('program_id') == $p->program_id ? 'selected' : '' }}>
                                        {{ $p->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-sticky-note"></i> Keterangan (Opsional)
                            </label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" 
                                placeholder="Tambahkan catatan penyaluran bantuan disini...">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a class="btn btn-back shadow-sm" href="{{ route('penerima.index') }}">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-save shadow">
                                <i class="fas fa-save me-2"></i> Simpan Data Penerima
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection