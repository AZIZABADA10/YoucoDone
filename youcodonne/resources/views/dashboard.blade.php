<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $user = Auth::user();
            @endphp

            @if($user->isClient())

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Mes Réservations</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ $user->reservations()->count() }}
                        </p>
                        <a href="{{ route('reservations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            Voir toutes →
                        </a>
                    </div>

                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Mes Favoris</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ $user->favoris()->count() }}
                        </p>
                        <a href="{{ route('favoris.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            Voir tous →
                        </a>
                    </div>

                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Restaurants disponibles</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ \App\Models\Restaurant::count() }}
                        </p>
                        <a href="{{ route('restaurants.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            Explorer →
                        </a>
                    </div>

                </div>

                {{-- Dernières réservations --}}
                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        Mes dernières réservations
                    </h3>

                    @php
                        $lastReservations = $user->reservations()
                            ->latest()
                            ->take(5)
                            ->with('restaurant')
                            ->get();
                    @endphp

                    @if($lastReservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($lastReservations as $reservation)
                                <div class="border-l-4 border-indigo-600 pl-4 py-2">
                                    <h4 class="font-semibold">
                                        {{ $reservation->restaurant->nom }}
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                    </p>
                                    <a href="{{ route('reservations.show', $reservation) }}"
                                       class="text-sm text-indigo-600 hover:text-indigo-800">
                                        Voir détails →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">
                            Vous n'avez pas encore de réservations.
                        </p>
                        <a href="{{ route('restaurants.index') }}"
                           class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            Faire une réservation →
                        </a>
                    @endif
                </div>

            @elseif($user->isRestaurateur())

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Mes Restaurants</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ $user->restaurants()->count() }}
                        </p>
                        <a href="{{ route('restaurants.create') }}"
                           class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            Ajouter →
                        </a>
                    </div>

                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Réservations totales</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ \App\Models\Reservation::whereIn(
                                'restaurant_id',
                                $user->restaurants()->pluck('id')
                            )->count() }}
                        </p>
                    </div>

                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Réservations du jour</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ \App\Models\Reservation::whereIn(
                                'restaurant_id',
                                $user->restaurants()->pluck('id')
                            )->whereDate('date', today())->count() }}
                        </p>
                    </div>

                </div>

            @elseif($user->isAdmin())

                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        Administration
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Bienvenue dans l'espace administrateur.
                    </p>
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                        Accéder au tableau de bord admin
                    </a>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>
