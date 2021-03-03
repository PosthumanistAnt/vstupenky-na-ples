@props([
    'icon' => null,
    'design' => 'primary',
    'class' => '',
    'type' => 'button',
])

@php($class = $class . ' btn-' . $design)

@if($attributes->get('href'))
    <a {{ $attributes }} class="{{ $class }}">
        @if($icon)
            @svg($icon, ['class' => '-ml-1 mr-2 h-5 w-5'])
        @endif

        {{ $slot }}
    </a>
@elseif(isset($options))
    <div x-data="{ showOptions: false }" class="flex flex-col relative" @click.away="showOptions = false">
        <span class="{{ $class }} p-0 flex items-stretch">
            <button type="{{ $type }}" class="{{ $class }} rounded-r-none" {{ $attributes }}>
                @if($icon)
                    @svg($icon, ['class' => '-ml-1 mr-2 h-5 w-5'])
                @endif

                {{ $slot }}
            </button>

            <button type="button" class="{{ $class }} focus:ring-offset-0 border-l border-none border-gray-300  rounded-r-md rounded-none" @click="showOptions = ! showOptions">
                @svg('heroicon-o-chevron-down', ['class' => 'h-5 w-5'])
            </button>
        </span>
        <div class="z-10 -ml-8 mt-1.5 overflow-hidden justify-start items-end flex flex-col border border-gray-300 shadow-md rounded-md"
            x-show="showOptions"
            x-cloak
            @click="showOptions = false"
        >
            {{ $options }}
        </div>
    </div>
@else
    <button type="{{ $type }}" {{ $attributes }} class="{{ $class }}">
        @if($icon)
            @svg($icon, ['class' => '-ml-1 mr-2 h-5 w-5'])
        @endif

        {{ $slot }}
    </button>
@endif
