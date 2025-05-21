<?php

namespace App\Filament\Resources\ApprovalUsulanBarangBaruResource\Pages;

use App\Filament\Resources\ApprovalUsulanBarangBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageApprovalUsulanBarangBarus extends ManageRecords
{
    protected static string $resource = ApprovalUsulanBarangBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
