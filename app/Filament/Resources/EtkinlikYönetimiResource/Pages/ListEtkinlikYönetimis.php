<?php

namespace App\Filament\Resources\EtkinlikYönetimiResource\Pages;

use App\Filament\Resources\EtkinlikYönetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEtkinlikYönetimis extends ListRecords
{
    protected static string $resource = EtkinlikYönetimiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
