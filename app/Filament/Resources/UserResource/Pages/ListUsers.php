<?php

// Bu dosya, Filament paneli için kullanıcıları listeleme sayfasını tanımlar.

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    // Bu sınıf, Filament'in kayıtları listeleme sayfasını genişletir.

    protected static string $resource = UserResource::class;
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
