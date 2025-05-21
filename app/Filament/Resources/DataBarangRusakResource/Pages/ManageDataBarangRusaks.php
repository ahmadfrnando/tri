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
            Actions\CreateAction::make(),
        ];
    }
}
