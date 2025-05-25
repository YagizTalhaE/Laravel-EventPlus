<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEtkinlikTur extends Model
{
    protected $table = 'user_etkinlik_tur';

    protected $fillable = ['user_id', 'tur'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
