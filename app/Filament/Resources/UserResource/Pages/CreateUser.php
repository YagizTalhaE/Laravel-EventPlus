<?php

// Bu dosya, Filament paneli için yeni bir kullanıcı oluşturma sayfasını tanımlar.

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    // Bu sınıf, Filament'in yeni kayıt oluşturma sayfasını genişletir.

    protected static string $resource = UserResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
