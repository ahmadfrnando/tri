<?php

namespace App\Http\Controllers;

use App\DataTables\BarangKeluarDataTable;
use App\Models\BarangKeluar;
use App\Models\Handphone;
use App\Models\RefKondisiBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Handphone::select('*')
                ->whereHas('status', function ($query) {
                    $query->where('id_status', 1);
                });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $actionBtn = '<a href="' . route('barang-keluar.edit', $row->id) . '" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deleteData(' . $row->id . ')">Delete</a>';
                    $actionBtn = '<button data-bs-toggle="modal" data-bs-target="#modalEdit" class="kelola btn btn-success btn-sm" data-id="' . $row->id . '">Kelola Barang</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $refKondisi = RefKondisiBarang::all();
        return view('barang-keluar.index', compact('refKondisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Data berhasil disimpan!',
        // ], 200);
        try {
            // Validasi data yang diterima
            $validatedData = $request->validate([
                'id' => 'required|exists:handphone,id', // Validasi ID, pastikan ID ada di database
                'tanggal_keluar' => 'required|date', // Validasi tanggal
                'harga_keluar' => 'required|numeric', // Validasi harga
                'id_kondisi' => 'required|exists:ref_kondisi_barang,id', // Validasi kondisi barang
                'bukti_barang_keluar' => 'required|file|mimes:jpeg,png,pdf,jpg|max:2048', // Validasi file
            ]);

            // Ambil data berdasarkan ID yang dikirimkan
            // Proses file upload jika ada
            $filePath = null;
            if ($request->hasFile('bukti_barang_keluar')) {
                $file = $request->file('bukti_barang_keluar');
                $filePath = $file->store('bukti-barang-keluar', 'public'); // Menyimpan file di public storage
            }
            BarangKeluar::create([
                'id_handphone' => $validatedData['id'],
                'tanggal_keluar' => $validatedData['tanggal_keluar'],
                'harga_keluar' => $validatedData['harga_keluar'],
                'id_kondisi' => $validatedData['id_kondisi'],
                'bukti_barang_keluar' => $filePath,
                'id_user' => auth()->user()->id
            ]);

            // Kembalikan respons sukses dengan data yang baru disimpan
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $validatedData
            ], 200);
        } catch (\Exception $e) {
            // Tangani kesalahan dengan memberikan informasi lebih rinci
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
