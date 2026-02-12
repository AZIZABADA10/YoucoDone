<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Creneau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with(['restaurant', 'creneau', 'payment'])
            ->latest()
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create(Restaurant $restaurant)
    {
        $horaires = $restaurant->horaires()
            ->with('creneaux')
            ->where('statut', 'ouvert')
            ->get();

        return view('reservations.create', compact('restaurant', 'horaires'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'creneau_id' => 'required|exists:creneaux,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $validated['user_id'] = Auth::id();

        $reservation = Reservation::create($validated);

        return redirect()->route('payments.create', $reservation)
            ->with('success', 'Réservation créée! Veuillez procéder au paiement.');
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        $reservation->load(['restaurant', 'creneau', 'payment']);
        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation annulée avec succès!');
    }
}