<div class="flex flex-col">
    <div class="flex flex-row justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 hidden sm:inline">{{ $title }}</h1>
        <x-lean::button design="outline" class="hidden sm:inline-flex" href="{{ $this->createRoute }}" icon="heroicon-o-plus">
            {{ $this->resource()::trans('index.new') }}
        </x-lean::button>
    </div>

    <div class="mt-1">
        <div class="mt-1 relative rounded-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.debounce.200ms="search" type="text" class="form-input block w-full pl-10 sm:text-sm sm:leading-5" placeholder="{{ $this->resource()::trans('index.search') }}">
        </div>
    </div>


    <div class="mt-3 overflow-x-auto border border-gray-200 rounded-md">
        @if($results->isEmpty())
            <div wire:loading.class.delay="opacity-70" wire:target="search" class="text-gray-500 bg-gray-50 flex items-center justify-center">
                <div class="p-5 flex items-center">
                    @svg('heroicon-o-x', ['class' => 'h-5 w-5 text-gray-400 mr-1'])
                    {{ $this->resource()::trans('index.no_results') }}
                </div>
            </div>
        @else
            <table class="min-w-full">
                <thead class="bg-gray-50 border-gray-200 border-b">
                    <tr>
                        @foreach($this->fields as $field)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $field->getLabel() }}
                            </th>
                        @endforeach
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{-- Actions --}}
                            </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                        @if($loop->odd)
                            <tr class="bg-white" wire:loading.class.delay="opacity-70" wire:target="search">
                        @else
                            <tr class="bg-gray-50" wire:loading.class.delay="opacity-70" wire:target="search">
                        @endif
                        @foreach($this->fieldsFor($result) as $field)
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {!! $this->resource()::$title === $field->name ? 'text-gray-800 font-medium' : 'text-gray-700' !!}">
                                <x-lean::field
                                :field="$field"
                            />
                            </td>
                        @endforeach

                        {{-- Buttons --}}
                        <td class="px-6 py-4 whitespace-no-wrap flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            {{-- Show --}}
                            <x-lean::link
                                :href="route('lean.resource.show', ['resource' => $resource, 'id' => $result->getKey()])"
                                class="flex items-center text-gray-500 group"
                            >
                                @svg('heroicon-o-eye', ['class' => 'w-4 h-4 text-gray-400 group-hover:text-purple-400'])
                                <span class="ml-1 text-sm group-hover:text-purple-600">
                                    {{ $this->resource()::trans('index.show') }}
                                </span>
                            </x-lean::link>

                            {{-- Edit --}}
                            <x-lean::link
                                :href="route('lean.resource.edit', ['resource' => $resource, 'id' => $result->getKey()])"
                                class="flex items-center text-gray-500 group"
                            >
                                @svg('heroicon-o-pencil-alt', ['class' => 'w-4 h-4 text-gray-400 group-hover:text-purple-400'])
                                <span class="ml-1 text-sm group-hover:text-purple-600">
                                    {{ $this->resource()::trans('index.edit') }}
                                </span>
                            </x-lean::link>

                            {{-- Delete --}}
                            <x-lean::link
                                x-data="{}"
                                :data-confirm-text="$this->resource()::trans('show.delete_confirm')"
                                @click="if (confirm($el.getAttribute('data-confirm-text'))) $wire.call('delete', {{ $result->id }})"
                                class="flex items-center text-gray-500 group cursor-pointer"
                            >
                                @svg('heroicon-o-trash', ['class' => 'w-4 h-4 text-gray-400 group-hover:text-purple-400'])
                                <span class="ml-1 text-sm group-hover:text-purple-600">
                                    {{ $this->resource()::trans('index.delete') }}
                                </span>
                            </x-lean::link>
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
