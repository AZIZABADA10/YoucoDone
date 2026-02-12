<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Réserver une table') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Informations du restaurant -->
                <div class="mb-8 pb-6 border-b">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $restaurant->nom }}</h3>
                    <p class="text-gray-600">📍 {{ $restaurant->localisation }}</p>
                    <p class="text-gray-600">🍴 {{ $restaurant->cuisine->type }}</p>
                </div>

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                    <!-- Date de réservation -->
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date de réservation *</label>
                        <input type="date" name="date" id="date" value="{{ old('date', today()->format('Y-m-d')) }}" min="{{ today()->format('Y-m-d') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Créneau horaire -->
                    <div class="mb-6">
                        <label for="creneau_id" class="block text-sm font-medium text-gray-700 mb-2">Créneau horaire *</label>
                        @if($horaires->count() > 0)
                            <select name="creneau_id" id="creneau_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('creneau_id') border-red-500 @enderror">
                                <option value="">Sélectionnez un créneau</option>
                                @foreach($horaires as $horaire)
                                    <optgroup label="{{ ucfirst($horaire->jour) }} - {{ $horaire->heure_ouverture->format('H:i') }} à {{ $horaire->heure_fermeture->format('H:i') }}">
                                        @foreach($horaire->creneaux as $creneau)
                                            <option value="{{ $creneau->id }}">
                                                {{ $creneau->hd->format('H:i') }} - {{ $creneau->hf->format('H:i') }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        @else
                            <p class="text-red-600">Aucun créneau disponible pour ce restaurant.</p>
                        @endif
                        @error('creneau_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informations importantes -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-md">
                        <h4 class="font-semibold text-blue-900 mb-2">ℹ️ Informations importantes</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Vous devrez effectuer un paiement pour confirmer votre réservation</li>
                            <li>• Un email de confirmation vous sera envoyé après le paiement</li>
                            <li>• Capacité du restaurant: {{ $restaurant->capacite }} personnes</li>
                        </ul>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                            Continuer vers le paiement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>