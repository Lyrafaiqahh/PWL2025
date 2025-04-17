@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Stok</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info">Import Stok</button>
                <a href="{{ url('/stok/export_excel') }}" class="btn btn-primary"><i class="fa fa-file- excel"></i> Export Stok EXCEL</a>
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
                <a href="{{ url('/stok/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file- pdf"></i> Export Stok PDF</a>
            </div>
        </div>

        <div class="card-body">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Stok Table -->
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

    <!-- Modal for Import Form -->
    <div id="modal-stok" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#modal-stok').load(url, function() {
            $('#modal-stok').modal('show');
        });
    }

    var tableStok;
    $(document).ready(function() {
        tableStok = $('#table_stok').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('stok/list') }}",
                "dataType": "json",
                "type": "POST"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang_id",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "user_id",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "stok_tanggal",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "stok_jumlah",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#table_stok_filter input').unbind().bind().on('keyup', function(e) {
            if (e.keyCode == 13) {
                tableStok.search(this.value).draw();
            }
        });
    });
</script>
@endpush
