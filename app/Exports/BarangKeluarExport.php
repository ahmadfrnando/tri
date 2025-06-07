<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangKeluarExport implements FromQuery, WithHeadings, WithEvents, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return BarangKeluar::query();
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'IMEI',
            'Model',
            'Tipe Handphone',
            'Ukuran Layar',
            'RAM',
            'Kondisi Barang Keluar',
            'Tanggal Keluar',
            'Harga Barang Keluar',
            // 'Bukti Barang Keluar',
        ];
    }

    public function map($barangKeluar): array
    {
        return [
            $barangKeluar->user->name,
            "'" . $barangKeluar->handphone->imei,
            $barangKeluar->handphone->model,
            $barangKeluar->handphone->tipe->nama_tipe,
            $barangKeluar->handphone->ukuran_layar . ' inch',
            $barangKeluar->handphone->ram->ram,
            $barangKeluar->kondisi->kondisi_barang,
            $barangKeluar->tanggal_keluar,
            $barangKeluar->harga_keluar,
            // ''
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => '"Rp"#,##0_-',
        ];
    }

    // public function drawings()
    // {
    //     $drawings = [];

    //     // Misal kamu ambil semua data dulu
    //     $barangKeluar = $this->query()->get();

    //     foreach ($barangKeluar as $index => $item) {
    //         if ($item->bukti_barang_keluar) {  // koreksi typo dari 'bukti_barang_masul'
    //             $drawing = new Drawing();
    //             $drawing->setName('Foto Barang Keluar');
    //             $drawing->setDescription('Foto Barang Keluar');
    //             $drawing->setPath(public_path('storage/' . $item->bukti_barang_keluar)); // pastikan path benar
    //             $drawing->setHeight(60);
    //             $drawing->setCoordinates('J' . ($index + 2)); // kolom J, baris mulai 2 karena header

    //             $drawings[] = $drawing;
    //         }
    //     }

    //     return $drawings;
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // $sheet->getColumnDimension('J')->setWidth(100);
                $sheet->getColumnDimension('B')->setWidth(100);

                
                $startRow = 2;
                $totalRows = $this->query()->count() + 1;
                
                for ($row = $startRow; $row <= $totalRows; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(70);
                }
            },
        ];
    }
}
