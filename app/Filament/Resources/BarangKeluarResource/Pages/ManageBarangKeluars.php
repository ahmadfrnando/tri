<?php

namespace App\Filament\Resources\BarangKeluarResource\Pages;

use App\Filament\Resources\BarangKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBarangKeluars extends ManageRecords
{
    protected static string $resource = BarangKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->action(function (array $data) {
                    return redirect()->route('barang-keluar.export');
                }),
            Actions\CreateAction::make()->label('Tambah Barang Keluar'),
        ];
    }
}
