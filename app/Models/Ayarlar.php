<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayarlar extends Model
{
protected $table = 'ayarlar';
protected $guarded = []; // veya: protected $fillable = ['site_adi', ...];
public $timestamps = true;

    protected $fillable = [
        'site_adi', 'site_mail', 'bakim_modu', 'facebook', 'twitter', 'instagram',
        'linkedin', 'firma_adi', 'telefon', 'adres', 'vergi_no', 'hakkimda',
    ];

}

