<?php

namespace App\Filament\Resources\DataBarangRusakResource\Pages;

use App\Filament\Resources\DataBarangRusakResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDataBarangRusaks extends ManageRecords
{
    protected static string $resource = DataBarangRusakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->action(function (array $data) {
                    return redirect()->route('barang-rusak.export');
                }),
            Actions\CreateAction::make()->label('Buat Data Barang Rusak')->color('danger'),
        ];
    }
}
