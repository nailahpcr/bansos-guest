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

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        } 
        $users = $query->latest()->paginate(9);

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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'min:3', 'confirmed'], 
            'role'     => 'required|in:admin,user', // Tambahkan validasi role
        ], [
            'name.required'     => 'Nama tidak boleh kosong',
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Format email tidak valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 3 karakter',
            'password.confirmed'=> 'Konfirmasi password tidak sesuai',
            'role.required'     => 'Role harus dipilih',
            'role.in'           => 'Pilihan role tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Simpan Data
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
            'role'     => $request->role, // Mengambil dari input form
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!'); 
    }


    /**
     * Show the form for editing the specified resource.
     */
   public function edit(User $user)
    {
        return view('pages.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:admin,user'], // Tambahkan validasi role saat update
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'role.required' => 'Role tidak boleh kosong',
            'role.in'       => 'Pilihan role tidak valid',
        ]);

        // Masukkan name, email, dan role ke dalam array update
        $userData = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
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
