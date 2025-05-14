<?php

namespace App\Filament\Resources\DuyurularResource\Pages;

use App\Filament\Resources\DuyurularResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDuyurular extends EditRecord
{
    protected static string $resource = DuyurularResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
