<div class="flex flex-col" @leanAction('show', $this->resource) @leanModel($this->resource(), $this->fields)>
    <div class="hidden sm:flex flex-row justify-between flex-wrap">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-300">{{ $title }}</h1>

        <div>
            <x-lean::button
                class="flex-none inline-flex justify-center rounded-md"
                design="danger"
                x-data="{}"
                @click="$model.delete()"
            >
                {{ $this->resource()::trans('show.delete') }}
            </x-lean::button>

            <x-lean::button x-data="Alpine.component('modalLink')('edit', $model)" design="outline" class="flex-none inline-flex justify-center rounded-md" href="{{ $editRoute }}">
                {{ $this->resource()::trans('show.edit') }}
            </x-lean::button>
        </div>
    </div>

    <div class="divide-y divide-solid divide-gray-100 dark:divide-gray-700">
        @foreach($this->fields as $field)
            <div class="{!! $field->isTitle() ? 'text-gray-800 dark:text-gray-300 font-medium' : 'text-gray-700 dark:text-gray-400' !!}">
                <x-lean::field-group :field="$field">
                    <x-lean::field :field="$field" />
                </x-lean::field-group>
            </div>
        @endforeach
    </div>

    <div class="hidden sm:block sm:mt-2">
        <x-lean::button x-data="Alpine.component('backButton')()" design="secondary" class="w-full sm:w-auto flex justify-center text-sm">
            {{ $this->resource()::trans('back') }}
        </x-lean::button>
    </div>

    <x-lean::navigation.mobile.menu>
        <x-slot name="left">
            <x-lean::navigation.mobile.link class="flex space-x-2 text-red"
                x-data="{}"
                @click="$model.delete()"
            >
                @svg('heroicon-o-trash', ['class' => 'h-6 w-6'])
                <div>
                    {{ $this->resource()::trans('show.delete') }}
                </div>
            </x-lean::navigation.mobile.link>
        </x-slot>
        <x-slot name="button">
            <x-lean::navigation.mobile.button :href="route('lean.resource.create', $this->resource()::alias())" />
        </x-slot>
        <x-slot name="right">
            <x-lean::navigation.mobile.link x-data="Alpine.component('modalLink')('edit', $model)" class="flex space-x-2" href="{{ $editRoute }}">
                @svg('heroicon-o-pencil-alt', ['class' => 'h-6 w-6'])
                <div>
                    {{ $this->resource()::trans('show.edit') }}
                </div>
            </x-lean::navigation.mobile.link>
        </x-slot>
    </x-lean::navigation.mobile.menu>
</div>
