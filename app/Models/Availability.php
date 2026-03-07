<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'psychologist_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
