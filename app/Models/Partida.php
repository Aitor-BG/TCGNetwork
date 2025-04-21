<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $fillable = [
        'event_id', 'jugador1', 'jugador2', 'ronda'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}