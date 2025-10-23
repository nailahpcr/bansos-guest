<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Bina Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hero-section {
            background-color: #3187e9;
            color: white;
            padding: 50px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
        }

        .card-container {
            padding: 20px 0;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #f8f9fa;
            text-align: center;
        }

        .footer p {
            margin: 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .table-custom-header th {
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem Informasi Bina Desa
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="display-6 mb-2">Daftar Program Bantuan Sosial dan Penerima Manfaat
            {{-- Menggunakan count() dengan Null Coalescing untuk menghindari error --}}
            <p class="lead mb-0">Total {{ count($programs ?? []) }} program aktif telah dialokasikan anggarannya</p>
        </div>
    </section>

    <section class="card-container">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{-- Judul dengan Total Program Dinamis --}}
                    <h5 class="mb-0">Data Program Bantuan Sosial (Total: {{ count($programs ?? []) }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- Cek apakah ada data, menggunakan Null Coalescing '?? []' --}}
                        @if(count($programs ?? []) > 0)
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-custom-header table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Program</th>
                                        <th>Nama Program</th>
                                        <th>Tahun</th>
                                        <th>Deskripsi</th>
                                        <th>Anggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop data dari $programs --}}
                                    @foreach($programs as $program)
                                    <tr>
                                        <td>{{ $program['program_id'] }}</td>
                                        <td>**{{ $program['kode'] }}**</td>
                                        <td>{{ $program['nama_program'] }}</td>
                                        <td>{{ $program['tahun'] }}</td>
                                        <td>{{ $program['deskripsi'] }}</td>
                                        <td>Rp {{ number_format($program['anggaran'], 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                             {{-- Pesan jika data kosong --}}
                             <p class="text-center text-muted mt-3 mb-0">Tidak ada data program yang ditemukan.</p>
                        @endif

                    </div>
                    
                    
                    
                    {{-- Keterangan Total Data Dinamis  --}}
                    <p class="text-muted small mb-0">Data program saat ini berjumlah: {{ count($programs ?? []) }}</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Sistem Informasi Bina Desa. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>