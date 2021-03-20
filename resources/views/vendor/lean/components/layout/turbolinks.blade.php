<x-lean::layout.component :attributes="$attributes">
    <x-slot name="head">
        <script src="{{ mix('turbolinks.js', 'vendor/lean') }}" defer></script>
    </x-slot>

    <x-slot name="body">
        <script src="{{ mix('livewire-turbolinks.js', 'vendor/lean') }}" data-turbolinks-eval="false"></script>
    </x-slot>
</x-lean::layout.component>
