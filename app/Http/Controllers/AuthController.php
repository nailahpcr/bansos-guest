<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rules;      
use Illuminate\Validation\ValidationException;
use App\Models\Warga;


class AuthController extends Controller
{

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('warga.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register(){
        return view('register');
    }

    public function create(){
        return view('login');
    }

    public function daftar(Request $request)
    {
        // 1. Validasi SEMUA input dari form register
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

        // 2. Hash password SEBELUM disimpan
        $data['password'] = Hash::make($data['password']);

        // 3. Buat warga baru menggunakan array $data yang sudah divalidasi
        $warga = Warga::create($data);

        // 4. Login-kan warga yang baru mendaftar
        Auth::login($warga);

        // 5. Arahkan ke dashboard warga
        return redirect()->route('home');
    }


    public function index()
    {
        if (Auth::check())
            return redirect()->route('dashboard');
        else{
            return view('auth.login');
        }
    }

};