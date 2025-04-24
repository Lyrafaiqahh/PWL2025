@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning">
                <i class="fa fa-file-pdf"></i> Export (PDF)
            </a>
            <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import</button>
            <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary">
                <i class="fa fa-file-excel"></i> Export (EXCEL)
            </a>
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data</button>
        </div>
    </div>
    <div class="card-body">            
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <table class="table table-bordered table-sm table-striped table-hover" id="table-penjualan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Penjualan</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var tablepenjualan;

    $(document).ready(function () {
        tablepenjualan = $('#table-penjualan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('penjualan/list') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}'
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", width: "5%", orderable: false, searchable: false },
                { data: "penjualan_kode", width: "10%" },
                { data: "pembeli", width: "37%" },
                { data: "penjualan_tanggal", width: "10%" },
                { data: "aksi", className: "text-center", width: "14%", orderable: false, searchable: false }
            ],
            drawCallback: function() {
                bindPenjualanButtons(); // Bind ulang tombol setelah redraw
            }
        });

        // Custom search: tekan ENTER untuk pencarian
        $('#table-penjualan_filter input').unbind().bind('keyup', function(e) {
            if (e.keyCode == 13) {
                tablepenjualan.search(this.value).draw();
            }
        });
    });

    function bindPenjualanButtons() {
        $('.btn-detail, .btn-edit').off('click').on('click', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            modalAction(url);
        });

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
                        tablepenjualan.ajax.reload(null, false); // reload tanpa reset halaman
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
