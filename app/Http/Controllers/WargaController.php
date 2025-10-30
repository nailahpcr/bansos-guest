<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada

class WargaController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk warga.
     */
    public function dashboard()
    {
        $warga = Auth::user(); // Dapatkan warga yang sedang login
        
        // Ambil riwayat program yang diikuti
        $programDiajukan = $warga->programBantuans()
                                ->orderBy('pivot_tanggal_pengajuan', 'desc')
                                ->paginate(5);

        return view('warga.dashboard', compact('warga', 'programDiajukan'));
    }

    /**
     * Menampilkan daftar semua data warga.
     */
    public function index()
    {
        $wargas = Warga::latest()->paginate(10);
        return view('warga.warga_crud.index', compact('wargas'));
    }

    /**
     * Menampilkan form untuk menambah data warga baru.
     */
    public function create()
    {
        return view('warga_crud.create');
    }

    /**
     * Menyimpan data warga baru ke dalam database.
     */
    public function store(Request $request)
    {
       $request->validate([
            // ... (aturan validasi Anda sudah benar)
            'no_ktp' => 'required|string|size:16|unique:warga,no_ktp',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'telp' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100|unique:warga,email',
       ]);

        Warga::create($request->all());

        // DIPERBAIKI: Menggunakan nama rute 'warga.index'
        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dari satu data warga.
     */
    public function show(Warga $warga) // <-- Sekarang 'warga' akan cocok
    {
        // PENTING: Muat data relasi program bantuan
        $warga->load('programBantuans');
        
        return view('warga.warga_crud.show', compact('warga'));
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     */
    public function edit(Warga $warga) // <-- 'warga' cocok
    {
        return view('warga_crud.edit', compact('warga'));
    }

    /**
     * Mengupdate data warga yang ada di database.
     */
    public function update(Request $request, Warga $warga) // <-- 'warga' cocok
    {
        $request->validate([
            // ... (aturan validasi Anda sudah benar)
            'no_ktp' => 'required|string|size:16|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'telp' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100|unique:warga,email,' . $warga->warga_id . ',warga_id',
        ]);

        $warga->update($request->all());

        // DIPERBAIKI: Menggunakan nama rute 'warga.index'
        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil diperbarui.');
    } 

    /**
     * Menghapus data warga dari database.
     */
    public function destroy(Warga $warga) // <-- 'warga' cocok
    {
        $warga->delete();

        // DIPERBAIKI: Menggunakan nama rute 'warga.index'
        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil dihapus.');
    }
}
