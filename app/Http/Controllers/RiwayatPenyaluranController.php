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
    public function index()
    {
        $riwayats = RiwayatPenyaluran::with(['program', 'penerima'])->latest()->paginate(10);
        return view('pages.riwayat.index', compact('riwayats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data untuk dropdown
        $programs = ProgramBantuan::all();
        $penerimas = PenerimaBantuan::with(['warga'])->get();
        // dd($penerimas);
        
        return view('pages.riwayat.create', compact('programs', 'penerimas'));
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
        //
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
    public function update(Request $request, string $id)
    {
        $riwayat = RiwayatPenyaluran::findOrFail($id);

        $request->validate([
            'program_id' => 'required',
            'penerima_id' => 'required',
            'tahap_ke' => 'required',
            'tanggal' => 'required|date',
            'nilai' => 'required|numeric',
            'file' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        // dd($data);
        if ($request->hasFile('file')) {
            // Hapus foto lama jika ada
            if ($riwayat->file) {
                Storage::disk('public')->delete($riwayat->file);
            }
            $data['file'] = $request->file('file')->store('bukti-penyaluran', 'public');
        }

        $riwayat->update($data);

        return redirect()->route('riwayat.index')->with('success', 'Data penyaluran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $riwayat = RiwayatPenyaluran::findOrFail($id);
        
        // Hapus file foto
        if ($riwayat->bukti_penyaluran) {
            Storage::disk('public')->delete($riwayat->bukti_penyaluran);
        }

        $riwayat->delete();

        return redirect()->route('riwayat.index')->with('success', 'Data berhasil dihapus.');
    }
}