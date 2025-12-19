@extends('layout.guest.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 col-md-8 mx-auto">
        <div class="card-body p-4">
            <h4 class="mb-4">Catat Penyaluran Baru</h4>
            
            <form action="{{ route('riwayat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                value="{{ $riwayat->... }}"
                
                {{-- Pilih Program --}}
                <div class="mb-3">
                    <label class="form-label">Program Bantuan</label>
                    <select name="program_id" class="form-select" required>
                        <option value="">Pilih Program</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->program_id }}">{{ $p->nama_program }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Penerima --}}
                <div class="mb-3">
                    <label class="form-label">Nama Penerima</label>
                    <select name="penerima_id" class="form-select" required>
                        <option value="">Pilih Warga</option>
                        @foreach($penerimas as $w)
                            <option value="{{ $w->pendaftar_id }}">{{ $w->nama_lengkap }} - {{ $w->nik }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahap Ke (Contoh: 1, 2)</label>
                        <input type="text" name="tahap_ke" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Penyaluran</label>
                        <input type="date" name="tanggal_penyaluran" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nilai Bantuan (Rp)</label>
                    <input type="number" name="nilai_bantuan" class="form-control" placeholder="Contoh: 300000" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Bukti Foto Penyaluran</label>
                    <input type="file" name="bukti_penyaluran" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill">Simpan Data</button>
            </form>
        </div>
    </div>
</div>
@endsection