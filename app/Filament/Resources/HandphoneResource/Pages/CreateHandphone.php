<?php

namespace App\Filament\Resources\HandphoneResource\Pages;

use App\Filament\Resources\HandphoneResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHandphone extends CreateRecord
{
    protected static string $resource = HandphoneResource::class;

    protected static ?string $title = 'Tambah Handphone';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
