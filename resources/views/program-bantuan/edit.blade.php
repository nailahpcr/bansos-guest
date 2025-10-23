<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Volt - Edit Program Bantuan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link type="text/css" href="{{ asset('assets/css/volt.css') }}" rel="stylesheet">
</head>

<body>
    {{-- Navbar Mobile --}}
    <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
        <a class="navbar-brand me-lg-5" href="#">
            <img class="navbar-brand-dark" src="{{ asset('assets/img/brand/light.svg') }}" alt="Volt logo" />
        </a>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    {{-- Sidebar --}}
    <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
        <div class="sidebar-inner px-4 pt-3">
            <ul class="nav flex-column pt-3 pt-md-0">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="{{ route('program-bantuan.index') }}" class="nav-link">
                        <span class="sidebar-text">Program Bantuan</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <main class="content" style="margin-left: 288px;">
        <div class="py-4">
             <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Edit Program Bantuan</h1>
                    <p class="mb-0">Form untuk mengubah data program bantuan.</p>
                </div>
                <div>
                    <a href="{{ route('program-bantuan.index') }}" class="btn btn-outline-gray-600"> Kembali</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h2 class="fs-5 fw-bold mb-0">Form Edit Program Bantuan</h2>
                    </div>
                    <div class="card-body">
            
                        <form action="{{ route('program-bantuan.update', $program_bantuan) }}" method="POST">
                            @csrf
                            @method('PUT') 

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kode">Kode Program</label>
                                    <input type="text" class="form-control" name="kode" value="{{ old('kode', $program_bantuan->kode) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama_program">Nama Program</label>
                                    <input type="text" class="form-control" name="nama_program" value="{{ old('nama_program', $program_bantuan->nama_program) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control" name="tahun" value="{{ old('tahun', $program_bantuan->tahun) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anggaran">Anggaran (Rp)</label>
                                    <input type="number" class="form-control" name="anggaran" value="{{ old('anggaran', $program_bantuan->anggaran) }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="4">{{ old('deskripsi', $program_bantuan->deskripsi) }}</textarea>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary" type="submit">Update Data</button>
                                <a href="{{ route('program-bantuan.index') }}" class="btn btn-gray-200">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white rounded shadow p-5 mb-4 mt-4">
             <div class="row">
                <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
                    <p class="mb-0 text-center text-lg-start">© 2019-{{ date('Y') }} <a
                            class="text-primary fw-normal" href="https://themesberg.com"
                            target="_blank">Themesberg</a>
                    </p>
                </div>
            </div>
        </footer>
    </main>

    <script src="{{ asset('vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>