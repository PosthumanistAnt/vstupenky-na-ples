@props([
    'action',
    'handle' => '',
    'data' => '',
])

<x-lean::modals.danger :action="$action">
    <x-slot name="data">
        resource: '',
        model: '',

        lang(string) {
            if (this.resource) {
                return window.Lean.trans(this.resource, '{{ $action }}.' + string);
            }
        },

        cancel() {
            window.Lean.modalManager.back();
        },

        confirm() {
            {{ $handle }}

            window.Lean.modalManager.back();
        },

        {{ $data }}
    </x-slot>

    <x-slot name="title">
        <h3 class="text-lg font-medium" x-text="lang('title')"></h3>
    </x-slot>

    <x-slot name="body">
        <span x-text="lang('body')"></span>
    </x-slot>

    <x-slot name="buttons">
        <x-lean::button class="text-center block" design="secondary" x-on:click="cancel()" x-text="lang('cancel')" />
        <x-lean::button class="text-center block" design="danger" x-on:click="confirm()" x-text="lang('confirm')" />
    </x-slot>
</x-lean::modals.danger>
