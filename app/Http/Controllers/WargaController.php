<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk warga.
     */
    public function dashboard()
    {
        $warga = Auth::user();

        $programDiajukan = $warga->programBantuans()
                                ->orderBy('pivot_tanggal_pengajuan', 'desc')
                                ->paginate(5);

        return view('pages.warga.index', compact('warga', 'programDiajukan'));
    }

    /** 
     * Menampilkan daftar semua data warga.
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $wargaQuery = Warga::query()->latest();

        if ($search) {
            $wargaQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('no_ktp', 'like', '%' . $search . '%')
                      ->orWhere('agama', 'like', '%' . $search . '%');
            });
        }

       $wargas = $wargaQuery->paginate(10)->withQueryString();

        $totalWarga = Warga::count();
        $totalLakiLaki = Warga::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Warga::where('jenis_kelamin', 'Perempuan')->count();

        return view('pages.warga.index', compact('wargas', 'totalWarga', 'totalLakiLaki', 'totalPerempuan', 'search'));    }

    /**
     * Menampilkan form untuk menambah data warga baru.
     */
    public function create()
    {
        return view('pages.warga.create');
    }

    /**
     * Menyimpan data warga baru ke dalam database.
     */
    public function store(Request $request)
    {
       $request->validate([
            'no_ktp' => 'required|string|size:16|unique:warga,no_ktp',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'telp' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100|unique:warga,email',
       ]);

        Warga::create($request->all());
        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan.');
        
    }

    /**
     * Menampilkan detail dari satu data warga.
     */
    public function show(Warga $warga)
    {
        $warga->load('programBantuans');

        return view('pages.warga.show', compact('warga'));
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     */
    public function edit(Warga $warga)
    {
        return view('pages.warga.edit', compact('warga'));
    }

    /**
     * Mengupdate data warga yang ada di database.
     */
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'no_ktp' => 'required|string|size:16|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'telp' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100|unique:warga,email,' . $warga->warga_id . ',warga_id',
        ]);

        $warga->update($request->all());

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Menghapus data warga dari database.
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil dihapus.');
    }
}
