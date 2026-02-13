<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('payments.create', compact('reservation'));
    }

    public function store(Request $request, Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        $validated = $request->validate([
            'method' => 'required|in:stripe,paypal',
        ]);

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'method' => $validated['method'],
            'status' => 'completed',
            'paid_at' => now(),
        ]);



        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Paiement effectué avec succès!');
    }
}