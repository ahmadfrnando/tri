<?php

namespace App\Filament\Resources\HandphoneResource\Pages;

use App\Filament\Resources\HandphoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;

class ListHandphones extends ListRecords
{
    protected static string $resource = HandphoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->action(function (array $data) {
                    return redirect()->route('semua-barang.export');
                }),
            Actions\CreateAction::make()->label('Tambah Handphone')
        ];
    }
}
