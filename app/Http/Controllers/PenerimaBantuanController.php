<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaBantuan;
use App\Models\Warga;
use App\Models\ProgramBantuan;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. INI BARIS PENTING: Definisikan $query di paling awal
        // Kita siapkan query dasar dengan relasi ke warga dan program
        $query = PenerimaBantuan::with(['warga', 'program']);

        // 2. Logika Search (Opsional, hanya jalan jika ada input 'cari')
        if ($request->has('cari') && $request->cari != null) {
            $keyword = $request->cari;

            $query->whereHas('warga', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%");
            })->orWhereHas('program', function ($q) use ($keyword) {
                $q->where('nama_program', 'like', "%{$keyword}%");
            });
        }

        // 3. Eksekusi query (Pagination)
        // Karena $query sudah didefinisikan di langkah 1, baris ini aman sekarang
        $penerima = $query->latest('created_at')->paginate(9);

        // 4. Return view
        return view('pages.penerima.index', compact('penerima'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warga = Warga::all();
        $program = ProgramBantuan::all();
        return view('pages.penerima.create', compact('warga', 'program'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required',
            'program_id' => 'required',
            'keterangan' => 'nullable|string'
        ]);

        PenerimaBantuan::create($request->all());

        return redirect()->route('pages.penerima.index')->with('success', 'Penerima bantuan berhasil ditambahkan.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = PenerimaBantuan::findOrFail($id);
        $warga = Warga::all();
        $program = ProgramBantuan::all();

        return view('pages.penerima.edit', compact('item', 'warga', 'program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = PenerimaBantuan::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('pages.penerima.index')->with('success', 'Data penerima berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = PenerimaBantuan::findOrFail($id);
        $item->delete();

        return redirect()->route('penerima.index')->with('success', 'Data berhasil dihapus.');
    }

    public function show($id)
    {
        // Contoh logika untuk mengambil data
        $penerima = \App\Models\PenerimaBantuan::findOrFail($id);

        return view('pages.penerima.show', compact('penerima'));
    }
}
