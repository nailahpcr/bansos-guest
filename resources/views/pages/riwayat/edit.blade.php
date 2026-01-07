@extends('layout.guest.app')

@section('title', 'Edit Riwayat Penyaluran')

@section('content')
    <style>
        #features {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 60px 0;
        }

        .card {
            border-radius: 20px;
            border: none;
        }

        .section-title h3 {
            color: #ff5876;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-label {
            font-weight: 600;
            color: #2d3436;
        }

        .btn-success {
            background: linear-gradient(45deg, #20bf6b, #0fb9b1);
            border: none;
            border-radius: 50px;
        }

        .btn-secondary {
            border-radius: 50px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px 15px;
        }

        .border-dashed {
            border-style: dashed !important;
        }
    </style>

    <section id="features" class="features section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center mb-4">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Edit Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Update Penyaluran</h2>
                    </div>

                    <div class="card shadow-lg wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4 p-md-5">

                            {{-- ALERT VALIDASI --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- FORM UTAMA --}}
                            <form action="{{ route('riwayat.update', $riwayat->penyaluran_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="form-label">Program Bantuan</label>
                                    <select name="program_id" class="form-select @error('program_id') is-invalid @enderror"
                                        required>
                                        @foreach ($programs as $p)
                                            <option value="{{ $p->program_id }}"
                                                {{ $riwayat->program_id == $p->program_id ? 'selected' : '' }}>
                                                {{ $p->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nama Penerima</label>
                                    <select name="penerima_id"
                                        class="form-select @error('penerima_id') is-invalid @enderror" required>
                                        @foreach ($penerimas as $w)
                                            <option value="{{ $w->penerima_id }}"
                                                {{ $riwayat->penerima_id == $w->penerima_id ? 'selected' : '' }}>
                                                {{ $w->warga->nama ?? 'N/A' }} - {{ $w->warga->no_ktp ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Tahap Ke</label>
                                        <input type="number" name="tahap_ke" class="form-control"
                                            value="{{ $riwayat->tahap_ke }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Penyaluran</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ $riwayat->tanggal }}" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nilai Bantuan (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="nilai" class="form-control"
                                            value="{{ $riwayat->nilai }}" required>
                                    </div>
                                </div>

                                <hr class="my-5">

                                {{-- MANAJEMEN FILE --}}
                                <div class="mb-4">
                                    <label class="form-label d-block">Dokumen Saat Ini:</label>
                                    @php $files = $riwayat->files ?? collect(); @endphp

                                    @if ($files->count() > 0)
                                        <div class="list-group mb-3">
                                            @foreach ($files as $file)
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center bg-light border-dashed">
                                                    <div class="d-flex align-items-center text-truncate">
                                                        <i
                                                            class="fas {{ str_contains($file->mime_type, 'pdf') ? 'fa-file-pdf text-danger' : 'fa-file-image text-primary' }} me-3 fs-4"></i>
                                                        <span class="text-truncate fw-bold">{{ $file->filename }}</span>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary"><i
                                                                class="fas fa-eye"></i></a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="deleteFile({{ $file->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted small italic">Belum ada dokumen pendukung.</p>
                                    @endif

                                    <label class="form-label text-primary mt-3">Unggah Dokumen Baru (Multi-upload)</label>
                                    <input type="file" name="dokumen_riwayat[]" class="form-control" multiple
                                        accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="text-muted">Format: JPG, PNG, PDF (Max 2MB per file)</small>
                                </div>

                                {{-- BUTTON ACTION --}}
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                    <a href="{{ route('riwayat.index') }}" class="btn btn-secondary px-4">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-success px-5 shadow-sm">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>

                            {{-- HIDDEN FORMS UNTUK HAPUS FILE --}}
                            @foreach ($files as $file)
                                {{-- Form ini harus ada agar script JavaScript bisa melakukan submit --}}
                                <form id="form-delete-file-{{ $file->id }}"
                                    action="{{ route('riwayat.files.destroy', $file->id) }}" method="POST"
                                    style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function deleteFile(id) {
            if (confirm('Hapus dokumen ini secara permanen?')) {
                document.getElementById('form-delete-file-' + id).submit();
            }
        }
    </script>
@endsection
