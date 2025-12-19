<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifikasiLapangan;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $verifikasi = \App\Models\VerifikasiLapangan::with(['pendaftar.warga', 'pendaftar.program'])
                    ->latest()
                    ->paginate(9); // Wajib paginate agar link() jalan

    return view('pages.verifikasi.index', compact('verifikasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendaftar = Pendaftar::all();
        return view('pages.verifikasi.create', compact('pendaftar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar_bantuan,pendaftar_id',
            'petugas'      => 'required|string',
            'tanggal'      => 'required|date',
            'skor'         => 'required|numeric',
            'foto_bukti'   => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $verifikasi = VerifikasiLapangan::create($request->all());

       $data = $request->except('foto_bukti');
    $verifikasi = VerifikasiLapangan::create($data);

    // 2. Logika Upload Foto (Menggunakan fitur bawaan Laravel)
    if ($request->hasFile('foto_bukti')) {
        // Simpan file ke folder storage/app/public/verifikasi_bukti
        $path = $request->file('foto_bukti')->store('verifikasi_bukti', 'public');
        
        // Update kolom foto_bukti di database dengan lokasi file
        $verifikasi->update(['foto_bukti' => $path]);
    }

        return redirect()->route('verifikasi.index')->with('success', 'Data berhasil disimpan');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
