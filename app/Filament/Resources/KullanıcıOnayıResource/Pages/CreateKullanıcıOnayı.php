<?php

// Bu dosya, Filament paneli için yeni bir kullanıcı onayı kaydı oluşturma sayfasını tanımlar.

namespace App\Filament\Resources\KullanıcıOnayıResource\Pages;

use App\Filament\Resources\KullanıcıOnayıResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKullanıcıOnayı extends CreateRecord
{
    // Bu sınıf, Filament'in yeni kayıt oluşturma sayfasını genişletir.

    protected static string $resource = KullanıcıOnayıResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
