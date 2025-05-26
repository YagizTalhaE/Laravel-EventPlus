<?php

// Bu dosya, Filament paneli için ilgi alanlarını (interest) listeleme sayfasını tanımlar.

namespace App\Filament\Resources\InterestResource\Pages;

use App\Filament\Resources\InterestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInterests extends ListRecords
{
    // Bu sınıf, Filament'in kayıtları listeleme sayfasını genişletir.

    protected static string $resource = InterestResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.

    protected function getHeaderActions(): array
    {
        // Sayfa başlığında görüntülenecek eylemleri tanımlar.
        return [
            Actions\CreateAction::make(),
            // Yeni bir 'Oluştur' eylemi ekler.
        ];
    }
}
