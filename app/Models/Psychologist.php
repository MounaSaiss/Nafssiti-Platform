<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;

class Psychologist extends Model
{
    protected $fillable = [
        'user_id',
        'specialization',
        'city',
        'experienceYears',
        'pricePerSession',
        'consultationType',
        'certificate',
        'photo',
        'description',
        'education',
        'validationStatus',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function unavailabilities()
    {
        return $this->hasMany(Unavailability::class);
    }

    public function privateNotes()
    {
        return $this->hasMany(PrivateNote::class);
    }

    public function therapeuticObjectives()
    {
        return $this->hasMany(TherapeuticObjective::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
