<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vstupenky na ples</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    @livewireStyles
</head>
<body>
    <div class="container">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>