<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Producto extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['user_id', 'nombre', 'descripcion', 'precio', 'estado', 'cantidad', 'imagen'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'nombre', 'estado', 'cantidad'])->logOnlyDirty();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
