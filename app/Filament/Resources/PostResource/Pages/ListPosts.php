<?php

// Bu dosya, Filament paneli için gönderileri (post) listeleme sayfasını tanımlar.

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    // Bu sınıf, Filament'in kayıtları listeleme sayfasını genişletir.

    protected static string $resource = PostResource::class;
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
