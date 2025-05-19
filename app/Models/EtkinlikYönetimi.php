<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtkinlikYönetimi extends Model
{
    use HasFactory;

    protected $table = 'etkinlik_yönetimis'; // Migration'daki tablo adıyla aynı olmalı

    protected $fillable = [
        'baslik',
        'aciklama',
        'baslangic_tarihi',
        'bitis_tarihi',
        'aktif',
        'adres',
        'tur',
        'gorsel'
    ];
}

