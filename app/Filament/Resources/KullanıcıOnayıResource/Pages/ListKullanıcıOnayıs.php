<?php

namespace App\Filament\Resources\KullanıcıOnayıResource\Pages;

use App\Filament\Resources\KullanıcıOnayıResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKullanıcıOnayıs extends ListRecords
{
    protected static string $resource = KullanıcıOnayıResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
