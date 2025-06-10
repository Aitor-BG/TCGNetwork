<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Partida extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'event_id',
        'jugador1',
        'jugador2',
        'ronda'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['jugador1', 'jugador2', 'ronda'])->logOnlyDirty();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}