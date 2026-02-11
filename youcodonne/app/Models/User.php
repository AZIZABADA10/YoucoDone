<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    // Relations
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function favoris()
    {
        return $this->belongsToMany(Restaurant::class, 'favoris');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }


    public function isRestaurateur(): bool
    {
        return $this->hasRole('restaurateur');
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}