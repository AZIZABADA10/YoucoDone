<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $restaurant->nom }}
            </h2>
            @can('update', $restaurant)
                <div class="space-x-2">
                    <a href="{{ route('restaurants.edit', $restaurant) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Modifier
                    </a>
                    <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Supprimer
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Photos -->
                    @if($restaurant->photos->count() > 0)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="grid grid-cols-2 gap-2 p-2">
                                @foreach($restaurant->photos as $photo)
                                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $restaurant->nom }}" class="w-full h-64 object-cover rounded">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Informations générales -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Informations</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">📍</span>
                                <div>
                                    <p class="font-semibold text-gray-700">Localisation</p>
                                    <p class="text-gray-600">{{ $restaurant->localisation }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">🍴</span>
                                <div>
                                    <p class="font-semibold text-gray-700">Type de cuisine</p>
                                    <p class="text-gray-600">{{ $restaurant->cuisine->type }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">👥</span>
                                <div>
                                    <p class="font-semibold text-gray-700">Capacité</p>
                                    <p class="text-gray-600">{{ $restaurant->capacite }} personnes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Horaires -->
                    @if($restaurant->horaires->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Horaires d'ouverture</h3>
                            <div class="space-y-2">
                                @foreach($restaurant->horaires as $horaire)
                                    <div class="flex justify-between items-center py-2 border-b">
                                        <span class="font-medium text-gray-700">{{ ucfirst($horaire->jour) }}</span>
                                        @if($horaire->statut === 'ouvert')
                                            <span class="text-gray-600">
                                                {{ $horaire->heure_ouverture->format('H:i') }} - {{ $horaire->heure_fermeture->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-red-600 font-medium">Fermé</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Menu -->
                    @if($restaurant->menus->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Menu</h3>
                            @foreach($restaurant->menus as $menu)
                                <div class="space-y-3">
                                    @foreach($menu->plats as $plat)
                                        <div class="flex justify-between items-start py-3 border-b">
                                            <div class="flex-1">
                                                <p class="text-gray-800">{{ $plat->content }}</p>
                                            </div>
                                            <span class="text-indigo-600 font-semibold ml-4">{{ number_format($plat->prix_unit, 2) }} €</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Colonne latérale - Réservation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Réserver une table</h3>
                        @auth
                            @if(Auth::user()->isClient())
                                <a href="{{ route('reservations.create', $restaurant) }}" class="block w-full bg-indigo-600 text-white text-center px-4 py-3 rounded-md hover:bg-indigo-700 font-semibold mb-4">
                                    Réserver maintenant
                                </a>
                                <form action="{{ route('favoris.toggle', $restaurant) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full border-2 border-indigo-600 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-50 font-semibold">
                                        {{ Auth::user()->favoris->contains($restaurant->id) ? '❤️ Retirer des favoris' : '🤍 Ajouter aux favoris' }}
                                    </button>
                                </form>
                            @else
                                <p class="text-gray-600 text-sm">Connectez-vous en tant que client pour réserver.</p>
                            @endif
                        @else
                            <p class="text-gray-600 mb-4">Connectez-vous pour réserver une table</p>
                            <a href="{{ route('login') }}" class="block w-full bg-indigo-600 text-white text-center px-4 py-3 rounded-md hover:bg-indigo-700 font-semibold">
                                Se connecter
                            </a>
                        @endauth

                        <div class="mt-6 pt-6 border-t">
                            <h4 class="font-semibold text-gray-700 mb-2">Propriétaire</h4>
                            <p class="text-gray-600">{{ $restaurant->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>