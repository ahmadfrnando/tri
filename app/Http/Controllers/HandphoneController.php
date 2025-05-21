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

class HandphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Handphone::with('kondisi', 'status')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id_kondisi', function ($row) {
                    return $row->getBadgeKondisi() ?? 'tidak tersedia';
                })
                ->addColumn('id_status', function ($row) {
                    return $row->getBadgeStatus() ?? 'tidak tersedia';
                })
                ->rawColumns(['id_kondisi', 'id_status'])
                ->make(true);
        }
        return view('handphone.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Handphone::with('kondisi', 'status')->get();
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

    public function search(Request $request)
    {
        $handphone = Handphone::where('id_status', 1)->where('imei', 'like', '%' . $request->q . '%')->get();
        return response()->json($handphone, 200);
    }
}
