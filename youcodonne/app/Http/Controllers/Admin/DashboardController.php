<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_restaurants' => Restaurant::count(),
            'total_reservations' => Reservation::count(),
            'total_users' => User::count(),
            'total_payments' => Payment::where('status', 'completed')->count(),
        ];

        // Top restaurants (par nombre de réservations)
        $topRestaurants = Restaurant::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get();

        // Réservations récentes
        $recentReservations = Reservation::with(['user', 'restaurant'])
            ->latest()
            ->take(10)
            ->get();

        // Restaurants par ville (Query Builder uniquement)
        $restaurantsParVille = DB::table('restaurants')
            ->select('localisation', DB::raw('count(*) as total'))
            ->groupBy('localisation')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'topRestaurants',
            'recentReservations',
            'restaurantsParVille'
        ));
    }
}