<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Duyurular;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Giriş yapılmamışsa öneri ve duyuru göstermek isteğe bağlı
        if (!$user) {
            $duyurular = Duyurular::where('aktif', true)
                ->latest()
                ->limit(5)
                ->get();

            return view('anasayfa', [
                'recommendedPosts' => collect(),
                'duyurular' => $duyurular,
            ]);
        }

        // Kullanıcının en çok tıkladığı ilgi alanlarını getir
        $topInterestIds = DB::table('clicks')
            ->join('posts', 'clicks.post_id', '=', 'posts.id')
            ->select('posts.interest_id', DB::raw('count(*) as total'))
            ->where('clicks.user_id', $user->id)
            ->groupBy('posts.interest_id')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('posts.interest_id');

        // O ilgi alanlarına göre önerilen postları getir
        $recommendedPosts = Post::whereIn('interest_id', $topInterestIds)
            ->latest()
            ->limit(10)
            ->get();

        // Aktif duyuruları getir
        $duyurular = Duyurular::where('aktif', true)
            ->latest()
            ->limit(5)
            ->get();

        return view('anasayfa', compact('recommendedPosts', 'duyurular'));
    }
}
