<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favoris = Auth::user()->favoris()
            ->with(['cuisine', 'photos'])
            ->paginate(12);

        return view('favoris.index', compact('favoris'));
    }

    public function toggle(Restaurant $restaurant)
    {
        $user = Auth::user();

        if ($user->favoris()->where('restaurant_id', $restaurant->id)->exists()) {
            $user->favoris()->detach($restaurant->id);
            $message = 'Restaurant retiré des favoris';
        } else {
            $user->favoris()->attach($restaurant->id);
            $message = 'Restaurant ajouté aux favoris';
        }

        return back()->with('success', $message);
    }
}