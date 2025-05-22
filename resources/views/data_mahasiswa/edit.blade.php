@extends('layouts.app')


@section('content')
    <h2>Edit Mahasiswa</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('data-mahasiswa.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>NIM:</label><br>
        <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" readonly><br><br>

        <label>Nama:</label><br>
        <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"><br><br>

        <label>Prodi:</label><br>
        <input type="text" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}"><br><br>

        <label>Angkatan:</label><br>
        <input type="text" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}"><br><br>

        <label>Foto Lama:</label><br>
        @if($mahasiswa->foto)
            <img src="{{ asset('Upload/image/' . $mahasiswa->foto) }}" width="100"><br><br>
        @endif

        <label>Ganti Foto (opsional):</label><br>
        <input type="file" name="foto"><br><br>

        <button type="submit">Update</button>
    </form>
@endsection
