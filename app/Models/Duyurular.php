<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duyurular extends Model
{
    use HasFactory;

    protected $table = 'duyurular';

    protected $fillable = [
        'baslik',
        'icerik',
        'aktif',
    ];
}
