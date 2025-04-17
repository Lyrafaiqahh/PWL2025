<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
 use PhpOffice\PhpSpreadsheet\IOFactory;
 use PhpOffice\PhpSpreadsheet\Spreadsheet;
 use Barryvdh\DomPDF\Facade\Pdf;
 
 

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok'],
        ];

        $page = (object) [
            'title' => 'Daftar stok barang yang tersedia dalam sistem',
        ];

        $activeMenu = 'stok';

        $stok = StokModel::all();

        return view('stok.index', compact('breadcrumb', 'activeMenu', 'page', 'stok'));
    }

    public function list(Request $request)
    {
        $stok = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at');

        if ($request->stok_id) {
            $stok->where('stok_id', $request->stok_id);
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah stok baru',
        ];

        $activeMenu = 'stok';

        return view('stok.create', compact('breadcrumb', 'activeMenu', 'page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::create($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $stok = StokModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail Stok',
        ];

        $activeMenu = 'stok';

        return view('stok.show', compact('breadcrumb', 'page', 'activeMenu', 'stok'));
    }

    public function edit(string $id)
    {
        $stok = StokModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Stok',
        ];

        $activeMenu = 'stok';

        return view('stok.edit', compact('breadcrumb', 'activeMenu', 'page', 'stok'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::find($id)->update($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat relasi dengan tabel lain');
        }
    }

    public function import()
    {
        return view('stok.import'); // Ganti view sesuai dengan konteks (stok)
    }
    
    public function import_ajax(Request $request)
{
    $rules = [
        'file_stok' => ['required', 'mimes:xlsx,xls', 'max:1024']
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi Gagal',
            'msgField' => $validator->errors()
        ]);
    }

    try {
        $file = $request->file('file_stok');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        if (count($data) > 1) {
            foreach ($data as $row => $value) {
                if ($row > 1) { // Lewati baris header
                    $insert[] = [
                        'barang_id'    => $value['A'],
                        'user_id'      => $value['B'],
                        'stok_tanggal' => $value['C'],
                        'stok_jumlah'  => $value['D'],
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            if (count($insert) > 0) {
                StokModel::insertOrIgnore($insert);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Tidak ada data yang diimport'
        ]);
    } catch (\Exception $e) {
        \Log::error('Stok Import Error: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Gagal mengunggah file: ' . $e->getMessage()
        ], 500);
    }
}

public function export_excel()
{
    // Ambil data stok yang akan diekspor
    $stoks = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at')
        ->orderBy('stok_id')
        ->get();

    // Load library PhpSpreadsheet
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Stok ID');
    $sheet->setCellValue('C1', 'Barang ID');
    $sheet->setCellValue('D1', 'User ID');
    $sheet->setCellValue('E1', 'Tanggal Stok');
    $sheet->setCellValue('F1', 'Jumlah Stok');
    $sheet->setCellValue('G1', 'Created At');
    $sheet->setCellValue('H1', 'Updated At');

    // Format header bold
    $sheet->getStyle('A1:H1')->getFont()->setBold(true);

    // Isi data stok
    $no = 1;
    $baris = 2;
    foreach ($stoks as $stok) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $stok->stok_id);
        $sheet->setCellValue('C' . $baris, $stok->barang_id);
        $sheet->setCellValue('D' . $baris, $stok->user_id);
        $sheet->setCellValue('E' . $baris, $stok->stok_tanggal);
        $sheet->setCellValue('F' . $baris, $stok->stok_jumlah);
        $sheet->setCellValue('G' . $baris, $stok->created_at);
        $sheet->setCellValue('H' . $baris, $stok->updated_at);
        $baris++;
        $no++;
    }

    // Set auto size untuk kolom
    foreach (range('A', 'H') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Set title sheet
    $sheet->setTitle('Data Stok');

    // Generate filename
    $filename = 'Data_Stok_' . date('Y-m-d_H-i-s') . '.xlsx';

    // Set header untuk download file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}

public function export_pdf()
{
    // Ambil data stok
    $stoks = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at')
        ->orderBy('stok_id')
        ->get();

    // Gunakan view 'stok.export_pdf' untuk generate PDF
    $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stoks]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption("isRemoteEnabled", true);
    $pdf->render();

    return $pdf->stream('Data Stok ' . date('Y-m-d_H-i-s') . '.pdf');
}

}
