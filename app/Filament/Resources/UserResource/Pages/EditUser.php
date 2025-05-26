<?php

// Bu dosya, Filament paneli için mevcut bir kullanıcıyı düzenleme sayfasını tanımlar.

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    // Bu sınıf, Filament'in mevcut kayıt düzenleme sayfasını genişletir.

    protected static string $resource = UserResource::class;
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
