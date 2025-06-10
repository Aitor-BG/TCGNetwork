<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pedido extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pedidos';

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'codigo-postal',
        'telefono',
        'contenido',
        'user_id',
    ];

    protected $casts = [
        'contenido' => 'array', // Permite acceder al contenido como array en lugar de JSON string
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nombre',
        'direccion',
        'ciudad',
        'codigo-postal',
        'telefono',
        'contenido',
        'user_id',])->logOnlyDirty();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
