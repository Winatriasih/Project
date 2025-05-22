<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use Illuminate\Http\Request;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Mahasiswa::all();
        return view('mahasiswa.index', compact('data'));
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
    public function store(Request $request )
    {
        // validasi data
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'jurusan' => 'required|string',
        ]);

        // simpan data ke database
        Mahasiswa::create($request->only('nama', 'nim', 'jurusan'));

        // redirect dengan pesan sukses
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan');


    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, Mahasiswa $mahasiswa)
    {
        // validasi data
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id,
            'jurusan' => 'required|string',
        ]);

        // update data
        $mahasiswa->update($request->all());

        //respon
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //validasi model
        if(!$mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('errors', 'Data mahasiswa tidak ditemukan');

        }

        //hapus
        $mahasiswa->delete();

        // response
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
