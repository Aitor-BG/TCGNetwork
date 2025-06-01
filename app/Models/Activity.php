<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    // Aquí puedes agregar métodos personalizados o relaciones extra

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
