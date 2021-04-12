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
    <div class="mt-8 absolute left-0 top-0">
        @auth
            <a href="{{ route('logout') }}" class="btn btn-secondary"> Odhlásit </a>
        @endauth
        @admin
            <a href="{{ url('admin') }}" class="btn btn-secondary"> Admin </a>
        @endadmin
    </div>
    
    <div class="mt-8 absolute right-0 top-0">
        @auth
            <span class="p-6 text-center text-xl bg-gradient-to-b from-green-900"> {{ Auth::user()->name }} </span>
            <a href="{{ route('dashboard') }}" class="p-6 text-center text-xl bg-gray-800 hover:bg-gray-700"> Objednávky </a>
        @endauth

        @guest
            <span class="p-6 text-center text-xl bg-gradient-to-b from-green-900"> Nepřihlášen </span>
        @endguest
    </div>

    <div class="container">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>