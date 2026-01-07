@extends('layout.guest.app')

@section('title', 'Edit Penerima Bantuan')

@section('content')
<style>
    /* Menyamakan background dan padding utama */
    #features {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 60px 0;
    }

    /* Menyamakan gaya kartu dengan Edit Verifikasi */
    .card {
        border-radius: 20px;
        border: none;
    }

    /* Menyamakan gaya judul seksi */
    .section-title h3 {
        color: #ff5876;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Menyamakan gaya label form */
    .form-label {
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 8px;
    }

    /* Gaya Input & Select agar sama bersihnya */
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #edf2f7;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ff5876;
        box-shadow: 0 0 0 3px rgba(255, 88, 118, 0.1);
        outline: none;
    }

    /* Menyamakan tombol Simpan (Gradient Hijau) */
    .btn-success {
        background: linear-gradient(45deg, #20bf6b, #0fb9b1);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(32, 191, 107, 0.3);
    }

    /* Menyamakan tombol Kembali */
    .btn-secondary {
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 700;
        background-color: #6c757d;
        border: none;
    }

    .alert-custom {
        background-color: rgba(255, 71, 87, 0.1);
        color: #ff4757;
        border: none;
        border-radius: 15px;
    }
</style>

<section id="features" class="features section">
    <div class="container">
        {{-- Menyamakan Header Halaman --}}
        <div class="row">
            <div class="col-12 text-center mb-4">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Edit Data</h3>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Ubah Penerima Bantuan</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Perbarui alokasi program atau keterangan penerima bantuan.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg wow fadeInUp" data-wow-delay=".8s">
                    <div class="card-body p-4 p-md-5">

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-custom p-3 mb-4">
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

                            <div class="mb-4">
                                <label class="form-label">Nama Warga / Penerima</label>
                                <select name="warga_id" class="form-select shadow-none @error('warga_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Warga --</option>
                                    @foreach($warga as $w)
                                        <option value="{{ $w->warga_id }}" {{ $item->warga_id == $w->warga_id ? 'selected' : '' }}>
                                            {{ $w->nama }} (NIK: {{ $w->no_ktp }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Program Bantuan yang Dialokasikan</label>
                                <select name="program_id" class="form-select shadow-none @error('program_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($program as $p)
                                        <option value="{{ $p->program_id }}" {{ $item->program_id == $p->program_id ? 'selected' : '' }}>
                                            {{ $p->nama_program }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="form-control shadow-none" rows="4" 
                                    placeholder="Tambahkan catatan atau alasan perubahan bantuan...">{{ old('keterangan', $item->keterangan) }}</textarea>
                            </div>

                            {{-- Menyamakan Barisan Tombol Bawah --}}
                            <div class="d-flex justify-content-between mt-5 border-top pt-4">
                                <a class="btn btn-secondary px-4 fw-bold" href="{{ route('penerima.index') }}">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection