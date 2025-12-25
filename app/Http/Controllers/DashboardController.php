<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramBantuan;

class DashboardController extends Controller
{
    public function indexPublic()
    {
        $programs = ProgramBantuan::latest()->paginate(9);

        return view('pages.home', compact('programs'));
    }

    public function showPublic(ProgramBantuan $program)
    {
        return view('pages.program.show', compact('program'));
    }
}
