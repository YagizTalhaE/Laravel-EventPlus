<?php

// Bu dosya, Filament paneli için mevcut bir gönderiyi (post) düzenleme sayfasını tanımlar.

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    // Bu sınıf, Filament'in mevcut kayıt düzenleme sayfasını genişletir.

    protected static string $resource = PostResource::class;
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
