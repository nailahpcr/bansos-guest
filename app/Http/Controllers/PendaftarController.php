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
        $status = $request->query('status_seleksi');

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
        if ($request->filled('status_seleksi')) {
            $query->where('status_seleksi', $status);
        }

        // 5. Eksekusi Pagination (9 data per halaman)
        // Menggunakan paginate() agar method links() dan appends() tersedia di Blade
        $pendaftar = $query->latest()->paginate(9);

        // 6. Mempertahankan Query String (Search & Filter) saat pindah halaman
        $pendaftar->appends($request->all());

        // 7. Hitung Statistik (Opsional untuk Dashboard)
        $totalPendaftar = PendaftarBantuan::count();
        $status = $request->status ?? 'Semua';

        // 9. Kirim Data ke View
        return view('pages.pendaftar.index', compact(
            'pendaftar',
            'totalPendaftar',
            'search',
            'status'
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
        $pendaftar = PendaftarBantuan::with(['program', 'warga', 'files'])->findOrFail($id);
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

        // 1. Update Data Utama
        $pendaftar->update([
            'program_id' => $request->program_id,
            'warga_id' => $request->warga_id,
            'status_seleksi' => $request->status_seleksi,
            'keterangan' => $request->keterangan,
        ]);

        // 2. Cek jika ada file baru yang diunggah
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Validasi file (Opsional tapi disarankan)
                $path = $file->store('pendaftaran/berkas', 'public');

                // Simpan ke tabel files (sesuaikan nama model file Anda)
                $pendaftar->files()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'ext' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->route('pendaftar.index')->with('success', 'Data dan berkas berhasil diperbarui!');
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
        $file = \App\Models\PendaftarFile::findOrFail($id);

        Storage::disk('public')->delete($file->path); // Hapus file fisik
        $file->delete(); // Hapus record database

        return back()->with('success', 'File berhasil dihapus.');
    }
}
