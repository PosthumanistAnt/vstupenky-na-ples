@props([
    'link',
    'icon',
])

@if(isset($link))
    @php($class ??= $link->active ? 'opacity-90 text-brand-600' : 'opacity-30')
    {{-- todo modalLinks --}}
    <a
        class="{{ $class }}"
        href="{{ $link->link }}"
        {{ $attributes->except(['class']) }}
    >
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            @svg($link->icon, ['class' => 'h-6 w-6'])
        @endif
    </a>
@else
    <a
        class="{{ $class ?? 'opacity-30' }}"
        href="#"
        {{ $attributes->except(['class']) }}
    >
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            @svg($icon, ['class' => 'h-6 w-6'])
        @endif
    </a>
@endif
