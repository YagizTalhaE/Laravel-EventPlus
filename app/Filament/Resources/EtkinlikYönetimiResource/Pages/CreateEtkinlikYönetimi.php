<?php

namespace App\Filament\Resources\EtkinlikYönetimiResource\Pages;

use App\Filament\Resources\EtkinlikYönetimiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEtkinlikYönetimi extends CreateRecord
{
    protected static string $resource = EtkinlikYönetimiResource::class;

    public function getTitle(): string
    {
        return 'Etkinlik Ekle';
    }

    public function getCreateButtonLabel(): string
    {
        return 'Etkinlik Ekle';
    }
}
