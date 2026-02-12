<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le restaurant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nom du restaurant -->
                    <div class="mb-6">
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du restaurant *</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $restaurant->nom) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nom') border-red-500 @enderror">
                        @error('nom')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div class="mb-6">
                        <label for="localisation" class="block text-sm font-medium text-gray-700 mb-2">Localisation *</label>
                        <input type="text" name="localisation" id="localisation" value="{{ old('localisation', $restaurant->localisation) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('localisation') border-red-500 @enderror">
                        @error('localisation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type de cuisine -->
                    <div class="mb-6">
                        <label for="cuisine_id" class="block text-sm font-medium text-gray-700 mb-2">Type de cuisine *</label>
                        <select name="cuisine_id" id="cuisine_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('cuisine_id') border-red-500 @enderror">
                            <option value="">Sélectionnez un type</option>
                            @foreach($cuisines as $cuisine)
                                <option value="{{ $cuisine->id }}" {{ old('cuisine_id', $restaurant->cuisine_id) == $cuisine->id ? 'selected' : '' }}>
                                    {{ $cuisine->type }}
                                </option>
                            @endforeach
                        </select>
                        @error('cuisine_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacité -->
                    <div class="mb-6">
                        <label for="capacite" class="block text-sm font-medium text-gray-700 mb-2">Capacité (nombre de personnes) *</label>
                        <input type="number" name="capacite" id="capacite" value="{{ old('capacite', $restaurant->capacite) }}" min="1" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('capacite') border-red-500 @enderror">
                        @error('capacite')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photos existantes -->
                    @if($restaurant->photos->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photos actuelles</label>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach($restaurant->photos as $photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $restaurant->nom }}" class="w-full h-32 object-cover rounded">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Nouvelles photos -->
                    <div class="mb-6">
                        <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">Ajouter de nouvelles photos</label>
                        <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="w-full @error('photos.*') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs photos (max 2MB chacune)</p>
                        @error('photos.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>