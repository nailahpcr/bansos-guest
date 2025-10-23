<?php

namespace App\Http\Controllers;

use App\Models\ProgramBantuan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProgramBantuanController extends Controller
{
    public function index(): View
    {

        $programs = ProgramBantuan::latest()->paginate(10); 
        return view('program-bantuan.index', compact('programs'));
    }

    /**
     * Menampilkan form untuk membuat program baru.
     */
    public function create(): View
    {
        
        return view('program-bantuan.create');
    }

    /**
     * Menyimpan program baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode'         => 'required|string|max:50|unique:program_bantuan,kode',
            'nama_program' => 'required|string|max:100',
            'tahun'        => 'required|integer|digits:4',
            'anggaran'     => 'required|numeric',
            'deskripsi'    => 'nullable|string',
        ]);

    
        ProgramBantuan::create($request->all());

        return redirect()->route('program-bantuan.index')
                         ->with('success', 'Program baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu program (opsional, jarang dipakai jika data sudah ada di index).
     */
    public function show(ProgramBantuan $program): View
    {
        return view('program-bantuan.show', compact('program'));
    }

    /**
     * Menampilkan form untuk mengedit program.
     */
    public function edit(ProgramBantuan $program_bantuan)
    {
        return view('program-bantuan.edit', compact('program_bantuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramBantuan $program_bantuan)
    {
        $request->validate([
            'kode'         => 'required|string|max:50|unique:program_bantuan,kode,' . $program_bantuan->program_id . ',program_id',
            'nama_program' => 'required|string|max:100',
            'tahun'        => 'required|integer|digits:4',
            'anggaran'     => 'required|numeric',
            'deskripsi'    => 'nullable|string',
        ]);

        $program_bantuan->update($request->all());

        return redirect()->route('program-bantuan.index')
                         ->with('success', 'Data program berhasil diperbarui.');
    }

    /**
     * Menghapus program dari database.
     */
    public function destroy(ProgramBantuan $program_bantuan): RedirectResponse
    {
        // Hapus data
        $program_bantuan->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('program-bantuan.index')
                         ->with('success', 'Data program berhasil dihapus.');
    }
}
