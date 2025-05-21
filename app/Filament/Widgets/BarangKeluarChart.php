<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BarangKeluarChart extends ChartWidget
{
    protected static ?string $heading = 'Barang Keluar';
    protected static ?int $sort = 8;

    protected function getData(): array
    {
        $dataMasuk = \App\Models\BarangKeluar::all()->groupBy('tanggal_keluar')->map(function ($item, $key) {
            return $item->count();
        });

        return [
            'labels' => $dataMasuk->keys()->toArray(),
            'datasets' => [[
                'label' => 'Barang Masuk',
                'data' => $dataMasuk->values()->toArray(),
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ]
            ]]
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
