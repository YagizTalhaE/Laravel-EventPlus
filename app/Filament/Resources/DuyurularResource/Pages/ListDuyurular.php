<?php

// Bu dosya, Filament paneli için duyuruları listeleme sayfasını tanımlar.

namespace App\Filament\Resources\DuyurularResource\Pages;

use App\Filament\Resources\DuyurularResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDuyurular extends ListRecords
{
    // Bu sınıf, Filament'in kayıtları listeleme sayfasını genişletir.

    protected static string $resource = DuyurularResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.

    protected function getHeaderActions(): array
    {
        // Sayfa başlığında görüntülenecek eylemleri tanımlar.
        return [
            Actions\CreateAction::make()
                // Yeni bir 'Oluştur' eylemi ekler.
                ->label('Duyuru Ekle')
            // Eylemin görünen etiketini 'Duyuru Ekle' olarak ayarlar.
        ];
    }
}
