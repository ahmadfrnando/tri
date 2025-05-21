<?php

namespace App\Http\Controllers;

use App\DataTables\BarangKeluarDataTable;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Handphone;
use App\Models\RefKondisiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;

class RiwayatBarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangKeluar::with('handphone', 'kondisi')->where('id_user', Auth::user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $actionBtn = '<a href="' . route('barang-keluar.edit', $row->id) . '" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deleteData(' . $row->id . ')">Delete</a>';
                    $actionBtn = '<a href="' . route('riwayat-barang-keluar.show', $row->id) . '" class="kelola btn btn-success btn-sm" data-id="' . $row->id . '">Detail Barang</a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('riwayat-barang-keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = BarangKeluar::with('handphone', 'kondisi')->where('id_user', Auth::user()->id)->get();
        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataKeluar = BarangKeluar::with('handphone')->where('id', $id)->first();
        $dataMasuk = BarangMasuk::with('handphone')->where('id_user', $dataKeluar->id_handphone)->first();
        return view('riwayat-barang-keluar.show', compact('dataMasuk', 'dataKeluar'));
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
