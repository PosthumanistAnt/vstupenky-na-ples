<x-lean::layout.component :attributes="$attributes">
    <x-slot name="head">
        {{-- The root URL telling Turbolinks what links are outside the admin panel's scope. --}}
        <meta name="turbolinks-root" content="{{ Lean::rootUrl() }}">

        {{--
            If there's a response with a different layout (an error), Turbolinks will
            detect a mismatch in this tag and refresh the layout using a new request.
        --}}
        <meta name="lean-layout" content="true" data-turbolinks-track="reload">

        {{-- Turbolinks & Turbolinks/Lean compatibility layer --}}
        <script src="{{ mix('turbolinks.js', 'vendor/lean') }}" defer></script>
    </x-slot>

    <x-slot name="body">
        {{-- Turbolinks/Livewire & Turbolinks/Alpine compatibility layer --}}
        <script src="{{ mix('turbolinks-adapter.js', 'vendor/lean') }}" data-turbolinks-eval="false"></script>
    </x-slot>
</x-lean::layout.component>
