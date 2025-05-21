<?php

namespace App\Exports;

use App\Models\DataBarangRusak;
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

class BarangRusakExport implements FromQuery, WithHeadings, WithEvents, WithDrawings, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return DataBarangRusak::query();
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
            'Kondisi Barang Rusak',
            'Tanggal',
            'Bukti Barang Rusak',
            'Deskripsi Kerusakan',
        ];
    }

    public function map($barangRusak): array
    {
        return [
            $barangRusak->user->name,
            "'" . $barangRusak->handphone->imei,
            $barangRusak->handphone->model,
            $barangRusak->handphone->tipe->nama_tipe,
            $barangRusak->handphone->ukuran_layar . ' inch',
            $barangRusak->handphone->ram->ram,
            $barangRusak->kondisi->kondisi_barang,
            $barangRusak->tanggal,
            '',
            $barangRusak->deskripsi_kerusakan,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function drawings()
    {
        $drawings = [];

        // Misal kamu ambil semua data dulu
        $barangRusak = $this->query()->get();

        foreach ($barangRusak as $index => $item) {
            if ($item->bukti_barang_rusak) {  // koreksi typo dari 'bukti_barang_masul'
                $drawing = new Drawing();
                $drawing->setName('Foto Barang Rusak');
                $drawing->setDescription('Foto Barang Rusak');
                $drawing->setPath(public_path('storage/' . $item->bukti_barang_rusak)); // pastikan path benar
                $drawing->setHeight(60);
                $drawing->setCoordinates('I' . ($index + 2)); // kolom J, baris mulai 2 karena header

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getColumnDimension('I')->setWidth(100);
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
