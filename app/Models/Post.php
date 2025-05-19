<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // 🔽 İLGİ ALANI (KATEGORİ) İLİŞKİSİ
    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }

    // 🔽 TIKLAMA İLİŞKİSİ
    public function clicks()
    {
        return $this->hasMany(Click::class);
    }
}
