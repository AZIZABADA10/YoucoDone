<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Favoris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($favoris->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($favoris as $restaurant)
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
                                <p class="text-sm text-gray-600 mb-3">🍴 {{ $restaurant->cuisine->type }}</p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        Voir détails →
                                    </a>
                                    <form action="{{ route('favoris.toggle', $restaurant) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-2xl hover:scale-110 transition-transform">
                                            ❤️
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $favoris->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <p class="text-gray-600 text-lg mb-4">Vous n'avez pas encore de restaurants favoris.</p>
                    <a href="{{ route('restaurants.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                        Découvrir les restaurants
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>