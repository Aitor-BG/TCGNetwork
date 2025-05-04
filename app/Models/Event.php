<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Event extends Model
{
    use HasFactory, LogsActivity;

    /*protected $fillable = ['name','start_date','end_date','color','details','inscritos','participantes'];*/
    protected $fillable = ['name','date','color','details','inscritos','participantes','estado','user_id'];

    public function getActivitylogOptions(): LogOptions
    {
        /*return LogOptions::defaults()
        ->logOnly(['name','start_date','end_date','inscritos']);*/

        return LogOptions::defaults()
        ->logOnly(['name','date','inscritos','estado'])->logOnlyDirty();
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

}
