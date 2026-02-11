<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cuisine_id',
        'nom',
        'localisation',
        'capacite',
    ];

    protected $dates = ['delete_at'];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function horaires()
    {
        return $this->hasMany(Horaire::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function favorisPar()
    {
        return $this->belongsToMany(User::class, 'favoris');
    }

    public function scopeParVille($query, $ville)
    {
        return $query->where('localisation', 'like', "%{$ville}%");
    }

    public function scopeParCuisine($query, $cuisineId)
    {
        return $query->where('cuisine_id', $cuisineId);
    }
}