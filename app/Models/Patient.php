<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'problematique_principale',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }


    // Calcule l'âge à partir de la date de naissance
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) return null;
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }

    // Date de début de suivi (date du premier rendez-vous partagé/confirmé)
    public function getSuiviStartDateAttribute()
    {
        $firstApp = $this->appointments()->where('status', 'confirmed')->orderBy('appointmentDate', 'asc')->first();
        return $firstApp ? $firstApp->appointmentDate : null;
    }
}
