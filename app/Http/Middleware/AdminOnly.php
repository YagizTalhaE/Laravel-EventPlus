<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            Auth::logout();

            // Laravel session'a özel bir flash mesaj bırak
            session()->flash('admin_access_denied', true);

            return redirect()->route('filament.admin.auth.login');
        }

        return $next($request);
    }
}


