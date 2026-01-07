<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPenyaluran;
use App\Models\ProgramBantuan;
use App\Models\PendaftarBantuan;
use App\Models\PenerimaBantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatPenyaluranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RiwayatPenyaluran::with(['program', 'penerima.warga']);

        // Gunakan 'where' dengan fungsi closure untuk membungkus logika pencarian (q)
        // Ini agar logika OR di dalam tidak mengganggu filter tahap di luar
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('penerima.warga', function ($sub) use ($request) {
                    $sub->where('nama', 'like', '%' . $request->q . '%');
                })->orWhereHas('program', function ($sub) use ($request) {
                    $sub->where('nama_program', 'like', '%' . $request->q . '%');
                });
            });
        }

        // Filter Tahap (Harus menggunakan where biasa di luar closure pencarian)
        if ($request->filled('tahap')) {
            $query->where('tahap_ke', $request->tahap);
        }

        $riwayats = $query->latest()->paginate(9);

        // Karena Anda sudah menghapus filter program di Blade, 
        // baris $programs di bawah ini bisa dihapus jika tidak dipakai lagi.
        return view('pages.riwayat.index', compact('riwayats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data untuk dropdown
        $pendaftar = PendaftarBantuan::all();
        $programs = ProgramBantuan::all();
        $penerimas = PenerimaBantuan::with(['warga'])->get();
        // dd($penerimas);

        return view('pages.riwayat.create', compact('programs', 'penerimas', 'pendaftar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'penerima_id' => 'required',
            'tahap_ke' => 'required|string',
            'tanggal' => 'required|date',
            'nilai' => 'required|numeric',
            'file' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->all();
        // dd( $data);

        // Upload Foto
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('bukti-penyaluran', 'public');
        }
        RiwayatPenyaluran::create($data);

        return redirect()->route('riwayat.index')->with('success', 'Data penyaluran berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data riwayat beserta relasi program, penerima, dan warga
        $riwayat = RiwayatPenyaluran::with(['program', 'penerima.warga'])->findOrFail($id);

        return view('pages.riwayat.show', compact('riwayat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $riwayat = RiwayatPenyaluran::findOrFail($id);
        $programs = ProgramBantuan::all();
        $penerimas = PenerimaBantuan::with(['warga'])->get();
        return view('pages.riwayat.edit', compact('riwayat', 'programs', 'penerimas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $riwayat = RiwayatPenyaluran::findOrFail($id);
        $riwayat->update($request->all());

        // Cek jika ada upload file (sesuai hasil debug dokumen_riwayat)
        if ($request->hasFile('dokumen_riwayat')) {
            foreach ($request->file('dokumen_riwayat') as $file) {
                $path = $file->store('riwayat_files', 'public');

                // Simpan ke model RiwayatFile
                $riwayat->files()->create([
                    'riwayat_id' => $riwayat->penyaluran_id,
                    'filename'   => $file->getClientOriginalName(),
                    'path'       => $path,
                    'mime_type'  => $file->getClientMimeType(),
                    'size'       => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('riwayat.index')->with('success', 'Data berhasil diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat = RiwayatPenyaluran::findOrFail($id);

        // Perbaikan: Gunakan nama kolom 'file' sesuai DB, bukan 'bukti_penyaluran'
        if ($riwayat->file) {
            Storage::disk('public')->delete($riwayat->file);
        }

        if ($riwayat->foto_penyerahan) {
            Storage::disk('public')->delete($riwayat->foto_penyerahan);
        }

        $riwayat->delete();
        return redirect()->route('riwayat.index')->with('success', 'Data berhasil dihapus.');
    }

    public function destroyFile($id)
    {
        // Cari data di tabel file pendukung
        $file = \App\Models\RiwayatFile::findOrFail($id);

        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        // Hapus data dari database
        $file->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
    }
}
