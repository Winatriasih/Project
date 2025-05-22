@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Title --}}
        <h4 class="d-inline">Data Mahasiswa</h4>

        {{-- Add Button (Page) --}}
        {{-- <a href="{{ route('mahasiswa.formTambah') }}" class="btn btn-primary btn-sm float-end">Tambah Data</a> --}}
        {{-- Add Button (Modal) --}}
        <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalAdd">
            Tambah Data
        </button>

        {{-- Modal Add --}}
        <div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalAddLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('mahasiswa.store') }}" method="POST">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalAddLabel">Tambah Data Mahasiswa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>

                            {{-- NIM --}}
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" maxlength="9"
                                    pattern="[0-9]{9}" inputmode="numeric" required>
                            </div>

                            {{-- Jurusan --}}
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditLabel">Edit Data Mahasiswa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="editNama" name="nama" value=""
                                    required>
                            </div>

                            {{-- NIM --}}
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="editNim" name="nim" value=""
                                    maxlength="9" pattern="[0-9]{9}" inputmode="numeric" required>
                            </div>

                            {{-- Jurusan --}}
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="editJurusan" name="jurusan" value=""
                                    required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        {{-- Modal Hapus --}}
        <div class="modal fade" id="modalHapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalHapusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalHapusLabel">Hapus Data Mahasiswa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus data ini?</p>
                            <p>Data yang dihapus tidak dapat dikembalikan.</p>
                            <p>Nama: <span id="hapusNama"></span></p>
                            <p>NIM: <span id="hapusNim"></span></p>
                            <p>Jurusan: <span id="hapusJurusan"></span></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        {{-- Alert Success / Error --}}
        @if (session('success'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('success') }}
            </div>
        @endif
        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Table --}}
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $mhs)
                    <tr>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->jurusan }}</td>
                        <td class="text-center">
                            {{-- Edit Button (Page) --}}
                            {{-- <a href="{{ route('mahasiswa.formEdit', $mhs->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                            {{-- Edit Button (Modal) --}}
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEdit" onclick="setEditData({{ $mhs }})">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            {{-- <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form> --}}
                            {{-- Delete Button (Modal) --}}
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalHapus" onclick="setDeleteData({{ $mhs }})">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function setEditData(mhs) {
            document.getElementById('editForm').action = `/mahasiswa/${mhs.id}`;
            document.getElementById('editNama').value = mhs.nama;
            document.getElementById('editNim').value = mhs.nim;
            document.getElementById('editJurusan').value = mhs.jurusan;
        }

        function setDeleteData(mhs) {
            document.querySelector('#modalHapus form').action = `/mahasiswa/${mhs.id}`;
            document.getElementById('hapusNama').innerText = mhs.nama;
            document.getElementById('hapusNim').innerText = mhs.nim;
            document.getElementById('hapusJurusan').innerText = mhs.jurusan;
        }
    </script>

@endsection
