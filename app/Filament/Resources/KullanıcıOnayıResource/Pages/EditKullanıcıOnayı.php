<?php

// Bu dosya, Filament paneli için mevcut bir kullanıcı onayı kaydını düzenleme sayfasını tanımlar.

namespace App\Filament\Resources\KullanıcıOnayıResource\Pages;

use App\Filament\Resources\KullanıcıOnayıResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKullanıcıOnayı extends EditRecord
{
    // Bu sınıf, Filament'in mevcut kayıt düzenleme sayfasını genişletir.

    protected static string $resource = KullanıcıOnayıResource::class;
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
