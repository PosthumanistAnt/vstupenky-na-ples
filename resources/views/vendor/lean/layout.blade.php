<html class="lean">
    <head>
        <x-lean::layout.meta />
        <x-lean::layout.styles />
        <x-lean::layout.pwa for="head" />
        <x-lean::layout.scripts for="head" />
        <x-lean::layout.darkmode for="head" />
        <x-lean::layout.turbolinks for="head" />
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen flex bg-white dark:bg-gray-800 sm:flex-row flex-col">
            <x-lean::navigation.sidebar>
                <x-slot name="bottom">
                    <x-lean::layout.darkmode for="toggle" />
                </x-slot>
            </x-lean::navigation.sidebar>
            <div class="min-h-full w-full flex justify-center px-4 py-2 sm:py-6 sm:px-8 overflow-hidden">
                <main class="w-full {{ Lean::$layoutWidth ?? 'sm:max-w-7xl' }}">
                    @yield('content')
                </main>
            </div>
        </div>

        {{-- todo remove 'layout' from the names of these --}}
        <x-lean::layout.notifications />
        <livewire:lean.layout.modal-manager :prefetch="Lean::$prefetchedActions" />
        <x-lean::console-log />

        {{-- todo run bootstrap lean on turbolinks visits --}}
        <x-lean::layout.scripts for="body" />
        <x-lean::layout.pwa for="body" />
        <x-lean::layout.turbolinks for="body" />
    </body>
</html>
