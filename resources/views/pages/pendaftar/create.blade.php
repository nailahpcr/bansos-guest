@extends('layout.guest.app')

@section('title', 'Tambah Pendaftar')

@section('content')
    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Pendaftaran Baru</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftarkan Warga</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Hubungkan warga dengan program bantuan yang tersedia.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('pendaftar.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Pilih Program --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Pilih Program Bantuan:</strong></label>
                                    <select name="program_id" class="form-select" required>
                                        <option value="">-- Pilih Program --</option>
                                        @foreach ($programs as $prog)
                                            <option value="{{ $prog->program_id }}" {{ old('program_id') == $prog->program_id ? 'selected' : '' }}>
                                                {{ $prog->nama_program }} ({{ $prog->tahun }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pilih Warga --}}
                                <div class="mb-3">
                                    <label class="form-label"><strong>Pilih Warga:</strong></label>
                                    <select name="warga_id" class="form-select" required>
                                        <option value="">-- Pilih Warga --</option>
                                        @foreach ($wargas as $w)
                                            <option value="{{ $w->warga_id }}" {{ old('warga_id') == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} - {{ $w->no_ktp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status & Keterangan --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Status Awal:</strong></label>
                                        <select name="status_seleksi" class="form-select">
                                            <option value="Pending" {{ old('status_seleksi', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Verifikasi" {{ old('status_seleksi') == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                            <option value="Diterima" {{ old('status_seleksi') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="Ditolak" {{ old('status_seleksi') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Keterangan (Opsional):</strong></label>
                                        <input type="text" name="keterangan" class="form-control"
                                            placeholder="Catatan tambahan..." value="{{ old('keterangan') }}">
                                    </div>
                                </div>

                                {{-- Upload Multiple Files --}}
                                <div class="mb-4">
                                    <label class="form-label"><strong>Upload File Pendukung:</strong></label>
                                    <div class="input-group">
                                        <input type="file" name="files[]" class="form-control" multiple 
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                                        <button class="btn btn-outline-secondary" type="button" id="addMoreFiles">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <small class="text-muted">Maksimal 10MB per file. Format: JPG, PNG, PDF, DOC, XLS</small>
                                    
                                    {{-- Preview area for selected files --}}
                                    <div id="filePreview" class="mt-3"></div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a class="btn btn-secondary" href="{{ route('pendaftar.index') }}">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[name="files[]"]');
            const filePreview = document.getElementById('filePreview');
            const addMoreBtn = document.getElementById('addMoreFiles');
            
            // Handle file selection preview
            if (fileInput && filePreview) {
                fileInput.addEventListener('change', function(e) {
                    filePreview.innerHTML = '';
                    
                    Array.from(e.target.files).forEach((file, index) => {
                        const div = document.createElement('div');
                        div.className = 'alert alert-light d-flex justify-content-between align-items-center mb-2';
                        
                        let preview = '';
                        if (file.type.startsWith('image/')) {
                            preview = `<i class="fas fa-image text-primary me-2"></i>`;
                            // Show image preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.width = '50px';
                                img.style.height = '50px';
                                img.style.objectFit = 'cover';
                                img.className = 'me-2 img-thumbnail';
                                div.querySelector('div').prepend(img);
                            };
                            reader.readAsDataURL(file);
                        } else if (file.type === 'application/pdf') {
                            preview = `<i class="fas fa-file-pdf text-danger me-2"></i>`;
                        } else if (file.type.includes('word') || file.type.includes('document')) {
                            preview = `<i class="fas fa-file-word text-primary me-2"></i>`;
                        } else if (file.type.includes('excel') || file.type.includes('spreadsheet')) {
                            preview = `<i class="fas fa-file-excel text-success me-2"></i>`;
                        } else {
                            preview = `<i class="fas fa-file me-2"></i>`;
                        }
                        
                        div.innerHTML = `
                            <div class="d-flex align-items-center">
                                ${preview}
                                <div>
                                    <div class="file-name">${file.name}</div>
                                    <small class="text-muted">(${(file.size / 1024).toFixed(2)} KB)</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger remove-file" data-index="${index}">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        
                        filePreview.appendChild(div);
                    });
                });
                
                // Remove file from preview and input
                filePreview.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-file')) {
                        const index = e.target.closest('.remove-file').dataset.index;
                        const dt = new DataTransfer();
                        const files = fileInput.files;
                        
                        for (let i = 0; i < files.length; i++) {
                            if (i != index) {
                                dt.items.add(files[i]);
                            }
                        }
                        
                        fileInput.files = dt.files;
                        fileInput.dispatchEvent(new Event('change'));
                    }
                });
            }
            
            // Add more files button
            if (addMoreBtn) {
                addMoreBtn.addEventListener('click', function() {
                    const newInput = document.createElement('input');
                    newInput.type = 'file';
                    newInput.name = 'files[]';
                    newInput.className = 'form-control mt-2';
                    newInput.multiple = true;
                    newInput.accept = '.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx';
                    newInput.addEventListener('change', function(e) {
                        // Merge files with main input
                        const dt = new DataTransfer();
                        const existingFiles = fileInput.files;
                        
                        for (let i = 0; i < existingFiles.length; i++) {
                            dt.items.add(existingFiles[i]);
                        }
                        
                        for (let i = 0; i < e.target.files.length; i++) {
                            dt.items.add(e.target.files[i]);
                        }
                        
                        fileInput.files = dt.files;
                        fileInput.dispatchEvent(new Event('change'));
                        
                        // Remove this additional input
                        e.target.remove();
                    });
                    
                    fileInput.parentNode.insertBefore(newInput, addMoreBtn);
                });
            }
        });
    </script>
@endsection