<form class="flex flex-col" wire:submit.prevent="submit" @leanAction('create', $this->resource) @leanModel($this->resource(), $this->fields)>
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-300 hidden sm:inline">{{ $title }}</h1>

    <div class="sm:divide-y divide-solid divide-gray-200 dark:divide-gray-700">
        @foreach($this->fields as $field)
            <div>
                <x-lean::field-group :field="$field" :errors="$errors->get($field->name)">
                    <x-lean::field
                        :field="$field"
                        :wire:model.lazy='"fieldMetadata.{$field->name}.value"'
                        autofocus
                    />
                </x-lean::field-group>
            </div>
        @endforeach
    </div>

    <div class="hidden sm:flex items-start justify-end">
        <x-lean::button x-data="Alpine.component('backButton')()" design="secondary">
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
            <x-lean::navigation.mobile.button icon="heroicon-o-check-circle" wire:click="submit" />
        </x-slot>
    </x-lean::navigation.mobile.menu>

    <div x-data @beforeunload.window="if (true) {
        {{-- $event.target.addEventListener($event.type, () => console.log('listening')) --}}
{{--
        new Promise((resolve, reject) => {
            Lean.modal('leave', {}, {
                resource: $action.resource.name,
                model: $model,
                stay: () => resolve(true),
                leave: () => resolve(false),
            })
        }).then(() => $event.preventDefault()) --}}

        {{-- console.log(prom);

        if (! prom) {
            $event.preventDefault();
        } --}}
    }">
</form>
