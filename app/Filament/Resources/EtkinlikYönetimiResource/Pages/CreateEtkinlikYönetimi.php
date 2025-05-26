<?php

// Bu dosya, Filament paneli için yeni bir etkinlik oluşturma sayfasını tanımlar.

namespace App\Filament\Resources\EtkinlikYönetimiResource\Pages;

use App\Filament\Resources\EtkinlikYönetimiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEtkinlikYönetimi extends CreateRecord
{
    // Bu sınıf, Filament'in yeni kayıt oluşturma sayfasını genişletir.

    protected static string $resource = EtkinlikYönetimiResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.

    public function getTitle(): string
    {
        // Sayfanın başlığını döndürür.
        return 'Etkinlik Ekle';
    }

    public function getCreateButtonLabel(): string
    {
        // Oluşturma düğmesinin etiketini döndürür.
        return 'Etkinlik Ekle';
    }
}
