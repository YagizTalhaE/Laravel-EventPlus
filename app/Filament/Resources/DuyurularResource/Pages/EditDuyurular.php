<?php

// Bu dosya, Filament paneli için mevcut bir duyuruyu düzenleme sayfasını tanımlar.

namespace App\Filament\Resources\DuyurularResource\Pages;

use App\Filament\Resources\DuyurularResource;
use Filament\Resources\Pages\EditRecord;

class EditDuyurular extends EditRecord
{
    // Bu sınıf, Filament'in mevcut kayıt düzenleme sayfasını genişletir.

    protected static string $resource = DuyurularResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
