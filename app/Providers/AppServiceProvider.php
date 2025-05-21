<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Ayarlar;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\App;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::componentNamespace('BladeUI\\Heroicons\\Components', 'heroicon');

        View::composer('*', function ($view) {
            $ayarlar = Ayarlar::first();
            $view->with('ayarlar', $ayarlar);
        });
        Carbon::setLocale('tr');
        setlocale(LC_TIME, 'tr_TR.UTF-8'); // tarih için
    }
}


