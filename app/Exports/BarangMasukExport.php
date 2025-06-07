<?php

namespace App\Exports;

use App\Models\BarangMasuk;
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

class BarangMasukExport implements FromQuery, WithHeadings, WithEvents, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return BarangMasuk::query();
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
            'Kondisi Barang Masuk',
            'Tanggal Masuk',
            'Harga Barang Masuk',
            // 'Bukti Barang Masuk',
        ];
    }

    public function map($barangMasuk): array
    {
        return [
            $barangMasuk->user->name,
            "'" . $barangMasuk->handphone->imei,
            $barangMasuk->handphone->model,
            $barangMasuk->handphone->tipe->nama_tipe,
            $barangMasuk->handphone->ukuran_layar . ' inch',
            $barangMasuk->handphone->ram->ram,
            $barangMasuk->kondisi->kondisi_barang,
            $barangMasuk->tanggal_masuk,
            $barangMasuk->harga_masuk,
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
    //     $barangMasuk = $this->query()->get();

    //     foreach ($barangMasuk as $index => $item) {
    //         if ($item->bukti_barang_masuk) {  // koreksi typo dari 'bukti_barang_masul'
    //             $drawing = new Drawing();
    //             $drawing->setName('Foto Barang Masuk');
    //             $drawing->setDescription('Foto Barang Masuk');
    //             $drawing->setPath(public_path('storage/' . $item->bukti_barang_masuk)); // pastikan path benar
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
