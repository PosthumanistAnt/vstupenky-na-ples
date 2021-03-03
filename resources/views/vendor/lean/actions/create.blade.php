<form class="flex flex-col" wire:submit.prevent="create">
    <h1 class="text-2xl font-semibold text-gray-900 hidden sm:inline">{{ $title }}</h1>

    <div class="sm:divide-y divide-solid divide-gray-200">
        @foreach($this->fields as $field)
            <div>
                @if(! isset($firstElementFocused) && $field->isEnabled())
                    <script>
                        window.addEventListener('DOMContentLoaded', () => document.getElementById('{{ $field->name }}').focus());
                    </script>
                    @php($firstElementFocused = true)
                @endif
                <x-lean::field-group :field="$field" :errors="$errors->get($field->name)">
                    <x-lean::field
                        :field="$field"
                        :wire:model.lazy='"fieldMetadata.{$field->name}.value"'
                    />
                </x-lean::field-group>
            </div>
        @endforeach
    </div>

    <div class="hidden sm:flex items-start justify-end">
        <x-lean::button design="secondary" onclick="window.history.back()">
            {{ $this->resource()::trans('back') }}
        </x-lean::button>

        <div class="ml-2">
            <x-lean::button design="outline" type="submit">
                <x-slot name="options">
                    <x-lean::button-option wire:click="createAndAnother">
                        {{ $this->resource()::trans('create.another') }}
                    </x-lean::button-option>

                    <x-lean::button-option wire:click="createAndEdit">
                        {{ $this->resource()::trans('create.edit') }}
                    </x-lean::button-option>
                </x-slot>
                {{ $this->resource()::trans('create.submit') }}
            </x-lean::button>
        </div>
    </div>

    <x-lean::navigation.mobile.menu>
        <x-slot name="button">
            <x-lean::navigation.mobile.button icon="heroicon-o-check-circle" wire:click="create" />
        </x-slot>
    </x-lean::navigation.mobile.menu>
</form>
