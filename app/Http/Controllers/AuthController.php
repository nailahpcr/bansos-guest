<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * 
     */
    private $staticUsers = [
        [
            'id'       => 1,
            'username' => 'nailah',
            'password' => 'Usernailah', 
            'name'     => 'Nailah Houra Disanova'
        ],
        [
            'id'       => 2,
            'username' => 'budi',
            'password' => 'Userbudi', 
            'name'     => 'budi'
        ],
    ];

   
    public function index()
    {
        return view('login-form');
    }

    
    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loggedInUser = null;

        
        foreach ($this->staticUsers as $user) {
            // Cek apakah username cocok
            if ($user['username'] === $credentials['username']) {
                // Jika username cocok, cek passwordnya
                if ($user['password'] === $credentials['password']) {
                    $loggedInUser = $user; // Simpan data user yang berhasil login
                    break; 
                }
            }
        }

        // Jika pengguna ditemukan dan password cocok
        if ($loggedInUser) {
            $request->session()->regenerate(); // Buat session baru 

            // Arahkan ke dashboard dengan data dari array
            return redirect()->route('dashboard')->with([
                'success'  => 'Login berhasil!',
                'name' => $loggedInUser['name'] 
            ]);
        }

        // Jika pengguna tidak ditemukan atau password salah
        return back()->withErrors([
            'credentials' => 'Username atau Password salah.'
        ])->withInput($request->only('username'));
    }
}