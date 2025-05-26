<?php

// Bu dosya, Filament paneli için mevcut bir etkinliği düzenleme sayfasını tanımlar.

namespace App\Filament\Resources\EtkinlikYönetimiResource\Pages;

use App\Filament\Resources\EtkinlikYönetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEtkinlikYönetimi extends EditRecord
{
    // Bu sınıf, Filament'in mevcut kayıt düzenleme sayfasını genişletir.

    protected static string $resource = EtkinlikYönetimiResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.

    protected function getHeaderActions(): array
    {
        // Sayfa başlığında görüntülenecek eylemleri tanımlar.
        return [
            Actions\DeleteAction::make(),
            // Bir 'Sil' eylemi ekler.
        ];
    }
}
