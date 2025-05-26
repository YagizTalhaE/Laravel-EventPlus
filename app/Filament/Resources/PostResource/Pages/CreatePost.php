<?php

// Bu dosya, Filament paneli için yeni bir gönderi (post) oluşturma sayfasını tanımlar.

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    // Bu sınıf, Filament'in yeni kayıt oluşturma sayfasını genişletir.

    protected static string $resource = PostResource::class;
    // Bu sayfanın hangi Filament kaynağı (resource) için kullanıldığını belirtir.
}
