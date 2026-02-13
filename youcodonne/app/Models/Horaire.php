<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'jour',
        'heure_ouverture',
        'heure_fermeture',
        'statut',
    ];

    protected $casts = [
        'heure_ouverture' => 'datetime:H:i',
        'heure_fermeture' => 'datetime:H:i',
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function creneaux()
    {
        return $this->hasMany(Creneau::class);
    }
}