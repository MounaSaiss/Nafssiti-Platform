<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Psychologist;

class FollowRequest extends Model
{
    protected $fillable = [
        'patient_id',
        'psychologist_id',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }
}
