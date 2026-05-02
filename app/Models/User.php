<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

     // Roles
    public const ROLE_PATIENT = 1;
    public const ROLE_PSYCHOLOGUE = 2;
    public const ROLE_ADMIN = 3;

    // Statuses
    public const STATUS_ACTIF = 'actif';
    public const STATUS_BANNI = 'banni';
    public const STATUS_EN_ATTENTE = 'en attente';

    public function isAdmin(): bool
    {
        return $this->role_id === self::ROLE_ADMIN;
    }

    public function isPatient(): bool
    {
        return $this->role_id === self::ROLE_PATIENT;
    }

    public function isPsychologue(): bool
    {
        return $this->role_id === self::ROLE_PSYCHOLOGUE;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role_id',
        'status',
    ];
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function psychologist(){
        return $this->hasOne(Psychologist::class);
    }

    public function patient(){
        return $this->hasOne(Patient::class);
    }

    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, Patient::class);
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
