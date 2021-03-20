<x-lean::layout.component :attributes="$attributes">
    <x-slot name="head">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ mix('lean.js', 'vendor/lean') }}" onload="bootstrapLean()" defer></script>
        @foreach(Lean::$assets['scripts'] as $script)
            {!! Lean::config("scripts.$script") !!}
        @endforeach
    </x-slot>
    <x-slot name="body">
        @livewireScripts

        <script>
            function bootstrapLean() {
                let state = @json(Lean::frontendState());

                Lean.state = {
                    title: document.getElementsByTagName('title')[0].innerText,
                    ...state.state
                };
                Lean.routes = state.routes;
                Lean.lang = state.lang;
            }
        </script>
    </x-slot>
</x-lean::layout.component>
