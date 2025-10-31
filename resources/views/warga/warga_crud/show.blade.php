@extends('layout.layout')

@section('title', 'Detail Data Warga')

@section('content')

<section id="features" class="features section">
    <div class="container">

        {{-- SECTION TITLE (Diadaptasi dari kode Anda) --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3 class="wow zoomIn" data-wow-delay=".2s">Manajemen Data</h3>
                    {{-- Judul dinamis menampilkan nama warga --}}
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Detail Warga: {{ $warga->nama }}</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Berikut adalah rincian lengkap dari data warga yang dipilih.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                    <div class="card-header">
                        <h4 class="mb-0">Informasi Lengkap Warga</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">ID Warga</th>
                                    <td>{{ $warga->warga_id }}</td>
                                </tr>
                                <tr>
                                    <th>No. KTP</th>
                                    <td>{{ $warga->no_ktp }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $warga->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Email</th>
                                    {{-- Menggunakan null coalescing '??' untuk data opsional --}}
                                    <td>{{ $warga->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $warga->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>{{ $warga->agama }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>{{ $warga->pekerjaan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $warga->telp ?? '-' }}</td>
                                </tr>

                                 <tr>
                                    <th>Tanggal Dibuat</th>
                                    {{--
                                      PERBAIKAN ERROR:
                                      Menggunakan helper optional() untuk mencegah error
                                      jika $warga->created_at bernilai null.
                                    --}}
                                    <td>{{ optional($warga->created_at)->format('d F Y \p\u\k\u\l H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diperbarui</th>
                                    {{-- PERBAIKAN ERROR: Terapkan juga di updated_at --}}
                                    <td>{{ optional($warga->updated_at)->format('d F Y \p\u\k\u\l H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        {{-- Tombol navigasi --}}
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
