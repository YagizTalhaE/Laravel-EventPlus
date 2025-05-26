<?php

// Bu dosya, Filament paneli için mevcut bir ilgi alanını (interest) düzenleme sayfasını tanımlar.

namespace App\Filament\Resources\InterestResource\Pages;

use App\Filament\Resources\InterestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInterest extends EditRecord
{
    // Bu sınıf, Filament'in mevcut kayıt düzenleme sayfasını genişletir.

    protected static string $resource = InterestResource::class;
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
