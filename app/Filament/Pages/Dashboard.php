<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    // Sayfa ikonunu ayarlıyoruz
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // Sayfanın kullanacağı Blade görünümü
    protected static string $view = 'filament.pages.dashboard';

    // Sol menüde görünecek başlık
    protected static ?string $title = 'Ana Sayfa';

    // Sol menüde gösterilecek etiket
    protected static ?string $navigationLabel = 'Ana Sayfa';

    // Navigasyonda ilk sıraya almak için sıralama
    protected static ?int $navigationSort = -1;

    // Giriş yapmış herkes görebilsin (isteğe bağlı override)
    public static function canView(): bool
    {
        return auth()->check(); // Giriş yapmış kullanıcılar için görünür
    }
}


