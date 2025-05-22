@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Mahasiswa</h1>
    <a href="{{ route('data-mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Angkatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $mhs)
            <tr>
                <td>
                    @if($mhs->foto)
                    <img src="{{ asset('Upload/image/' . $mhs->foto) }}" width="80">
                @endif

                </td>
                <td>{{ $mhs->nim }}</td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->prodi }}</td>
                <td>{{ $mhs->angkatan }}</td>
                <td>
                    <a href="{{ route('data-mahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('data-mahasiswa.destroy', $mhs->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin?')" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
