<?php


namespace App\Filament\Pages;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Notifications\Notification;

class Login extends BaseLogin
{
    public function mount(): void
    {
        parent::mount();

        if (session()->pull('admin_access_denied')) {
            Notification::make()
                ->title('Adminlik yetkiniz yok.')
                ->danger()
                ->persistent()
                ->send();
        }
    }
}

