<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;

    protected $fillable = [
        'horaire_id',
        'hd',
        'hf',
    ];

    protected $casts = [
        'hd' => 'datetime',
        'hf' => 'datetime',
    ];

    // Relations
    public function horaire()
    {
        return $this->belongsTo(Horaire::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}