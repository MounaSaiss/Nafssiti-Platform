<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unavailability extends Model
{
    protected $table = 'unavailabilities';

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
}
