@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @empty($penjualan)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered">
                <tr>
                    <th>Kode Penjualan</th>
                    <td>{{ $penjualan->kode_penjualan }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td>{{ $penjualan->pembeli }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $penjualan->tanggal }}</td>
                </tr>
            </table>

            <hr>
            <h5>Detail Barang</h5>
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->penjualan_detail as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>{{ number_format($detail->harga) }}</td>
                        <td>{{ number_format($detail->qty * $detail->harga) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endempty

        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection
