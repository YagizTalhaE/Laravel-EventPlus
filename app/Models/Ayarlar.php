<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayarlar extends Model
{
protected $table = 'ayarlar';
protected $guarded = []; // veya: protected $fillable = ['site_adi', ...];
public $timestamps = true;
}

