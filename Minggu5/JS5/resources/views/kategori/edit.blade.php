@extends('layout/app')

@section('content')
<div class="container">
    <h2>Edit Kategori</h2>
    <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kodeKategori" class="form-label">Kode Kategori</label>
            <input type="text" name="kodeKategori" class="form-control" value="{{ $kategori->kategori_kode }}" required>
        </div>

        <div class="mb-3">
            <label for="namaKategori" class="form-label">Nama Kategori</label>
            <input type="text" name="namaKategori" class="form-control" value="{{ $kategori->kategori_nama }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
