<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;

class KategoriController extends Controller
{
    public function index()
{
    $kategori = KategoriModel::all(); // Ambil semua data kategori
    return view('kategori.index', compact('kategori')); // Kirim data ke view
}

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kodeKategori' => 'required|unique:m_kategori,kategori_kode',
        'namaKategori' => 'required'
    ]);

    // Simpan data ke database
    KategoriModel::create([
        'kategori_kode' => $request->kodeKategori,
        'kategori_nama' => $request->namaKategori,
    ]); 

    return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
}
public function edit($id)
{
    $kategori = KategoriModel::findOrFail($id);
    return view('kategori.edit', compact('kategori'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'kodeKategori' => 'required|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
        'namaKategori' => 'required'
    ]);

    $kategori = KategoriModel::where('kategori_id', $id)->firstOrFail();
    $kategori->update([
        'kategori_kode' => $request->kodeKategori,
        'kategori_nama' => $request->namaKategori,
    ]);

    return redirect('/kategori')->with('success', 'Kategori berhasil diperbarui!');
}

}
