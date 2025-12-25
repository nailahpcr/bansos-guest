<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function dashboard()
    {
        $warga = Auth::user();

        $programDiajukan = $warga->programBantuan()
                                ->orderBy('pivot_tanggal_pengajuan', 'desc')
                                ->paginate(6);

        return view('pages.warga.index', compact('warga', 'programDiajukan'));
    }


    public function index(Request $request) 
    {
        $search = $request->input('search');
        $genderFilter = $request->input('gender'); // Parameter baru untuk filter gender

        $wargaQuery = Warga::query()->latest();

        // 1. Logika Pencarian (Nama, NIK, Agama)
        if ($search) {
            $wargaQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('no_ktp', 'like', '%' . $search . '%')
                    ->orWhere('agama', 'like', '%' . $search . '%');
            });
        }

        // 2. Logika Pemfilteran Jenis Kelamin (Gender)
        if ($genderFilter && $genderFilter !== 'Semua') {
            $wargaQuery->where('jenis_kelamin', $genderFilter);
        }

        $wargas = $wargaQuery->paginate(9)->withQueryString();

        $totalWarga = Warga::count();
        $totalLakiLaki = Warga::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Warga::where('jenis_kelamin', 'Perempuan')->count();

        return view('pages.warga.index', compact('wargas', 'totalWarga', 'totalLakiLaki', 'totalPerempuan', 'search', 'genderFilter')); 
    }
   
    public function create()
    {
        return view('pages.warga.create');
    }

   
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


    public function show(Warga $warga)
    {
        $warga->load('programBantuan');

        return view('pages.warga.show', compact('warga'));
    }


    public function edit(Warga $warga)
    {
        return view('pages.warga.edit', compact('warga'));
    }


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


    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil dihapus.');
    }
}
