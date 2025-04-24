@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Stok</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info">Import</button>
            <a href="{{ url('/stok/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export (EXCEL)</a>
            <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Data</button>
            <a href="{{ url('/stok/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export (PDF)</a>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
            <thead>
            <tr>
                <th>No</th>
                <th>Barang ID</th>
                <th>User ID</th>
                <th>Tanggal Stok</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal untuk Tambah/Edit/Detail -->
<div id="modal-stok" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#modal-stok').load(url, function () {
            $('#modal-stok').modal('show');
        });
    }

    var tableStok;

    $(document).ready(function () {
        tableStok = $('#table_stok').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('stok/list') }}",
                type: "POST"
            },
            columns: [
                { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'barang_id' },
                { data: 'user_id' },
                { data: 'stok_tanggal' },
                { data: 'stok_jumlah' },
                { data: 'aksi', className: 'text-center', orderable: false, searchable: false }
            ],
            drawCallback: function () {
                bindStokButtons(); // <-- penting!
            }
        });

        // pencarian hanya aktif saat tekan Enter
        $('#table_stok_filter input').unbind().bind('keyup', function (e) {
            if (e.keyCode == 13) {
                tableStok.search(this.value).draw();
            }
        });
    });

    function bindStokButtons() {
        // Tombol detail dan edit (pakai modal Ajax)
        $('.btn-detail, .btn-edit').off('click').on('click', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            modalAction(url);
        });

        // Tombol hapus
        $('.btn-hapus').off('click').on('click', function (e) {
            e.preventDefault();
            if (confirm('Yakin ingin menghapus data ini?')) {
                const url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        tableStok.ajax.reload(null, false); // reload tanpa reset halaman
                        alert(res.message || 'Data berhasil dihapus');
                    },
                    error: function () {
                        alert('Gagal menghapus data');
                    }
                });
            }
        });
    }
</script>
@endpush
