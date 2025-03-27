@extends('layouts/template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ url('barang') }}" class="form-horizontal">
                @csrf

                <div class="form-group row">
                    <label for="barang_id" class="col-1 control-label col-form-label">ID</label>
                    <div class="col-11">
                        <input type="text" class="form-control" name="barang_id" id="barang_id" value="{{ old('barang_id') }}" required>
                    </div>
                    @error('barang_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="barang_kode" class="col-1 control-label col-form-label">Kode</label>
                    <div class="col-11">
                        <input type="text" class="form-control" name="barang_kode" id="barang_kode" value="{{ old('barang_kode') }}" required>
                    </div>
                    @error('barang_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="barang_nama" class="col-1 control-label col-form-label">Nama</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ old('barang_nama') }}" required>
                    </div>
                    @error('barang_nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="kategori_id" class="col-1 control-label col-form-label">Kategori</label>
                    <div class="col-11">
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('kategori_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="harga" class="col-1 control-label col-form-label">Harga</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required>
                    </div>
                    @error('harga')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="stok" class="col-1 control-label col-form-label">Stok</label>
                    <div class="col-11">
                        <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok') }}" required>
                    </div>
                    @error('stok')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('barang') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush