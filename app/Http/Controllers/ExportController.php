<?php

namespace App\Http\Controllers;

use App\Exports\BarangKeluarExport;
use App\Exports\BarangMasukExport;
use App\Exports\BarangRusakExport;
use App\Exports\HandphoneExport;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function semuaBarang()
    {   
        $dateTime = now();
        $date = $dateTime->format('YmdHis');
        return Excel::download(new HandphoneExport, 'handphone'. '-' . $date .'.xlsx');
    }

    public function barangMasuk()
    {   
        $dateTime = now();
        $date = $dateTime->format('YmdHis');
        return Excel::download(new BarangMasukExport, 'Barang-Masuk'. '-' . $date .'.xlsx');
    }

    public function barangKeluar()
    {   
        $dateTime = now();
        $date = $dateTime->format('YmdHis');
        return Excel::download(new BarangKeluarExport, 'Barang-Keluar'. '-' . $date .'.xlsx');
    }

    public function barangRusak()
    {   
        $dateTime = now();
        $date = $dateTime->format('YmdHis');
        return Excel::download(new BarangRusakExport, 'Barang-Rusak'. '-' . $date .'.xlsx');
    }
}
