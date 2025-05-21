<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBarangMasuks extends ManageRecords
{
    protected static string $resource = BarangMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->action(function (array $data) {
                    return redirect()->route('barang-masuk.export');
                }),
            Actions\CreateAction::make()->label('Tambah Barang Masuk'),
        ];
    }
}
