<?php

namespace App\Filament\Widgets;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\DataBarangRusak;
use App\Models\Handphone;
use App\Models\UsulanBarangBaru;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDataBarang extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Handphone::count()),
            Stat::make('Total Barang Masuk', BarangMasuk::count()),
            Stat::make('Total Barang Keluar', BarangKeluar::count()),
            Stat::make('Total Barang Rusak', DataBarangRusak::count()),
            Stat::make('Total Usulan Barang Baru', UsulanBarangBaru::count()),
        ];
    }
}
