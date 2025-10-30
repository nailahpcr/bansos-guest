<?php

namespace App\Http\Controllers;

use App\Models\ProgramBantuan; // Ganti jika nama model Anda berbeda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{

    public function indexPublic()
    {
        $programs = ProgramBantuan::latest()->paginate(9);
        // Tampilkan view untuk guest
        return view('home', compact('programs'));
    }

    public function index()
    {
        $programs = ProgramBantuan::latest()->paginate(10);
        // Tampilkan view manajemen CRUD untuk warga
        return view('program.index', compact('programs'));
    }

    public function create()
    {
        return view('program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:program_bantuan',
            'nama_program' => 'required',
            'tahun' => 'required|integer',
            'anggaran' => 'required|numeric',
        ]);

        ProgramBantuan::create($request->all());
        return redirect()->route('program.index')->with('success', 'Program baru berhasil dibuat.');
    }

    public function show(ProgramBantuan $program)
    {
        return view('program.show', compact('program'));
    }

    public function edit(ProgramBantuan $program)
    {
        return view('program.edit', compact('program'));
    }

    public function update(Request $request, ProgramBantuan $program)
    {
        $request->validate([
            'kode' => 'required|unique:programBantuan,kode,' . $program->program_id . ',program_id',
            'nama_program' => 'required',
            'tahun' => 'required|integer',
            'anggaran' => 'required|numeric',
        ]);

        $program->update($request->all());
        return redirect()->route('program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(ProgramBantuan $program)
    {
        $program->delete();
        return redirect()->route('program.index')->with('success', 'Program berhasil dihapus.');
    }

    public function ajukanProgram($program_id)
    {
        $user = Auth::user();

        $program = ProgramBantuan::findOrFail($program_id);

        $user->programBantuans()->attach($program->program_id);

        return redirect()->route('program.index')->with('success', 'Anda berhasil mengikuti program ' . $program->nama_program);
    }

    public function batalkanProgram(ProgramBantuan $program) 
{
    $user = Auth::user();
    $user->programBantuans()->detach($program); 
    return redirect()->route('program.index')->with('success', 'Partisipasi Anda pada program "' . $program->nama_program . '" telah dibatalkan.');
}
}
