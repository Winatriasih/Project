<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMahasiswa;
use Intervention\Image\Laravel\Facades\Image;

class DataMahasiswaController extends Controller
{
    public function index()
    {
        $data = DataMahasiswa::all();
        return view('data_mahasiswa.index', compact('data'));
    }

    public function create()
    {
        return view('data_mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:data_mahasiswa,nim',
            'nama' => 'required',
            'prodi' => 'required',
            'angkatan' => 'required|digits:4',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $mahasiswa = new DataMahasiswa($request->except('foto'));

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('Upload/image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $img = Image::read($image->getRealPath());
            $img->resize(300, 300)->save($destinationPath . '/' . $filename);

            $mahasiswa->foto = $filename;
        }
        $mahasiswa->save();
        return redirect()->route('data-mahasiswa.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);
        return view('data_mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);
        return view('data_mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'prodi' => 'required',
            'angkatan' => 'required|digits:4',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fileName = $mahasiswa->foto;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->foto && file_exists(public_path('Upload/image/' . $mahasiswa->foto))) {
                unlink(public_path('Upload/image/' . $mahasiswa->foto));
            }

            $image = $request->file('foto');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('Upload/image/' . $fileName);

            Image::make($image)->resize(300, 300)->save($path);
        }

        $mahasiswa->update([
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'foto' => $fileName,
        ]);

        return redirect()->route('data-mahasiswa.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);

        // Hapus file foto jika ada
        if ($mahasiswa->foto && file_exists(public_path('Upload/image/' . $mahasiswa->foto))) {
            unlink(public_path('Upload/image/' . $mahasiswa->foto));
        }

        $mahasiswa->delete();

        return redirect()->route('data-mahasiswa.index')->with('success', 'Data berhasil dihapus');
    }
}
