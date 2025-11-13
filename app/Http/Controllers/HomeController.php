<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramBantuan;

class HomeController extends Controller
{
    public function index()
    {
        $programs = ProgramBantuan::latest()->paginate(10);
        return view('pages.home',  compact('programs'));
    }

    public function about()
{
    return view('pages.about'); 
}
}

