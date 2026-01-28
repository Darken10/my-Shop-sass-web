<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold">My Shop</a>
                    </div>
                    @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900">Utilisateurs</a>
                        <div class="dropdown">
                            <a href="#" class="text-gray-600 hover:text-gray-900">{{ auth()->user()->name }}</a>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main>
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
