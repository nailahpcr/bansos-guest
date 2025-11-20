<?php
namespace App\Http\Controllers;

use App\Models\ProgramBantuan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{

    public function indexPublic()
    {
        $programs = ProgramBantuan::latest()->paginate(9);

        return view('home', compact('programs'));
    }

    public function index()
    {
        $programs = ProgramBantuan::latest()->paginate(10);
    
        return view('pages.program.index', compact('programs'));
    }

    public function create()
    {
        return view('pages.program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'         => 'required|unique:program_bantuan',
            'nama_program' => 'required',
            'tahun'        => 'required|integer',
            'anggaran'     => 'required|numeric',
        ]);

        ProgramBantuan::create($request->all());
        return redirect()->route('kelola-program.index')->with('success', 'Program baru berhasil dibuat.');
    }

    public function show(ProgramBantuan $program)
    {
        return view('pages.program.show', compact('program'));
    }

    public function edit(string $program_id)
    {
        $program = ProgramBantuan::findOrFail($program_id);
        return view('pages.program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode'         => 'required',
            'nama_program' => 'required',
            'tahun'        => 'required|integer',
            'anggaran'     => 'required|numeric',
            'deskripsi'     => 'required',
        ]);

        $program = ProgramBantuan::findOrFail($id);

        $program->update($validatedData);

        return redirect()->route('kelola-program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(ProgramBantuan $program)
    {
        $program->delete();
        
        return redirect()->route('kelola-program.index')->with('success', 'Program berhasil dihapus.');
    }

    public function ajukanProgram($program_id)
    {
        $user = Auth::user();

        $program = ProgramBantuan::findOrFail($program_id);

        $user->programBantuans()->attach($program->program_id);

        return redirect()->route('kelola-program.index')->with('success', 'Anda berhasil mengikuti program ' . $program->nama_program);
    }

    public function batalkanProgram(ProgramBantuan $program)
    {
        $user = Auth::user();
        $user->programBantuans()->detach($program);

        return redirect()->route('kelola-program.index')->with('success', 'Partisipasi Anda pada program "' . $program->nama_program . '" telah dibatalkan.');
    }
}
