<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = 
            [[
                'program_id' => '1',
                'kode' => 'BANSOS2025',
                'nama_program' => 'Program Bantuan Sosial',
                'tahun' => '2025',
                'deskripsi' => 'Bantuan sosial berupa paket sembako untuk keluarga kurang mampu',
                'anggaran' => '150000000.00',
            ],
            [
                'program_id' => '2',
                'kode' => 'PKH2025',
                'nama_program' => 'Program Keluarga Harapan',
                'tahun' => '2025',
                'deskripsi' => 'Bantuan sosial dalam memenuhi kebutuhan pendidikan dan kesehatan',
                'anggaran' => '250000000.00',
            ],
            [
                'program_id' => '3',
                'kode' => 'BR2025',
                'nama_program' => 'Program Bedah Rumah',
                'tahun' => '2025',
                'deskripsi' => 'Bantuan renovasi rumah tidak layak huni',
                'anggaran' => '500000000.00',
            ]];
    
        return view('program', compact('programs')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
