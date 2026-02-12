<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paiement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Récapitulatif de la réservation -->
                <div class="mb-8 pb-6 border-b">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Récapitulatif de votre réservation</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="font-semibold text-lg text-gray-800 mb-2">{{ $reservation->restaurant->nom }}</p>
                        <p class="text-gray-600">📍 {{ $reservation->restaurant->localisation }}</p>
                        <p class="text-gray-600">📅 {{ $reservation->date->format('d/m/Y') }}</p>
                        @if($reservation->creneau)
                            <p class="text-gray-600">🕐 {{ $reservation->creneau->hd->format('H:i') }} - {{ $reservation->creneau->hf->format('H:i') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Formulaire de paiement -->
                <form action="{{ route('payments.store', $reservation) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Choisissez votre méthode de paiement *</label>
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="method" value="stripe" required class="mr-4">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">💳 Carte bancaire (Stripe)</p>
                                    <p class="text-sm text-gray-600">Paiement sécurisé par carte</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="method" value="paypal" class="mr-4">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">🅿️ PayPal</p>
                                    <p class="text-sm text-gray-600">Paiement via votre compte PayPal</p>
                                </div>
                            </label>
                        </div>
                        @error('method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informations importantes -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-md">
                        <h4 class="font-semibold text-blue-900 mb-2">ℹ️ Mode test activé</h4>
                        <p class="text-sm text-blue-800">Cette plateforme est en mode test. Aucun paiement réel ne sera effectué. Vous recevrez un email de confirmation après validation.</p>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('reservations.show', $reservation) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300">
                            Retour
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                            Confirmer le paiement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>