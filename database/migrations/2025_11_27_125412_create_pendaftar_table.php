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
    public function index(Request $request)
    {
        // Ambil query pencarian
        $search = $request->query('q');
        
        // Mulai query Pendaftar dengan eager loading
        $query = Pendaftar::with(['program', 'warga']);
        
        // Logika Pencarian
        if ($search) {
            $searchTerm = strtolower($search);
            
            $query->where(function($q) use ($searchTerm) {
                
                // 1. Mencari berdasarkan nama warga atau NIK.
                $q->whereHas('warga', function($qWarga) use ($searchTerm) {
                    $qWarga->whereRaw('LOWER(nama) LIKE ?', ['%' . $searchTerm . '%'])
                           // PERBAIKAN: Mengganti ke 'nik'
                           // Jika masih error, GANTI 'nik' DENGAN NAMA KOLOM NIK YANG PASTI DI TABEL WARGA ANDA.
                           ->orWhere('nik', 'like', '%' . $searchTerm . '%'); 
                });
                
                // 2. Mencari berdasarkan nama program (Case-insensitive)
                $q->orWhereHas('program', function($qProgram) use ($searchTerm) {
                    $qProgram->whereRaw('LOWER(nama_program) LIKE ?', ['%' . $searchTerm . '%']);
                });
                
            });
        }

        // Lanjutkan dengan pagination menggunakan variabel $query yang sudah disaring
        $pendaftar = $query->latest()->paginate(6);
        
        // Pastikan pagination links mempertahankan parameter pencarian
        // Variabel $search bisa null, jadi gunakan operator null-coalesce
        $pendaftar->appends(['q' => $search ?? null]); 
        
        // Hitung statistik (Mengacu pada jumlah Pendaftar)
        $totalPendaftar = Pendaftar::count(); // Total Pendaftar
        $totalLakiLaki = Pendaftar::whereHas('warga', function($q) {
            $q->where('jenis_kelamin', 'Laki-laki'); // Sesuaikan kolom dan nilai jenis kelamin
        })->count();
    
        $totalPerempuan = Pendaftar::whereHas('warga', function($q) {
            $q->where('jenis_kelamin', 'Perempuan'); // Sesuaikan kolom dan nilai jenis kelamin
        })->count();

        // Kirimkan variabel 'search' dan statistik ke view
        return view('pages.pendaftar.index', compact('pendaftar', 'totalPendaftar', 'totalLakiLaki', 'totalPerempuan', 'search'));
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
            // Pastikan status yang diinput sesuai dengan ENUM di database
            'status'     => 'required|in:Pending,Verifikasi,Ditolak', 
        ]);

        // Cek duplikasi agar warga tidak daftar program yang sama 2 kali
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
        // Method show biasanya digunakan untuk menampilkan detail, bisa diisi nanti
        $pendaftar = Pendaftar::findOrFail($id);
        return view('pages.pendaftar.show', compact('pendaftar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Menggunakan findOrFail untuk penanganan 404 yang lebih baik
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
        // Menggunakan findOrFail untuk penanganan 404 yang lebih baik
        $pendaftar = Pendaftar::findOrFail($id); 

        $request->validate([
            'program_id' => 'required|exists:program_bantuan,program_id', 
            'warga_id'   => 'required|exists:warga,warga_id', 
            // Pastikan status yang diinput sesuai dengan ENUM di database
            'status'     => 'required|in:Pending,Verifikasi,Ditolak', 
        ]);

        // Update data secara eksplisit
        $pendaftar->update([
            'program_id' => $request->program_id,
            'warga_id' => $request->warga_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pendaftar.index')->with('success', 'Data pendaftaran berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menggunakan findOrFail untuk penanganan 404 yang lebih baik
        $pendaftar = Pendaftar::findOrFail($id); 
        $pendaftar->delete();

        return redirect()->route('pendaftar.index')->with('success', 'Data pendaftaran berhasil dihapus!');
    }
}