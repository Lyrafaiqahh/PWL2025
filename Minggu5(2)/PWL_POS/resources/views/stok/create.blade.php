@extends('layouts/template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ url('stok') }}" class="form-horizontal">
                @csrf

                <div class="form-group row">
                    <label for="barang_id" class="col-2 control-label col-form-label">Barang ID</label>
                    <div class="col-10">
                        <input type="number" class="form-control" name="barang_id" id="barang_id" value="{{ old('barang_id') }}" required>
                    </div>
                    @error('barang_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="user_id" class="col-2 control-label col-form-label">User ID</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="user_id" name="user_id" value="{{ old('user_id') }}" required>
                    </div>
                    @error('user_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="stok_tanggal" class="col-2 control-label col-form-label">Tanggal</label>
                    <div class="col-10">
                        <input type="datetime-local" class="form-control" id="stok_tanggal" name="stok_tanggal" value="{{ old('stok_tanggal') }}" required>
                    </div>
                    @error('stok_tanggal')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="stok_jumlah" class="col-2 control-label col-form-label">Jumlah</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah" value="{{ old('stok_jumlah') }}" required>
                    </div>
                    @error('stok_jumlah')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
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
