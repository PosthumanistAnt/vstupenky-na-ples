<x-lean::layout.component :attributes="$attributes">
    <x-slot name="head">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ mix('lean.js', 'vendor/lean') }}" onload="setStaticLeanState(); initializeLean()" defer></script>
        @foreach(Lean::$assets['scripts'] as $script)
            {!! Lean::config("scripts.$script") !!}
        @endforeach

        <script id="lean-static-state">
            window.setStaticLeanState = () => {
                let { lang, routes } = @json(Lean::frontendState('lang', 'routes'));

                Lean.lang = lang;
                Lean.routes = routes;
            };
        </script>
    </x-slot>
    <x-slot name="body">
        @livewireScripts

        <script>
            window.initializeLean = () => {
                // Global state cleanup
                window.LivewireManagingDOM = false;
                window.skipAlpineTransitions = false;

                let state = @json(Lean::frontendState('state')).state;

                Lean.state = {
                    title: document.getElementsByTagName('title')[0].innerText,
                    ...state
                };
            }
        </script>
    </x-slot>
</x-lean::layout.component>
