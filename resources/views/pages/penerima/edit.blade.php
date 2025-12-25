@extends('layout.guest.app')

@section('title', 'Edit Penerima Bantuan')

@section('content')
<style>
    /* Konsistensi tema dengan Edit Warga */
    .edit-section {
        padding: 80px 0;
        background-color: #fcfcfc;
    }

    .section-title h2 {
        color: #2d3436;
        font-weight: 700;
        margin-bottom: 20px;
    }

    /* Glassmorphism Card Style */
    .custom-card-edit {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 25px;
        border: 1px solid rgba(255, 107, 129, 0.2);
        box-shadow: 0 20px 40px rgba(255, 107, 129, 0.1);
        padding: 40px;
    }

    /* Style Label dengan Ikon */
    .form-label {
        font-weight: 600;
        color: #4a4a4a;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label i {
        color: #FF6B81; /* Warna ikon pink sesuai tema warga */
        font-size: 1.1rem;
        width: 25px;
        text-align: center;
    }

    /* Input, Select & Textarea Styling */
    .form-control, .form-select {
        border: 1px solid rgba(255, 107, 129, 0.2);
        border-radius: 12px;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-control { height: 52px; }
    textarea.form-control { height: auto; }

    .form-control:focus, .form-select:focus {
        border-color: #FF6B81;
        box-shadow: 0 0 0 4px rgba(255, 107, 129, 0.1);
        outline: none;
    }

    /* Button Styling */
    .btn-save-changes {
        background-color: #FF6B81;
        border: none;
        color: white;
        padding: 12px 35px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save-changes:hover {
        background-color: #ee4e66;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 107, 129, 0.3);
        color: white;
    }

    .btn-back {
        background-color: #f1f2f6;
        color: #57606f;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
    }

    .btn-back:hover {
        background-color: #dfe4ea;
        color: #2d3436;
    }
</style>

<section class="features edit-section">
    <div class="container">
        {{-- Judul Halaman --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                        <i class="fas fa-hand-holding-heart me-1"></i> Update Data Penerima
                    </span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Edit Penerima Bantuan</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Sesuaikan alokasi program bantuan untuk warga yang bersangkutan.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center wow fadeInUp" data-wow-delay=".7s">
            <div class="col-lg-8">
                <div class="custom-card-edit">
                    
                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 p-3 mb-4" style="background-color: rgba(255, 71, 87, 0.1); color: #ff4757;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('penerima.update', $item->penerima_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Pilih Warga --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Nama Warga
                                </label>
                                <select name="warga_id" class="form-select" required>
                                    <option value="">-- Pilih Warga --</option>
                                    @foreach($warga as $w)
                                        <option value="{{ $w->id }}" 
                                            {{ $item->warga_id == $w->id ? 'selected' : '' }}>
                                            {{ $w->nama }} (NIK: {{ $w->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Pilih Program --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-gift"></i> Program Bantuan
                                </label>
                                <select name="program_id" class="form-select" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($program as $p)
                                        <option value="{{ $p->program_id }}" 
                                            {{ $item->program_id == $p->program_id ? 'selected' : '' }}>
                                            {{ $p->nama_program }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-comment-alt"></i> Keterangan
                                </label>
                                <textarea name="keterangan" class="form-control" rows="4" 
                                    placeholder="Tambahkan catatan atau alasan bantuan...">{{ old('keterangan', $item->keterangan) }}</textarea>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a href="{{ route('penerima.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-save-changes shadow">
                                <i class="fas fa-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection