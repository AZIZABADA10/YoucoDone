<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Restaurants') }}
            </h2>
            @if(Auth::check() && (Auth::user()->isRestaurateur() || Auth::user()->isAdmin()))
                <a href="{{ route('restaurants.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Ajouter un restaurant
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtres de recherche -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('restaurants.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du restaurant</label>
                        <input type="text" name="nom" id="nom" value="{{ request('nom') }}" placeholder="Rechercher..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                        <input type="text" name="ville" id="ville" value="{{ request('ville') }}" placeholder="Paris, Lyon..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="cuisine_id" class="block text-sm font-medium text-gray-700 mb-2">Type de cuisine</label>
                        <select name="cuisine_id" id="cuisine_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Tous les types</option>
                            @foreach($cuisines as $cuisine)
                                <option value="{{ $cuisine->id }}" {{ request('cuisine_id') == $cuisine->id ? 'selected' : '' }}>
                                    {{ $cuisine->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>

            <!-- Liste des restaurants -->
            @if($restaurants->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($restaurants as $restaurant)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                            @if($restaurant->photos->count() > 0)
                                <img src="{{ asset('storage/' . $restaurant->photos->first()->image) }}" alt="{{ $restaurant->nom }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">🍽️</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $restaurant->nom }}</h3>
                                <p class="text-sm text-gray-600 mb-1">📍 {{ $restaurant->localisation }}</p>
                                <p class="text-sm text-gray-600 mb-1">🍴 {{ $restaurant->cuisine->type }}</p>
                                <p class="text-sm text-gray-600 mb-3">👥 Capacité: {{ $restaurant->capacite }} personnes</p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        Voir détails →
                                    </a>
                                    @auth
                                        <form action="{{ route('favoris.toggle', $restaurant) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-2xl hover:scale-110 transition-transform">
                                                {{ Auth::user()->favoris->contains($restaurant->id) ? '❤️' : '🤍' }}
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $restaurants->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <p class="text-gray-600 text-lg">Aucun restaurant trouvé avec ces critères.</p>
                    <a href="{{ route('restaurants.index') }}" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                        Voir tous les restaurants
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>