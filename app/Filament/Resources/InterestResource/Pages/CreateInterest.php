<?php

// Bu dosya, Filament paneli için yeni bir ilgi alanı (interest) oluşturma sayfasını tanımlar.

namespace App\Filament\Resources\InterestResource\Pages;

use App\Filament\Resources\InterestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInterest extends CreateRecord
{
    // Bu sınıf, Filament'in yeni kayıt oluşturma sayfasını genişletir.

    protected static string $resource = InterestResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
