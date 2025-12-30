@extends('layout.guest.app')

@section('title', 'Manajemen Data Warga')

@section('content')
    <style>
        /*judul*/
        /* --- Styling Judul yang Serasi dengan Tema Pink --- */

        .section-title {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        /* H3 - Subtitle Atas */
        .section-title h3 {
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #ffffff;
            /* Glow tipis agar teks putih "angkat" dari background pink */
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            opacity: 0.9;
        }

        /* H2 - Judul Utama (Daftar Program Bantuan) */
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 15px;
            /* Efek Glow Putih yang Soft */
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.4),
                0 0 30px rgba(255, 88, 118, 0.2);
            letter-spacing: -0.5px;
        }

        /* Garis Dekoratif di bawah H2 */
        .section-title h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 5px;
            background: #ffffff;
            margin: 15px auto 0;
            border-radius: 50px;
            /* Glow pada garis dekoratif */
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
        }

        /* P - Deskripsi di bawah judul */
        .section-title p {
            font-size: 1.1rem;
            color: #ffffff !important;
            font-weight: 400;
            max-width: 600px;
            margin: 20px auto 0;
            opacity: 0.9;
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        /* Efek Animasi Glow Tambahan (Opsional) */
        .section-title h2 {
            animation: titleGlow 3s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            from {
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            }

            to {
                text-shadow: 0 0 20px rgba(255, 255, 255, 0.6),
                    0 0 30px rgba(255, 107, 129, 0.3);
            }
        }

        /* 1. Background Halaman: Gradasi Pink ke Putih */
        body {
            background: linear-gradient(180deg, #ff5876 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .features.section {
            background: transparent;
            /* Memastikan background section tidak menutupi gradasi body */
        }

        /* 2. Action Bar & Search Group */
        .action-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 107, 129, 0.1);
        }

        .search-combined-group {
            display: flex;
            flex-grow: 1;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .search-combined-group .form-select,
        .search-combined-group .form-control {
            border: none;
            height: 48px;
        }

        .search-combined-group .form-select {
            max-width: 160px;
            background-color: #f8f9fa;
            border-right: 1px solid #eee;
        }

        .btn-inner-search {
            background: #FF6B81;
            color: #fff;
            padding: 0 20px;
            border: none;
            transition: 0.3s;
        }

        .btn-inner-search:hover {
            background: #ee4e66;
            color: #fff;
        }

        /* 3. Action Buttons */
        .btn-add-warga {
            background: #2ecc71;
            color: #fff;
            height: 48px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            white-space: nowrap;
        }

        .btn-add-warga:hover {
            background: #27ae60;
            color: #fff;
            transform: translateY(-2px);
        }

        /* 4. Statistics Cards */
        .stat-card {
            transition: 0.3s;
            border-radius: 15px;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .bg-decoration {
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: currentColor;
            border-radius: 50%;
            opacity: 0.05;
            z-index: 1;
        }

        /* 5. Citizen Cards */
        /* --- Styling Citizen Card yang Diperbarui --- */

        .citizen-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            /* Border tipis transparan */
            background: #ffffff;
            /* Putih solid agar teks hitam terbaca jelas */
            position: relative;
            overflow: hidden;
        }

        .citizen-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        /* Header Card (Nama) */
        .citizen-card .card-title {
            color: #2d3436;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }

        /* Subtitle (NIK) */
        .citizen-card .card-subtitle {
            background: #f8f9fa;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 8px;
            color: #636e72 !important;
            font-weight: 600;
        }

        /* Garis Pemisah */
        .citizen-card hr {
            border-top: 1px dashed #dfe6e9;
            opacity: 1;
        }

        /* Info List (Ikon & Teks) */
        .citizen-card .mb-4 p {
            color: #444 !important;
            /* Warna teks lebih gelap agar jelas */
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .citizen-card .mb-4 p i {
            width: 25px;
            color: #ff5876;
            /* Warna ikon disamakan dengan tema pink */
            font-size: 1rem;
        }

        /* Styling Tombol Aksi */
        .citizen-card .btn-group .btn {
            border-radius: 12px !important;
            margin: 0 4px;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hover Warna Solid untuk masing-masing fungsi */

        .btn-light-info {
            background: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
            border: none;
        }

        .btn-light-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: none;
        }

        .btn-light-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: none;
        }

        /* Efek saat tombol ditekan (Click) */
        .citizen-card .btn-group .btn:active {
            transform: translateY(-1px) scale(0.98);
        }

        /* Efek Badge untuk Jenis Kelamin (Opsional) */
        .citizen-card p:first-child {
            margin-top: 10px;
        }

        /* Overlay halus saat hover */
        .citizen-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ff5876, #ff85a1);
            opacity: 0;
            transition: 0.3s;
        }

        .citizen-card:hover::before {
            opacity: 1;
        }

        /* 6. Responsive Data */
        @media (max-width: 991px) {
            .action-bar-container {
                flex-direction: column;
                align-items: stretch;
            }

            .search-combined-group {
                flex-direction: column;
                border: none;
                gap: 10px;
            }

            .search-combined-group .form-select,
            .search-combined-group .form-control {
                max-width: 100%;
                border-radius: 10px !important;
                border: 1px solid #eee;
            }

            .btn-add-warga {
                justify-content: center;
            }
        }
    </style>

    <section id="features" class="features section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <div class="section-title">
                        <h3 class="wow zoomIn text-white" data-wow-delay=".2s">Manajemen Data</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Daftar Data Warga</h2>
                        <p class="wow fadeInUp  text-white" data-wow-delay=".6s">Kelola informasi kependudukan dengan cepat
                            dan akurat.</p>
                    </div>
                </div>
            </div>

            {{-- Search bar, Filter kolom, Create Warga --}}
            <div class="row mb-4 wow fadeInUp" data-wow-delay=".7s">
                <div class="col-12">
                    <div class="action-bar-container shadow-sm">
                        <form action="{{ route('warga.index') }}" method="GET" class="flex-grow-1">
                            <div class="search-combined-group">
                                <select name="gender" class="form-select shadow-none">
                                    <option value="" {{ request('gender') == '' ? 'selected' : '' }}>Semua Gender
                                    </option>
                                    <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                <input type="text" name="search" class="form-control shadow-none"
                                    placeholder="Cari NIK atau Nama..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-inner-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <div class="d-flex gap-2">
                            <a class="btn-add-warga" href="{{ route('warga.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Warga
                            </a>
                            @if (request('search') || request('gender'))
                                <a href="{{ route('warga.index') }}"
                                    class="btn btn-light border d-flex align-items-center justify-content-center"
                                    style="width: 48px; border-radius: 12px;">
                                    <i class="fas fa-sync-alt text-muted"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- information card --}}
            <div class="row g-4 mb-5">
                @php
                    $cards = [
                        [
                            'label' => 'Total Warga',
                            'value' => $totalWarga,
                            'icon' => 'fa-users',
                            'color' => 'text-primary',
                            'bg' => 'rgba(13, 110, 253, 0.1)',
                        ],
                        [
                            'label' => 'Laki-laki',
                            'value' => $totalLakiLaki,
                            'icon' => 'fa-male',
                            'color' => 'text-info',
                            'bg' => 'rgba(13, 202, 240, 0.1)',
                        ],
                        [
                            'label' => 'Perempuan',
                            'value' => $totalPerempuan,
                            'icon' => 'fa-female',
                            'color' => 'text-danger',
                            'bg' => 'rgba(220, 53, 69, 0.1)',
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="col-md-4 wow fadeInUp" data-wow-delay=".3s">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body p-4 position-relative">
                                <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                                    <div class="icon-box rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px; background: {{ $card['bg'] }};">
                                        <i class="fas {{ $card['icon'] }} fa-2x {{ $card['color'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase mb-1 fw-bold {{ $card['color'] }}"
                                            style="font-size: 0.7rem; letter-spacing: 1px;">{{ $card['label'] }}</div>
                                        <h2 class="h3 mb-0 fw-bold text-dark">{{ number_format($card['value']) }}</h2>
                                    </div>
                                </div>
                                <div class="bg-decoration"
                                    style="color: {{ str_contains($card['color'], 'primary') ? '#0d6efd' : (str_contains($card['color'], 'info') ? '#0dcaf0' : '#dc3545') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row g-4">
                @forelse ($wargas as $warga)
                    <div class="col-md-6 col-lg-4 wow fadeInUp">
                        <div class="card citizen-card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold text-truncate">{{ $warga->nama }}</h5>
                                <h6 class="card-subtitle mb-3 text-muted small"><i class="fas fa-id-card me-1"></i>
                                    {{ $warga->no_ktp }}</h6>
                                <hr class="my-3 opacity-25">

                                <div class="mb-4">
                                    <p class="mb-1 small text-muted"><i
                                            class="fas fa-venus-mars me-2"></i>{{ $warga->jenis_kelamin }}</p>
                                    <p class="mb-1 small text-muted"><i class="fas fa-pray me-2"></i>{{ $warga->agama }}
                                    </p>
                                    <p class="mb-0 small text-muted"><i
                                            class="fas fa-phone me-2"></i>{{ $warga->telp ?? '-' }}</p>
                                </div>

                                {{-- button action --}}
                                <div class="btn-group w-100 gap-2">
                                    <a href="{{ route('warga.show', $warga->warga_id) }}"
                                        class="btn btn-light-info flex-fill rounded-3 py-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('warga.edit', $warga->warga_id) }}"
                                        class="btn btn-light-warning flex-fill rounded-3 py-2"><i
                                            class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-light-danger flex-fill rounded-3 py-2"
                                        data-bs-toggle="modal" data-bs-target="#del{{ $warga->warga_id }}"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="del{{ $warga->warga_id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-body text-center p-4">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <h5 class="fw-bold">Hapus Data?</h5>
                                    <p class="small text-muted">Yakin ingin menghapus <strong>{{ $warga->nama }}</strong>?
                                    </p>
                                    <div class="d-flex gap-2 mt-4">
                                        <button type="button" class="btn btn-light flex-fill rounded-pill"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('warga.destroy', $warga->warga_id) }}" method="POST"
                                            class="flex-fill">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger w-100 rounded-pill">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80"
                            class="opacity-25 mb-3" alt="Empty">
                        <p class="text-muted">Data warga tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {!! $wargas->appends(request()->except('page'))->links() !!}
            </div>
        </div>
    </section>
@endsection
