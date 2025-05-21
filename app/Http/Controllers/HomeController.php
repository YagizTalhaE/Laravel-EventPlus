<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Duyurular;
use Illuminate\Support\Facades\DB;
use App\Models\EtkinlikYönetimi;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Popüler ve aktif etkinlikleri al
        $populerEvents = EtkinlikYönetimi::where('populer_mi', true)
            ->where('aktif', true) // <--- burada aktif_mi değil aktif kullandık
            ->latest()
            ->limit(4)
            ->get();

        if (!$user) {
            $duyurular = Duyurular::where('aktif', true)
                ->latest()
                ->limit(5)
                ->get();

            return view('anasayfa', [
                'recommendedPosts' => collect(),
                'duyurular' => $duyurular,
                'populerEvents' => $populerEvents,
            ]);
        }

        $topInterestIds = DB::table('clicks')
            ->join('posts', 'clicks.post_id', '=', 'posts.id')
            ->select('posts.interest_id', DB::raw('count(*) as total'))
            ->where('clicks.user_id', $user->id)
            ->groupBy('posts.interest_id')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('posts.interest_id');

        $recommendedPosts = Post::whereIn('interest_id', $topInterestIds)
            ->latest()
            ->limit(10)
            ->get();

        $duyurular = Duyurular::where('aktif', true)
            ->latest()
            ->limit(5)
            ->get();

        return view('anasayfa', compact('recommendedPosts', 'duyurular', 'populerEvents'));
    }
}
