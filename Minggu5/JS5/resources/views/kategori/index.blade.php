<div class="container">
    <h3>Daftar Kategori</h3>
    <a href="{{ url('/kategori/create') }}" class="btn btn-success mb-3">+ Add Kategori</a>

    <table id="kategoriTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Kategori ID</th>
                <th>Kategori Kode</th>
                <th>Kategori Nama</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $k)
            <tr>
                <td>{{ $k->kategori_id }}</td>
                <td>{{ $k->kategori_kode }}</td>
                <td>{{ $k->kategori_nama }}</td>
                <td>{{ $k->created_at }}</td>
                <td>{{ $k->updated_at ?? '(NULL)' }}</td>
                <td>
                <a href="{{ route('kategori.edit', $k->kategori_id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('kategori.destroy',$k->kategori_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
