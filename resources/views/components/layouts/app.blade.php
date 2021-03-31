<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vstupenky na ples</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>

    @livewireStyles
</head>
<body class="bg-gray-900 text-gray-200">
    <div class="p-6 fixed right-2 top-2 text-center text-xl bg-gradient-to-b from-green-900">
        @auth
            {{ Auth::user()->name }}
        @endauth

        @guest
            Nepřihlášen
        @endguest
    </div>
    <div class="container">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>