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

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}
