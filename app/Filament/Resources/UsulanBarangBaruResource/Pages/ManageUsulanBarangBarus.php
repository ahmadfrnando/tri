<?php

namespace App\Filament\Resources\UsulanBarangBaruResource\Pages;

use App\Filament\Resources\UsulanBarangBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUsulanBarangBarus extends ManageRecords
{
    protected static string $resource = UsulanBarangBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
