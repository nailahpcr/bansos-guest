<?php

namespace App\Http\Controllers;

use App\Models\ProgramBantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class ProgramController extends Controller
{
    // ==========================================
    // 1. FUNGSI KHUSUS ADMIN (Kelola Program)
    // ==========================================
    public function indexAdmin(Request $request)
    {
        $available_years = ProgramBantuan::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        $query = ProgramBantuan::latest();

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('q')) {
            $query->where('nama_program', 'like', '%' . $request->q . '%');
        }

        $programs = $query->paginate(9)->withQueryString();

        return view('pages.program.index', compact('programs', 'available_years'));
    }

    public function create()
    {
        return view('pages.program.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode'         => 'required|unique:program_bantuan,kode',
            'nama_program' => 'required',
            'tahun'        => 'required|integer',
            'anggaran'     => 'required|numeric',
            'deskripsi'    => 'nullable|string',
            'file'         => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = $file->store('program_bantuan', 'public');

            $validatedData['file'] = $path;
        }

        ProgramBantuan::create($validatedData);

        return redirect()->route('kelola-program.index')->with('success', 'Program berhasil dibuat.');
    }

    public function show(ProgramBantuan $program)
    {
        return view('pages.program.show', compact('program'));
    }

    public function edit(ProgramBantuan $program)
    {
        return view('pages.program.edit', compact('program'));
    }

    public function update(Request $request, ProgramBantuan $program)
{
    $validatedData = $request->validate([
        'kode'         => 'required|unique:program_bantuan,kode,' . $program->program_id . ',program_id',
        'nama_program' => 'required',
        'tahun'        => 'required|integer',
        'anggaran'     => 'required|numeric',
        'deskripsi'    => 'nullable|string',
        'file'         => 'nullable|file|mimes:jpg,png,pdf,docx|max:10240', // Sesuaikan mimes & max size
    ]);

    // 1. Logika hapus file jika flag 'hapus_file' dikirim dari View
    if ($request->hapus_file == '1') {
        if ($program->file) {
            Storage::disk('public')->delete($program->file);
            $program->file = null;
            $program->save(); 
        }
    }

    // 2. Logika jika ada file baru yang diunggah
    if ($request->hasFile('file')) {
        if ($program->file && Storage::disk('public')->exists($program->file)) {
            Storage::disk('public')->delete($program->file);
        }

        $validatedData['file'] = $request->file('file')->store('program_bantuan', 'public');
    } else {
        unset($validatedData['file']);
    }

    // 3. Update semua data teks
    $program->update($validatedData);

    // Jika dipanggil dari halaman Detail (Show), sebaiknya kembali ke detail, bukan index
    if ($request->has('hapus_file') || $request->hasFile('file')) {
        return back()->with('success', 'Lampiran berhasil diperbarui.');
    }

    return redirect()->route('kelola-program.index')->with('success', 'Program berhasil diperbarui.');
}
    public function destroy(ProgramBantuan $program)
    {
        // 1. Cek apakah kolom file memiliki isi
        if ($program->file) {
            // 2. Cek apakah file benar-benar ada di disk public sebelum dihapus
            if (Storage::disk('public')->exists($program->file)) {
                Storage::disk('public')->delete($program->file);
            }
        }
        // 3. Hapus data dari database
        $program->delete();

        return redirect()->route('kelola-program.index')
            ->with('success', 'Program dan lampiran terkait berhasil dihapus.');
    }


    // ==========================================
    // 2. FUNGSI KHUSUS WARGA (Program-Warga)
    // ==========================================
    public function indexWarga(Request $request)
    {
        $query = ProgramBantuan::latest();

        // Warga mungkin hanya melihat program yang sedang aktif/tahun berjalan
        if ($request->filled('q')) {
            $query->where('nama_program', 'like', '%' . $request->q . '%');
        }

        $programs = $query->paginate(9);
        return view('pages.program.index', compact('programs'));
    }

    public function showWarga(ProgramBantuan $program)
    {
        return view('pages.program.show', compact('program'));
    }

    public function ajukanProgram(ProgramBantuan $program, Request $request)
    {
        $user = Auth::user(); // Pastikan user ini memiliki relasi ke tabel pendaftar
        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('pendaftaran_berkas', 'public');
        }

        // Menggunakan attach untuk mengisi tabel pendaftar_bantuans
        // Pastikan di model User/Warga nama relasinya adalah 'programBantuan'
        $user->ProgramBantuan()->attach($program->program_id, [
            'tanggal_daftar' => now(),
            'status_seleksi' => 'Pending', // Sesuaikan dengan nama kolom di pendaftar_bantuans
            'file'           => $filePath,
        ]);

        return redirect()->route('kelola-program.index')
            ->with('success', 'Anda berhasil mendaftar pada program ' . $program->nama_program);
    }

    public function batalkanProgram(ProgramBantuan $program)
    {
        $user = Auth::user();

        // Detach akan menghapus baris di tabel pendaftar_bantuans 
        // berdasarkan program_id dan user_id/nik
        $user->ProgramBantuan()->detach($program->program_id);

        return redirect()->route('kelola-program.index')
            ->with('success', 'Pendaftaran Anda pada program "' . $program->nama_program . '" telah dibatalkan.');
    }
}
