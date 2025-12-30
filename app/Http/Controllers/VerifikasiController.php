<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifikasiLapangan;
use App\Models\VerifikasiFile;
use App\Models\PendaftarBantuan;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = VerifikasiLapangan::with(['pendaftar.warga', 'pendaftar.program']);

        // 1. Pencarian Umum (Nama Warga atau Catatan)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('catatan', 'like', '%' . $search . '%')
                    ->orWhereHas('pendaftar.warga', function ($qw) use ($search) {
                        $qw->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        // 2. Filter Spesifik: Nama Petugas
        if ($request->filled('filter_petugas')) {
            $query->where('petugas', 'like', '%' . $request->filter_petugas . '%');
        }

        // 3. Filter Spesifik: Status 
        if ($request->filled('status')) {
            if ($request->status == 'layak') {
                $query->where('skor', '>=', 70);
            } elseif ($request->status == 'kurang') {
                $query->where('skor', '<', 70);
            }
        }

        $verifikasi = $query->latest()->paginate(9)->withQueryString();

        return view('pages.verifikasi.index', compact('verifikasi'));
    }

    public function create()
    {
        $pendaftar = PendaftarBantuan::all();
        return view('pages.verifikasi.create', compact('pendaftar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar_bantuans,id',
            'petugas'      => 'required|string',
            'tanggal'      => 'required|date',
            'skor'         => 'required|numeric',
            'files.*'   => 'required|image|mimes:jpeg,png,jpg,|max:2048',
        ]);

        // Simpan data (Hanya satu kali create)
        $verifikasi = VerifikasiLapangan::create($request->except('files'));
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('verifikasi_bukti', 'public');
                $verifikasi->files()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path'     => $path
                ]);
            }
        }

        return redirect()->route('verifikasi.index')->with('success', 'Data berhasil disimpan');
    }

    public function show(string $id)
    {
        $verifikasi = VerifikasiLapangan::with(['pendaftar.warga', 'pendaftar.program'])
            ->findOrFail($id);

        return view('pages.verifikasi.show', compact('verifikasi'));
    }

    public function edit(string $id)
    {
        $verifikasi = VerifikasiLapangan::with('files')->findOrFail($id);
        $pendaftar = PendaftarBantuan::all();

        $files = $verifikasi->files;
        return view('pages.verifikasi.edit', compact('verifikasi', 'pendaftar', 'files'));
    }

    public function update(Request $request, string $id)
    {
        $verifikasi = VerifikasiLapangan::findOrFail($id);

        $validated = $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar_bantuans,pendaftar_id',
            'petugas'      => 'required|string',
            'tanggal'      => 'required|date',
            'skor'         => 'required|numeric',
            'files.*'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $verifikasi->update($request->except('files'));

        // Tambah file baru tanpa menghapus yang lama (Incremental)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('verifikasi_bukti', 'public');
                $verifikasi->files()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path'     => $path
                ]);
            }
        }

        return redirect()->route('verifikasi.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $verifikasi = VerifikasiLapangan::with('files')->findOrFail($id);
        // Hapus file foto dari storage
        foreach ($verifikasi->files as $file) {
            Storage::disk('public')->delete($file->path);
        }

        $verifikasi->delete();

        return redirect()->route('verifikasi.index')->with('success', 'Data berhasil dihapus');
    }

    public function destroyFile($id)
    {
        $file = \App\Models\VerifikasiFile::findOrFail($id);

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();

        return back()->with('success', 'Berkas berhasil dihapus');
    }
}
