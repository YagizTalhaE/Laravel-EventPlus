<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = [
        'name',
        'price',
        'kontenjan',
        'etkinlik_yönetimis_id',
    ];

    public function etkinlik()
    {
        return $this->belongsTo(EtkinlikYönetimi::class, 'etkinlik_yönetimis_id');
    }
    public function event()
    {
        return $this->belongsTo(EtkinlikYönetimi::class);
    }
}
