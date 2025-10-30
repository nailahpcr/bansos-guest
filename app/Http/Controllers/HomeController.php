<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramBantuan;

class HomeController extends Controller
{
    public function index()
    {
        $programs = ProgramBantuan::latest()->paginate(10); 
        return view('home',  compact('programs'));
    }
}