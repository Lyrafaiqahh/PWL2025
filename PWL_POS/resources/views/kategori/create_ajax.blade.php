<form action="{{ url('/kategori/ajax') }}" method="POST" id="form-tambah"> @csrf
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="kategori_kode" class="col-1 control-label col-form-label">Kode</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="kategori_kode" id="kategori_kode" value="{{ old('kategori_kode') }}">
                </div>

                @error('kategori_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group row">
                <label for="kategori_nama" class="col-1 control-label col-form-label">Nama</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" value="{{ old('kategori_nama') }}" required>

                    @error('kategori_nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</div>
</form>
