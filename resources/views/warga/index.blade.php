@extends('layouts.app') {{-- atau layout Volt utama kamu --}}

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="fs-5 fw-bold mb-0">Data Warga</h2>
                <a href="{{ route('warga.create') }}" class="btn btn-sm btn-primary">Tambah Warga</a>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>No KTP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Agama</th>
                            <th>Pekerjaan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wargas as $warga)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $warga->no_ktp }}</td>
                                <td>{{ $warga->nama }}</td>
                                <td>{{ $warga->jenis_kelamin }}</td>
                                <td>{{ $warga->agama }}</td>
                                <td>{{ $warga->pekerjaan }}</td>
                                <td>{{ $warga->telp }}</td>
                                <td>{{ $warga->email }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                    <form action="{{ route('warga.destroy', $warga->warga_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
