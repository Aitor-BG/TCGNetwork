<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;

    protected $fillable = ['competidor', 'event_id', 'puntos', 'victorias', 'derrotas', 'bye', 'porcentaje1', 'porcentaje2'];


}
