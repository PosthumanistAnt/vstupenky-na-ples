<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vstupenky na ples</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>    
    <div class="fixed inset-x-0 top-1 text-center xl:flex xl:justify-between xl:items-baseline">
        @auth
            <a href="{{ url('/') }}">
                <button class="p-6 text-5xl xl:text-8xl tracking-widest font-extrabold text-gray-200 hover:text-gray-400"> Vybrat vstupenky </button>
            </a> 
        @endauth   
        @guest
            <a href="{{ route('login') }}">
                <button class="p-6 text-5xl xl:text-8xl tracking-widest font-extrabold text-gray-200 hover:text-gray-400"> Přihlásit </button>
            </a> 
        @endguest
    </div>
    <div class="container">
        <div class="h-screen w-screen bg-gray-900 text-gray-200 flex justify-center items-center">
            <h1 class="text-5xl font-bold tracking-wide p-8 w-full text-center">Nemáte dostatečná práva</h1>
        </div>
    </div>
</body>
</html>
