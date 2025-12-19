@extends('layout.guest.app') 

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Penyaluran</h2>
        <a href="{{ route('riwayat.create') }}" class="btn btn-primary rounded-pill">
            <i class="fas fa-plus me-1"></i> Catat Penyaluran
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program</th>
                        <th>Penerima</th>
                        <th>Tahap</th>
                        <th>Tanggal</th>
                        <th>Nilai</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayats as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->program->nama_program }}</td>
                        {{-- Sesuaikan nama kolom nama di tabel penerima --}}
                        <td>{{ $item->penerima->nama_lengkap ?? 'N/A' }}</td> 
                        <td>{{ $item->tahap_ke }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->tanggal_penyaluran)) }}</td>
                        <td>Rp {{ number_format($item->nilai_bantuan, 0, ',', '.') }}</td>
                        <td>
                            @if($item->bukti_penyaluran)
                                <a href="{{ asset('storage/' . $item->bukti_penyaluran) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-image"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('riwayat.edit', $item->penyaluran_id) }}" class="btn btn-sm btn-warning text-white">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('riwayat.destroy', $item->penyaluran_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $riwayats->links() }}
        </div>
    </div>
</div>
@endsection