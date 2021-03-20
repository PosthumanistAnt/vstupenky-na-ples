<x-lean::layout.component :attributes="$attributes">
    <x-slot name="head">
        <link rel="manifest" href="{{ route('lean.assets.manifest', [], false) }}">
    </x-slot>

    <x-slot name="body">
        <script data-turbolinks-eval="false">
            if ('serviceWorker' in navigator) {
                window.addEventListener('DOMContentLoaded', () => {
                    navigator.serviceWorker.register('{{ mix("service-worker.js", "vendor/lean") }}')
                        .then((reg) => {
                            console.log('Service worker registered.', reg);
                        });
                });
            }
        </script>
    </x-slot>
</x-lean::layout.component>
