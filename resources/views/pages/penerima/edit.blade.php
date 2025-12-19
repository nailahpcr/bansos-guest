@extends('layout.guest.app')

@section('title', 'Edit Penerima Bantuan')

@section('content')

    <section class="section">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    
                    {{-- KARTU FORM EDIT --}}
                    <div class="card shadow-sm border-0 wow fadeInUp" data-wow-delay=".2s">
                        
                        {{-- Header Kartu --}}
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0" style="font-weight: 600;">
                                <i class="fas fa-edit me-2"></i> Edit Data Penerima
                            </h5>
                        </div>

                        {{-- Body Kartu --}}
                        <div class="card-body p-4">
                            
                            {{-- Perhatikan route update membutuhkan ID --}}
                            <form action="{{ route('penerima.update', $item->penerima_id) }}" method="POST">
                                @csrf
                                @method('PUT') {{-- Wajib untuk method Update --}}

                                {{-- 1. DROPDOWN WARGA --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Warga</label>
                                    <select name="warga_id" class="form-control form-select">
                                        <option value="">-- Pilih Warga --</option>
                                        @foreach($warga as $w)
                                            <option value="{{ $w->id }}" 
                                                {{-- Logika Selected: Jika ID warga di data ini == ID di loop --}}
                                                {{ $item->warga_id == $w->id ? 'selected' : '' }}>
                                                {{ $w->nama }} (NIK: {{ $w->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 2. DROPDOWN PROGRAM --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Program Bantuan</label>
                                    <select name="program_id" class="form-control form-select">
                                        <option value="">-- Pilih Program --</option>
                                        @foreach($program as $p)
                                            <option value="{{ $p->program_id }}" 
                                                {{-- Logika Selected --}}
                                                {{ $item->program_id == $p->program_id ? 'selected' : '' }}>
                                                {{ $p->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 3. INPUT KETERANGAN --}}
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="4" 
                                        placeholder="Tambahkan catatan...">{{ old('keterangan', $item->keterangan) }}</textarea>
                                </div>

                                {{-- 4. TOMBOL AKSI --}}
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('penerima.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Batal
                                    </a>
                                    
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
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