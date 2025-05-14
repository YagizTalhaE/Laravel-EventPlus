<?php

namespace App\Filament\Resources\AyarlarResource\Pages;

use App\Filament\Resources\AyarlarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAyarlar extends EditRecord
{
    protected static string $resource = AyarlarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
