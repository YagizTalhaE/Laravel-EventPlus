<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EtkinlikYönetimi extends Model
{
    use HasFactory;

    protected $table = 'etkinlik_yönetimis';

    protected $fillable = [
        'baslik',
        'slug',
        'aciklama',
        'kurallar',
        'baslangic_tarihi',
        'bitis_tarihi',
        'aktif',
        'adres',
        'ilce',
        'mekan',
        'gorsel',
        'tur',
        'populer_mi',
    ];

    protected static function booted()
    {
        static::creating(function ($etkinlik) {
            $etkinlik->slug = Str::slug($etkinlik->baslik);
        });

        static::updating(function ($etkinlik) {
            $etkinlik->slug = Str::slug($etkinlik->baslik);
        });
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'etkinlik_yönetimis_id');
    }
}
