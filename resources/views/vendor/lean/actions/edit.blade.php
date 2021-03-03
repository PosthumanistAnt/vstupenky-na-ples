<form class="flex flex-col" wire:submit.prevent="submit">
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
                {{-- Some components require a value to be created, even if wire:model is used. Hence both wire:model and value. --}}
                <x-lean::field-group :field="$field" :errors="$errors->get($field->name)">
                    <x-lean::field
                        :field="$field"
                        :wire:model.lazy='"fieldMetadata.{$field->name}.value"'
                    />
                </x-lean::field-group>
            </div>
        @endforeach
    </div>

    <div class="hidden sm:flex justify-end flex-row mt-2 w-full">
        <x-lean::button class="flex justify-center" design="secondary" onclick="window.history.back()">
            {{ $this->resource()::trans('back') }}
        </x-lean::button>

        <div class="sm:ml-2 sm:mb-0 mb-2">
            <x-lean::button class="flex justify-center w-full sm:w-auto" design="outline" type="submit">
                {{ $this->resource()::trans('edit.submit') }}
            </x-lean::button>
        </div>
    </div>

    <x-lean::navigation.mobile.menu>
        <x-slot name="left">
            <x-lean::navigation.mobile.link class="flex space-x-2" onclick="window.history.back()">
                @svg('heroicon-o-arrow-left', ['class' => 'h-6 w-6'])
                <div>
                    {{ $this->resource()::trans('back') }}
                </div>
            </x-lean::navigation.mobile.link>
        </x-slot>
        <x-slot name="button">
            <x-lean::navigation.mobile.button :href="route('lean.resource.create', $this->resource()::alias())" />
        </x-slot>
        <x-slot name="right">
            <x-lean::navigation.mobile.link class="text-purple-600 flex space-x-2" active="true" wire:click="submit">
                <div>
                    {{ $this->resource()::trans('edit.submit_mobile') }}
                </div>
                @svg('heroicon-o-check-circle', ['class' => 'h-6 w-6'])
            </x-lean::navigation.mobile.link>
        </x-slot>
    </x-lean::navigation.mobile.menu>
</form>
