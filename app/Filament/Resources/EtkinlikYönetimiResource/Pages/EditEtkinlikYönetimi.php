<?php

namespace App\Filament\Resources\EtkinlikYönetimiResource\Pages;

use App\Filament\Resources\EtkinlikYönetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEtkinlikYönetimi extends EditRecord
{
    protected static string $resource = EtkinlikYönetimiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
