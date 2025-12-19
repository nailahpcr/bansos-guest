<?php
namespace App\Http\Controllers;

use App\Models\ProgramBantuan; 
use App\Models\MediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{

    public function indexPublic()
    {
        $programs = ProgramBantuan::latest()->paginate(6
    );

        return view('pages.home', compact('programs'));
    }

    public function showPublic(ProgramBantuan $program)
    {
        $media = MediaModel::where('ref_table', 'App\Models\ProgramBantuan')
                             ->where('ref_id', $program->program_id)
                             ->get();
        return view('pages.program.show', compact('program', 'media'));
    }

   public function index(Request $request)
{
    // 1. Ambil daftar tahun yang unik dari database untuk isi Dropdown
    // (Misal: ada data 2023, 2024, 2025 -> maka dropdown isinya itu saja)
    $available_years = ProgramBantuan::select('tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

    // 2. Mulai Query Utama
    $query = ProgramBantuan::latest();

    // 3. Filter berdasarkan Tahun (jika dipilih)
    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    // 4. Filter berdasarkan Pencarian Nama Program (jika diketik)
    if ($request->filled('q')) {
        $query->where('nama_program', 'like', '%' . $request->q . '%');
    }

    // 5. Eksekusi Pagination
    $programs = $query->paginate(9)->withQueryString();

    // 6. Kirim data programs DAN available_years ke View
    return view('pages.program.index', compact('programs', 'available_years'));
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
            'deskripsi'    => 'nullable|string',
        ]);

        ProgramBantuan::create($request->all());
        return redirect()->route('kelola-program.index')->with('success', 'Program baru berhasil dibuat.');
    }

    public function show(ProgramBantuan $program)
    {
        $media = MediaModel::where('ref_table', 'App\Models\ProgramBantuan')
                             ->where('ref_id', $program->program_id)
                             ->get();
        return view('pages.program.show', compact('program', 'media'));
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
        ]);

        $program->update($validatedData);
        return redirect()->route('kelola-program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(ProgramBantuan $program)
    {
        $mediaToDelete = MediaModel::where('ref_table', 'App\Models\ProgramBantuan')
                                   ->where('ref_id', $program->program_id)
                                   ->get();
                                   
        foreach ($mediaToDelete as $media) {
            // Hapus file fisik
            Storage::delete('public/uploads/program_bantuan/' . $media->file_name); 
            $media->delete(); // Hapus entri dari tabel media
        }

        $program->delete();
        return redirect()->route('kelola-program.index')->with('success', 'Program berhasil dihapus.');
    }

    public function uploadMedia(Request $request, ProgramBantuan $program)
    {
        $request->validate([
            'file_program' => 'required|image|max:10240', // 10MB, images only
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('file_program')) {
            $file = $request->file('file_program');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', $file->getClientOriginalName());
            $filePath = 'uploads/program_bantuan/';
        
            // Simpan file
            $file->storeAs($filePath, $fileName, 'public');

            // Simpan ke database
            MediaModel::create([
                'ref_table' => 'App\Models\ProgramBantuan',
                'ref_id' => $program->program_id,
                'file_name' => $fileName,
                'caption' => $request->caption,
                'mime_type' => $file->getMimeType(),
                'sort_order' => 0,
            ]);

            return redirect()->route('kelola-program.show', $program->program_id)
                             ->with('success', 'Gambar berhasil diunggah.');
        }
        
        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    public function deleteMedia($media_id)
    {
        $media = MediaModel::findOrFail($media_id);
        $program_id = $media->ref_id;
        
        // Hapus file fisik
        Storage::delete('public/uploads/program_bantuan/' . $media->file_name);
        
        // Hapus entri dari tabel media
        $media->delete();
        
        // Tentukan redirect berdasarkan route sebelumnya
        $previousUrl = url()->previous();
        
        // Jika datang dari route admin, redirect ke admin
        if (str_contains($previousUrl, '/kelola-program/')) {
            return redirect()->route('kelola-program.show', $program_id)
                             ->with('success', 'Dokumen berhasil dihapus.');
        }

        // Redirect ke program.show (public route) 
        return redirect()->route('program.show', $program_id)
                         ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function ajukanProgram(ProgramBantuan $program)
    {
        $user = Auth::user();
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