<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Réservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($reservations->count() > 0)
                <div class="space-y-4">
                    @foreach($reservations as $reservation)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-2">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $reservation->restaurant->nom }}</h3>
                                    <p class="text-gray-600">📍 {{ $reservation->restaurant->localisation }}</p>
                                    <p class="text-gray-600">🍴 {{ $reservation->restaurant->cuisine->type }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Date de réservation</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->date->format('d/m/Y') }}</p>
                                    @if($reservation->creneau)
                                        <p class="text-sm text-gray-600">{{ $reservation->creneau->hd->format('H:i') }} - {{ $reservation->creneau->hf->format('H:i') }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col justify-center space-y-2">
                                    @if($reservation->payment && $reservation->payment->status === 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            ✓ Payé
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            ⏳ En attente
                                        </span>
                                    @endif
                                    <a href="{{ route('reservations.show', $reservation) }}" class="text-center text-indigo-600 hover:text-indigo-800 font-medium">
                                        Voir détails →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <p class="text-gray-600 text-lg mb-4">Vous n'avez pas encore de réservations.</p>
                    <a href="{{ route('restaurants.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                        Découvrir les restaurants
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>