<?php

namespace App\Http\Controllers;

use App\DataTables\BarangKeluarDataTable;
use App\Models\BarangKeluar;
use App\Models\DataBarangRusak;
use App\Models\Handphone;
use App\Models\RefKondisiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;

class KelolaBarangRusakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataBarangRusak::with('handphone')->where('id_user', Auth::user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('bukti_barang_rusak', function ($row) {
                    $image = '<img src="' . asset('storage/' . $row->bukti_barang_rusak) . '" width="100" height="100" alt="Bukti Barang Rusak">';
                    return $image;
                })
                ->addColumn('tanggal', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y');
                })
                ->addColumn('imei', function ($row) {
                    return $row->handphone ? $row->handphone->imei : '-';
                })
                ->addColumn('model', function ($row) {
                    return $row->handphone ? $row->handphone->model : '-';
                })

                ->rawColumns(['bukti_barang_rusak'])
                ->make(true);
        }
        return view('kelola-barang-rusak.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DataBarangRusak::with('handphone')->where('id_user', Auth::user()->id)->get();
        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_handphone' => 'required|exists:handphone,id',
                'tanggal' => 'required|date',
                'deskripsi_kerusakan' => 'required|string',
                // 'bukti_barang_rusak' => 'required|file|mimes:jpeg,png,pdf,jpg|max:2048',
            ]);

            $filePath = null;
            // if ($request->hasFile('bukti_barang_rusak')) {
            //     $file = $request->file('bukti_barang_rusak');
            //     $filePath = $file->store('bukti-barang-rusak', 'public');
            // }
            DataBarangRusak::create([
                'id_handphone' => $validatedData['id_handphone'],
                'tanggal' => $validatedData['tanggal'],
                'deskripsi_kerusakan' => $validatedData['deskripsi_kerusakan'],
                'bukti_barang_rusak' => $filePath,
                'id_user' => auth()->user()->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $validatedData
            ], 200);
        } catch (\Exception $e) {
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
