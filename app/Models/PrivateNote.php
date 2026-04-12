<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateNote extends Model
{
    protected $fillable = ['psychologist_id', 'patient_id', 'content'];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
