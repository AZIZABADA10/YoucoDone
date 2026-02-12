<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youco'Done - Réservation de restaurants</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Youco'Done</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Connexion</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Inscription</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-indigo-600 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Réservez votre table en quelques clics
                </h1>
                <p class="text-xl text-indigo-100 mb-8">
                    Découvrez les meilleurs restaurants et réservez instantanément
                </p>
                <a href="{{ route('restaurants.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-md text-lg font-semibold hover:bg-gray-100">
                    Explorer les restaurants
                </a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="text-indigo-600 text-4xl mb-4">🔍</div>
                    <h3 class="text-xl font-semibold mb-2">Recherche facile</h3>
                    <p class="text-gray-600">Trouvez le restaurant parfait selon vos critères</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="text-indigo-600 text-4xl mb-4">📅</div>
                    <h3 class="text-xl font-semibold mb-2">Réservation instantanée</h3>
                    <p class="text-gray-600">Réservez votre table en temps réel</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="text-indigo-600 text-4xl mb-4">💳</div>
                    <h3 class="text-xl font-semibold mb-2">Paiement sécurisé</h3>
                    <p class="text-gray-600">Payez en toute sécurité en ligne</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>