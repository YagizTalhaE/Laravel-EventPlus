<?php

namespace App\Filament\Resources\DuyurularResource\Pages;

use App\Filament\Resources\DuyurularResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDuyurulars extends ListRecords
{
    protected static string $resource = DuyurularResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
