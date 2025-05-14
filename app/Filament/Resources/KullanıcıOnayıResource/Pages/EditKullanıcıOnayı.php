<?php

namespace App\Filament\Resources\KullanıcıOnayıResource\Pages;

use App\Filament\Resources\KullanıcıOnayıResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKullanıcıOnayı extends EditRecord
{
    protected static string $resource = KullanıcıOnayıResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
