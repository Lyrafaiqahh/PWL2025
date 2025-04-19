@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Kategori</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/kategori/import') }}')" class="btn btn-info">
                    <i class="fa fa-upload"></i> Import Kategori
                </button>
                <a href="{{ url('/kategori/create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                <button onclick="modalAction('{{ url('/kategori/create_ajax') }}')" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i> Tambah (Ajax)
                </button>
                <a href="{{ url('/kategori/export_excel') }}" class="btn btn-success">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ url('/kategori/export_pdf') }}" class="btn btn-warning">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_kategori" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                    <option value="">- Semua -</option>
                                    @foreach($kategori as $l)
                                        <option value="{{ $l->kategori_id }}">{{ $l->kategori_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Kategori Barang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        const tableKategori = $('#table_kategori').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('kategori/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: function (d) {
                    d.filter_kategori = $('.filter_kategori').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "kategori_kode" },
                { data: "kategori_nama" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });

        $('.filter_kategori').change(function () {
            tableKategori.draw();
        });
    });
</script>
@endpush
