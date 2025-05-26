<?php

// Bu dosya, Filament paneli için kullanıcı onayı kayıtlarını listeleme sayfasını tanımlar.

namespace App\Filament\Resources\KullanıcıOnayıResource\Pages;

use App\Filament\Resources\KullanıcıOnayıResource;
use Filament\Resources\Pages\ListRecords;

class ListKullanıcıOnayları extends ListRecords
{
    // Bu sınıf, Filament'in kayıtları listeleme sayfasını genişletir.

    protected static string $resource = KullanıcıOnayıResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
