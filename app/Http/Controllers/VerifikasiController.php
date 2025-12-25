<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifikasiLapangan;
use App\Models\PendaftarBantuan;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    public function index(Request $request)
{
    // Gunakan query builder agar bisa ditambah filter
    $query = VerifikasiLapangan::with(['pendaftar.warga', 'pendaftar.program']);

    // 1. Filter Pencarian Nama Petugas atau Catatan
    if ($request->filled('q')) {
        $query->where(function($q) use ($request) {
            $q->where('petugas', 'like', '%' . $request->q . '%')
              ->orWhere('catatan', 'like', '%' . $request->q . '%');
        });
    }

    // 2. Filter Skor (Sesuaikan dengan dropdown di Blade)
    if ($request->filled('skor')) {
        if ($request->skor == 'layak') {
            $query->where('skor', '>=', 70);
        } elseif ($request->skor == 'kurang') {
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
            'pendaftar_id' => 'required|exists:pendaftar_bantuans',
            'petugas'      => 'required|string',
            'tanggal'      => 'required|date',
            'skor'         => 'required|numeric',
            'file'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan data (Hanya satu kali create)
        $verifikasi = VerifikasiLapangan::create($request->except('file'));
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('verifikasi_bukti', 'public');
            $verifikasi->update(['file' => $path]);
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
        $verifikasi = VerifikasiLapangan::findOrFail($id);
        $pendaftar = PendaftarBantuan::all();
        
        return view('pages.verifikasi.edit', compact('verifikasi', 'pendaftar'));
    }

    public function update(Request $request, string $id)
    {
        $verifikasi = VerifikasiLapangan::findOrFail($id);

        $validated = $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar_bantuans,pendaftar_id',
            'petugas'      => 'required|string',
            'tanggal'      => 'required|date',
            'skor'         => 'required|numeric',
            'file'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $verifikasi->update($request->except('file'));

        if ($request->hasFile('file')) {
            // Hapus foto lama jika ada
            if ($verifikasi->file) {
                Storage::disk('public')->delete($verifikasi->file);
            }
            
            $path = $request->file('file')->store('verifikasi_bukti', 'public');
            $verifikasi->update(['file' => $path]);
        }

        return redirect()->route('verifikasi.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $verifikasi = VerifikasiLapangan::findOrFail($id);

        // Hapus file foto dari storage
        if ($verifikasi->file) {
            Storage::disk('public')->delete($verifikasi->file);
        }

        $verifikasi->delete();

        return redirect()->route('verifikasi.index')->with('success', 'Data berhasil dihapus');
    }
}