<div class="flex flex-col" @leanAction('index', $this->resource)>
    <div class="flex flex-row justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 hidden sm:inline">{{ $title }}</h1>
        <x-lean::button x-data="Alpine.component('modalLink')('create', '{{ $this->resource }}')" design="outline" class="hidden sm:inline-flex" href="{{ $this->createRoute }}" icon="heroicon-o-plus">
            {{ $this->resource()::trans('index.new') }}
        </x-lean::button>
    </div>

    <div class="mt-1">
        <div class="mt-1 relative rounded-md ">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                @svg('heroicon-o-search', ['class' => 'h-5 w-5 text-gray-400'])
            </div>
            <input wire:model.debounce.200ms="search" type="text" class="
                dark:bg-gray-900 dark:border-transparent
                form-input block w-full pl-10 sm:text-sm sm:leading-5"
            placeholder="{{ $this->resource()::trans('index.search') }}">
        </div>
    </div>

    <div
        wire:ignore.self
        x-data="{ show: @json($this->activeFilters()->isNotEmpty()) }"
        x-init="
            $watch('show', show => {
                if (! show) {
                    $wire.removeAllFilters();
                }
            })
        "
        class="flex flex-col items-end"
    >
        <div
            class="my-2 font-medium text-sm cursor-pointer"
            x-on:click="show = ! show"
            x-text="show ? '{{ $this->resource()::trans('index.reset_advanced_search') }}' : '{{ $this->resource()::trans('index.advanced_search') }}'"
            wire:replace
        >
            @if($this->activeFilters()->isEmpty())
                {{ $this->resource()::trans('index.advanced_search') }}
            @else
                {{ $this->resource()::trans('index.reset_advanced_search') }}
            @endif
        </div>

        <div class="w-full flex divide-solid divide-gray-300 divide-x border border-gray-300 rounded-md px-4 py-2" x-show="show" @if($this->activeFilters()->isEmpty()) x-cloak @endif>
            <div class="flex-1 p-2">
                <div class="grid grid-cols-12 items-center gap-x-4 gap-y-3 text-gray-600 py-2" wire:key="activeFilters">
                    @forelse($this->activeFilters() as $filter)
                        <div>
                            <button wire:click="removeFilter('{{ $filter->getKey() }}')" class="styled-focus rounded-md">
                                @svg('heroicon-o-x', ['class' => 'h-5 w-5 text-gray-400 hover:text-gray-600 transition'])
                            </button>
                        </div>
                        <label class="font-medium leading-none block col-span-2 text-right">{{ $filter->getLabel() }}</label>
                        <x-lean::filter :filter="$filter" class="flex flex-row space-x-2 items-center col-span-9" />
                    @empty
                        <div class="text-gray-600 col-span-12">{{ $this->resource()::trans('index.no_filters_selected') }}</div>
                    @endforelse
                </div>

                @if($this->availableFilters()->isNotEmpty())
                    <div class="text-sm text-gray-800" wire:key="availableFilters">
                        <span>{{ $this->resource()::trans('index.filter_by') }}</span>
                        @foreach($this->availableFilters() as $filter)
                            <button class="mt-2 px-2 py-1 border border-gray-300 styled-focus rounded-md" wire:click="selectFilter('{{ $filter->getKey() }}')">{{ $filter->getLabel() }}</button>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex-1 p-2 divide-solid divide-gray-200 divide-y text-gray-700">
                <div class="p-2">{{ $this->resource()::trans('index.per_page') }}</div>
                <div class="p-2">{{ $this->resource()::trans('index.columns') }}</div>
            </div>
        </div>
    </div>

    <div class="mt-3 overflow-x-auto border border-gray-200 rounded-md {{ $results->isEmpty() ? 'dark:border-transparent' : 'dark:border-gray-900' }}">
        @if($results->isEmpty())
            <div wire:loading.class.delay="opacity-70" wire:target="search,filterMetadata" class="text-gray-500 bg-gray-50 dark:text-gray-300 dark:bg-gray-700 flex items-center justify-center">
                <div class="p-5 flex items-center">
                    @svg('heroicon-o-x', ['class' => 'h-5 w-5 text-gray-400 mr-1'])
                    {{ $this->resource()::trans('index.no_results') }}
                </div>
            </div>
        @else
            <table class="min-w-full">
                <thead class="bg-gray-50 border-gray-200 border-b dark:bg-gray-900 dark:border-transparent">
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="form-checkbox"
                                @if($this->everythingSelected || $this->pageSelected)
                                    checked
                                    wire:click="unselectPage"
                                @else
                                    wire:click="selectPage"
                                @endif
                            >
                        </th>
                        @foreach($this->fields as $field)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ $field->getLabel() }}
                            </th>
                        @endforeach
                        <th
                            class="px-6 py-3 flex justify-end space-x-2 font-normal"
                            wire:loading.class="opacity-50 pointer-events-none"
                        >
                            {{-- Actions --}}
                            @if(! $selected->isEmpty())
                                {{-- Edit --}}
                                <div class="">
                                    <x-lean::modal>
                                        <x-slot name="trigger">
                                            <div
                                                x-on:click="show = true"
                                                class="cursor-pointer flex items-center text-gray-500 dark:text-gray-400 group font-bold"
                                            >
                                                @svg('heroicon-o-pencil-alt', [
                                                    'class' => 'w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-brand-400 dark:group-hover:text-brand-500',
                                                ])
                                                <span class="ml-1 text-sm group-hover:text-brand-600 dark:group-hover:text-brand-400">
                                                    Edit
                                                </span>
                                            </div>
                                        </x-slot>

                                        <x-slot name="title">
                                            <div>{{ $this->resource()::trans('bulk_edit.title') }}</div>
                                        </x-slot>

                                        <div>
                                            @livewire('lean.bulk-edit', [
                                                'resource' => $this->resource,
                                                'models' => $this->selected->toArray(),
                                            ])
                                            @forgetLastChild($this)
                                        </div>
                                    </x-lean::modal>
                                </div>

                                <x-lean::delete-modal>
                                    <x-slot name="trigger">
                                        <a
                                            href="#"
                                            @click="show = true"
                                            class="flex items-center text-gray-500 dark:text-gray-400 group cursor-pointer"
                                        >
                                            @svg('heroicon-o-trash', ['class' => 'w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-red-400 dark:group-hover:text-red-500'])
                                            <span class="font-bold   ml-1 text-sm group-hover:text-red-600 dark:group-hover:text-red-400">
                                                {{ $this->resource()::trans('index.delete') }}
                                            </span>
                                        </a>
                                    </x-slot>

                                    <x-slot name="title">
                                        {{ $this->resource()::trans('delete_multiple.title') }}
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="flex flex-col space-y-4">
                                            <span>
                                                {{ $this->resource()::trans('delete_multiple.body', [
                                                    'count' => $this->selected->count(),
                                                ]) }}
                                            </span>

                                            <div class="flex flex-col sm:flex-row justify-end gap-2">
                                                <x-lean::button class="text-center block" design="secondary" @click="show = false">Cancel</x-lean::button>
                                                <x-lean::button class="text-center block" design="danger" @click="$action.deleteSelected(); show = false">Delete</x-lean::button>
                                            </div>
                                        </div>
                                    </x-slot>
                                </x-lean::delete-modal>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($this->pageSelected || $this->resultsOnOtherPageSelected)
                        <tr class="bg-gray-100 text-sm text-gray-700">
                            {{-- Select on the left, actions on the right = count + 2 --}}
                            <td class="px-6 py-3" colspan="{{ $this->fields->count()+2 }}">
                                @if($this->everythingSelected)
                                    <span>
                                        {!! gloss()->choice('lean::resources.index.selected_all', $selected->count()) !!}
                                    </span>
                                    <a class="styled" href="#" wire:click="unselectAll">
                                        {!! gloss('lean::resources.index.unselect_all_button') !!}
                                    </a>
                                @elseif($this->pageSelected || $this->resultsOnOtherPageSelected)
                                    <span>
                                        {!! gloss()->choice('lean::resources.index.selected', $selected->count()) !!}
                                    </span>
                                    <span>
                                        {!! gloss()->choice('lean::resources.index.select_all_count', $results->total()) !!}
                                    </span>
                                    <a class="styled" href="#" wire:click="selectAll">
                                        {!! gloss('lean::resources.index.select_all_button') !!}
                                    </a>
                                    @if($this->resultsOnOtherPageSelected)
                                        <a class="styled" href="#" wire:click="unselectAll">
                                            {!! gloss('lean::resources.index.unselect_all_button') !!}
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                    @foreach($results as $result)
                        @if($loop->odd)
                            {{-- todo: These need wire:ignore.self because they have the model key, but the background color needs wire:replace.self --}}
                            <tr class="bg-white dark:bg-gray-800" wire:loading.class.delay="opacity-70" wire:target="search,filterMetadata" wire:key="model-{{ $result->getKey() }}" @leanModel($this->resource(), $fields = $this->fieldsFor($result), true)>
                        @else
                            <tr class="bg-gray-50 dark:bg-gray-700" wire:loading.class.delay="opacity-70" wire:target="search,filterMetadata" wire:key="model-{{ $result->getKey() }}" @leanModel($this->resource(), $fields = $this->fieldsFor($result), true)>
                        @endif
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <input type="checkbox" class="form-checkbox"
                                @if($this->isSelected($result->getKey()))
                                    checked
                                @endif

                                wire:click="toggleSelection({{ $result->getKey() }})"
                            >
                        </td>
                        @foreach($fields as $field)
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm
                                    {!! $field->isTitle() ? 'text-gray-800 dark:text-gray-300 font-medium' : 'text-gray-700 dark:text-gray-400' !!}
                                ">
                                <x-lean::field :field="$field" />
                            </td>
                        @endforeach

                        {{-- Buttons --}}
                        <td class="px-6 py-4 whitespace-no-wrap flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            {{-- Show --}}
                            <a
                                x-data="Alpine.component('modalLink')('show', $model)"
                                href="{{ route('lean.resource.show', ['resource' => $resource, 'id' => $result->getKey()]) }}"
                                class="flex items-center text-gray-500 transition dark:text-gray-400 group"
                            >
                                @svg('heroicon-o-eye', ['class' => 'transition w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-brand-400 dark:group-hover:text-brand-500'])
                                <span class="ml-1 text-sm group-hover:text-brand-600 dark:group-hover:text-brand-400 transition">
                                    {{ $this->resource()::trans('index.show') }}
                                </span>
                            </a>

                            {{-- Edit --}}
                            <a
                                x-data="Alpine.component('modalLink')('edit', $model)"
                                href="{{ route('lean.resource.edit', ['resource' => $resource, 'id' => $result->getKey()]) }}"
                                class="flex items-center text-gray-500 transition dark:text-gray-400 group"
                            >
                                @svg('heroicon-o-pencil-alt', ['class' => 'transition w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-brand-400 dark:group-hover:text-brand-500'])
                                <span class="ml-1 text-sm group-hover:text-brand-600 dark:group-hover:text-brand-400 transition">
                                    {{ $this->resource()::trans('index.edit') }}
                                </span>
                            </a>

                            {{-- Delete --}}
                            <a
                                href="#"
                                x-data="{}"
                                @click="$model.delete()"
                                class="flex items-center text-gray-500 transition dark:text-gray-400 group cursor-pointer"
                            >
                                @svg('heroicon-o-trash', ['class' => 'transition w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-red-400 dark:group-hover:text-red-500'])
                                <span class="ml-1 text-sm group-hover:text-red-600 dark:group-hover:text-red-400 transition">
                                    {{ $this->resource()::trans('index.delete') }}
                                </span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-6">
        {{ $results->links('lean::pagination') }}
    </div>

    <x-lean::navigation.mobile.menu>
        <x-slot name="button">
            <x-lean::navigation.mobile.button :href="$this->createRoute" />
        </x-slot>
    </x-lean::navigation.mobile.menu>
</div>
