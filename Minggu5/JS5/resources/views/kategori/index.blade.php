@extends('layout/app')

@section('content')
    <div class="container">
        <h3>Daftar Kategori</h3>
        <table id="kategoriTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Kategori ID</th>
                    <th>Kategori Kode</th>
                    <th>Kategori Nama</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $k)
                <tr>
                    <td>{{ $k->kategori_id }}</td>
                    <td><span style="color: {{ $k->kategori_kode == 'CML' ? 'green' : 'blue' }}; font-weight: bold;">{{ $k->kategori_kode }}</span></td>
                    <td style="background-color: {{ $k->kategori_kode == 'MNR' ? '#D3E9D3' : 'white' }}">{{ $k->kategori_nama }}</td>
                    <td style="color: {{ $k->kategori_kode == 'CML' ? 'red' : 'blue' }};">{{ $k->created_at }}</td>
                    <td><span style="color: gray;">{{ $k->updated_at ?? '(NULL)' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tambahkan script DataTables --}}
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#kategoriTable').DataTable();
        });
    </script>
    @endpush
@endsection
