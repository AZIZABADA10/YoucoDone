<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Restaurant::with(['cuisine', 'photos', 'user']);

        if ($request->filled('ville')) {
            $query->parVille($request->ville);
        }

        if ($request->filled('cuisine_id')) {
            $query->parCuisine($request->cuisine_id);
        }

        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        $restaurants = $query->paginate(12);
        $cuisines = Cuisine::all();

        return view('restaurants.index', compact('restaurants', 'cuisines'));
    }

    public function create()
    {
        $this->authorize('create', Restaurant::class);
        $cuisines = Cuisine::all();
        return view('restaurants.create', compact('cuisines'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Restaurant::class);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'cuisine_id' => 'required|exists:cuisines,id',
            'capacite' => 'required|integer|min:1',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        $restaurant = Restaurant::create($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public');
                $restaurant->photos()->create(['image' => $path]);
            }
        }

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurant créé avec succès!');
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['cuisine', 'photos', 'menus.plats', 'horaires', 'user']);
        return view('restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        $cuisines = Cuisine::all();
        return view('restaurants.edit', compact('restaurant', 'cuisines'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'cuisine_id' => 'required|exists:cuisines,id',
            'capacite' => 'required|integer|min:1',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $restaurant->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public');
                $restaurant->photos()->create(['image' => $path]);
            }
        }

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurant mis à jour avec succès!');
    }

    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);

        foreach ($restaurant->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
        }

        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant supprimé avec succès!');
    }
}