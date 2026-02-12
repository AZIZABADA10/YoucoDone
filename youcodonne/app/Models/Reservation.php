<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'creneau_id',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}