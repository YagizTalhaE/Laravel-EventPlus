<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Burada event modelini kullanarak gerçek arama yapılabilir.
        // Şimdilik demo amaçlı sorguyu view'a gönderiyoruz.

        return view('events.search_results', compact('query'));
    }
}

