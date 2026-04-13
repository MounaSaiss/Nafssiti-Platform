<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'psychologist_id',
        'type',
        'path_or_url',
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }
}
