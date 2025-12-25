<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramBantuan;
use App\Models\Warga;
use App\Models\PendaftarBantuan;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    public function index(Request $request)
{
    // 1. Ambil Parameter Query dari URL
    $search = $request->query('q');
    $status_filter = $request->query('status_seleksi');

    // 2. Inisialisasi Query dengan Eager Loading (Warga & Program)
    // Gunakan eager loading 'warga' dan 'program' untuk mencegah N+1 Query Problem
    $query = PendaftarBantuan::with(['program', 'warga', 'files']);

    // 3. Logika Pencarian (Nama, NIK, atau Nama Program)
    if ($search) {
        $searchTerm = strtolower($search);
        $query->where(function ($q) use ($searchTerm) {
            $q->whereHas('warga', function ($qWarga) use ($searchTerm) {
                $qWarga->whereRaw('LOWER(nama) LIKE ?', ['%' . $searchTerm . '%'])
                       ->orWhere('no_ktp', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('program', function ($qProgram) use ($searchTerm) {
                $qProgram->whereRaw('LOWER(nama_program) LIKE ?', ['%' . $searchTerm . '%']);
            });
        });
    }

    // 4. Logika Filter Status Seleksi
    if ($status_filter) {
        $query->where('status_seleksi', $status_filter);
    }

    // 5. Eksekusi Pagination (9 data per halaman)
    // Menggunakan paginate() agar method links() dan appends() tersedia di Blade
    $pendaftar = $query->latest()->paginate(9);

    // 6. Mempertahankan Query String (Search & Filter) saat pindah halaman
    $pendaftar->appends($request->all());

    // 7. Hitung Statistik (Opsional untuk Dashboard)
    $totalPendaftar = PendaftarBantuan::count();
    $totalLakiLaki = PendaftarBantuan::whereHas('warga', function ($q) {
        $q->where('jenis_kelamin', 'Laki-laki');
    })->count();

    $totalPerempuan = PendaftarBantuan::whereHas('warga', function ($q) {
        $q->where('jenis_kelamin', 'Perempuan');
    })->count();

    // 8. Daftar Status untuk Looping Dropdown di View
    $statuses = ['Pending', 'Verifikasi', 'Ditolak', 'Diterima'];

    // 9. Kirim Data ke View
    return view('pages.pendaftar.index', compact(
        'pendaftar',
        'totalPendaftar',
        'totalLakiLaki',
        'totalPerempuan',
        'search',
        'statuses'
    ));
}

    public function create()
    {
        $programs = ProgramBantuan::all();
        $wargas = Warga::all();

        return view('pages.pendaftar.create', compact('programs', 'wargas'));
    }



    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'program_id'     => 'required|exists:program_bantuan,program_id', // Pastikan nama tabel benar
            'warga_id'       => 'required|exists:warga,warga_id',
            'status_seleksi' => 'required|in:Pending,Verifikasi,Ditolak,Diterima',
            'files.*'        => 'nullable|file|mimes:pdf,jpg,png,docx|max:2048'
        ]);

        // 2. Cek duplikasi pendaftaran (logika $cek Anda)
        $cek = PendaftarBantuan::where('program_id', $request->program_id)
            ->where('warga_id', $request->warga_id)
            ->first();
        if ($cek) {
            return back()->with('error', 'Warga ini sudah terdaftar di program tersebut!');
        }

        // 3. Simpan data Pendaftar (PASTIKAN SEMUA FIELD MASUK)
        $pendaftar = PendaftarBantuan::create([
            'program_id'     => $request->program_id,
            'warga_id'       => $request->warga_id,
            'tanggal_daftar' => now(),
            'status_seleksi' => $request->status_seleksi,
            'keterangan'     => $request->keterangan,
        ]);

        // 4. Proses Upload Multiple Files (Jika ada)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('pendaftar_berkas', 'public');

                $pendaftar->files()->create([
                    'filename'  => $file->getClientOriginalName(),
                    'path'      => $path,
                    'mime_type' => $file->getMimeType(),
                    'size'      => $file->getSize(),
                ]);
                // Jika Anda punya tabel lampiran, simpan di sini:
                // LampiranPendaftar::create([
                //    'pendaftar_id' => $pendaftar->id, 
                //    'path' => $path
                // ]);
            }
        }

        return redirect()->route('pendaftar.index')->with('success', 'Pendaftaran berhasil disimpan.');
    }


    public function show(string $id)
    {
        $pendaftar = PendaftarBantuan::with(['program', 'warga',])->findOrFail($id);
        return view('pages.pendaftar.show', compact('pendaftar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pendaftar = PendaftarBantuan::findOrFail($id);
        $programs = ProgramBantuan::all();
        $wargas = Warga::all();

        return view('pages.pendaftar.edit', compact('pendaftar', 'programs', 'wargas'));
    }


    public function update(Request $request, $id)
    {
        $pendaftar = PendaftarBantuan::findOrFail($id);

        $request->validate([
            'program_id'     => 'required|exists:program_bantuan,program_id',
            'warga_id'       => 'required|exists:warga,warga_id',
            'status_seleksi' => 'required|in:Pending,Verifikasi,Ditolak,Diterima',
            'files.*'        => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        ]);

        $pendaftar->update($request->only(['program_id', 'warga_id', 'status_seleksi', 'keterangan']));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('pendaftar_berkas', 'public');

                // Simpan ke database melalui relasi
                $pendaftar->files()->create([

                    'filename'  => $file->getClientOriginalName(),
                    'path'      => $path,
                    'mime_type' => $file->getMimeType(),
                    'size'      => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('pendaftar.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftar = PendaftarBantuan::findOrFail($id);

        // Hapus file fisik sebelum hapus data
        foreach ($pendaftar->files as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        $pendaftar->delete();
        return redirect()->route('pendaftar.index')->with('success', 'Data pendaftaran berhasil dihapus!');
    }

    public function destroyFile($id)
    {
        $file = \App\Models\PendaftarBantuan::findOrFail($id);

        if (Storage::disk('public')->exists($file->path)) {
        Storage::disk('public')->delete($file->path);
    }
        $file->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
