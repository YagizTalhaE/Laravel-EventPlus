<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ayarlar;

class CheckBakimModu
{
    public function handle($request, Closure $next)
    {
        $ayar = Ayarlar::first();

        if ($ayar && $ayar->bakim_modu) {
            // Sadece adminler erişebilsin istersen buraya auth kontrolü ekleyebilirsin
            return response()->view('bakim'); // resources/views/bakim.blade.php
        }

        return $next($request);
    }
}

