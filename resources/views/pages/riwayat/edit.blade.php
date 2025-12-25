@extends('layout.guest.app')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 col-md-8 mx-auto">
            <div class="card-body p-4">
                <h4 class="mb-4">Edit Data Penyaluran</h4>

                {{-- Update action ke route update dan tambahkan ID --}}
                <form action="{{ route('riwayat.update', $riwayat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Laravel memerlukan directive method PUT untuk proses update --}}
                    @method('PUT')

                    {{-- Pilih Program --}}
                    <div class="mb-3">
                        <label class="form-label">Program Bantuan</label>
                        <select name="program_id" class="form-select" required>
                            <option value="">Pilih Program</option>
                            @foreach ($programs as $p)
                                <option value="{{ $p->program_id }}" {{ $riwayat->program_id == $p->program_id ? 'selected' : '' }}>
                                    {{ $p->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Penerima --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Penerima</label>
                        <select name="penerima_id" class="form-select" required>
                            <option value="">Pilih Warga</option>
                            @foreach ($penerimas as $w)
                                <option value="{{ $w->penerima_id }}" {{ $riwayat->penerima_id == $w->penerima_id ? 'selected' : '' }}>
                                    {{ $w->warga->nama ?? 'Nama Tidak Ditemukan' }} - 
                                    {{ $w->warga->no_ktp ?? 'NIK Tidak Ada' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahap Ke</label>
                            <input type="text" name="tahap_ke" class="form-control" value="{{ $riwayat->tahap_ke }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Penyaluran</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $riwayat->tanggal }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nilai Bantuan (Rp)</label>
                        <input type="number" name="nilai" class="form-control" value="{{ $riwayat->nilai }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Bukti Foto Penyaluran</label>
                        @if($riwayat->file)
                            <div class="mb-2">
                                <small class="text-muted d-block">Foto saat ini:</small>
                                <img src="{{ asset('storage/' . $riwayat->file) }}" alt="Bukti" class="img-thumbnail" style="height: 100px">
                            </div>
                        @endif
                        <input type="file" name="file" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Update Data</button>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-light w-100 rounded-pill mt-2">Batal</a>
                </form>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger mx-4 mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection