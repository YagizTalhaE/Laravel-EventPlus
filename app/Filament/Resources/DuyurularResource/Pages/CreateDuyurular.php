<?php

// Bu dosya, Filament paneli için yeni bir duyuru oluşturma sayfasını tanımlar.

namespace App\Filament\Resources\DuyurularResource\Pages;

use App\Filament\Resources\DuyurularResource;
use Filament\Resources\Pages\CreateRecord;


class CreateDuyurular extends CreateRecord
{
    // Bu sınıf, Filament'in yeni kayıt oluşturma sayfasını genişletir.

    protected static string $resource = DuyurularResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
