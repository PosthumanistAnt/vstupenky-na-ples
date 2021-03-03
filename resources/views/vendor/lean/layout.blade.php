<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ mix('lean.css', 'vendor/lean') }}">
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        <title>{{ $title ?? '' }} | {{ Lean::name() }}</title>
        @livewireStyles
        @stack('_lean.styles')
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
        <script src="{{ asset('js/app.js') }}"></script>
    </head>

    <body class="font-sans">
        <div class="min-h-screen flex bg-white sm:flex-row flex-col">
            <x-lean::navigation.sidebar />
            <div class="min-h-full w-full flex justify-center px-4 py-2 sm:py-6 sm:px-8">
                <main class="w-full sm:max-w-7xl">
                    @yield('content')
                </main>
            </div>
        </div>

        <x-lean::notification />
        <x-lean::console-log />

        @livewireScripts
        <script src="{{ mix('lean.js', 'vendor/lean') }}"></script>
        @stack('_lean.scripts')
        {!! config('lean.scripts.alpine') !!}
    </body>
</html>
