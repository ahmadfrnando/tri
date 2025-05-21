<?php

namespace App\Exports;

use App\Models\Handphone;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HandphoneExport implements FromQuery, WithHeadings, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return Handphone::query()
            ->where('id_kondisi', '!=', null);
    }

    public function headings(): array
    {
        return [
            'IMEI',
            'Model',
            'Tipe Handphone',
            'Ukuran Layar',
            'RAM',
            'Kondisi Barang',
            'Status Barang',
        ];
    }

    public function map($hp): array
    {
        return [
            "'" . $hp->imei,
            $hp->model,
            $hp->tipe->nama_tipe,
            $hp->ukuran_layar . ' inch',
            $hp->ram->ram,
            $hp->kondisi->kondisi_barang,
            $hp->status->status_handphone,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
