<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with('user');

        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('user.nama', function ($penjualan) {
                return $penjualan->user->nama ?? '-';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                    <button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menyimpan data penjualan baru
public function store(Request $request)
{
    $request->validate([
        'pembeli' => 'required|string|min:3|max:100',
        'penjualan_tanggal' => 'required|date',
        'user_id' => 'required|integer'
    ]);

    $lastId = PenjualanModel::max('penjualan_id') ?? 0;
    $kode = 'PJ-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

    PenjualanModel::create([
        'penjualan_kode' => $kode,
        'pembeli' => $request->pembeli,
        'penjualan_tanggal' => $request->penjualan_tanggal,
        'user_id' => $request->user_id
    ]);

    return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
}

// Menampilkan detail penjualan
public function show(string $id)
{
    // Ambil data penjualan berdasarkan ID dan relasinya
    $penjualan = PenjualanModel::with(['penjualan_detail.barang'])->find($id);

    // Jika data tidak ditemukan
    if (!$penjualan) {
        return view('penjualan.show', [
            'penjualan'  => null,
            'page'       => (object)['title' => 'Detail Penjualan'],
            'breadcrumb' => (object)['title' => 'Detail Penjualan', 'list' => ['Home', 'Penjualan', 'Detail']],
            'activeMenu' => 'penjualan'
        ]);
    }

    return view('penjualan.show', [
        'penjualan'  => $penjualan,
        'page'       => (object)['title' => 'Detail Penjualan'],
        'breadcrumb' => (object)['title' => 'Detail Penjualan', 'list' => ['Home', 'Penjualan', 'Detail']],
        'activeMenu' => 'penjualan'
    ]);
}



// Menampilkan halaman form edit penjualan
public function edit(string $id)
{
    $penjualan = PenjualanModel::find($id);
    $users = UserModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Penjualan',
        'list' => ['Home', 'Penjualan', 'Edit']
    ];

    $page = (object) [
        'title' => 'Edit Penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualan.edit', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'users'));
}

// Menyimpan perubahan data penjualan
public function update(Request $request, string $id)
{
    $request->validate([
        'pembeli' => 'required|string|min:3|max:100',
        'penjualan_tanggal' => 'required|date',
        'user_id' => 'required|integer'
    ]);

    PenjualanModel::find($id)->update([
        'pembeli' => $request->pembeli,
        'penjualan_tanggal' => $request->penjualan_tanggal,
        'user_id' => $request->user_id
    ]);

    return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
}

// Menghapus data penjualan
public function destroy(string $id)
{
    $check = PenjualanModel::find($id);

    if (!$check) {
        return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
    }

    try {
        PenjualanModel::destroy($id);
        return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terkait dengan data lain');
    }
}


    public function create_ajax()
    {
        $users = UserModel::select('user_id', 'nama')->get();
        return view('penjualan.create_ajax', compact('users'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pembeli' => 'required|string|min:3|max:100',
            'penjualan_tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $lastId = PenjualanModel::max('penjualan_id') ?? 0;
            $kode = 'PJN' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

            PenjualanModel::create([
                'penjualan_kode' => $kode,
                'pembeli' => $request->pembeli,
                'penjualan_tanggal' => $request->penjualan_tanggal,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show_ajax($id)
    {
        $penjualan = PenjualanModel::with(['user', 'detail.barang'])->findOrFail($id);
        return view('penjualan.show_ajax', compact('penjualan'));
    }

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        $users = UserModel::select('user_id', 'nama')->get();

        return view('penjualan.edit_ajax', compact('penjualan', 'users'));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'pembeli' => 'required|string|min:3|max:100',
            'penjualan_tanggal' => 'required|date',
            'user_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $penjualan = PenjualanModel::find($id);

        if ($penjualan) {
            $penjualan->update([
                'pembeli' => $request->pembeli,
                'penjualan_tanggal' => $request->penjualan_tanggal,
                'user_id' => $request->user_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil diupdate'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', compact('penjualan'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $penjualan = PenjualanModel::find($id);

        if ($penjualan) {
            $penjualan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil dihapus'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        $rules = [
            'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_penjualan');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        foreach ($data as $i => $value) {
            if ($i > 1) {
                $insert[] = [
                    'user_id' => $value['A'],
                    'pembeli' => $value['B'],
                    'penjualan_kode' => $value['C'],
                    'penjualan_tanggal' => $value['D'],
                    'created_at' => now(),
                ];
            }
        }

        if (!empty($insert)) {
            PenjualanModel::insertOrIgnore($insert);
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Tidak ada data yang diimport'
        ]);
    }

    public function export_excel()
    {
        $penjualan = PenjualanModel::select('penjualan_kode', 'pembeli')
            ->orderBy('penjualan_id')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Pembeli');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $row = 2;
        foreach ($penjualan as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $data->penjualan_kode);
            $sheet->setCellValue('C' . $row, $data->pembeli);
            $row++;
        }

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Data_Penjualan_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualan = PenjualanModel::select('penjualan_kode', 'pembeli')
            ->orderBy('penjualan_id')
            ->get();

            $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
