<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\ProgramBantuan;
use App\Models\Warga;
use App\Models\PendaftarFile;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $status = $request->query('status');
        
        $query = Pendaftar::with(['program', 'warga']);
        
        // Logika Pencarian
        if ($search) {
            $searchTerm = strtolower($search);
            
            $query->where(function($q) use ($searchTerm) {
                
                // 1. Mencari berdasarkan nama warga atau NIK.
                $q->whereHas('warga', function($qWarga) use ($searchTerm) {
                    $qWarga->whereRaw('LOWER(nama) LIKE ?', ['%' . $searchTerm . '%'])
                           ->orWhere('no_ktp', 'like', '%' . $searchTerm . '%'); 
                });
                
                // 2. Mencari berdasarkan nama program (Case-insensitive)
                $q->orWhereHas('program', function($qProgram) use ($searchTerm) {
                    $qProgram->whereRaw('LOWER(nama_program) LIKE ?', ['%' . $searchTerm . '%']);
                });
                
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $pendaftar = $query->latest()->paginate(6);
        $pendaftar->appends($request->except('page'));        
        $totalPendaftar = Pendaftar::count(); 
        $totalLakiLaki = Pendaftar::whereHas('warga', function($q) {
            $q->where('jenis_kelamin', 'Laki-laki'); 
        })->count();
    
        $totalPerempuan = Pendaftar::whereHas('warga', function($q) {
            $q->where('jenis_kelamin', 'Perempuan'); 
        })->count();

        $statuses = ['Pending', 'Verifikasi', 'Ditolak'];
        return view('pages.pendaftar.index', compact('pendaftar', 'totalPendaftar', 'totalLakiLaki', 'totalPerempuan', 'search', 'status', 'statuses'));
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
            'status'     => 'required|in:Pending,Verifikasi,Ditolak', 
            'keterangan' => 'nullable|string|max:500',
            'files.*'    => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',

        ]);

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
        // Upload multiple files 
         if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('pendaftar_files', 'public');
                
                PendaftarFile::create([
                    'pendaftar_id' => $pendaftar->id,
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('pendaftar.index')->with('success', 'Pendaftaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        return view('pages.pendaftar.show', compact('pendaftar'));
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
        $pendaftar = Pendaftar::findOrFail($id); 

        $validated =$request->validate([
            'program_id' => 'required|exists:program_bantuan,program_id', 
            'warga_id'   => 'required|exists:warga,warga_id', 
            'status'     => 'required|in:Pending,Verifikasi,Ditolak', 
            'keterangan' => 'nullable|string|max:500',
            'files.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        ]);

        $pendaftar->update([
            'program_id' => $request->program_id,
            'warga_id' => $request->warga_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

    if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('pendaftar_files', 'public');
                
                PendaftarFile::create([
                    'pendaftar_id' => $pendaftar->pendaftar_id,
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('pendaftar.index')
            ->with('success', 'Pendaftar berhasil diperbarui.');
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

      public function destroyFile($id)
    {
        $file = PendaftarFile::findOrFail($id);
        
        // Hapus file dari storage
        Storage::disk('public')->delete($file->path);
        
        // Hapus record dari database
        $file->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
    
}