<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Warga;
use App\Models\User;
use App\Http\Middleware\CheckIsLogin;


class AuthController extends Controller
{
  
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            session(['last_login' => now()->format('d M Y, H:i')]);

            // REDIRECT BERDASARKAN ROLE
            if ($user->role === 'admin') {
                return redirect()->route('home-admin')->with('success', 'Selamat Datang Admin!');
            }

            return redirect()->route('home')->with('success', 'Login berhasil!');
        } else {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function create()
    {
        return view('auth.login');
    }

    public function daftar(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'size:16', 'unique:warga,no_ktp'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:warga,email'],
            'password' => ['required', 'string', 'confirmed'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'agama' => ['required', 'string', 'max:50'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'telp' => ['nullable', 'string', 'max:15'],
        ]);

        $data['password'] = Hash::make($data['password']);
        
        // Simpan data ke tabel warga
        $warga = Warga::create($data);

        // Simpan data ke tabel users
        $user = User::create([
            'name'     => $data['nama'],
            'email'    => $data['email'],
            'password' => $data['password'], 
            'role'     => 'admin' // Pastikan ini benar admin atau warga sesuai kebutuhan
        ]);

        // PERBAIKAN: Login menggunakan objek $user, bukan $warga
        Auth::login($user);

        // Redirect ke dashboard karena rolenya admin
        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

   public function index()
    {
        if (Auth::check()) {
        return redirect()->route('warga.index');
        }
        return view('auth.login');
    }
}