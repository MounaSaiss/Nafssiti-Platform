<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TherapeuticObjective extends Model
{
    protected $fillable = [
        'psychologist_id',
        'patient_id',
        'description',
        'status'
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
