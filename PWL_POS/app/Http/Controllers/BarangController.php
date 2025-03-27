<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Barang',
            'list'  => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        $kategori = KategoriModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function list(Request $request)
    {
        $products = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id', 'harga', 'stok')->with('kategori');

        if ($request->kategori_id) {
            $products->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $kategori = KategoriModel::all();
        $activeMenu = 'barang';

        return view('barang.create', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode'   => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'   => 'required|string|max:100',
            'kategori_id'   => 'required|integer',
            'harga'         => 'required|integer',
            'stok'          => 'required|integer'
        ]);

        BarangModel::create($request->only(['barang_kode', 'barang_nama', 'kategori_id', 'harga', 'stok']));

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function edit(string $id)
    {
        $barang = BarangModel::findOrFail($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_kode'   => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama'   => 'required|string|max:100',
            'kategori_id'   => 'required|integer',
            'harga'         => 'required|integer',
            'stok'          => 'required|integer'
        ]);

        BarangModel::findOrFail($id)->update($request->only(['barang_kode', 'barang_nama', 'kategori_id', 'harga', 'stok']));

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    public function destroy(string $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            $barang->delete();
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
