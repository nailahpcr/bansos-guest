<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\ProgramBantuan;
use App\Models\Warga;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendaftar = Pendaftar::with(['program', 'warga'])->latest()->paginate(6);
        $totalWarga = Pendaftar::count();
        $totalLakiLaki = Pendaftar::whereHas('warga', function($query) {
        $query->where('jenis_kelamin', 'Laki-laki'); // Sesuaikan kolom dan nilai jenis kelamin
        })->count();
    
        $totalPerempuan = Pendaftar::whereHas('warga', function($query) {
        $query->where('jenis_kelamin', 'Perempuan'); // Sesuaikan kolom dan nilai jenis kelamin
        })->count();
        return view('pages.pendaftar.index', compact('pendaftar', 'totalWarga', 'totalLakiLaki', 'totalPerempuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = ProgramBantuan::all();
        $wargas = Warga::all();

        return view('pages.pendaftar.create', compact('programs', 'wargas'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        $request->validate([
            'program_id' => 'required|exists:program_bantuan,program_id',
            'warga_id'   => 'required|exists:warga,warga_id',
            'status'     => 'required',
        ]);

        // Cek duplikasi agar warga tidak daftar program yang sama 2 kali (Opsional)
        $cek = Pendaftar::where('program_id', $request->program_id)
                               ->where('warga_id', $request->warga_id)
                               ->first();

        if($cek) {
            return back()->with('error', 'Warga ini sudah terdaftar di program tersebut!');
        }

        Pendaftar::create([
            'program_id' => $request->program_id,
            'warga_id' => $request->warga_id,
            'tanggal_daftar' => now(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pendaftar.index')->with('success', 'Pendaftaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $programs = ProgramBantuan::all();
        $wargas = Warga::all();

        return view('pages.pendaftar.edit', compact('pendaftar', 'programs', 'wargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'program_id' => 'required',
            'warga_id'   => 'required',
            'status'     => 'required',
        ]);

        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update($request->all());

        return redirect()->route('pendaftar.index')->with('success', 'Data pendaftaran berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->delete();

        return redirect()->route('pendaftar.index')->with('success', 'Data pendaftaran berhasil dihapus!');
    }
}
