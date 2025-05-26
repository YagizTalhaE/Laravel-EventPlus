<?php

// Bu dosya, Filament yönetici paneli için özel bir giriş sayfası oluşturur.

namespace App\Filament\Pages;
// Bu, dosyanın bulunduğu isim alanını belirtir.

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Notifications\Notification;
// Gerekli Filament sınıflarını içeri aktarır.

class Login extends BaseLogin
{
    // Bu sınıf, Filament'in varsayılan giriş sayfasını genişletir.

    public function mount(): void
    {
        parent::mount();
        // Temel sınıfın yükleme metodunu çağırır.

        if (session()->pull('admin_access_denied')) {
            // Eğer yönetici erişimi reddedildiyse kontrol eder.

            Notification::make()
                // Kullanıcıya bir bildirim gösterir.
                ->title('Adminlik yetkiniz yok.')
                ->danger()
                ->persistent()     // Bildirimin kalıcı olmasını sağlar.
                ->send();
        }
    }
}
