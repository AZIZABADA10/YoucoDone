<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la réservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Statut de la réservation -->
                <div class="mb-6 text-center">
                    @if($reservation->payment && $reservation->payment->status === 'completed')
                        <div class="inline-flex items-center px-6 py-3 rounded-full text-lg font-medium bg-green-100 text-green-800">
                            ✓ Réservation confirmée
                        </div>
                    @else
                        <div class="inline-flex items-center px-6 py-3 rounded-full text-lg font-medium bg-yellow-100 text-yellow-800">
                            ⏳ En attente de paiement
                        </div>
                    @endif
                </div>

                <!-- Informations du restaurant -->
                <div class="mb-8 pb-6 border-b">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ $reservation->restaurant->nom }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Localisation</p>
                            <p class="text-gray-800">📍 {{ $reservation->restaurant->localisation }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Type de cuisine</p>
                            <p class="text-gray-800">🍴 {{ $reservation->restaurant->cuisine->type }}</p>
                        </div>
                    </div>
                </div>

                <!-- Détails de la réservation -->
                <div class="mb-8 pb-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Détails de votre réservation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Date</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $reservation->date->format('d/m/Y') }}</p>
                        </div>
                        @if($reservation->creneau)
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Heure</p>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $reservation->creneau->hd->format('H:i') }} - {{ $reservation->creneau->hf->format('H:i') }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Référence</p>
                            <p class="text-gray-800">#{{ $reservation->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Réservé le</p>
                            <p class="text-gray-800">{{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informations de paiement -->
                @if($reservation->payment)
                    <div class="mb-8 pb-6 border-b">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informations de paiement</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Méthode</p>
                                <p class="text-gray-800">{{ ucfirst($reservation->payment->method) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Statut</p>
                                @if($reservation->payment->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        ✓ Payé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        ⏳ En attente
                                    </span>
                                @endif
                            </div>
                            @if($reservation->payment->paid_at)
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Payé le</p>
                                    <p class="text-gray-800">{{ $reservation->payment->paid_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('reservations.index') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Retour à mes réservations
                    </a>
                    <div class="space-x-4">
                        @if(!$reservation->payment || $reservation->payment->status !== 'completed')
                            <a href="{{ route('payments.create', $reservation) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                                Procéder au paiement
                            </a>
                        @endif
                        @can('delete', $reservation)
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700">
                                    Annuler la réservation
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>