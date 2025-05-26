<?php

// Bu dosya, Filament paneli için etkinlikleri listeleme sayfasını tanımlar.

namespace App\Filament\Resources\EtkinlikYönetimiResource\Pages;

use App\Filament\Resources\EtkinlikYönetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;


class ListEtkinlikYönetimis extends ListRecords
{
    // Bu sınıf, Filament'in kayıtları listeleme sayfasını genişletir.

    protected static string $resource = EtkinlikYönetimiResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.

    protected function getHeaderActions(): array
    {
        // Sayfa başlığında görüntülenecek eylemleri tanımlar.
        return [
            Actions\CreateAction::make()->label('Etkinlik Ekle'),
            // Yeni bir 'Oluştur' eylemi ekler ve etiketini 'Etkinlik Ekle' olarak ayarlar.
        ];
    }
}
