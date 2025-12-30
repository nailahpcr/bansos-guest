@extends('layout.guest.app')

@section('title', 'Detail Data Warga')

@section('content')
    <style>
        /* Background Konsisten */
        .show-section {
            padding: 60px 0;
            background: linear-gradient(to bottom, #FFD1DC 0%, #B2E2F2 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Glassmorphism Card Style */
        .custom-card-show {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            border: 1px solid rgba(255, 107, 129, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            padding: 30px;
            max-width: 700px;
            /* Membatasi lebar card agar tidak terlalu meluas */
            margin: 0 auto;
        }

        .table-detail {
            margin-bottom: 0;
            width: 100%;
        }

        .table-detail th {
            background-color: rgba(255, 107, 129, 0.03);
            color: #636e72;
            font-weight: 600;
            /* KUNCI: Lebar th diperkecil agar data (td) lebih merapat ke kiri */
            width: 180px;
            border-top: none;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            white-space: nowrap;
        }

        .table-detail th i {
            color: #FF6B81;
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .table-detail td {
            vertical-align: middle;
            padding: 12px 15px;
            color: #2d3436;
            border-top: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        /* Menghilangkan border bawah pada baris terakhir */
        .table-detail tr:last-child th,
        .table-detail tr:last-child td {
            border-bottom: none;
        }

        /* Button Styling */
        .btn-back,
        .btn-edit-action {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-back {
            background-color: #f1f2f6;
            color: #57606f;
        }

        .btn-back:hover {
            background-color: #dfe4ea;
            transform: translateY(-2px);
        }

        .btn-edit-action {
            background-color: #FF6B81;
            color: white;
        }

        .btn-edit-action:hover {
            background-color: #ee4e66;
            color: white;
            box-shadow: 0 5px 15px rgba(255, 107, 129, 0.3);
            transform: translateY(-2px);
        }
    </style>

    <section class="features show-section">
        <div class="container">
            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <div class="section-title">
                        <span class="badge rounded-pill px-3 py-2 mb-3"
                            style="background: rgba(255, 107, 129, 0.1); color: #FF6B81;">
                            <i class="fas fa-id-card me-1"></i> Profil Warga
                        </span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Detail: {{ $warga->nama }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Informasi lengkap data kependudukan yang terdaftar di
                            sistem.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="custom-card-show wow fadeInUp" data-wow-delay=".7s">
                        <div class="table-responsive">
                            <table class="table table-detail">
                                <tbody>
                                    <tr>
                                        <th><i class="fas fa-fingerprint"></i> ID Warga</th>
                                        <td><strong>{{ $warga->warga_id }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-id-card"></i> No. KTP (NIK)</th>
                                        <td>{{ $warga->no_ktp }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user"></i> Nama Lengkap</th>
                                        <td>{{ $warga->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-envelope"></i> Alamat Email</th>
                                        <td>{{ $warga->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-venus-mars"></i> Jenis Kelamin</th>
                                        <td>{{ $warga->jenis_kelamin }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-pray"></i> Agama</th>
                                        <td>{{ $warga->agama }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-briefcase"></i> Pekerjaan</th>
                                        <td>{{ $warga->pekerjaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-phone-alt"></i> No. Telepon</th>
                                        <td>{{ $warga->telp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-calendar-alt"></i> Terdaftar Pada</th>
                                        <td>{{ $warga->created_at ? $warga->created_at->format('d F Y') : 'Tanggal tidak tersedia' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('warga.index') }}" class="btn btn-back shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                            </a>
                            <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-edit-action shadow">
                                <i class="fas fa-edit me-2"></i> Edit Data Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
