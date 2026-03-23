<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Psychologist;
use App\Models\Availability;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'psychologist_id',
        'availability_id',
        'appointmentDate',
        'appointmentTime',
        'status',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }
}
