<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }
        $users = $query->latest()->paginate(10);
        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Definisikan dan Jalankan Validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // Kita bisa menggunakan Rules\Password::defaults() untuk keamanan yang lebih baik
            'password' => ['required', 'string', 'min:3', 'confirmed'], 
        ], [
            // Pesan Validasi Khusus (Sudah Sangat Baik)
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 3 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // 2. Cek Kegagalan Validasi
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator) // Mengirim error kembali ke view
                             ->withInput(); // Mengirim input lama kembali
        }

        // 3. Simpan Data dengan Hash Password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-HASH
        ]);

        // 4. Redirect Sukses
        // Menggunakan 'users.index' yang sesuai dengan Resource Route
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!'); 
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $users)
    {
        return view('pages.user.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $users)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $users->id],
            // Password tidak wajib diisi saat update
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $userData = $request->only('name', 'email');

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $users->update($userData);

        return redirect()->route('user.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $users)
    {
        $users->delete();

        return redirect()->route('user.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }
}
