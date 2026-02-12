<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques générales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Total Restaurants</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_restaurants'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Total Réservations</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_reservations'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Total Utilisateurs</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Paiements Confirmés</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_payments'] }}</p>
                </div>
            </div>

            <!-- Top Restaurants -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Top 5 Restaurants (par réservations)</h3>
                <div class="space-y-3">
                    @foreach($topRestaurants as $restaurant)
                        <div class="flex justify-between items-center py-3 border-b">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $restaurant->nom }}</p>
                                <p class="text-sm text-gray-600">{{ $restaurant->localisation }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-indigo-600">{{ $restaurant->reservations_count }}</p>
                                <p class="text-sm text-gray-600">réservations</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Restaurants par ville (Query Builder) -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Restaurants par ville</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($restaurantsParVille as $ville)
                        <div class="border rounded-lg p-4">
                            <p class="font-semibold text-gray-800">{{ $ville->localisation }}</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $ville->total }}</p>
                            <p class="text-sm text-gray-600">restaurants</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Réservations récentes -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Réservations récentes</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créée le</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentReservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $reservation->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->restaurant->nom }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>