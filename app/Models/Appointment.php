<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Psychologist;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'psychologist_id',
        'appointmentDate',
        'appointmentTime',
        'status',
        'consultation_status',
        'notes',
        'rejection_reason',
        'jitsi_room_id',
        'is_started',
    ];

    protected $casts = [
        'is_started' => 'boolean',
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
