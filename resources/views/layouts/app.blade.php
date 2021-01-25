<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vstupenky na ples</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body>
    <div class="container h-screen w-screen ">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>